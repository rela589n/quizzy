<?php

use App\Models\StudentGroup;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentGroup::create([
            'name' => 'ПІ-172',
            'uri_alias' => 'pi-172',
            'year' => '2017'
        ]);
    }
}
