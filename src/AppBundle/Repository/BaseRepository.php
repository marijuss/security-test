<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BaseEntity;
use Doctrine\ORM\EntityRepository;

// TODO: refactor
class BaseRepository extends EntityRepository
{
    // TODO: rethink this one (abstract?)
    public function getFiltered(BaseEntity $entity)
    {
        return null;
    }

    public function isScheduledForUpdate(BaseEntity $entity)
    {
        $this->_em->getUnitOfWork()->isScheduledForUpdate($entity);
    }

    public function detach($entity)
    {
        $this->_em->detach($entity);
        return $entity;
    }

    public function persist(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        return $entity;
    }

    public function flush(BaseEntity $entity = null)
    {
        $this->_em->flush();
        return $entity;
    }

    public function create(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
        return $entity;
    }

    public function update(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function delete(BaseEntity $entity, $flush = true)
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function beginTransaction()
    {
        $this->_em->getConnection()->beginTransaction();
    }

    public function commit()
    {
         $this->_em->getConnection()->commit();
    }

    public function rollback()
    {
         $this->_em->getConnection()->rollback();
    }

    public function resetConnection()
    {
        if (!$this->_em->isOpen()) {
            $this->_em = $this->_em->create(
                $this->_em->getConnection(), $this->_em->getConfiguration());
        }
    }
}
