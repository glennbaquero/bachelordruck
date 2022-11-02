<?php

namespace App\Livewire;

use Domain\Categories\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Test extends Component
{
    public null|int $test = 1;

    public array $categories;

    public function mount(): void
    {
        $this->categories = Category::get()->toTree()->toArray();
    }

    public function render(): View
    {
        return view('livewire.test');
    }

    public function getCategories()
    {
        foreach ($this->categories as $category) {
            yield $category;
        }
    }

    public function walk($categories, $prefix = '-')
    {
        foreach ($categories as $category) {
            echo $prefix.' '.$category['name'].'<br>';

            $this->walk($category['children'], $prefix.'-');
        }
    }

    public function update($ids)
    {
        dd($ids);
    }

    public function updateGroup($ids)
    {
        dd($ids);
    }

    public function remove($id)
    {
        dd($id);
    }
}
