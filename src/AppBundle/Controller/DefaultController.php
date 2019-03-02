<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Posts;
use AppBundle\Entity\PostsCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $posts=$this->getDoctrine()
        ->getRepository(Posts::class)
        ->findBy([], ['createdAt' => 'desc'], 3
        );
        $categories=$this->getDoctrine()->getRepository(PostsCategory::class)
            ->findAll();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories
        ]);

    }
}
