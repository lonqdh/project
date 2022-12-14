<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/brand')]
class BrandController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/index', name: 'brand_index')]
    public function brandIndex()
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();
        return $this->render('brand/index.html.twig',
            [
                'brands' => $brands
            ]
        );
    }

    #[Route('/list', name: 'brand_list')]
    public function brandList()
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();
        return $this->render('brand/index.html.twig',
            [
                'brands' => $brands
            ]
        );
    }

    #[Route('/detail/{id}', name: 'brand_detail')]
    public function brandDetail($id, BrandRepository $brandRepository)
    {
        $brand = $brandRepository->find($id);
        if ($brand == null) {
            $this->addFlash('Warning', 'Invalid brand !');
            return $this->redirectToRoute('brand_index');
        }
        return $this->render('brand/detail.html.twig',
            [
                'brand' => $brand
            ]
        );
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete/{id}', name: 'brand_delete')]
    public function brandDelete($id, ManagerRegistry $managerRegistry)
    {
        $brand = $managerRegistry->getRepository(Brand::class)->find($id);
        if ($brand == null) {
            $this->addFlash('Warning', 'Brand not exist!');
        } else {
            $manager = $managerRegistry->getManager();
            $manager->remove($brand);
            $manager->flush();
            $this->addFlash('Info', 'Delete brand success');
        }
        return $this->redirectToRoute('brand_index');
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/add', name: 'brand_add')]
    public function brandAdd(Request $request)
    {
        $brand = new Brand;
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($brand);
            $manager->flush();
            $this->addFlash('Info', 'Add brand success');
            return $this->redirectToRoute('brand_index');
        }
        return $this->renderForm('brand/add.html.twig',
            [
                'brandForm' => $form
            ]
        );
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/edit/{id}', name: 'brand_edit')]
    public function brandEdit($id, Request $request)
    {
        $brand = $this->getDoctrine()->getRepository(Brand::class)->find($id);
        if ($brand == null) {
            $this->addFlash('Warning', 'Brand not existed !');
            return $this->redirectToRoute('brand_index');
        } else {
            $form = $this->createForm(BrandType::class, $brand);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($brand);
                $manager->flush();
                $this->addFlash('Info', 'Edit brand successfully !');
                return $this->redirectToRoute('brand_index');
            }
            return $this->renderForm('brand/edit.html.twig',
                [
                    'brandForm' => $form
                ]
            );
        }
    }
}
