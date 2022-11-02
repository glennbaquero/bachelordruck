<?php

namespace Database\Seeders;

use Domain\Pages\Models\Layout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layouts = [
            ['id' => 1, 'title' => 'Home', 'token' => 'bachelordruck.home'],
            ['id' => 2, 'title' => 'Page', 'token' => 'bachelordruck.page'],
            ['id' => 3, 'title' => 'Gallery', 'token' => 'bachelordruck.gallery'],
            ['id' => 4, 'title' => 'Contact', 'token' => 'bachelordruck.contact'],
            ['id' => 5, 'title' => 'Price', 'token' => 'bachelordruck.price'],
            ['id' => 6, 'title' => 'Have your thesis printed and bound', 'token' => 'bachelordruck.technical-work-printing-and-binding-let'],
        ];

        foreach ($layouts as $layout) {
            Layout::updateOrCreate(Arr::only($layout, 'id'), $layout);
        }
    }
}
