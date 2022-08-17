<?php

namespace App\Controller;

use App\Entity\Designer;
use App\Form\DesignerType;
use App\Repository\DesignerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/designer')]
class DesignerController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/index', name: 'designer_index')]
    public function designerIndex(): Response
    {
        $designers = $this->getDoctrine()->getRepository(Designer::class)->findAll();
        return $this->render('designer/index.html.twig',
        [
            'designers' => $designers ,
        ]);
    }

    #[Route('/list', name: 'designer_list')]
    public function listIndex(): Response
    {
        $designers = $this->getDoctrine()->getRepository(Designer::class)->findAll();
        return $this->render('designer/list.html.twig',
        [
            'designers' => $designers ,
        ]);
    }

    #[Route('/detail/{id}', name: 'designer_detail')]
    public function designerDetail ($id, DesignerRepository $designerRepository) {
      $designer = $designerRepository->find($id);
      if ($designer == null) {
          $this->addFlash('Warning', 'Invalid designer id ');
          return $this->redirectToRoute('designer_index');
      }
      return $this->render('designer/detail.html.twig',
          [
              'designer' => $designer
          ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/add', name: 'designer_add')]
    public function designerAdd(Request $request): Response
    {
        $designer = new Designer;
        $form = $this->createForm(DesignerType::class,$designer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($designer);
                $manager->flush();
                $this->addFlash('Info','Successfully added');
                return $this->redirectToRoute('designer_index');
        }
        return $this->render('designer/add.html.twig',
        [
            'designerForm' => $form ->createView()
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/edit{id}', name: 'designer_edit')]
    public function designerEdit($id, Request $request): Response
    {
        $designer = $this->getDoctrine()->getRepository(Designer::class)->find($id);
        if($designer == null){
            $this->addFlash('Warning', 'Designer does not exist');
            return $this->redirectToRoute('designer_index');
        }else{
            $form = $this->createForm(DesignerType::class,$designer);
            $form->handleRequest($request);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
                $manager->persist($designer);
                $manager->flush();
                $this->addFlash('Info','Successfully edited');
                return $this->redirectToRoute('designer_index');
        }
        return $this->renderForm('designer/edit.html.twig',
        [
            'designerForm' => $form 
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete{id}', name: 'designer_delete')]
    public function designerDelete($id, ManagerRegistry $managerRegistry): Response
    {
        $designer = $managerRegistry->getRepository(Designer::class)->find($id);
        if($designer == null){
            $this->addFlash('Warning', 'Designer does not exist');

        }else{
            $manager = $managerRegistry->getManager();
            $manager->remove($designer);
            $manager->flush();
            $this->addFlash('Info','Successfully deleted');
        }
        return $this->redirectToRoute('designer_index');
    }


}
