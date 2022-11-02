@props([
'label' => 'Datei zum Hochladen hier hinziehen',
'buttonClass' => '',
'maxFiles' => 0,
'maxFileSize' => '',
'modelId' => null,
'modelClass' => '',
'mediaCollection' => '',
'uploadedFiles' => [],
'allowUpload' => true,
'fileTypes' => [],
])

@php
    $id = 'file-upload-' . Str::random(16);;
    $target = route('files-upload.upload', ['modelId' => $modelId, 'modelClass' => $modelClass, 'mediaCollection' => $mediaCollection, 'maxFiles' => $maxFiles])
@endphp

<div wire:ignore.self x-data="fileUpload(
    '{{ $id }}',
    '{{ $target }}',
    '{{ $label }}',
    {{ json_encode($fileTypes) }},
    {{ empty($maxFiles) ? 'undefined' : $maxFiles }},
    {{ empty($maxFileSize) ? 'undefined' : "'" . $maxFileSize . "'" }}
    )" x-ref="draggable">

    @if($allowUpload)
        <div>
            <button x-ref="file_upload_btn" class="{{$buttonClass}}" {{ $attributes->merge(['type' => 'button' ]) }}>
            <span class="flex gap-x-2 items-center justify-center">
                <x-icon name="upload" class="w-6 h-6"/>
                {{ $label }}
            </span>
            </button>

            <div class="bg-gray-100 mt-2 progress w-full text-center h-6 relative" x-ref="progress"
                 style="display: none;">
                <div class="bg-blue-500 progress-bar h-6" x-ref="progress_bar" style="width: 0%">
                    <small x-ref="progress_percent_label"
                           class="text-brand-primary absolute inset-x-0 mt-0.5">0%</small>
                </div>
            </div>
        </div>
    @endif

    <x-file-upload-files :id="$id" :files="$uploadedFiles" :allow-delete="$allowUpload"></x-file-upload-files>
</div>

@pushOnce('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUpload', (id, target, label, fileTypes, maxFiles = undefined, maxFileSize = undefined) => ({
            resumable: null,
            files: [],
            init() {
                let maxFileSizeInBytes

                if (typeof maxFileSize === 'undefined') {
                    maxFileSizeInBytes = undefined
                } else {
                    maxFileSizeInBytes = this.toBytes(maxFileSize).toString()
                }

                this.resumable = new Resumable({
                    target: target,
                    query: {_token: '{{ csrf_token() }}'},
                    chunkSize: 1 * 1024 * 1024,
                    forceChunkSize: true,
                    headers: {
                        'Accept': 'application/json',
                    },
                    testChunks: false,
                    throttleProgressCallbacks: 1,
                    maxFiles: maxFiles,
                    maxFileSize: maxFileSizeInBytes,
                    fileType: fileTypes,
                });

                let _this = this
                const fileUploadButton = this.$refs.file_upload_btn

                if (!fileUploadButton) {
                    return
                }

                const draggable = this.$refs.draggable
                const progress = this.$refs.progress
                const progressBar = this.$refs.progress_bar
                const progressPercentLabel = this.$refs.progress_percent_label

                _this.resumable.assignBrowse(fileUploadButton);
                _this.resumable.assignDrop(draggable);

                _this.resumable.on('fileAdded', function (file, event) {
                    progress.style.display = 'block';

                    _this.$dispatch('file-added', {file: makeFileFromResumable(file), id})

                    _this.resumable.upload();
                });

                _this.resumable.on('fileSuccess', function (file, response) {
                    fileUploadButton.disabled = false;

                    if (maxFiles === 1) {
                        _this.$dispatch('files-clear', {id})
                    }

                    const data = JSON.parse(response);
                    const files = data.media

                    _this.$dispatch('file-success', {file: makeFileFromResumable(file), id, files})

                    if (_this.resumable.progress() >= 1) {
                        while (_this.resumable.files.length > 0) {
                            _this.resumable.files.pop()
                        }

                        progress.style.display = 'none';
                    }
                });

                _this.resumable.on('fileError', function (file, response) {
                    fileUploadButton.disabled = false;
                    progress.style.display = 'none';
                });

                _this.resumable.on('fileProgress', function (file, message) {
                    _this.$dispatch('file-updated', {file: makeFileFromResumable(file), id})

                    fileUploadButton.disabled = true;
                    updateProgress(Math.floor(_this.resumable.progress() * 100));
                });

                function makeFileFromResumable(file) {
                    return {
                        id: file.uniqueIdentifier,
                        file_name: file.fileName,
                        progress: file.progress(),
                        size: file.size,
                        temporary: true,
                    }
                }

                function updateProgress(value) {
                    progressBar.style.width = `${value}%`;
                    progressPercentLabel.innerHTML = `${value}%`;
                }
            },

            toBytes(sizeInWord) {
                let trimSizeInWord = sizeInWord.replaceAll(' ', '').toUpperCase()

                let index = 0

                for (let i = 0; i < trimSizeInWord.length; i++) {
                    if (isNaN(trimSizeInWord[i])) {
                        break;
                    } else {
                        index = i;
                    }
                }

                const size = trimSizeInWord.substring(0, index + 1)
                const type = trimSizeInWord.substring(index + 1)

                const types = ["B", "KB", "MB", "GB", "TB"];

                const key = types.indexOf(type.toUpperCase())

                if (typeof key !== "boolean") {
                    return size * 1024 ** key;
                }

                return 0;
            }
        }))
    })
</script>
@endpushOnce
