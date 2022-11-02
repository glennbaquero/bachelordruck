<?php

namespace Domain\Pages\Models;

use Domain\Banners\Models\Banner;
use Domain\Galleries\Models\Gallery;
use Domain\Pages\Helpers\PageTreeHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Page extends Model
{
    use NodeTrait;

    protected $guarded = [];

    public function label(): Attribute
    {
        $this->loadMissing('pagesLanguage.language');

        return Attribute::get(function () {
            return $this->pagesLanguage->map(function ($pageLanguage) {
                return $pageLanguage->getNameWithLanguageCode();
            })->implode(' | ');
        });
    }

    public function pagesLanguage()
    {
        return $this->hasMany(PageLanguage::class);
    }

    public static function getSelectTree(): array
    {
        $helper = new PageTreeHelper();

        return $helper->getSelectTree();
    }

    public function banner()
    {
        return $this->hasOne(Banner::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class)->orderBy('sort');
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['label'] = $this->label;

        return $array;
    }
}
