<div>
    <section class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full">Bestättigung und Datenupload</h1>

        <div>
            <x-bachelordruck.checkout-progress current="4"
                                               :urls="\Domain\Orders\Helpers\OrderCheckoutHelpers::checkoutUrls()"></x-bachelordruck.checkout-progress>
        </div>

        <div class="side-padding mx-auto max-w-5xl flex flex-col items-center justify-center gap-x-4 gap-y-6 my-5">
            <div class="text-center font-bold text-xl gap-x-4 gap-y-6">
                <p>Vielen Dank für lhren Einkauf!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Quisque non tellus orci ac.</p>
            </div>

            <div class="text-center border-t w-full border-brand-primary text-xl gap-x-4">
            </div>
            <div class="flex gap-x-4">
                <div class="file-upload">
                    <div class="my-6">
                        <x-bachelordruck.button
                            onclick="location.href='{{ route('order.upload-center', ['language' => $language, 'sessionId' => $sessionId]) }}'"
                            class="bg-brand-primary text-white">
                            Heir geht es zu dem Datenupload
                        </x-bachelordruck.button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

