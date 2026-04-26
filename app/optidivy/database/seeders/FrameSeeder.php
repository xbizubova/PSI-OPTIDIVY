<?php

namespace Database\Seeders;

use App\Models\Frame;
use Illuminate\Database\Seeder;

class FrameSeeder extends Seeder
{
    // color: 1=čierna, 2=hnedá, 3=zlatá, 4=strieborná, 5=modrá
    // material: 1=plast, 2=kov, 3=titán, 4=drevo

    public function run(): void
    {
        $frames = [
            ['color' => 1, 'material' => 1], // čierna plast
            ['color' => 1, 'material' => 2], // čierna kov
            ['color' => 2, 'material' => 1], // hnedá plast
            ['color' => 3, 'material' => 2], // zlatá kov
            ['color' => 3, 'material' => 3], // zlatá titán
            ['color' => 4, 'material' => 2], // strieborná kov
            ['color' => 5, 'material' => 1], // modrá plast
            ['color' => 2, 'material' => 4], // hnedá drevo
        ];

        foreach ($frames as $frame) {
            Frame::create($frame);
        }
    }
}
