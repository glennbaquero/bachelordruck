<div>
    <section class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full">KontaktDaten</h1>

        <div>
            <x-bachelordruck.checkout-progress current="2" :urls="\Domain\Orders\Helpers\OrderCheckoutHelpers::checkoutUrls()"></x-bachelordruck.checkout-progress>
        </div>

        <form x-data="{
            isRecipientDifferent: @entangle('order.is_recipient_different').defer,

            get displayRecipient() {
                return this.isRecipientDifferent === true || this.isRecipientDifferent === '1'
            },
        }" class="side-padding mx-auto max-w-5xl flex flex-col gap-x-4 gap-y-6 my-5" wire:submit.prevent="create">
            <div class="flex gap-x-4 gap-y-6">
                <div>
                    <x-frontend.radio
                        id="private-customer"
                        name="customer-type"
                        label="Privatkunde"
                        value="private"
                        wire:model.defer="order.customer_type"
                    ></x-frontend.radio>
                </div>
                <div>
                    <x-frontend.radio
                        id="company"
                        name="customer-type"
                        label="Firma"
                        value="company"
                        wire:model="order.customer_type"
                    ></x-frontend.radio>
                </div>
            </div>
            <div class="grid grid-col-1 lg:grid-cols-11 gap-x-4 gap-y-6">
                <div class="col-span-1 lg:col-span-3">
                    <x-frontend.select
                        option-class="text-xl"
                        default-option="Andere*"
                        :options="$titleOptions"
                        wire:model.defer="order.title"
                    >
                    </x-frontend.select>
                </div>

                <div class="col-span-1 lg:col-span-4">
                    <x-frontend.input placeholder="Vorname*" name="order.firstname"
                                      wire:model.defer="order.firstname"></x-frontend.input>
                </div>

                <div class="col-span-1 lg:col-span-4">
                    <x-frontend.input placeholder="Nachname*" name="order.lastname"
                                      wire:model.defer="order.lastname"></x-frontend.input>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-4 gap-y-6">
                <div class="col-span-1 lg:col-span-6">
                    <x-frontend.input placeholder="E-Mail Adresse*" name="order.email"
                                      wire:model.defer="order.email" type="email"></x-frontend.input>
                </div>
                <div class="col-span-1 lg:col-span-6">
                    <x-frontend.input placeholder="Telefon" name="order.phone"
                                      wire:model.defer="order.phone"></x-frontend.input>
                </div>
            </div>

            <div>
                <label class="font-bold">Adresse</label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-11 gap-x-4 gap-y-6">
                <div class="grid-cols-1 lg:col-span-4">
                    <x-frontend.input placeholder="Straße und Hausnummer*" name="order.street"
                                      wire:model.defer="order.street"></x-frontend.input>
                </div>
                <div class="grid-cols-1 lg:col-span-3">
                    <x-frontend.input placeholder="Postleitzahl" name="order.postal_code"
                                      wire:model.defer="order.postal_code"></x-frontend.input>
                </div>
                <div class="grid-cols-1 lg:col-span-4">
                    <x-frontend.input placeholder="Ort*" name="order.city"
                                      wire:model.defer="order.city"></x-frontend.input>
                </div>
            </div>

            <div>
                <x-frontend.checkbox
                    id="delivery_address"
                    name="delivery_address"
                    label="Die Liefeadresse weicht von der Rechnungsadresse ab."
                    value="1"
                    x-model="isRecipientDifferent"
                >
                </x-frontend.checkbox>
            </div>

            <div x-cloak x-show="displayRecipient" class="flex flex-col gap-x-4 gap-y-6">
                <div>
                    <label class="font-bold">Liefeadresse</label>
                </div>

                <div class="grid grid-col-1 lg:grid-cols-11 gap-x-4 gap-y-6">
                    <div class="col-span-1 lg:col-span-3">
                        <x-frontend.select
                            option-class="text-xl"
                            default-option="Andere*"
                            :options="$titleOptions"
                            wire:model.defer="order.recipient_title"
                        >
                        </x-frontend.select>
                    </div>

                    <div class="col-span-1 lg:col-span-4">
                        <x-frontend.input placeholder="Vorname*" name="order.recipient_firstname"
                                          wire:model.defer="order.recipient_firstname"></x-frontend.input>
                    </div>

                    <div class="col-span-1 lg:col-span-4">
                        <x-frontend.input placeholder="Nachname*" name="order.recipient_lastname"
                                          wire:model.defer="order.recipient_lastname"></x-frontend.input>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-11 gap-x-4 gap-y-6">
                    <div class="grid-cols-1 lg:col-span-4">
                        <x-frontend.input placeholder="Straße und Hausnummer*" name="order.recipient_street"
                                          wire:model.defer="order.recipient_street"></x-frontend.input>
                    </div>
                    <div class="grid-cols-1 lg:col-span-3">
                        <x-frontend.input placeholder="Postleitzahl" name="order.recipient_postal_code"
                                          wire:model.defer="order.recipient_postal_code"></x-frontend.input>
                    </div>
                    <div class="grid-cols-1 lg:col-span-4">
                        <x-frontend.input placeholder="Ort*" name="order.recipient_city"
                                          wire:model.defer="order.recipient_city"></x-frontend.input>
                    </div>
                </div>
            </div>

            <div class="flex justify-end w-full">
                <x-bachelordruck.button type="submit" class="w-full sm:w-auto bg-brand-primary text-white">
                    Weiter
                    <x-spinner wire:loading wire:target="create"
                               class="w-3 h-3"></x-spinner>
                </x-bachelordruck.button>
            </div>
        </form>
    </section>
</div>
