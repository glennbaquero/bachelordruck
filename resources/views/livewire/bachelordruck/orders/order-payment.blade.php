<div class="lg:w-1/2 xl:w-1/2 md:w-1/2 sm:w-96 w-full xl:p-0 lg:p-0 md:p-0 sm:p-2.5 p-2.5 mx-auto">

    <section x-data="{
            selectedPaymentMethod: '',
            isLoading: false,

            renderPayment() {
                let self = this;
                var FUNDING_SOURCES = [
                    paypal_sdk.FUNDING.PAYPAL,
                    paypal_sdk.FUNDING.CARD,
                    paypal_sdk.FUNDING.SEPA,
                ]

                FUNDING_SOURCES.forEach(function (fundingSource) {
                    var button = paypal_sdk.Buttons({
                        fundingSource: fundingSource,
                        // Set up the transaction
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: {{ $basketPositions->gross() }}
                                    }
                                }],
                                payer: {
                                    name: {
                                        given_name: '{{ $order->firstname }}',
                                        surname: '{{ $order->lastname }}'
                                    },
                                    email_address: '{{ $order->email }}',
                                    address: {
                                        address_line_1: '{{ $order->street }}',
                                        address_line_2: '{{ $order->street }}',
                                        admin_area_2: '{{ $order->city  }}',
                                        admin_area_1: '{{ $order->city  }}',
                                        postal_code: '{{ $order->postal_code }}',
                                        country_code: 'DE'
                                    },

                                    phone: {
                                        phone_type: 'MOBILE',
                                        phone_number: {
                                            national_number: '{{ $order->phone }}'
                                        }
                                    }
                                },
                            });
                        },

                        // Finalize the transaction
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(orderData) {
                                self.isLoading = true;
                                $wire.emit('paymentSuccess', orderData);
                            });
                        },
                        onError: function(err) {
                            // Show an error page here, when an error occurs
                            console.log('error', err)
                            // Redirect to an Error Page...
                            // ???
                        }
                    })

                    if (button.isEligible()) {
                        if(fundingSource === 'card') {
                            button.render('#paypal-card-container')
                        } else if(fundingSource === 'sepa') {
                            button.render('#paypal-sepa-container')
                        } else {
                            button.render('#paypal-button-container')
                        }
                    }
                })
            }
        }" x-init="renderPayment" class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full">Leiferung und Zahlungsmethode</h1>

        <div>
            <x-bachelordruck.checkout-progress current="3" :urls="\Domain\Orders\Helpers\OrderCheckoutHelpers::checkoutUrls()"></x-bachelordruck.checkout-progress>
        </div>
{{--        wire:loading wire:target="paymentSuccess"--}}
        <div x-show="isLoading">
            <div  class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
                <h2 class="text-center text-white text-xl font-semibold">{{__('Loading')}}...</h2>
                <p class="w-1/2 text-center text-white">{{__('This may take a few seconds, please don\'t close this page.')}}</p>
            </div>
        </div>

        <p class="page-title">Rechnungsadresse</p>
        <p class="text-regular">{{ $order->fullName }}, {{ $order->address }}</p>
        <hr class="mt-3 mb-3">
        <p class="page-title">Lieferadresse</p>
        @if($order->is_recipient_different)
            <p class="text-regular">{{ $order->recipientFullName }}, {{ $order->recipientAddress }}</p>
        @else
            <p class="text-regular">{{ $order->fullName }}, {{ $order->address }}</p>
        @endif
        <hr class="mt-3 mb-3">
        <p class="page-title">Lieferung</p>
        @foreach($basketPositions as $_key => $basketPosition)
            <div class="flex {{ ($_key+1) !== count($basketPositions) ? 'border-b' : '' }} py-4">
                <div class="text-regular">
                    <p>
                        {{ $basketPosition->product_details2  }}
                    </p>
                </div>
                <div class="text-regular">
                    <p>{{ $basketPosition->priceFormatted }}€</p>
                </div>
            </div>
        @endforeach
        <hr class="mt-3 mb-3 border-brand-primary">
        <div class=" text-right ">
            <p>Netto {{ $basketPositions->totalCostFormatted() }} €</p>
            <p>Brutto <span class="font-bold text-3xl text-regular">{{ $basketPositions->grossFormatted() }} €</span></p>
        </div>

        <div class="grid xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 grid-cols-1 gap-3">
            <div class="col-span-full">
                <p class="page-title">Zahlungsart</p>
            </div>
            <div class="col-span-1">
                <x-frontend.radio
                    id="vorkasse"
                    name="payment"
                    label="Vorkasse"
                    value="payment_in_advance"
                    wire:model.defer="paymentMethod"
                    x-model="selectedPaymentMethod"
                ></x-frontend.radio>
            </div>
            <div class="col-span-1">
                <div class="flex items-center">
                    <input
                        id="visa"
                        type="radio"
                        name="payment"
                        value="card"
                        class="radio hidden"
                        wire:model.defer="paymentMethod"
                        x-model="selectedPaymentMethod"
                    />
                    <label for="visa" class="flex items-center cursor-pointer text-normal">
                        <span class="circle w-9 h-9 inline-block mr-2 rounded-full border border-gray-500 flex-no-shrink bg-white"></span>
                        <img src="{{ asset('images/logo-visa_mastercard.svg') }}" class="w-1/2">
                    </label>
                </div>
            </div>
            <div class="col-span-1">
                <div class="flex items-center">
                    <input
                        id="paypal"
                        type="radio"
                        name="payment"
                        value="paypal"
                        class="radio hidden"
                        wire:model.defer="paymentMethod"
                        x-model="selectedPaymentMethod"
                    />
                    <label for="paypal" class="flex items-center cursor-pointer text-normal">
                        <span class="circle w-9 h-9 inline-block mr-2 rounded-full border border-gray-500 flex-no-shrink bg-white"></span>
                        <img src="{{ asset('images/logo-paypal.svg') }}" class="w-1/2">
                    </label>
                </div>
            </div>
            <div class="col-span-1">
                <x-frontend.radio
                    id="sepa_firmenlastschrift"
                    name="payment"
                    label="Sepa-Firmenlastschrift"
                    value="bank"
                    wire:model.defer="paymentMethod"
                    x-model="selectedPaymentMethod"
                ></x-frontend.radio>
            </div>
        </div>
        <br>
        <div id="paypal-button-container" x-show="selectedPaymentMethod === 'paypal'"></div>
        <div id="paypal-card-container" x-show="selectedPaymentMethod === 'card'"></div>
        <div id="paypal-sepa-container" x-show="selectedPaymentMethod === 'bank'"></div>

        <div class="flex mt-5 mb-5">
            <div class="w-1/2">
                <x-bachelordruck.button onclick="location.href='{{ route('order.contact-details', [$language = 'de']) }}'" class="bg-gray-100 text-brand-primary mb-40">
                    Zuruck
                </x-bachelordruck.button>
            </div>
            <div class="w-1/2" x-show="selectedPaymentMethod === 'payment_in_advance'">
                <button
                        wire:click="paymentSuccess"
                        @click="isLoading = true"
                        class="float-right xl:w-1/2 lg:w-1/2 md:w-1/2 sm:w-3/4 xs:w-3/4 w-3/4 text-center p-1 bg-brand-primary text-title text-white text-2xl"
                >
                    Weiter
                </button>
            </div>
        </div>

    </section>
</div>


@pushOnce('styles')
    <style>
        .radio + label span.circle {
            transition: background .2s,
            transform .2s;
        }

        .radio:checked + label span.circle {
            background-color: var(--color-brand-primary);
            box-shadow: 0px 0px 0px 6px var(--color-brand) inset;
        }

        .radio:checked + label {
            color: var(--color-brand-primary);
        }
    </style>
@endPushOnce

@pushOnce('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('bachelordruck.paypal_client_id') }}&currency=EUR&components=buttons,marks&locale=de_DE&buyer-country=DE" data-namespace="paypal_sdk"></script>
    <script>

    </script>
@endPushOnce
