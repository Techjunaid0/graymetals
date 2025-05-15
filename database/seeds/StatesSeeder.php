<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as Eloquent;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('seeds_data/states.sql');

        if(file_exists($path))
        {
            Eloquent::unguard();

            \DB::unprepared(file_get_contents($path));
            $this->command->info('States table seeded!');
        }
        else
        {

            $this->command->error('File Does Not Exist.');
        }
    }
}
