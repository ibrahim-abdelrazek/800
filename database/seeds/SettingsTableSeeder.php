<?php

namespace Backpack\Settings\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'app_name',
            'name'        => 'Application Name',
            'value'       => '800PHARMACY',
        ],
        [
            'key'         => 'contact_email',
            'name'        => 'Contact email address',
            'value'       => 'admin@800pharmacy.com',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted '.count($this->settings).' records.');
    }
}
