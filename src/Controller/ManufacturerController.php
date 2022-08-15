<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Request;
use App\Repository\ManufacturerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/list', name: 'manufacturer_list')]
    public function manufacturerList () {
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll();
        return $this->render('manufacturer/list.html.twig'
    [
       // 'manufacturers' => $manufacturers
    ]);
    }

    #[Route('/detail/{id}', name: 'manufacturer_detail')]
    public function manufacturerDetail ($id, ManufacturerRepository $manufacturerRepository) {
        $manufacturer = $manufacturerRepository->find($id);
        if($manufacturer == null){
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
        return $this->redirectToRoute('manufacturer_index');
    }

    #[Route('/add', name:'manufacturer_add')]
    public function manufacturerAdd (Request $request){
        $manufacturer = new Manufacturer;
        $form = $this->createForm(ManufacturerType::class, $manufacturer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($manufacturer);
            $manager->flush();
            $this->addFlash('Info','Add manufacturer success');
            return $this->redirectToRoute('manufacturer_index');
        }
        return $this->renderForm('manufacturer/add.html.twig',
    [
        'manufacturerForm' => $form
    ]);
    }

    #[Route('/edit/{$id}', name:'manufacturer_edit')]
    public function manufacturerEdit ($id, Request $request){
        $manufacturer = $this->getDoctrine()->getRepository(Manufacturer::class)->find($id);
        if ($manufacturer == null){
            $this->addFlash('Warning','Manufacturer not exist');
            return $this->redirectToRoute('manufacturer_index');
        } else {
            $form = $this->createForm(ManufacturerType::class, $manufacturer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($manufacturer);
                $manager->flush();
                $this->addFlash('Info','Edit author successfully!');
                return $this->redirectToRoute('manufacturer_index');
            }
            return $this->renderForm('manufacturer/edit.html.twig',
        [
            'manufacturerForm' => $form
        ]);
        }
    }

}
