<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Models\Container;
use Domain\Exceptions\UnableToCopyContainerMedia;
use Exception;
use Illuminate\Support\Facades\Storage;
use Livewire\FileUploadConfiguration;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContainerCopyMediaFromSourceAction
{
    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws UnableToCopyContainerMedia
     */
    public function __invoke(Container $container): void
    {
        /** @var Container $sourceContainer */
        $sourceContainer = $container->sourceContainer;

        /**
         * Only copy media for containers with images.
         */
        if (! $sourceContainer->type->hasImage()) {
            return;
        }

        try {
            $sourceContainer->media->each(function (Media $media) use ($container) {
                if (FileUploadConfiguration::isUsingS3()) {
                    $mediaToCreate = $container->addMediaFromUrl(Storage::disk('s3')->url($media->getPath()));
                } else {
                    $mediaToCreate = $container->addMedia($media->getPath());
                }

                $mediaToCreate
                    ->preservingOriginal()
                    ->withProperties($media->only([
                        'name',
                        'file_name',
                    ]))
                    ->toMediaCollection($media->collection_name);
            });
        } catch (Exception) {
            throw new UnableToCopyContainerMedia(__('Unable to copy container media.'));
        }
    }
}
