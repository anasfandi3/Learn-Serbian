<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            ["happy", "srećan", "happy.jfif"],
            ["nice", "lijepo", "nice.jfif"],
            ["friend", "prijatelju", "friend.jfif"],
            ["explosion", "eksplozija", "explosion.jfif"],
            ["carrot", "šargarepa", "carrot.jfif"],
            ["car", "auto", "car.jfif"],
            ["soldier", "vojnik", "soldier.jfif"],
            ["fear", "strah", "fear.jfif"],
            ["relativity", "relativnost", "relativity.jfif"],
            ["book", "knjiga", "book.jfif"],
            ["earth", "Zemlja", "earth.jfif"],
            ["speed limit", "ograničenje brzine", "speedlimit.jfif"],    
        ];
        foreach ($arr as $item) {
            $newRecord = new Translation();
            $newRecord->english = $item[0];
            $newRecord->serbian = $item[1];
            $newRecord->image_name = $item[2];
            $newRecord->save();
        }
    }
}
