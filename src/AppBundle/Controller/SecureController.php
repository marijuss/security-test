<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecureController extends Controller
{
    public function indexAction()
    {
//        $user = $this->getUser();

        // the above is a shortcut for this
//        $user = $this->get('security.token_storage')->getToken()->getUser();


        return $this->render('AppBundle:Secure:index.html.twig', array(
//            'entity' => $entity,
//            'edit_form' => $editForm->createView(),
//            'courses' => $courses,
        ));
    }

    public function test1Action(Request $request)
    {
        return $this->render('AppBundle:Secure:test1.html.twig');
    }

    public function test2Action(Request $request)
    {
        return $this->render('AppBundle:Secure:test2.html.twig');
    }
}
