<?php
use Faker\Generator as Faker;
use App\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content'=>$faker->sentence(),
        'user_id'=>function(){
            return App\User::all()->random()->id;
        },
        'gallery_id'=>function(){
            return App\Gallery::all()->random()->id;
        }
    ];
});
