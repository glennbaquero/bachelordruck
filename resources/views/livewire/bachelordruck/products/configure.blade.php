<div>
    <section class="w-full header-margin-top">
        <h1 class="page-title text-center uppercase w-full">Konfigurienren sie ihr produkt</h1>
        <div
            x-data="{
                hasSpineLabel: @entangle('productConfiguration.has_book_spine_label').defer,
                hasBookCorners: @entangle('productConfiguration.has_book_corners').defer,
                hasRibbon: @entangle('productConfiguration.has_ribbon').defer,
                doubleSidedPrinting: @entangle('productConfiguration.double_sided_printing').defer,
                additionalServices: @entangle('productConfiguration.additional_services').defer,
                productCoverColorId: @entangle('productConfiguration.product_cover_color_id').defer,
                productCoverColorImages: @entangle('productCoverColorImages').defer,

                additionalServiceRequiresCdLabelId: @entangle('additionalServiceRequiresCdLabelId').defer,
                additionalServiceRequiresCdLabelOptionId: @entangle('additionalServiceRequiresCdLabelOptionId').defer,

                get displaySpineLabelOptions() {
                    return this.hasSpineLabel === true || this.hasSpineLabel === '1'
                },

                get displayBookCornersOptions() {
                    return this.hasBookCorners === true || this.hasBookCorners === '1'
                },

                get displayRibbonOptions() {
                    return this.hasRibbon === true || this.hasRibbon === '1'
                },

                get displayTextCdLabel() {
                    return this.additionalServices.includes(this.additionalServiceRequiresCdLabelId.toString())
                },

                checkRequiresCd(additionalServiceId) {
                    // If the selected checkbox is the `Klebehülle für CD`, it will include the `CD brennen mit Labeldruck`
                    if (additionalServiceId.toString() === this.additionalServiceRequiresCdLabelOptionId.toString()) {
                        if (!this.displayTextCdLabel) {
                            this.additionalServices = this.additionalServices.concat(this.additionalServiceRequiresCdLabelId.toString(), additionalServiceId.toString())
                        }
                    }

                    if (additionalServiceId.toString() === this.additionalServiceRequiresCdLabelId.toString()) {
                        if (this.displayTextCdLabel) {
                            this.additionalServices = this.additionalServices.filter((additionalService) => ![this.additionalServiceRequiresCdLabelId.toString(), this.additionalServiceRequiresCdLabelOptionId.toString()].includes(additionalService.toString()));
                        }
                    }

                    this.$wire.priceShouldUpdate()
                },
                modalClose: true,

                makeSticky() {
                    this.modalClose = true
                }
            }"
            class="xl:gap-2 lg:gap-2 grid grid-cols-1 lg:grid-cols-3 md:grid-cols-1 mx-auto pb-4 xl:pr-4 lg:pr-4 pt-4 sm:grid-cols-1 xl:grid-cols-3">

            <div class="flex flex-col items-center">
                <div :class="{ 'sticky top-0': modalClose }" class="w-full">
                    <!-- Product Image -->
                    @if($product->has_cover_color)
                        <div @modalclosed="makeSticky" @click="modalClose = false">
                            <x-frontend.lightbox>
                                <span x-html="productCoverColorImages[productCoverColorId]"></span>
                            </x-frontend.lightbox>
                        </div>
                    @else

                        <div @modalclosed="makeSticky" @click="modalClose = false">
                            <x-frontend.lightbox>
                                {{ $product->getFirstMedia('image')->img()->attributes(['class' => 'cursor-zoom-in lightbox mx-auto w-8/12 sm:6/12 lg:w-10/12']) }}
                            </x-frontend.lightbox>
                        </div>
                    @endif


                    <div class="w-full hidden md:block">
                        @include('livewire.bachelordruck.products.partials.cost')
                    </div>
                </div>
            </div>

            <div class="col-span-2 mt-0 md:mt-5">
                <div class="w-full sticky top-20 z-40 mb-5 block md:hidden">
                    @include('livewire.bachelordruck.products.partials.cost')
                </div>

                <p class="px-5 lg:px-0 font-bold text-2xl">{{ $product->title }}</p>
                <div class="striped__div">
                @if($product->isHardcoverBinding())
                    <!-- Cover Colors and Cover Imprint Colors -->
                    @include('livewire.bachelordruck.products.partials.cover-colors-and-cover-imprint-colors')

                    <!-- Book Spine Hardcover Binding -->
                    @if($product->has_book_spine_label)
                        @include('livewire.bachelordruck.products.partials.book-spine-hardcover-binding')
                    @endif
                @else
                    <!-- Cover Foils, Formats and Back Covers -->
                    @include('livewire.bachelordruck.products.partials.cover-foils-and-formats-and-back-covers')
                @endif

                <!-- Book Corners and Ribbon -->
                @if ($product->has_book_corners && $product->has_ribbon)
                    @include('livewire.bachelordruck.products.partials.book-corners-and-ribbon')
                @endif

                <!-- Paper Thicknesses -->
                @include('livewire.bachelordruck.products.partials.paper-thicknesses')

                <!-- Additional Services -->
                @include('livewire.bachelordruck.products.partials.additional-services')

                <!-- Notes -->
                    @include('livewire.bachelordruck.products.partials.notes')
                </div>
            </div>
        </div>
    </section>
</div>
