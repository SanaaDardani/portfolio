<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostsCategory;
use AppBundle\Form\PostsCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("posts-category")
 */
class PostsCategoryController extends Controller
{
    /**
     * @Route("", name="postsCategory_index")
     */
    public function indexAction(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $postCategory = new PostsCategory();
        $form = $this
                    ->createForm(PostsCategoryType::class, $postCategory);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $entityManager->persist($postCategory);
            $entityManager->flush();
        }

       $postsCategory = $this->getDoctrine()
                       ->getRepository(PostsCategory::class)
                       ->findAll();

        return $this->render('PostsCategory/index.html.twig', array(
            'postsCategory' => $postsCategory,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/delete", name="postsCategory_delete")
     */
    public function deleteAction(Request $requestObject)
    {
        //dump($requestObject->request->all());die;
        $dataRequest = $requestObject->request->all();
        $em = $this->getDoctrine()->getManager();
        $postCategory = $this->getDoctrine()->getRepository(PostsCategory::class)
            ->find($dataRequest["id"]);

        $em->remove($postCategory);
        $em->flush();
        return $this->redirectToRoute("postsCategory_index");
    }

    /**
     * @Route("/update", name="postsCategory_update")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dataRequest = $request->request->all();
        $postCategory = $this->getDoctrine()->getRepository(PostsCategory::class)
            ->find($dataRequest["id"]);
        $postCategory->setName($dataRequest['name']);
        $em->persist($postCategory);
        $em->flush();
        return $this->redirectToRoute("postsCategory_index");
    }



}
