<?php

namespace Domain\Orders\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class ProductConfigurationData extends DataTransferObject
{
    public int $product_id;

    public bool $has_cover_color = false;

    public ?int $product_cover_color_id = null;

    public ?int $product_cover_imprint_color_id = null;

    public bool $has_book_spine_label = false;

    public ?int $product_book_spine_color_id = null;

    public ?string $book_spine_label = null;

    public float $book_spine_label_surcharge = 0;

    public bool $has_book_corners = false;

    public ?int $product_book_corner_color_id = null;

    public float $book_corners_surcharge = 0;

    public bool $has_ribbon = false;

    public ?int $product_ribbon_color_id = null;

    public float $book_ribbon_surcharge = 0;

    public ?int $product_paper_thickness_id = null;

    public ?int $total_number_of_pages = null;

    public ?int $number_of_colored_pages = null;

    public bool $double_sided_printing = false;

    public float $price_per_page_bw = 0;

    public float $price_per_page_color = 0;

    public array $additional_services = [];

    public array $additional_service_surcharges = [];

    public ?string $text_label_printing_cd = null;

    public ?int $product_cover_foil_id = null;

    public ?int $product_format_id = null;

    public ?int $product_back_cover_id = null;

    public array $details = [];

    public bool $include_print_file = false;

    public bool $use_print_file_from_first_item = false;

    public bool $use_cd_files_from_first_item = false;

    public bool $burn_to_cd = false;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        int $product_id,
        bool $has_cover_color = false,
        ?int $product_cover_color_id = null,
        ?int $product_cover_imprint_color_id = null,
        bool $has_book_spine_label = false,
        ?int $product_book_spine_color_id = null,
        ?string $book_spine_label = null,
        float $book_spine_label_surcharge = 0,
        bool $has_book_corners = false,
        ?int $product_book_corner_color_id = null,
        float $book_corners_surcharge = 0,
        bool $has_ribbon = false,
        ?int $product_ribbon_color_id = null,
        float $book_ribbon_surcharge = 0,
        ?int $product_paper_thickness_id = null,
        ?int $total_number_of_pages = null,
        ?int $number_of_colored_pages = null,
        bool $double_sided_printing = false,
        float $price_per_page_bw = 0,
        float $price_per_page_color = 0,
        array $additional_services = [],
        array $additional_service_surcharges = [],
        ?string $text_label_printing_cd = null,
        ?int $product_cover_foil_id = null,
        ?int $product_format_id = null,
        ?int $product_back_cover_id = null,
        bool $include_print_file = false,
        bool $use_print_file_from_first_item = false,
        bool $use_cd_files_from_first_item = false,
        bool $burn_to_cd = false,
    ): ProductConfigurationData {
        return new self(get_defined_vars());
    }
}
