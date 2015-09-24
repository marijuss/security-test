<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BaseEntity;
use AppBundle\Entity\Participant;

class ParticipantRepository extends BaseRepository
{
    public function getFiltered(BaseEntity $criteria, $returnQuery = false)
    {
        $builder = $this->createQueryBuilder('entity')
            ->select('entity', 'instances')
            ->leftJoin('entity.courseInstances', 'instances');

        $builder->where('true = true');
        /* @var $criteria Participant */
        $instances = $criteria->getCourseInstances()->getValues();
        if (!empty($instances)) {
            $builder->andWhere('instances = :instance')
                ->setParameter('instance', $instances[0]);
        }
        $builder->addOrderBy('entity.lastName', 'ASC');
        $builder->addOrderBy('entity.firstName', 'ASC');

        $query = $builder->getQuery();

        return ($returnQuery) ? $query : $query->getResult();
    }
}
