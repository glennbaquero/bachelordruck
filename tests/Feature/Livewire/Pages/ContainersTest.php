<?php

use App\Livewire\Domain\Pages\Containers;
use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Models\Container;
use Domain\Pages\Enums\ImageAlignmentEnum;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\Helpers\UserLanguageSessionHelper;

function createContainerComponent(): TestableLivewire
{
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();

    Container::factory()->create([
        'sort' => 1,
        'title' => 'Container Title 1',
        'image_alignment' => null,
        'content' => 'Container Content 1',
        'type' => ContainerTypeEnum::HEADLINE_TEXT->value,
        'pages_language_id' => $pageLanguage->id,
        'url' => null,
    ]);

    $pageLanguage->load('containers');

    return livewire(Containers::class, [$pageLanguage]);
}

function createMediaArray(): array
{
    Storage::fake('images');

    config()->set('filesystems.disks.images', [
        'driver' => 'local',
        'root' => Storage::disk('images')->getConfig(),
    ]);

    config()->set('media-library.disk_name', 'images');

    $temporaryUploadModelClass = config('media-library.temporary_upload_model');

    $uploadedFile = UploadedFile::fake()->image('image.png');

    $livewireUpload = $temporaryUploadModelClass::createForFile(
        $uploadedFile,
        session()->getId(),
        (string) Str::uuid(),
        'image.png',
    );

    /** @var Media $media */
    $media = $livewireUpload->getFirstMedia();

    return [
        $media['uuid'] => [
            'name' => $media->name,
            'fileName' => $media->file_name,
            'oldUuid' => (string) Str::uuid(),
            'uuid' => $media->uuid,
            'previewUrl' => $media->hasGeneratedConversion('preview') ? $media->getUrl('preview') : '',
            'order' => $media->order_column,
            'size' => $media->size,
            'mime_type' => $media->mime_type,
            'extension' => pathinfo($media->file_name, PATHINFO_EXTENSION),
        ],
    ];
}

it('loads containers list', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();

    $containerHeadlineText = Container::factory()->create([
        'sort' => 1,
        'title' => 'Container Title 1',
        'image_alignment' => null,
        'content' => 'Container Content 1',
        'type' => ContainerTypeEnum::HEADLINE_TEXT->value,
        'pages_language_id' => $pageLanguage->id,
        'url' => null,
    ]);

    /** @var Container $containerHeadlineTextImage */
    $containerHeadlineTextImage = Container::factory()->create([
        'sort' => 1,
        'title' => 'Container Title 2',
        'image_alignment' => ImageAlignmentEnum::LEFT->value,
        'content' => 'Container Content 2',
        'type' => ContainerTypeEnum::HEADLINE_TEXT_IMAGE->value,
        'pages_language_id' => $pageLanguage->id,
        'url' => null,
    ]);

    attachMediaToModel($containerHeadlineTextImage);

    $this->get(route('page.containers', $pageLanguage))
        ->assertOk()
        ->assertSeeText('Container Title 1')
        ->assertSeeText('Container Content 1')
        ->assertSeeText('Container Title 2')
        ->assertSeeText('Container Content 2')
        ->assertSee($containerHeadlineTextImage->getFirstMediaUrl('images'))
        ->assertSeeLivewire(Containers::class);
});

it('it can validates and insert a new youtube url container', function () {
    $component = createContainerComponent();

    $component->call('insertNewContainer', ContainerTypeEnum::YOUTUBE_VIDEO->value);

    $containers = $component->get('containers');

    expect($containers)->toHaveCount(2);

    expect($containers[1])
        ->id->toBeNull()
        ->title->toBeNull()
        ->content->toBeNull()
        ->image_alignment->toBeNull()
        ->type->toBe(ContainerTypeEnum::YOUTUBE_VIDEO);

    expect(Container::all())->toHaveCount(1);

    // Validate that the title, content and image are required
    $component->call('save');
    $component->assertHasErrors([
        'container.url' => 'required',
    ]);

    $component->set('container.url', 'https://www.youtube.com/watch?v=HmZKgaHa3Fg');
    $component->call('save');

    expect(Container::all())->toHaveCount(2);

    $savedContainer = Container::query()->latest('id')->first();

    expect($savedContainer)->url->toBe('https://www.youtube.com/watch?v=HmZKgaHa3Fg');

    $component->assertSee('https://www.youtube-nocookie.com/embed/HmZKgaHa3Fg');
});

it('it can validates and insert a new headline text container', function () {
    $component = createContainerComponent();

    $component->call('insertNewContainer', ContainerTypeEnum::HEADLINE_TEXT->value);
    $containers = $component->get('containers');

    expect($containers)->toHaveCount(2);

    expect($containers[1])
        ->id->toBeNull()
        ->title->toBeNull()
        ->content->toBeNull()
        ->image_alignment->toBeNull()
        ->type->toBe(ContainerTypeEnum::HEADLINE_TEXT);

    expect(Container::all())->toHaveCount(1);

    // Validate that the title, content and image are required
    $component->call('save');
    $component->assertHasErrors([
        'container.content' => 'required',
    ]);

    $component->set('container.title', 'Test Title');
    $component->set('container.content', 'Test Content');
    $component->call('save');

    expect(Container::all())->toHaveCount(2);

    $savedContainer = Container::query()->latest('id')->first();

    expect($savedContainer)->title->toBe('Test Title');

    $component->assertSee('Test Title');
    $component->assertSee('Test Content');
});

it('it can validates and insert a new headline text image container', function () {
    $component = createContainerComponent();

    $component->call('insertNewContainer', ContainerTypeEnum::HEADLINE_TEXT_IMAGE->value);
    $containers = $component->get('containers');

    expect($containers)->toHaveCount(2);

    expect($containers[1])
        ->id->toBeNull()
        ->title->toBeNull()
        ->content->toBeNull()
        ->image_alignment->toBe(ImageAlignmentEnum::RIGHT->value)
        ->type->toBe(ContainerTypeEnum::HEADLINE_TEXT_IMAGE);

    $mediaArray = createMediaArray();

    expect(Container::all())->toHaveCount(1);

    // Validate that the title, content and image are required
    $component->call('save');
    $component->assertHasErrors([
        //        'container.title' => 'required',
        'container.content' => 'required',
        'container.image' => 'required',
    ]);

    $component->set('container.title', 'Test Title');
    $component->set('container.content', 'Test Content');
    $component->set('images', $mediaArray);
    $component->call('save');

    expect(Container::all())->toHaveCount(2);

    $savedContainer = Container::query()->latest('id')->first();

    $url = $savedContainer->getFirstMediaUrl('images');

    expect($savedContainer)->title->toBe('Test Title');

    $component->assertSee('Test Title');
    $component->assertSee('Test Content');
    $component->assertSee($url);
});

it('it can validate and insert an image container', function () {
    $component = createContainerComponent();

    $component->call('insertNewContainer', ContainerTypeEnum::IMAGE->value);
    $containers = $component->get('containers');

    expect($containers)->toHaveCount(2);

    expect($containers[1])
        ->id->toBeNull()
        ->title->toBeNull()
        ->content->toBeNull()
        ->image_alignment->toBe(ImageAlignmentEnum::RIGHT->value)
        ->type->toBe(ContainerTypeEnum::IMAGE);

    $mediaArray = createMediaArray();

    expect(Container::all())->toHaveCount(1);

    // Validate that an image is required
    $component->call('save');
    $component->assertHasErrors(['container.image' => 'required']);

    // Supply image and save
    $component->set('images', $mediaArray);
    $component->call('save');

    expect(Container::all())->toHaveCount(2);

    $savedContainer = Container::query()->latest('id')->first();

    $url = $savedContainer->getFirstMediaUrl('images');

    // Check if the image has been rendered.
    $component->assertSee($url);
});

it('it can validates and insert a new headline, text and youtube url container', function () {
    $component = createContainerComponent();

    $component->call('insertNewContainer', ContainerTypeEnum::HEADLINE_TEXT_YOUTUBE_VIDEO->value);
    $containers = $component->get('containers');

    expect($containers)->toHaveCount(2);

    expect($containers[1])
        ->id->toBeNull()
        ->title->toBeNull()
        ->content->toBeNull()
        ->image_alignment->toBeNull()
        ->type->toBe(ContainerTypeEnum::HEADLINE_TEXT_YOUTUBE_VIDEO);

    expect(Container::all())->toHaveCount(1);

    // Validate that the title, content and image are required
    $component->call('save');
    $component->assertHasErrors([
        'container.title' => 'required',
        'container.content' => 'required',
        'container.url' => 'required',
    ]);

    $component->set('container.title', 'Test Title');
    $component->set('container.content', 'Test Content');
    $component->set('container.url', 'https://www.youtube.com/watch?v=HmZKgaHa3Fg');
    $component->call('save');

    expect(Container::all())->toHaveCount(2);

    $savedContainer = Container::query()->latest('id')->first();

    expect($savedContainer)->title->toBe('Test Title')
        ->url->toBe('https://www.youtube.com/watch?v=HmZKgaHa3Fg');

    $component->assertSee('Test Title');
    $component->assertSee('Test Content');
    $component->assertSee('https://www.youtube-nocookie.com/embed/HmZKgaHa3Fg');
});
