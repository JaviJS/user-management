<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhotoUser;

class PhotoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photo_user = new PhotoUser();
        $photo_user->name = "yoongi1.jpg";
        $photo_user->url = env('APP_URL_COMPLETE')."/resources/photo_user/yoongi1.jpg";
        $photo_user->extension = "jpg";
        $photo_user->original_name = "yoongi1.jpg";
        $photo_user->user_id = 1;
        $photo_user->save();
    }
}
