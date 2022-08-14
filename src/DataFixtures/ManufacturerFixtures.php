<?php

namespace App\DataFixtures;

use App\Entity\Manufacturer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ManufacturerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nhasanxuat = ["Good Clothing Company","Apparel Production Inc","Billoomi Fashion"];
        $anh = ["https://fashinza.com/textile/wp-content/uploads/2021/10/uLn8UkHZ_400x400-370x370.jpeg",
        "https://media-exp1.licdn.com/dms/image/C4D0BAQGDO1MaULF8tw/company-logo_200_200/0/1568076736534?e=2147483647&v=beta&t=WRDqHhBQaYt9XZ2Y0bcLchholcK9K4MRloo7McDZ4d0",
        "http://media.releasewire.com/photos/show/?id=181471"];

        for ($i=0; $i < 5; $i++) { 
            $key = array_rand($nhasanxuat,1);
            $keyanh = array_rand($anh,1);
            $manufacturer = new Manufacturer;
            $manufacturer->setName($nhasanxuat[$key])
                        ->setImage($anh[$keyanh])
                        ->setEmail("anhlonglichlam@gmail.com");
            $manager->persist($manufacturer);
        }
        $manager->flush();
    }
}
