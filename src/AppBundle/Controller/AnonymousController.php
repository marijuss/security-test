<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Form\RegistrationType;
use AppBundle\Services\ParticipantService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnonymousController extends Controller
{
    protected $participantService;

    public function __construct(ParticipantService $participantService)
    {
        $this->participantService = $participantService;
    }

    public function indexAction()
    {
        return $this->render('AppBundle:Anonymous:index.html.twig', array(
//            'entity' => $entity,
//            'edit_form' => $editForm->createView(),
//            'courses' => $courses,
            ));
    }

    public function test1Action(Request $request)
    {
        return $this->render('AppBundle:Anonymous:test1.html.twig');
    }

    public function test2Action(Request $request)
    {
        return $this->render('AppBundle:Anonymous:test2.html.twig');
    }

    public function showRegistrationAction(Request $request)
    {
        $entity = new Participant();
        $form = $this->createForm(new RegistrationType(), $entity, array(
            'action' => $this->generateUrl('anonymous_register'),
            'method' => 'PUT',
            'validation_groups' => array('registration'),
        ));

        return $this->render(
            'AppBundle:Anonymous:registration.html.twig',
            array('form' => $form->createView())
        );
    }

    public function registerAction(Request $request)
    {
        $entity = new Participant();
        $form = $this->createForm(new RegistrationType(), $entity, array(
            'action' => $this->generateUrl('anonymous_register'),
            'method' => 'PUT',
            'validation_groups' => array('registration'),
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');

            $this->participantService->create($entity, $this->container->get('security.password_encoder'));
        }

        return $this->render(
            'AppBundle:Anonymous:registration.html.twig',
            array('form' => $form->createView())
        );
    }
}
