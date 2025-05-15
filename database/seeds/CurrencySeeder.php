<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency 			= new Currency;
        $currency->iso3 	= "USD";
        $currency->symbol 	= "$";
        $currency->save();

        $currency 			= new Currency;
        $currency->iso3 	= "EUR";
        $currency->symbol 	= "€";
        $currency->save();

        $currency 			= new Currency;
        $currency->iso3 	= "GBP";
        $currency->symbol 	= "£";
        $currency->save();
    }
}
