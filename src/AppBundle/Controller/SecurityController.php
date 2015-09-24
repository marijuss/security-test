<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function loginAction()
    {
//        $user = $this->getUser();
//        dump($user);
        // the above is a shortcut for below one
//        $user = $this->get('security.token_storage')->getToken()->getUser();


        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $entity = new Participant();
        $entity->setEmail($lastUsername);
        $form = $this->createForm(new LoginType(), $entity, array(
            'action' => $this->generateUrl('security_login_check'),
            'validation_groups' => array('none'),
        ));

        return $this->render(
            'AppBundle:Security:login.html.twig',
            array(
                'form' => $form->createView(),
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    public function loginCheckAction() {}

//    public function logoutAction() {}
}
