<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/** @deprecated */
class LiteratureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $literature = new \App\Models\Literature();
        $literature->description = 'Book 1, page 30';
        $literature->test_id = 210;
        $literature->save();
    }
}
