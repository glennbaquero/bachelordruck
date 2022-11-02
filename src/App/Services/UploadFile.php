<?php

namespace App\Services;

use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadFile
{
    public function __invoke(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (! $receiver->isUploaded()) {
            throw new UploadMissingFileException();
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file

            $model = app($request->modelClass)->find($request->modelId);

            if ((int) $request->maxFiles === 1) {
                $model->clearMediaCollection($request->mediaCollection);
            }

            $model->addMedia($file)
                ->toMediaCollection($request->mediaCollection);

            // delete chunked file
            if (file_exists($file->getPathname())) {
                unlink($file->getPathname());
            }

            $model->load(['media' => function ($query) use ($request) {
                $query->where('collection_name', $request->mediaCollection);
            }]);

            foreach ($model->media as $media) {
                $media->append('signed_url');
            }

            return $model;
        }

        // otherwise return percentage information
        $handler = $fileReceived->handler();

        return [
            'done' => $handler->getPercentageDone(),
            'status' => 200,
        ];
    }

    // https://github.com/pionl/laravel-chunk-upload/issues/10
    public function checkChunk(Request $request)
    {
        // The frontend library resumable.js calls this function before uploading every chunk to know if
        // it already exists. This is useful in case the upload was interrupted for some reason.

        // Get the path where the chunks are stored
        $path = storage_path('app/chunks/');

        // The last part of the chunks are formed by an identifier and the chunk number
        $fileName = '*'.$request->resumableIdentifier.'.'.$request->resumableChunkNumber.'.part';
        $fullName = $path.$fileName;

        // Search for a file that ends with the file name we defined
        $chunk = glob($fullName);

        if (count($chunk)) {
            // Let resumable.js know that the chunk exists
            return response('ok', 200); // The chunk will not be re-uploaded
        } else {
            // Chunk not found
            return response('ko', 204); // The chunk will be uploaded
        }
    }

    public function download(Media $media, Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        set_time_limit(0);

        if (ob_get_level()) {
            ob_end_clean();
        }

        return response()->streamDownload(function () use ($media) {
            echo file_get_contents($media->getPath());
        }, $media->file_name);
    }
}
