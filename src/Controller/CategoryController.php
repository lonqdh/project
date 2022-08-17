<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/index', name: 'category_index')]
    public function categoryIndex(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig',
        [
            'categories' => $categories ,
        ]);
    }

    #[Route('/list', name: 'category_list')]
    public function listIndex(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/list.html.twig',
        [
            'categories' => $categories ,
        ]);
    }

    #[Route('/detail/{id}', name: 'category_detail')]
    public function categoryrDetail ($id, CategoryRepository $categoryRepository) {
      $category = $categoryRepository->find($id);
      if ($category == null) {
          $this->addFlash('Warning', 'Invalid category id ');
          return $this->redirectToRoute('category_index');
      }
      return $this->render('category/detail.html.twig',
          [
              'category' => $category
          ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/add', name: 'category_add')]
    public function categoryAdd(Request $request): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();
                $this->addFlash('Info','Successfully added');
                return $this->redirectToRoute('category_index');
        }
        return $this->render('category/add.html.twig',
        [
            'categoryForm' => $form ->createView()
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/edit{id}', name: 'category_edit')]
    public function categoryEdit($id, Request $request): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if($category == null){
            $this->addFlash('Warning', 'Category does not exist');
            return $this->redirectToRoute('category_index');
        }else{
            $form = $this->createForm(CategoryType::class,$category);
            $form->handleRequest($request);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();
                $this->addFlash('Info','Successfully edited');
                return $this->redirectToRoute('category_index');
        }
        return $this->renderForm('category/edit.html.twig',
        [
            'categoryForm' => $form 
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete{id}', name: 'category_delete')]
    public function categoryDelete($id, ManagerRegistry $managerRegistry): Response
    {
        $category = $managerRegistry->getRepository(Category::class)->find($id);
        if($category == null){
            $this->addFlash('Warning', 'Category does not exist');

        }else{
            $manager = $managerRegistry->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('Info','Successfully deleted');
        }
        return $this->redirectToRoute('category_index');
    }


}
