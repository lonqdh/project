<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/material')]
class MaterialController extends AbstractController
{
    #[Route('/index', name: 'material_index')]
    public function materialIndex(): Response
    {
        $materials = $this->getDoctrine()->getRepository(Material::class)->findAll();
        return $this->render('material/index.html.twig', [
            'materials' => $materials
        ]);
    }

    #[Route('/list', name :'material_list')]
    public function materialList()
    {
        $materials = $this->getDoctrine()->getRepository(Material::class)->findAll();
        return $this->render('material/list.html.twig',[
            'materials' => $materials
        ]);
    }

    #[Route('/detail/{id}', name : 'material_detail')]
    public function materialDetail($id,MaterialRepository $materialRepository){
        $material = $materialRepository->find($id);
        if ($material != null)
        {
            return $this->render('material/detail.html.twig',[
                'material' => $material
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'material_delete')]
    public function materialDelete ($id, ManagerRegistry $managerRegistry) {
      $material = $managerRegistry->getRepository(Material::class)->find($id);
      if ($material == null) {
          $this->addFlash('Warning', 'Material deos not exist !');
      } 
      //check xem còn product trong material$material hay không trước khi xóa
    //   else if (count($material->getProduct()) > 0) {
    //     $this->addFlash('Warning', 'Can not delete this material !');
    //   }  nho uncomment sau khi tao product !!!
      else {
          $manager = $managerRegistry->getManager();
          $manager->remove($material);
          $manager->flush();
          $this->addFlash('Info', 'Delete material successfully !');
      }
      return $this->redirectToRoute('material_index');
    }

    #[Route('/add', name: 'material_add')]
    public function genreAdd (Request $request) {
      $material = new Material;
      $form = $this->createForm(MaterialType::class,$material);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($material);
          $manager->flush();
          $this->addFlash('Info','Add material successfully !');
          return $this->redirectToRoute('material_index');
      }
      return $this->renderForm('material/add.html.twig',
      [
          'materialForm' => $form
      ]);
    }

    #[Route('/edit/{id}', name: 'material_edit')]
    public function materialEdit ($id, Request $request) {
        $material = $this->getDoctrine()->getRepository(Material::class)->find($id);
        if ($material == null) {
            $this->addFlash('Warning', 'Material does not exist !');
            return $this->redirectToRoute('material_index');
        } else {
            $formMaterial = $this->createForm(MaterialType::class,$material);
            $formMaterial->handleRequest($request);
            if ($formMaterial->isSubmitted() && $formMaterial->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($material);
                $manager->flush();
                $this->addFlash('Info','Edit material successfully !');
                return $this->redirectToRoute('material_index');
            }
            return $this->renderForm('material/edit.html.twig',
            [
                'formMaterial' => $formMaterial
            ]);
        }
      }

}

