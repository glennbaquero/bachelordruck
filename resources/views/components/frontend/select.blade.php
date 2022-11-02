@props([
'showLabel' => false,
'label' => '',
'prepend' => '',
'append' => '',
'clearable' => false,
'options' => [],
'optionLabel' => 'label',
'optionValue' => 'id',
'defaultOption' => __('Please select an option'),
'labelClass' => '',
'optionClass' => '',
])

<div
    x-data="customSelect({
            open: false,
            value: @entangle($attributes->wire('model')),
            selected: null,
            options: @js($options),
            defaultOption: '{{$defaultOption}}',
            optionLabel: '{{$optionLabel}}',
            optionValue: '{{$optionValue}}',
            prepend: '{{$prepend}}',
            append: '{{$append}}',
        })"
    x-init="init()"
    class="space-y-1"
>
    @if($showLabel)
    <label @click="onButtonClick()" id="assigned-to-label"
           class="{{ $labelClass }} cursor-pointer block leading-5">{{ $label }} &nbsp;</label>
    @endif
    <div class="relative">
                  <span class="inline-block w-full shadow-sm">
                    <button x-ref="button" @click="onButtonClick()" type="button" aria-haspopup="listbox"
                            :aria-expanded="open"
                            aria-labelledby="assigned-to-label"
                            class="{{ $optionClass }} cursor-default relative w-full border border-gray-400 bg-white pl-3 pr-6 py-2 text-left focus:outline-none focus:shadow-brand-primary focus:border-brand-primary focus:ring-brand-primary focus:ring-1 transition ease-in-out duration-150 sm:leading-5 min-h-[46px] max-h-[46px]">
                      <div class="flex items-center space-x-3 py-1">
                          <p class="flex justify-between w-full items-center">
                            <span
                                x-text="prepend + selectedItem[optionLabel] + append"
                                class="block truncate"
                                :class="{'text-gray-500': !value}"
                            >
                            </span>
                              @if($clearable)
                                  <template x-if="value">
                                  <a href="" class="cursor-pointer justify-items-end"
                                     @click.prevent="String(value) = null">
                                    <svg class="w-4 h-4 pr-1 fill-brand-primary-copyright" fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  stroke-width="2"
                                                                                  d="M6 18L18 6M6 6l12 12"></path></svg>

                                  </a>
                              </template>
                              @endif
                          </p>
                      </div>
                      <span class="absolute inset-y-0 right-0 flex items-center pr-0.5 pointer-events-none">
                          <div class="w-10 h-10 bg-[#acacac] flex justify-center items-center">
                              <svg version="1.1" id="Ebene_1" xmlns="http://www.w3.org/2000/svg"
                                   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                   width="15px" height="7px" viewBox="0 0 15 7" enable-background="new 0 0 15 7"
                                   xml:space="preserve">
                                    <polygon fill="#FFFFFF" points="7.486,7 0,0 15,0 "/>
                              </svg>
                          </div>
                      </span>
                    </button>
                  </span>
        @error($attributes->wire('model')->value)
        <div class="-mt-0.5"><small class="-mt-2"><span class="text-red-500">{{ $message }}</span></small>
        </div> @enderror
        <div x-show="open" @focusout="onEscape()" @click.away="open = false"
             x-description="Select popover, show/hide based on select state."
             x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="absolute mt-[1px] w-full bg-white shadow-lg z-50"
             style="display: none;">
            <ul @keydown.enter.stop.prevent="onOptionSelect()"
                @keydown.space.stop.prevent="onOptionSelect()" @keydown.escape="onEscape()"
                @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()"
                x-ref="listbox" tabindex="-1" role="listbox" aria-labelledby="assigned-to-label"
                :aria-activedescendant="activeDescendant"
                class="max-h-56 py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">

                @foreach($options as $option)
                    <li id="assigned-to-option-{{ $loop->index }}" role="option"
                        @click="choose('{{ $option[$optionValue] }}')" @mouseenter="selected = {{ $loop->index }}"
                        @mouseleave="selected = null"
                        :class="{ 'text-white bg-brand-primary': selected === {{ $loop->index }}, 'text-gray-900': !(selected === {{ $loop->index }}) }"
                        class="bg-brand-primary text-white cursor-default select-none relative py-3 pl-4 pr-9">
                        <div class="flex items-center space-x-3">
                            <span
                                :class="{ 'font-semibold': String(value) === '{{ $option[$optionValue] }}', 'font-normal': !(String(value) === '{{ $option[$optionValue] }}') }"
                                class="{{ $optionClass }} block truncate">
                            {{ $option[$optionLabel] }}
                          </span>
                        </div>
                        <span x-show="String(value) === '{{ $option[$optionValue] }}'"
                              :class="{ 'text-white': selected === {{$loop->index}}, 'text-brand-primary': !(selected === {{$loop->index}}) }"
                              class="absolute inset-y-0 right-0 flex items-center pr-4 text-white">
                          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"></path>
                          </svg>
                        </span>
                    </li>

                @endforeach

            </ul>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customSelect', (otherOptions) => {
            return {
                init() {
                    this.$refs.listbox.focus()
                    this.optionCount = this.$refs.listbox.children.length
                    this.$watch('selected', value => {
                        if (!this.open) return

                        if (this.selected === null) {
                            this.activeDescendant = ''
                            return
                        }

                        if (this.selected >= 0) {
                            this.activeDescendant = this.$refs.listbox.children[this.selected].id
                        }
                    })
                },
                options: [],
                activeDescendant: null,
                optionCount: null,
                open: false,
                selected: null,
                value: null,
                choose(option) {
                    this.value = option
                    this.open = false
                },
                onButtonClick() {
                    if (this.open) return

                    this.selected = this.options.indexOf(this.selectedItem)

                    this.open = true

                    this.$nextTick(() => {
                        this.$refs.listbox.focus()
                        if (this.selected >= 0) {
                            this.$refs.listbox.children[this.selected].scrollIntoView({block: 'nearest'})
                        }
                    })
                },
                onOptionSelect() {
                    if (this.selected !== null) {
                        this.value = this.options[this.selected][this.optionValue]
                    }

                    this.open = false
                    this.$refs.button.focus()
                },
                onEscape() {
                    this.open = false
                    this.$refs.button.focus()
                },
                onArrowUp() {
                    if (this.selected === 0) {
                        return
                    }

                    this.selected = this.selected -1

                    this.$refs.listbox.children[this.selected].scrollIntoView({block: 'nearest'})
                },
                onArrowDown() {
                    if (this.selected === this.options.length - 1) {
                        return
                    }

                    this.selected = this.selected + 1
                    this.$refs.listbox.children[this.selected].scrollIntoView({block: 'nearest'})
                },

                get hasSelection() {
                    return Boolean(this.value)
                },

                get selectedItem() {
                    let selectOption = this.options.find((option) => String(option.id) === String(this.value));

                    if (!selectOption) {
                        return {
                            [this.optionLabel]: this.defaultOption
                        }
                    }

                    return selectOption
                },
                ...otherOptions,
            }
        });
    })

</script>
@endPushOnce
