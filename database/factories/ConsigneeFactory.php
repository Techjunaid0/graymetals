<?php

use Faker\Generator as Faker;

$factory->define(App\Consignee::class, function (Faker $faker) {
	$faker->addProvider(new \Faker\Provider\Person($faker));
	$faker->addProvider(new \Faker\Provider\Address($faker));
	$faker->addProvider(new \Faker\Provider\PhoneNumber($faker));
    return [
        'name' 			=> $faker->name,
        'phone' 		=> $faker->unique()->phoneNumber,
        'primary_email' => $faker->unique()->safeEmail,
        'address' 		=> $faker->address,
        'country_id' 	=> 1,
        'postal_code' 	=> $faker->postcode,
    ];
});
