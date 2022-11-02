<?php

namespace App\Livewire\Bachelordruck;

use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\Actions\OrderCompleteAction;
use Domain\Orders\Actions\OrderPositionConfigurationUpdateAction;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Jobs\SendOrderCompleteMail;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderPosition;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Support\Traits\HasRemoveMedia;
use function view;

class UploadCenter extends Component
{
    use DefaultLayoutDataTrait;
    use WithMedia;
    use HasRemoveMedia;

    public string $name = 'uploadCenter';

    public string $sessionId = 'uploadCenter';

    public string $language;

    public $items;

    public array $includePrintFiles = [];

    public array $usePrintFileFromFirstItem = [];

    public array $useCdFilesFromFirstItem = [];

    public Order $order;

    public function mount(string $language, string $sessionId): void
    {
        $this->language = $language;
        $this->sessionId = $sessionId;

        $this->loadData();

        $this->setCheckboxesData();
    }

    protected function loadData()
    {
        if (isset($this->order)) {
            return;
        }

        $this->order = cache()->remember($this->getOrderCacheName(), now()->addMinutes(5), function () {
            return Order::query()
                ->select([
                    'id',
                    'session_id',
                    'payment',
                    'status',
                    'completed_at',
                ])
                ->where('session_id', $this->sessionId)
                ->first();
        });

        $this->order->load([
            'orderPositions.product.media',
            'orderPositions.media:id,model_id,file_name,size,collection_name,disk,model_type,uuid',
        ]);

        foreach ($this->order->orderPositions as $orderPosition) {
            foreach ($orderPosition->media as $media) {
                $media->append('signed_url');
            }
        }

        $this->items = $this->order->orderPositions;
    }

    private function getOrderCacheName(): string
    {
        return 'upload_center.order.'.$this->sessionId;
    }

    private function setCheckboxesData()
    {
        foreach ($this->items as $item) {
            $this->includePrintFiles[$item->id] = $item->configuration['include_print_file'];
            $this->usePrintFileFromFirstItem[$item->id] = $item->configuration['use_print_file_from_first_item'];
            $this->useCdFilesFromFirstItem[$item->id] = $item->configuration['use_cd_files_from_first_item'];
        }
    }

    public function updateIncludePrintFiles(int $orderPositionId, bool $currentState)
    {
        $orderPosition = OrderPosition::find($orderPositionId);
        app(OrderPositionConfigurationUpdateAction::class)($orderPosition, ['include_print_file' => ! $currentState]);
    }

    public function updateUsePrintFileFromFirstItem(int $orderPositionId, bool $currentState)
    {
        $orderPosition = OrderPosition::find($orderPositionId);
        app(OrderPositionConfigurationUpdateAction::class)($orderPosition, ['use_print_file_from_first_item' => ! $currentState]);
    }

    public function updateUseCdFilesFromFirstItem(int $orderPositionId, bool $currentState)
    {
        $orderPosition = OrderPosition::find($orderPositionId);
        app(OrderPositionConfigurationUpdateAction::class)($orderPosition, ['use_cd_files_from_first_item' => ! $currentState]);
    }

    public function complete()
    {
        $this->loadData();

        $this->validateFiles();

        $this->order = app(OrderCompleteAction::class)($this->order);

        SendOrderCompleteMail::dispatch($this->order);

        cache()->forget($this->getOrderCacheName());
    }

    public function render(): View
    {
        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.orders.upload-center', [
        ])
            ->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language))
            ->slot('livewireContent');
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws ValidationException
     */
    private function validateFiles(): void
    {
        $errors = [];

        /** @var OrderPosition $orderPosition */
        foreach ($this->order->orderPositions as $orderPosition) {
            $configuration = new ProductConfigurationData($orderPosition->configuration);

            if (! $configuration->use_print_file_from_first_item && $orderPosition->getMedia('thesis')->count() === 0) {
                $errors[] = __('Print file is required');
            }

            if (! empty($configuration->product_cover_imprint_color_id) && $orderPosition->getMedia('cover-imprint')->count() === 0) {
                $errors[] = __('Cover Imprint file is required');
            }

            if ($configuration->burn_to_cd && ! $configuration->use_cd_files_from_first_item && $orderPosition->getMedia('cd')->count() === 0) {
                $errors[] = __('CD Files are required');
            }
        }

        if (count($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
