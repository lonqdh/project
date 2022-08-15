<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brandname = ["Gucci","Louis Vuitton","Nike"];
        $anh = ["https://menback.com/wp-content/uploads/2020/03/logo-gucci.jpg",
        "https://gigamall.com.vn/data/2019/09/05/15023424_LOGO-NIKE-500x500.jpg",
        "https://caodangytehadong.edu.vn/wp-content/uploads/thuong-hieu-thoi-trang-noi-tieng-1.jpg"];

        for ($i=0; $i < 3; $i++) { 
            $key = array_rand($brandname,1);
            $keyanh = array_rand($anh,1);
            $brand = new Brand;
            $brand->setName($brandname[$key])
                        ->setImage($anh[$keyanh])
                        ->setTelephone("099999999")
                        ->setEmail("longhoang@gmail.com");
            $manager->persist($brand);
        }

        $manager->flush();
    }
}
