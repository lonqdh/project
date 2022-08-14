<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = ["T-Shirt","Dress","Short"];
        $anh = ["https://media1.popsugar-assets.com/files/thumbor/Y6bXcbnD2g1jMbkcbAVaPt0u-ps/fit-in/728xorig/filters:format_auto-!!-:strip_icc-!!-/2016/03/30/634/n/1922564/3b4e46771b2b4218_682443_ou_xl/i/Shop-Salma-Gucci-Dress.jpg",
        "https://static.nike.com/a/images/t_default/yjmjfgvca8w01dcyzokk/sportswear-t-shirt-zmMkxS.png",
        "https://assets.adidas.com/images/w_600,f_auto,q_auto/67132742fd8849bc9574ac710179c38b_9366/Quan_short_Chelsea_3_Soc_AEROREADY_Essentials_Mau_xanh_da_troi_GL0023_21_model.jpg"];
        for ($i=0; $i < 3; $i++) { 
            $key = array_rand($category,1);
            $keyanh = array_rand($anh,1);
            $category = new Category;
            $category->setName($category[$key])
                        ->setImage($anh[$keyanh])
                        ->setDescription("Types of clothes for you");
            $manager->persist($category);
        }

        $manager->flush();
    }
}
