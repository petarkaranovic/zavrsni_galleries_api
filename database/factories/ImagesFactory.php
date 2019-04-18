<?php
use Faker\Generator as Faker;
use App\Image;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'url'=>$faker->imageUrl($width=640,$height=480),
        'gallery_id'=>function(){
            return App\Gallery::all()->random()->id;
        }
    ];
});
