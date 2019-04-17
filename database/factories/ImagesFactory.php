<?php
use Faker\Generator as Faker;
use App\Image;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'url'=>$faker->imageUrl,
        'gallery_id'=>function(){
            return App\Gallery::all()->random()->id;
        }
    ];
});
