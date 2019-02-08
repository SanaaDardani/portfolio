<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostsCategory;
use AppBundle\Entity\ProjectsCategory;
use AppBundle\Form\ProjectsCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("projects-category")
 */
class ProjectsCategoryController extends Controller
{
    /**
     * @Route("",name="projectsCategory_index")
     */
    public function indexAction(Request $request)
    {
        //pour l'insertion
        $em=$this->getDoctrine()->getManager();
        $ProjectsCategory=new ProjectsCategory();
        $formProjects=$this->createForm(ProjectsCategoryType::class,$ProjectsCategory);
        $formProjects->handleRequest($request);
        if ($formProjects->isSubmitted())
        {
            $em->persist($ProjectsCategory);
            $em->flush();
        }
        //end

        //affichage
        $ProjectsCategory=$this
            ->getDoctrine()->getRepository(ProjectsCategory::class)
            ->findAll();
        //end
        return $this->render('ProjectsCategory/index.html.twig', array(
            'projectsCategory' => $ProjectsCategory,
            'formProjects' => $formProjects->createView()

        ));
    }


    /**
     * @Route("/delete", name="projectsCategory_delete")
     */
    public function supprimerAction(Request $requestSupprimer)
    {
        $allRequest = $requestSupprimer->request->all();
        $em=$this->getDoctrine()->getManager();
        $projectCategory=$this->getDoctrine()
            ->getRepository(ProjectsCategory::class)
            ->find($allRequest["id"]);
        $em->remove($projectCategory);
        $em->flush();
        return $this->redirectToRoute("projectsCategory_index");

    }

    /**
     * @Route("/modifier", name="projectsCategory_update")
     */
    public function UpdateAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $dataRequest=$request->request->all();

        $postCategory=$this->getDoctrine()
            ->getRepository(ProjectsCategory::class)
            ->find($dataRequest["id"]);

        $postCategory->setName($dataRequest['name']);
        $em->persist($postCategory);
        $em->flush();
        return $this->redirectToRoute("projectsCategory_index");

    }
}
