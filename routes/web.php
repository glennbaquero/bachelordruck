<?php

use App\Helpers\RouteHelpers;
use Domain\Pages\Models\Page;
use Illuminate\Support\Facades\Route;
use Support\Helpers\UserLanguageSessionHelper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test/pages', function () {
    dump(
        Page::with([
            'ancestors:id',
            'pagesLanguage' => function ($query) {
                $query->where('language_id', 1);
            },
        ])
        ->get(['id', 'parent_id', '_lft', '_rgt'])->toTree()->toArray()
    );
});

Route::get('/dev', function () {
    UserLanguageSessionHelper::set('en');

    return view('devtest');
});

Route::middleware(['auth', 'backend.language'])->group(function () {
    Route::get('/users', \App\Livewire\Domain\Users\Lists\UsersList::class)->name('user.list');
    Route::get('/users/create', \App\Livewire\Domain\Users\Create\UserCreate::class)->name('user.create');
    Route::get('/users/{model}', \App\Livewire\Domain\Users\Show\UserShow::class)->name('user.show');
    Route::get('/users/{model}/edit', \App\Livewire\Domain\Users\Edit\UserEdit::class)->name('user.edit');
    Route::get('/users/{model}/change_password', \App\Livewire\Domain\Users\Edit\UserChangePassword::class)->name('user.change_password');

    Route::get('/banners', \App\Livewire\Domain\Banners\Lists\BannersList::class)->name('banner.list');
    Route::get('/banners/create', \App\Livewire\Domain\Banners\Create\BannerCreate::class)->name('banner.create');
    Route::get('/banners/{model}', \App\Livewire\Domain\Banners\Show\BannerShow::class)->name('banner.show');
    Route::get('/banners/{model}/edit', \App\Livewire\Domain\Banners\Edit\BannerEdit::class)->name('banner.edit');

    Route::get('/pages', \App\Livewire\Domain\Pages\Lists\PagesList::class)->name('page.list');
    Route::get('/pages/create', \App\Livewire\Domain\Pages\Create\PageCreate::class)->name('page.create');
    Route::get('/pages/{model}', \App\Livewire\Domain\Pages\Show\PageShow::class)->name('page.show');
    Route::get('/pages/{model}/edit', \App\Livewire\Domain\Pages\Edit\PageEdit::class)->name('page.edit');

    Route::get('/pages/{pageLanguage}/containers', \App\Livewire\Domain\Pages\Containers::class)->name('page.containers');
    Route::get('/pages/{pageLanguage}/copy_containers', \App\Livewire\Domain\Pages\CopyContainers::class)->name('page.copy_containers');

    Route::get('/galleries', \App\Livewire\Domain\Galleries\Lists\GalleryList::class)->name('gallery.list');
    Route::get('/galleries/create', \App\Livewire\Domain\Galleries\Create\GalleryCreate::class)->name('gallery.create');
    Route::get('/galleries/{model}/edit', \App\Livewire\Domain\Galleries\Edit\GalleryEdit::class)->name('gallery.edit');
    Route::get('/galleries/{model}', \App\Livewire\Domain\Galleries\Show\GalleryShow::class)->name('gallery.show');

    Route::get('/news', \App\Livewire\Domain\News\Lists\NewsList::class)->name('news.list');
    Route::get('/news/create', \App\Livewire\Domain\News\Create\NewsCreate::class)->name('news.create');
    Route::get('/news/{model}/edit', \App\Livewire\Domain\News\Edit\NewsEdit::class)->name('news.edit');
    Route::get('/news/{model}', \App\Livewire\Domain\News\Show\NewsShow::class)->name('news.show');

    Route::get('/orders', \App\Livewire\Domain\Orders\Lists\OrdersList::class)->name('order.list');
    Route::get('/orders/{model}', \App\Livewire\Domain\Orders\Show\OrderShow::class)->name('order.show');
    Route::get('/orders/{model}/edit', \App\Livewire\Domain\Orders\Edit\OrdersEdit::class)->name('order.edit');

    Route::get('user/languages/{languageCode}', \App\Languages\Controllers\LanguageController::class)->name('user.language');

    RouteHelpers::includeLivewireRoutes('Products');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-cover-color-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-book-spine-color-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-ribbon-color-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-book-corner-color-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-paper-thickness-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-format-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-cover-foil-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-back-cover-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'product-cover-imprint-color-routes.php');
    RouteHelpers::includeLivewireRoutes('Products', filename: 'additional-service-routes.php');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::mediaLibrary();

Route::get('/files/upload', [\App\Services\UploadFile::class, 'checkChunk'])->name('files-upload.check');
Route::get('/files/upload/{media:uuid}/download/{fileName}', [\App\Services\UploadFile::class, 'download'])->name('files-upload.download');
Route::post('/files/upload', \App\Services\UploadFile::class)->name('files-upload.upload');

require __DIR__.'/auth.php';

Route::middleware(['frontend.language'])->group(function () {
    Route::get('/{language}/facharbeit-drucken-und-binden-lassen/{product:slug}/{basketId?}/{newVariantSlug?}', \App\Livewire\Bachelordruck\ConfigureProduct::class)->name('product.configure');

    Route::get('/{language}/warenkorb', \App\Livewire\Bachelordruck\BasketItems::class)->name('order.basket-items');
    Route::get('/{language}/warenkorb/kontaktdaten', \App\Livewire\Bachelordruck\ContactDetails::class)->name('order.contact-details');
    Route::get('/{language}/warenkorb/leiferung-und-zahlungsmethode', \App\Livewire\Bachelordruck\OrderPayment::class)->name('order.payment');
    Route::get('/{language}/warenkorb/{sessionId}/bestattigung-und-datenupload', \App\Livewire\Bachelordruck\ConfirmationAndDataUpload::class)->name('order.confirmation-and-data-upload');
    Route::get('/{language}/warenkorb/{sessionId}/datenubergabe', \App\Livewire\Bachelordruck\UploadCenter::class)->name('order.upload-center');

    Route::get('{language}/contact-us', [\App\Pages\Controllers\Frontend\PageController::class, 'getContact'])->name('contact');
    Route::get('/media/{media}/download', [\App\Media\Controllers\MediaController::class, 'download'])->name('media.download');
    Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

    Route::get('/renew_session', \App\Http\Controllers\RenewSessionController::class)->name('renew_session');

    Route::get('/{language}', [\App\Pages\Controllers\Frontend\PageController::class, 'index'])->name('page.home')
        ->where('language', 'en|de');
    Route::get('/{language}/news', [\App\News\Controllers\Frontend\NewsController::class, 'index']);
    Route::get('/{language}/news/{slug}', [\App\News\Controllers\Frontend\NewsController::class, 'slug'])->name('news.slug');
    Route::get('/{language}/galleries', [\App\Gallery\Controllers\Frontend\GalleryController::class, 'index']);
    Route::get('/{language}/galleries/{gallery:slug}', [\App\Gallery\Controllers\Frontend\GalleryController::class, 'gallery'])->name('gallery.detail');
    Route::get('{language}/{page?}', [\App\Pages\Controllers\Frontend\PageController::class, 'index'])->name('page')
        ->where('language', 'en|de');
    Route::post('{language}/{page?}', [\App\Pages\Controllers\Frontend\PageController::class, 'postPage'])->name('post.page')
        ->where('language', 'en|de');
    Route::get('/frontend/banner/{page}', [\App\Banners\Controllers\Frontend\BannerController::class, 'banner']);

    Route::get('/{language}/{any?}', [\App\Pages\Controllers\Frontend\PageController::class, 'any'])->where('any', '.+')->name('any.page');
});
