@props([
'language' => config('app.locale'),
'dateFormat' => \Support\Helpers\Date::getFormat(),
'label' => '',
'minDate' => null,
'enableTime' => false,
'noCalendar' => false,
])

<div wire:ignore x-data="datepicker(@entangle($attributes->wire('model')),
    {
        locale: '{{$language}}',
        altFormat: '{{$dateFormat}}',
        enableTime: @js($enableTime),
        noCalendar: @js($noCalendar),
        minDate: @js($minDate),
        altInput: true,
    }
)" {{ $attributes->class('relative') }}>
    <div class="flex flex-col">
        <label @click="open" for="{{$attributes->wire('model')->value}}" class="cursor-pointer block text-sm leading-5 font-medium text-gray-700 mb-1">{{$label}}&nbsp;</label>
        <div class="flex items-center gap-2 relative">
            <input x-ref="datepicker" x-model="value"
                   class="w-full min-h-[46px] border border-gray-300 bg-white sm:text-sm sm:leading-5 focus:outline-none focus:shadow-brand focus:ring-brand focus:ring-1 focus:border-brand"
                   type="text">
            <template v-if="value">
                <a href="" class="cursor-pointer justify-items-end absolute right-1 mt-[0.3rem]"
                   @click.prevent="value = null">
                    <svg class="w-4 h-4 pr-1 fill-brand-copyright" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>

                </a>
            </template>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('datepicker', (model, config) => ({
            value: model,
            init() {
                this.pickr = flatpickr(this.$refs.datepicker, config)
                this.$watch('value', function (newValue) {
                    this.pickr.setDate(newValue);
                }.bind(this));
            },
            reset() {
                this.value = null;
            },
            open() {
                this.pickr.open()
            }
        }))
    })
</script>
@endPushOnce
