<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * @Route("", name="author_index")
     */
    public function indexAction(Request $request)
    {
        //insertion
        $em=$this->getDoctrine()->getManager();
        $Author=new Author();
        $formAuthor=$this->createForm(AuthorType::class,$Author);
        $formAuthor->handleRequest($request);
     if ($formAuthor->isSubmitted())
     {
         $em->persist($Author);
         $em->flush();
     }
        // end insertion

        $author=$this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();
        return $this->render('Author/index.html.twig', array(
            'authorview'=>$author,
            'formAuthor' => $formAuthor->createView()

        ));
    }
    /**
     * @Route("/delete", name="author_delete")
     */
    public function supprimerAction(Request $request)
    {
        $dataRequest=$request->request->all();
        $em=$this->getDoctrine()->getManager();
        $author=$this->getDoctrine()
            ->getRepository(Author::class)
            ->find($dataRequest["id"]);
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('author_index');
    }

    /**
     * @Route("/update", name="author_update")
     */
    public function updateAction(Request $request)
    {
        $dataRequest=$request->request->all();
        $em=$this->getDoctrine()->getManager();
        $author=$this->getDoctrine()
            ->getRepository(Author::class)
            ->find($dataRequest["id"]);
        $author->setFirstName($dataRequest["firstName"])
            ->setLastName($dataRequest["lastName"])
            ->setAge($dataRequest["age"])
            ->setJob($dataRequest["job"])
            ->setAdresse($dataRequest["adresse"])
            ->setTel($dataRequest["tel"])
            ->setSexe($dataRequest["sexe"]);
        $em->persist($author);
        $em->flush();

        return $this->redirectToRoute('author_index');
    }
}
