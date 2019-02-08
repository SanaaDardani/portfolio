<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @Route("Users")
 */
class UserController extends Controller
{
    /**
     * @Route("", name="user_index")
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('Users/index.html.twig', array(
            'users' => $users));
        /*$users=$this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('Users/index.html.twig', ['users' => $users]);*/

    }

    /**
     * @Route("/update/{id}",name="users_update")
     */
    public function updateAction(Request $request, User $Users)
    {
        $em = $this->getDoctrine()->getManager();
        $formUsers = $this->createForm(UserType::class, $Users);
        $formUsers->handleRequest($request);
        if ($formUsers->isSubmitted()) {
            $em->persist($formUsers->getData());
            $em->flush();
            return $this->redirectToRoute('user_index');
        }
        return $this->render('Users/update.html.twig',
            ['formUser' => $formUsers->createView()]);

    }

}
