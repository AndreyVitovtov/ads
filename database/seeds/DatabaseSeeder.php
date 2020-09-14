<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ContactsTypeSeeder::class);
        $this->call(SettingsButtonsSeeder::class);
        $this->call(SettingsPagesSeeder::class);
        $this->call(SettingsMainSeeder::class);

    }
}
