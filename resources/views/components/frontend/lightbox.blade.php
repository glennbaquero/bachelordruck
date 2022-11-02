@props([
'animated' => false,
])
<div>
    <div x-data="{
        showModal : false,
        src : '',
        desc : '',
        name: '',
        images: [],
        init () {
            $nextTick(() => {
                this.images = []

                let images = document.getElementsByClassName('lightbox')
                let counter = 0;
                for (let image of images) {
                    image.index = counter
                    $dispatch('img-push', {name: image.dataset.name, src: image.getAttribute('src'), srcset: image.getAttribute('srcset'), desc: image.dataset.description, index: counter})

                    image.addEventListener('click', e => {
                        $dispatch('img-modal', {src: image.getAttribute('src'), srcset: image.getAttribute('srcset'), name: image.dataset.name, desc: image.dataset.description, index: image.index})
                    })

                    counter++
                }
            })
        },
        handleEvent(e) {
            this.showModal = true
            this.src = e.detail.src
            this.name = e.detail.name
            this.desc = e.detail.desc
            this.index = e.detail.index
        },
        closeModal() {
            this.showModal = false
            this.$dispatch('modalclosed')
        },
        pushImage(e) {
            this.images.push({
                name: e.detail.name,
                src: e.detail.src,
                desc: e.detail.desc,
                index: e.detail.index,
            })
        },
        showPreviousImg()
        {
            currentIndex = this.index

            if (currentIndex < 0) return

            if (currentIndex === 0) {
                this.src = this.images[this.images.length - 1].src
                this.name = this.images[this.images.length - 1].name
                this.desc = this.images[this.images.length - 1].desc
                this.index = this.images[this.images.length - 1].index

                return
            }

            this.src = this.images[currentIndex - 1].src
            this.name = this.images[currentIndex - 1].name
            this.desc = this.images[currentIndex - 1].desc
            this.index = this.images[currentIndex - 1].index
        },
        showNextImg()
        {
            currentIndex = this.index

            if (currentIndex < 0) return

            if (currentIndex === this.images.length - 1) {
                this.src = this.images[0].src
                this.name = this.images[0].name
                this.desc = this.images[0].desc
                this.index = this.images[0].index

                return
            }

            this.src = this.images[currentIndex + 1].src
            this.name = this.images[currentIndex + 1].name
            this.desc = this.images[currentIndex + 1].desc
            this.index = this.images[currentIndex + 1].index
        },
    }">
        <div
            @lightboxinit.window="init() && handleEvent"
            @img-modal.window="handleEvent"
            x-cloak
            x-show="showModal"
            @img-push.window="pushImage"
            @if($animated)
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            @endif
            x-on:click="closeModal"
            @keyup.escape.window="closeModal"
            @keyup.left.window="showPreviousImg"
            @keyup.right.window="showNextImg"
            class="p-2 fixed w-full h-full inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75"
        >
            <button x-show="images.length > 1" class="absolute top-1/2 right-0.5" @click.prevent.stop="showNextImg">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <button x-show="images.length > 1" class="absolute top-1/2 left-0.5" @click.prevent.stop="showPreviousImg">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <div class="flex flex-col w-5/6 h-5/6">
                <div class="z-50">
                    <button @click="closeModal" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="p-2 h-full w-full">
                    <img :alt="name" class="object-contain h-full w-full" :srcset="src" :src="src">
                    <p x-text="desc" class="text-center text-white"></p>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{}"
    >
        {{ $slot }}
    </div>
</div>
