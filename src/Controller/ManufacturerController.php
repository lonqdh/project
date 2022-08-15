<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manufacturer')]
class ManufacturerController extends AbstractController
{
    #[Route('/index', name: 'manufacturer_index')]
    public function manufacturerIndex () {
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll();
        return $this->render('manufacturer/index.html.twig'
    [
       // 'manufacturers' => $manufacturers
    ]);
    }

    #[Route('/detail/{id}', name: 'manufacturer_detail')]
    public function manufacturerDetail ($id, ManufacturerRepository $manufacturerRepository) {
        $manufacturer = $manufacturerRepository->find($id);
        if($manufacturer ==null){
            $this->addFlash('Warning','Invalid manufacturer');
            return $this->redirectToRoute('manufacturer_index');
        }
        return $this->render('manufacturer/detail.html.twig'
    [
        // 'manufacturer' => $manufacturer
    ]);
    }

    #[Route('/delete/{id}', name: 'manufacturer_delete')]
    public function manufacturerDelete ($id, ManagerRegistry $managerRegistry){
        $manufacturer = $managerRegistry->getRepository(Manufacturer::class)->find($id);
        if ($manufacturer == null){
            $this->addFlash('Warning','Manufacturer not exist!');
        } else {
            $manager = $managerRegistry->getManager();
            $manager->remove($manufacturer);
            $manager->flush();
            $this->addFlash('Info','Delete manufacturer success!');
        }
    }
}
