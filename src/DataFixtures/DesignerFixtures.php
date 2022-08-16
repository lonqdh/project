<?php

namespace App\DataFixtures;

use App\Entity\Designer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DesignerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $designername = ["Bo Long dep trai","Quoc Viet cute","Quy ngai Tony"];
        $anh = ["https://fn.vinhphuc.edu.vn/UploadImages/mnlienchau/admin/tho-dong-vat-3%20c%C3%BAn%20con.jpg",
        "https://nhacpro.vn/uploads/articles/ccfeee8d.jpg",
        "https://vnn-imgs-a1.vgcloud.vn/znews-photo.zadn.vn/Uploaded/izhqv/2020_11_12/viechannelphotos_rap_viet_tap_15_thi_sinh_rpt_mck_1_16050204487251365930315_crop_1605020583124889154191.jpg"];

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
