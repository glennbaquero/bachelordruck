<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\AdditionalService;
use Spatie\DataTransferObject\DataTransferObject;

class AdditionalServiceData extends DataTransferObject
{
    public string $title;

    public string $tooltip;

    public float $surcharge;

    public int $sort;

    public StatusEnum $status;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $title,
        string $tooltip,
        int $surcharge,
        int $sort = 0,
        StatusEnum $status = StatusEnum::DRAFT,
    ): AdditionalServiceData {
        return new self(get_defined_vars());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromModel(AdditionalService $additionalService): AdditionalServiceData
    {
        return new self(
            title: $additionalService->title,
            tooltip: $additionalService->tooltip,
            surcharge: $additionalService->surcharge,
            sort: $additionalService->sort,
            status: $additionalService->status,
        );
    }
}
