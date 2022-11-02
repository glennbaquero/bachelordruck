<?php

namespace Domain\Products\Models;

use Database\Factories\ProductFactory;
use Domain\Orders\Models\OrderPosition;
use Domain\Products\Enums\ProductBindingEnum;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Domain\Products\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Support\Castables\IntegerCurrency;
use Support\Helpers\Decimals;

/**
 * \Domain\Products\Models\Product
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $tooltip short description for list tooltip
 * @property string $description long richtext description for detail page
 * @property int $price cheapest possible price [Cents]
 * @property bool $has_cover_color
 * @property bool $has_cover_imprint_color
 * @property bool $has_cover_foil
 * @property bool $has_back_cover
 * @property bool $has_book_spine_label
 * @property int $book_spine_label_surcharge Surcharge in [Cents]
 * @property bool $has_book_corners
 * @property int $book_corners_surcharge Surcharge in [Cents]
 * @property bool $has_ribbon
 * @property int $ribbon_surcharge Surcharge in [Cents]
 * @property int $sort field for order by
 * @property StatusEnum $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product search(string $searchTerm)
 * @method static Builder|Product whereBookCornersSurcharge($value)
 * @method static Builder|Product whereBookSpineLabelSurcharge($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereHasBackCover($value)
 * @method static Builder|Product whereHasBookCorners($value)
 * @method static Builder|Product whereHasBookSpineLabel($value)
 * @method static Builder|Product whereHasCoverColor($value)
 * @method static Builder|Product whereHasCoverFoil($value)
 * @method static Builder|Product whereHasCoverImprintColor($value)
 * @method static Builder|Product whereHasRibbon($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereRibbonSurcharge($value)
 * @method static Builder|Product whereSort($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereTooltip($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|OrderPosition[] $orderPositions
 * @property-read int|null $order_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductBookSpineColor[] $productBookSpineColors
 * @property-read int|null $product_book_spine_colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductCoverColor[] $productCoverColors
 * @property-read int|null $product_cover_colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductFormat[] $productFormats
 * @property-read int|null $product_formats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductPaperThickness[] $productPaperThicknesses
 * @property-read int|null $product_paper_thicknesses_count
 *
 * @method static ProductQueryBuilder|Product sortedActive()
 * @method static ProductQueryBuilder|Product whereSlug($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductBookSpineColor[] $activeProductBookSpineColors
 * @property-read int|null $active_product_book_spine_colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductCoverColor[] $activeProductCoverColors
 * @property-read int|null $active_product_cover_colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductFormat[] $activeProductFormats
 * @property-read int|null $active_product_formats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\ProductPaperThickness[] $activeProductPaperThicknesses
 * @property-read int|null $active_product_paper_thicknesses_count
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use MediaTrait;

    protected $fillable = [
        'slug',
        'title',
        'tooltip',
        'description',
        'price',
        'has_cover_color',
        'has_cover_imprint_color',
        'has_cover_foil',
        'has_back_cover',
        'has_book_spine_label',
        'book_spine_label_surcharge',
        'has_book_corners',
        'book_corners_surcharge',
        'has_ribbon',
        'ribbon_surcharge',
        'sort',
        'status',
    ];

    protected $casts = [
        'slug' => 'string',
        'title' => 'string',
        'tooltip' => 'string',
        'description' => 'string',
        'price' => IntegerCurrency::class,
        'has_cover_color' => 'boolean',
        'has_cover_imprint_color' => 'boolean',
        'has_cover_foil' => 'boolean',
        'has_back_cover' => 'boolean',
        'has_book_spine_label' => 'boolean',
        'book_spine_label_surcharge' => IntegerCurrency::class,
        'has_book_corners' => 'boolean',
        'book_corners_surcharge' => IntegerCurrency::class,
        'has_ribbon' => 'boolean',
        'ribbon_surcharge' => IntegerCurrency::class,
        'sort' => 'integer',
        'status' => StatusEnum::class,
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('title', 'LIKE', '%'.$searchTerm.'%');
//                     ->orWhere('xyz', 'LIKE', '%'.$searchTerm.'%')
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function getLabelAttribute(): string
    {
        return $this->title ?? '';
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['label'] = $this->label;

        return $array;
    }

    protected function hasManySortedActive(HasMany $relations): HasMany
    {
        return $relations->where('status', StatusEnum::ACTIVE->value)
            ->orderBy('sort');
    }

    public function productPaperThicknesses(): HasMany
    {
        return $this->hasMany(ProductPaperThickness::class);
    }

    public function activeProductPaperThicknesses(): HasMany
    {
        return $this->hasManySortedActive($this->productPaperThicknesses());
    }

    public function productCoverColors(): HasMany
    {
        return $this->hasMany(ProductCoverColor::class);
    }

    public function activeProductCoverColors(): HasMany
    {
        return $this->hasManySortedActive($this->productCoverColors());
    }

    public function productBookSpineColors(): HasMany
    {
        return $this->hasMany(ProductBookSpineColor::class);
    }

    public function activeProductBookSpineColors(): HasMany
    {
        return $this->hasManySortedActive($this->productBookSpineColors());
    }

    public function productFormats(): HasMany
    {
        return $this->hasMany(ProductFormat::class);
    }

    public function activeProductFormats(): HasMany
    {
        return $this->hasManySortedActive($this->productFormats());
    }

    public static function query(): ProductQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    /**
     * @throws \Exception
     */
    public function priceFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->price);
    }

    /**
     * @throws \Exception
     */
    public function bookSpineLabelSurchargeFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->book_spine_label_surcharge);
    }

    public function bookCornersSurchargeFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->book_corners_surcharge);
    }

    public function ribbonSurchargeFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->ribbon_surcharge);
    }

    public function orderPositions(): HasMany
    {
        return $this->hasMany(OrderPosition::class);
    }

    public function withBookSpineLabel(): Attribute
    {
        return Attribute::get(function () {
            return "Mit Buchrückenbeschriftung \n + ".
                $this->bookSpineLabelSurchargeFormatted.
                ' €';
        });
    }

    public function bookCornersLabel(): Attribute
    {
        return Attribute::get(function () {
            return 'Mit Buchecken + '.
                $this->bookCornersSurchargeFormatted.
                ' €';
        });
    }

    public function ribbonLabel(): Attribute
    {
        return Attribute::get(function () {
            return 'Mit Leseband + '.
                $this->ribbonSurchargeFormatted.
                ' €';
        });
    }

    public function binding(): ProductBindingEnum
    {
        if ($this->has_cover_foil && $this->has_book_spine_label) {
            return ProductBindingEnum::PERFECT;
        }

        if ($this->has_cover_foil && ! $this->has_book_spine_label) {
            return ProductBindingEnum::PLASTIC_SPIRAL;
        }

        return ProductBindingEnum::HARDCOVER;
    }

    public function isHardcoverBinding(): bool
    {
        return $this->has_cover_color;
    }

    public function isPlasticSpiralBinding(): bool
    {
        return $this->has_cover_foil && ! $this->has_book_spine_label;
    }

    public function isPerfectBinding(): bool
    {
        return $this->has_cover_foil && $this->has_book_spine_label;
    }
}
