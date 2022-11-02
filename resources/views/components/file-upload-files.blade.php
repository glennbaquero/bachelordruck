@props([
'files' => [],
'id' => 'file-upload',
'allowDelete' => true,
])

<div wire:ignore x-data="fileUploadFiles('{{$id}}', {{ json_encode($files) }})">
    <div @file-added.window="(event) => fileAdded(event.detail.file, event.detail.id)"
         @file-updated.window="(event) => fileUpdated(event.detail.file, event.detail.id)"
         @file-success.window="(event) => fileSuccess(event.detail.file, event.detail.id, event.detail.files)"
         @files-clear.window="(event) => filesClear(event.detail.id)"
         class="flex flex-col gap-2 mt-4">
        <template x-for="file in files" :key="`files-${file.id}`">
            <div class="flex gap-3 items-center">
                <svg width="23" height="29" viewBox="0 0 23 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.20834 27.625H18.7917C19.5652 27.625 20.3071 27.3177 20.8541 26.7707C21.401 26.2237 21.7083 25.4819 21.7083 24.7083V10.7287C21.7083 10.342 21.5546 9.97114 21.281 9.69771L13.3856 1.80229C13.1122 1.52878 12.7413 1.37508 12.3546 1.375H4.20834C3.43479 1.375 2.69292 1.68229 2.14594 2.22927C1.59896 2.77625 1.29167 3.51812 1.29167 4.29167V24.7083C1.29167 25.4819 1.59896 26.2237 2.14594 26.7707C2.69292 27.3177 3.43479 27.625 4.20834 27.625Z"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <template x-if="file.signed_url">
                    <a :href="file.signed_url">
                        <span x-text="file.file_name + ' (' + fileSizeToHuman(file.size) + ')'"
                              class="text-brand-primary"></span>
                        <span x-show="file.progress < 1" x-text="progressToHuman(file.progress)"
                              class="text-brand-primary"></span>
                    </a>
                </template>
                <template x-if="!file.signed_url">
                    <div>
                    <span x-text="file.file_name + ' (' + fileSizeToHuman(file.size) + ')'"
                          class="text-brand-primary"></span>
                        <span x-show="file.progress < 1" x-text="progressToHuman(file.progress)"
                              class="text-brand-primary"></span>
                    </div>
                </template>
                @if ($allowDelete)
                    <button @click="removeMedia(file)">
                        <div class="flex">
                            <svg x-show="! file.temporary && ! file.removing" width="20" height="21" viewBox="0 0 20 21"
                                 fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 12.5L10 10.5M10 10.5L12 8.5M10 10.5L8 8.5M10 10.5L12 12.5M19 10.5C19 11.6819 18.7672 12.8522 18.3149 13.9442C17.8626 15.0361 17.1997 16.0282 16.364 16.864C15.5282 17.6997 14.5361 18.3626 13.4442 18.8149C12.3522 19.2672 11.1819 19.5 10 19.5C8.8181 19.5 7.64778 19.2672 6.55585 18.8149C5.46392 18.3626 4.47177 17.6997 3.63604 16.864C2.80031 16.0282 2.13738 15.0361 1.68508 13.9442C1.23279 12.8522 1 11.6819 1 10.5C1 8.11305 1.94821 5.82387 3.63604 4.13604C5.32387 2.44821 7.61305 1.5 10 1.5C12.3869 1.5 14.6761 2.44821 16.364 4.13604C18.0518 5.82387 19 8.11305 19 10.5Z"
                                    stroke="#BCBCBC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <x-spinner class="w-5 h-5" x-show="file.removing"></x-spinner>
                        </div>
                    </button>
                @endif
            </div>
        </template>
    </div>
</div>

@pushOnce('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUploadFiles', (id, files) => ({
            files: files,
            id: id,

            filesClear(id) {
                if (this.id !== id) {
                    return;
                }

                this.files = []
            },

            fileAdded(file, id) {
                if (this.id !== id) {
                    return;
                }

                this.files.push(file)
            },

            fileUpdated(file, id) {
                if (this.id !== id) {
                    return;
                }

                const index = this.files.findIndex((f) => f.id === file.id)

                if (index >= 0) {
                    this.files.splice(index, 1, file)
                }
            },

            removeFile(file) {
                const index = this.files.findIndex((f) => f.id === file.id)

                if (index >= 0) {
                    this.files.splice(index, 1)
                }
            },

            fileSuccess(file, id, files) {
                if (this.id !== id) {
                    return;
                }

                this.removeFile(file)

                const temporaryFiles = this.files.filter((f) => f.temporary);

                this.files = files.concat(temporaryFiles)
            },

            fileSizeToHuman(fileSize) {
                const units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                let l = 0, n = parseInt(fileSize, 10) || 0;
                while (n >= 1024 && ++l) {
                    n = n / 1024;
                }

                const size = parseFloat(n.toFixed(n < 10 && l > 0 ? 1 : 0));

                return (new Intl.NumberFormat('de-DE', {}).format(size)) + ' ' + units[l];
            },

            progressToHuman(progress) {
                return new Intl.NumberFormat('de-DE', {}).format(parseFloat((progress * 100).toFixed(2))) + '%'
            },

            async removeMedia(file) {
                file.removing = true;

                await this.$wire.removeMedia(file.id);

                this.removeFile(file)
            }
        }))
    })
</script>
@endpushOnce
