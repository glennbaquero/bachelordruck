<?php

namespace App\Livewire\Base;

use Domain\Settings\Actions\SettingStoreAction;
use Illuminate\Support\Str;
use Livewire\Component;
use Support\Helpers\ModelHelpers;

class Setting extends Component
{
    public array $form;

    public string $model;

    public array $settings;

    public function mount(string $model): void
    {
        $this->model = $model;
        \Domain\Settings\Models\Setting::all()->filter(fn ($setting) => Str::startsWith($setting->token, $model))
            ->each(function ($setting) {
                [$model, $token] = explode('.', $setting->token);
                $this->settings[$model][$token] = $setting->payload;
            });

        $this->form = app($this->getForm())->getForm()->toArray();
        $this->form['elements'] = $this->caster($this->form['elements']);
    }

    private function caster(array $elements): array
    {
        foreach ($elements as $key => $element) {
            if (array_key_exists('elements', $element)) {
                $elements[$key]['elements'] = $this->caster($element['elements']);
            }

            if (array_key_exists('cast', $element)) {
                $elements[$key]['cast'] = $element['cast']->value;
            }

            if (array_key_exists('key', $element)) {
                $elements[$key]['key'] = $element['key']->value;
            }

            if (array_key_exists('depends', $element)) {
                if ($element['depends']) {
                    $elements[$key]['depends']['key'] = $element['depends']['key']->value;
                }
            }
        }

        return $elements;
    }

    public function update(SettingStoreAction $settingStoreAction): void
    {
        $data = [];
        foreach (array_keys($this->settings[$this->model]) as $token) {
            $data[$this->model.'.'.$token] = $this->settings[$this->model][$token];
        }
        $settingStoreAction($data);
        session()->flash('message', $this->getNotificationMessage());
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.setting');
    }

    protected function getForm(): string
    {
        $domain = ModelHelpers::getDomain($this->model);

        return (string) Str::of($this->model)->ucfirst()->prepend('Domain\\'.$domain.'\\SettingsForms\\')->append('SettingsForm');
    }

    protected function getNotificationMessage(): string
    {
        return __('setting.save_notification', ['model' => __('model.'.$this->model)]);
    }
}
