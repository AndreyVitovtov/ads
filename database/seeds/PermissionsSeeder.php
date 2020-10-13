<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'statistics'
            ], [
                'name' => 'users'
            ], [
                'name' => 'mailing'
            ], [
                'name' => 'countries'
            ], [
                'name' => 'cities'
            ], [
                'name' => 'rubrics'
            ], [
                'name' => 'subsections'
            ], [
                'name' => 'ads'
            ], [
                'name' => 'moderators'
            ], [
                'name' => 'languages'
            ], [
                'name' => 'contacts'
            ], [
                'name' => 'answers'
            ], [
                'name' => 'payment'
            ], [
                'name' => 'settings'
            ]
        ]);
    }
}
