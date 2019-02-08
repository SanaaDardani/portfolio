<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("projects")
 */
class ProjectController extends Controller
{
    /**
     * @Route("",name="projects_index")
     */
    public function indexAction()
    {
        $projects=$this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        return $this->render('Projects/index.html.twig',['projects' => $projects]);
    }

    /**
     * @Route("/create",name="projects_create")
     */
    public function createAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $projects=new Project();
        $formProjects=$this->createForm(ProjectType::class,$projects);
        $formProjects->handleRequest($request);
        if ($formProjects->isSubmitted())
        {
            $em->persist($projects);
            $em->flush();
            return $this->redirectToRoute('projects_index');
        }
        return $this->render('Projects/create.html.twig',
            ['formProjects' => $formProjects->createView()]);

    }

    /**
     * @Route("/update/{id}",name="projects_update")
     */
    public function updateAction(Request $request,Project $projects)
    {
        $em=$this->getDoctrine()->getManager();
        $formProjects=$this->createForm(ProjectType::class,$projects);
        $formProjects->handleRequest($request);
        if ($formProjects->isSubmitted())
        {
            $em->persist($projects);
            $em->flush();
            return $this->redirectToRoute('projects_index');
        }
        return $this->render('Projects/modifier.html.twig',
            ['formProjects' => $formProjects->createView()]);

    }
    /**
     * @Route("/delete/{id}",name="projects_delete")
     */
    public function deleteAction(Project $project)
    {
        return $this->render('Projects/supprimer.html.twig',[
            'projects' => $project]);
    }
    /**
     * @Route("/delete_confirmation/{id}",name="projects_delete_confirmation")
     */
    public function deleteConfirmation(Project $project)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('projects_index');
    }

}
