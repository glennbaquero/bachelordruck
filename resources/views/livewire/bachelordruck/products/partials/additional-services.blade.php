<div class="grid grid-cols-1 lg:gap-40 md:gap-40 p-5 pl-5 xl:gap-40 ">
    <div class="col-span-1">
        <p class="inline-flex font-bold text-title my-2">
            CD Klebehülle*
        </p>
        <div class="gap-5 flex flex-wrap">
            @foreach($additionalServices as $additionalService)
                <div class="col-span-1 my-2">
                    <x-frontend.checkbox
                        x-model="additionalServices"
                        id="{{ 'additional-service' . $loop->index }}"
                        name="additional-service"
                        :label="$additionalService->titleWithSurcharge"
                        :value="$additionalService->id"
                        @click="checkRequiresCd({{ $additionalService->id }})"
                    ></x-frontend.checkbox>
                </div>
            @endforeach
        </div>
        <div x-show="displayTextCdLabel" class="col-span-full">
            <p class="font-bold text-normal my-2">Text Labeldruck CD</p>
            <textarea wire:model.defer="productConfiguration.text_label_printing_cd" rows="4"
                      class="md:w-1/3 sm:w-full xs:w-full w-full"></textarea>
        </div>
    </div>
</div>
