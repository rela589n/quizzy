<?php

use App\Models\StudentGroup;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public const GROUPS_LIMIT = 4;

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

        StudentGroup::create([
            'name' => 'ПІ-171',
            'uri_alias' => 'pi-171',
            'year' => '2017'
        ]);

        StudentGroup::create([
            'name' => 'ПІ-181',
            'uri_alias' => 'pi-181',
            'year' => '2018'
        ]);

        StudentGroup::create([
            'name' => 'ПІ-182',
            'uri_alias' => 'pi-182',
            'year' => '2017'
        ]);
    }
}
