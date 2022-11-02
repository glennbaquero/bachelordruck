import Alpine from 'alpinejs';
import Tooltip from "@ryangjchandler/alpine-tooltip";
import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Picker from 'vanilla-picker'
import Table from '@tiptap/extension-table'
import TableRow from '@tiptap/extension-table-row'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import '@nextapps-be/livewire-sortablejs';
import axios from 'axios';
import Link from '@tiptap/extension-link'

import Swiper from 'swiper/bundle';
import 'swiper/css';
import 'swiper/css/pagination';

import Viewer from 'viewerjs';
import 'viewerjs/dist/viewer.css';

import 'tippy.js/themes/light.css';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import 'flatpickr/dist/l10n/de.js'

import Resumable from 'resumablejs'

window.Swiper = Swiper
window.Viewer = Viewer
window.Picker = Picker
window.axios = axios
window.flatpickr = flatpickr
window.Resumable = Resumable;


window.setupEditor = content => {
    return {
        editor: null,
        content: content,
        element: null,
        updatedAt: Date.now(),
        isActive(type, opts = {}, updatedAt) {
            return this.editor.isActive(type, opts);
        },
        can(method) {
            return this.editor.can()[method]()
        },
        setLink() {
            const previousUrl = this.editor.getAttributes('link').href
            const url = window.prompt('URL', previousUrl)

            // cancelled
            if (url === null) {
                return
            }

            // empty
            if (url === '') {
                Alpine.raw(this.editor)
                    .chain()
                    .focus()
                    .extendMarkRange('link')
                    .unsetLink()
                    .run()

                return
            }

            let target = '_self'

            if (url.startsWith('http')) {
                target = '_blank'
            }

            Alpine.raw(this.editor)
                .chain()
                .focus()
                .extendMarkRange('link')
                .setLink({ href: url, target })
                .run()

        },
        init(element) {
            this.editor = new Editor({
                element: element,
                extensions: [
                    StarterKit,
                    Table.configure({
                        resizable: true,
                    }),
                    TableRow,
                    TableHeader,
                    TableCell,
                    Link.configure({
                        openOnClick: false,
                        HTMLAttributes: {
                            class: 'blue-500',
                        },
                    }),
                ],
                content: this.content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML()
                    this.updatedAt = Date.now()
                },
                onCreate: ({ editor }) => {
                    this.updatedAt = Date.now();
                },
                onSelectionUpdate: ({ editor }) => {
                    this.updatedAt = Date.now();
                },
                editorProps: {
                    attributes: {
                        class: 'prose prose-sm m-5 focus:outline-none border-none p-0'
                    }
                }
            })
        },
    }
}


window.$modals = {
    show(name) {
        console.log('emit')
        window.dispatchEvent(
            new CustomEvent('modal', { detail: name })
        );
    }
}

Alpine.plugin(Tooltip);
window.Alpine = Alpine;
Alpine.start();


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
