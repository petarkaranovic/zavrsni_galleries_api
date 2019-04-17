<?php
use Illuminate\Database\Seeder;
use App\Gallery;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Gallery::class,50)->create();
    }
}
