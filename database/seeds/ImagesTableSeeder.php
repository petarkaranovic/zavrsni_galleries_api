<?php
use Illuminate\Database\Seeder;
use App\Image;
use App\Gallery;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gallery::all()->each(function(App\Gallery $gallery){
            $gallery->images()->saveMany(factory(Image::class, 10)->make());
        });
    }
}
