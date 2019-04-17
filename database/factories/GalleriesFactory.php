<?php
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'description'=>$faker->text($maxNbChars=1000),
        'user_id'=>function(){
            return App\User::all()->random()->id;
        }
    ];
});
