<?php

use App\Livewire\Domain\Products\Create\AdditionalServiceCreate;
use App\Livewire\Domain\Products\Edit\AdditionalServiceEdit;
use App\Livewire\Domain\Products\Lists\AdditionalServicesList;
use App\Livewire\Domain\Products\Show\AdditionalServiceShow;
use Domain\Products\Models\AdditionalService;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

function additionalServiceHasParent(): bool
{
    return false;
}

it('loads additionalServices list', function () {
    $this->webActingAs();

    $this->get(route('additional_service.list'))
        ->assertOk()
        ->assertSeeLivewire(AdditionalServicesList::class);
});

it('displays list of additionalServices', function () {
    $additionalServices = AdditionalService::factory()->count(20)->create();
    $component = livewire(AdditionalServicesList::class);

    expect($component->get('createRoute'))
        ->toBe(route('additional_service.create'));

    expect($component->get('rows'))
        ->toHaveCount(additionalServiceHasParent() ? 1 : $component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $additionalServices
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create additionalService route', function () {
    $this->webActingAs();

    $this->get(route('additional_service.create'))
        ->assertOk()
        ->assertSeeLivewire(AdditionalServiceCreate::class);
});

it('create a additionalService', function () {
    $this->webActingAs();

    /** @var AdditionalService $additionalService */
    $additionalService = AdditionalService::factory()->make();

    $component = livewire(AdditionalServiceCreate::class)
        ->set('additionalService.title', $additionalService->title)
        ->set('additionalService.tooltip', $additionalService->tooltip)
        ->set('additionalService.surcharge', $additionalService->surcharge)
        ->set('additionalService.sort', $additionalService->sort)
        ->set('additionalService.status', $additionalService->status)
        ->call('create');

    $component->assertRedirect(route('additional_service.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('additional_services', [
        'title' => $additionalService->title,
        'tooltip' => $additionalService->tooltip,
        'surcharge' => $additionalService->surcharge * 100,
        'sort' => $additionalService->sort,
        'status' => $additionalService->status,
    ]);
});

it('shows additionalService', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $additionalService = AdditionalService::factory()->create();

    $this->get(route('additional_service.show', ['model' => $additionalService->id]))
        ->assertOk()
        ->assertSeeLivewire(AdditionalServiceShow::class)
        ->assertSee([
            'Title',
            'Tooltip',
            // Add other fields that are being displayed
        ])
        ->assertSee([
            $additionalService->title,
            $additionalService->tooltip,
        ]);
});

it('load edit additionalService route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $additionalService = AdditionalService::factory()->create();

    $this->get(route('additional_service.edit', ['model' => $additionalService->id]))
        ->assertOk()
        ->assertSeeLivewire(AdditionalServiceEdit::class)
        ->assertSee([
            'Title',
            'Tooltip',
        ])
        ->assertSee([
            $additionalService->title,
            $additionalService->tooltip,
        ]);
});

it('update additionalService', function () {
    $additionalService = AdditionalService::factory()->create([
        'title' => 'Title',
    ]);

    livewire(AdditionalServiceEdit::class, [
        'model' => $additionalService->id,
    ])
        ->set('additionalService.title', 'New title')
        ->call('update')
        ->assertRedirect(route('additional_service.list'))
        ->assertSessionHas('message');

    $additionalService->refresh();

    expect($additionalService)
        ->title->toBe('New title');
});
