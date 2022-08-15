<?php

namespace App\DataFixtures;

use App\Entity\Designer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DesignerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $designername = ["Bo Long dep trai","Thang Viet","Quy ngai Tony"];
        $anh = ["https://taimeme.com/public/upload/memes/thay-giao-huan-hoa-hong-giang-bai-mon-giao-duc-xa-hoi-90d35fe69feef6385c1dfda341ea9b33.jpg",
        "https://media.discordapp.net/attachments/875652964520448006/1004680120117772328/IMG_0434.jpg?width=527&height=702",
        "https://camo.voz.tech/8bca714b8015086d538dddd86ce3f6cfeb7f696d/68747470733a2f2f692e696d6775722e636f6d2f594559545944702e706e67/"];

        for ($i=0; $i < 3; $i++) { 
            $key = array_rand($designername,1);
            $keyanh = array_rand($anh,1);
            $designer = new Designer;
            $designer->setName($designername[$key])
                        ->setImage($anh[$keyanh])
                        ->setEmail("longhoangcute@gmail.com");
            $manager->persist($designer);
        }

        $manager->flush();
    }
}
