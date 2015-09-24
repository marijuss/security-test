<?php

namespace AppBundle\Services;

use AppBundle\Entity\Participant;
use AppBundle\Repository\ParticipantRepository;

class ParticipantService
{
    protected $repository;

    public function __construct(ParticipantRepository $repository)
    {
        $this->repository = $repository;
    }

    /* @var $passwordEncoder \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder */
    public function create(Participant $entity, $passwordEncoder)
    {
        // TODO: must have validation that guarantees that the password is 4096 characters or fewer.
        $entity->setPassword($passwordEncoder->encodePassword($entity, $entity->getPassword()));
        return $this->repository->create($entity);
    }
}
