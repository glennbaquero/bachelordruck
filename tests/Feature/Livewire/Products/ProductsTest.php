<?php

use App\Livewire\Domain\Products\Create\ProductCreate;
use App\Livewire\Domain\Products\Edit\ProductEdit;
use App\Livewire\Domain\Products\Lists\ProductsList;
use App\Livewire\Domain\Products\Show\ProductShow;
use Domain\Products\Models\Product;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads products list', function () {
    $this->webActingAs();

    $this->get(route('product.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductsList::class);
});

it('displays list of products', function () {
    $products = Product::factory()->count(20)->create();
    $component = livewire(ProductsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $products
            ->pluck('title')
            ->splice(0, 10)
            ->all()
    );
});

it('load create product route', function () {
    $this->webActingAs();

    $this->get(route('product.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductCreate::class);
});

it('create a product', function () {
    $this->webActingAs();

    /** @var Product $product */
    $product = Product::factory()->make();

    $component = livewire(ProductCreate::class)
        ->set('product.slug', $product->slug)
        ->set('product.title', $product->title)
        ->set('product.tooltip', $product->tooltip)
        ->set('product.description', $product->description)
        ->set('product.price', $product->price)
        ->set('product.has_cover_color', $product->has_cover_color)
        ->set('product.has_cover_imprint_color', $product->has_cover_imprint_color)
        ->set('product.has_cover_foil', $product->has_cover_foil)
        ->set('product.has_back_cover', $product->has_back_cover)
        ->set('product.has_book_spine_label', $product->has_book_spine_label)
        ->set('product.book_spine_label_surcharge', $product->book_spine_label_surcharge)
        ->set('product.has_book_corners', $product->has_book_corners)
        ->set('product.book_corners_surcharge', $product->book_corners_surcharge)
        ->set('product.has_ribbon', $product->has_ribbon)
        ->set('product.ribbon_surcharge', $product->ribbon_surcharge)
        ->set('product.sort', $product->sort)
        ->set('product.status', $product->status)
        ->call('create');

    $component->assertRedirect(route('product.show', ['model' => $component->product->id]))
            ->assertSessionHas('message');

    $productArray = $product->toArray();

    $productArray['price'] *= 100;
    $productArray['book_spine_label_surcharge'] *= 100;
    $productArray['book_corners_surcharge'] *= 100;
    $productArray['ribbon_surcharge'] *= 100;

    unset($productArray['label']);

    $this->assertDatabaseHas('products', $productArray);
});

it('shows product', function () {
    UserLanguageSessionHelper::set('en');

    $this->webActingAs();

    /** @var Product $product */
    $product = Product::factory()->create();

    $this->get(route('product.show', ['model' => $product->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductShow::class)
        ->assertSee([
            'Title',
            'Tooltip',
            'Description',
        ])
        ->assertSee([
            $product->title,
            $product->tooltip,
            $product->description,
        ]);
});

it('load product edit route', function () {
    UserLanguageSessionHelper::set('en');

    $this->webActingAs();

    /** @var Product $product */
    $product = Product::factory()->create();

    $this->get(route('product.edit', ['model' => $product->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductEdit::class)
        ->assertSee([
            'Title',
            'Tooltip',
            'Description',
        ])
        ->assertSee([
            $product->title,
            $product->tooltip,
            $product->description,
        ]);
});

it('update product', function () {
    $this->webActingAs();

    $product = Product::factory()->create([
        'title' => 'Product Title',
    ]);

    livewire(ProductEdit::class, ['model' => $product->id])
        ->set('product.title', 'Product Title Updated')
        ->call('update')
        ->assertRedirect(route('product.list'))
        ->assertSessionHas('message');

    $product->refresh();

    expect($product)
        ->title->toBe('Product Title Updated');
});
