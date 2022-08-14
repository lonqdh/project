<?php

namespace App\DataFixtures;

use App\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaterialFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $chatlieu = ["Cotton","Wool","Silk","Leather","Denim"];
        $mau = ["White","Blue","Yellow","Orange","Black"];
        $vai = ["Polyester","Nylon","Acrylic"];
        $texture = ["Rough","Smooth","Soft","Light"];
        for ($i=0; $i < 5; $i++) { 
            $key = array_rand($chatlieu,1);
            $keymau = array_rand($mau,1);
            $keyvai = array_rand($vai,1);
            $keytexture = array_rand($texture,1);
            $material = new Material;
            $material->setName($chatlieu[$key])
                        ->setColor($mau[$keymau])
                        ->setTexture($texture[$keytexture])
                        ->setFabric($vai[$keyvai]);
            $manager->persist($material);
        }
        $manager->flush();
    }
}
