<div>
    <div x-data="{
        showModal : false,
        src : '',
        name: '',
        links: [],
        handleEvent(e) {
            this.showModal = true
            this.src = e.detail.src
            this.name = e.detail.name
        },
        closeModal() {
            this.showModal = false
        },
        pushLink(e) {
            this.links.push({
                name: e.detail.name,
                src: e.detail.src,
            })
            console.log(this.links)
        },
        showPreviousLink()
        {
            let currentIndex = this.links.findIndex(link => {
                return link.name === this.name
            })

            console.log(currentIndex)

            if (currentIndex < 0) return

            if (currentIndex === 0) {
                this.src = this.links[this.links.length - 1].src
                this.name = this.links[this.links.length - 1].name

                return
            }

            this.src = this.links[currentIndex - 1].src
            this.name = this.links[currentIndex - 1].name
        },
        showNextLink()
        {
            let currentIndex = this.links.findIndex(link => {
                return link.name === this.name
            })

            if (currentIndex < 0) return

            if (currentIndex === this.links.length - 1) {
                this.src = this.links[0].src
                this.name = this.links[0].name

                return
            }

            this.src = this.links[currentIndex + 1].src
            this.name = this.links[currentIndex + 1].name
        }
    }">
        <div
            @zoom-modal.window="handleEvent"
            x-show="showModal"
            @zoom-push.window="pushLink"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            x-on:click="src='';name='';closeModal()"
            @keyup.escape.window="closeModal"
            @keyup.left.window="showPreviousLink"
            @keyup.right.window="showNextLink"
            class="p-2 fixed w-full h-full inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75"
        >
            <button class="absolute top-1/2 right-0.5" @click.prevent.stop="showNextLink">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            <button class="absolute top-1/2 left-0.5" @click.prevent.stop="showPreviousLink">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <div class="flex flex-col w-5/6 h-5/6">
                <div class="z-50">
                    <button @click="closeModal" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="p-2 h-full w-full">
                    <p x-text="name" class="text-center text-white"></p>
                    <iframe :src="src" class="w-full h-full"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{}"
        x-init="function () {
            let links = document.getElementsByClassName('zoom')
            for (let link of links) {
                $dispatch('zoom-push', {name: link.dataset.name, src: link.getAttribute('href')})
                link.addEventListener('click', e => {
                    $dispatch('zoom-modal', {src: link.getAttribute('href'), name: link.dataset.name});
                    e.preventDefault();
                })
            }
        }"
    >
        {{ $slot }}
    </div>
</div>
