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
            'name' => 'ПІ-132',
            'uri_alias' => 'pi-132',
            'year' => '2013'
        ]);

        StudentGroup::create([
            'name' => 'ПІ-131',
            'uri_alias' => 'pi-131',
            'year' => '2013'
        ]);

        StudentGroup::create([
            'name' => 'ПІ-141',
            'uri_alias' => 'pi-141',
            'year' => '2014'
        ]);

        StudentGroup::create([
            'name' => 'ПІ-142',
            'uri_alias' => 'pi-142',
            'year' => '2014'
        ]);
    }
}
