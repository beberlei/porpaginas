<?php

namespace Porpaginas\Doctrine\ORM\RSM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\DBAL\Query\QueryBuilder;
use Porpaginas\Arrays\ArrayPage;

final class Result implements \Porpaginas\Result
{
    /**
     * @param EntityManagerInterface  $em
     * @param ResultSetMappingBuilder $rsm
     * @param QueryBuilder            $qb
     * @param callable|null           $countQueryBuilderModifier
     */
    public function __construct(EntityManagerInterface $em, ResultSetMappingBuilder $rsm, QueryBuilder $qb, \Closure $countQueryBuilderModifier = null)
    {
        $this->em  = $em;
        $this->rsm = $rsm;
        $this->qb  = $qb;
        $this->countQueryBuilderModifier = $countQueryBuilderModifier ?: function($qb) {
            return $qb->select('count(*)');
        };
    }

    public function take($offset, $limit)
    {
        $qb = clone $this->qb;
        $qb
            ->setMaxResults($limit)
            ->setFirstResult($offset)
        ;

        $query = $this->em->createNativeQuery($qb->getSql(), $this->rsm);
        $query->setParameters($qb->getParameters());

        return new ArrayPage($query->execute(), $offset, $limit, $this->count());
    }

    public function count()
    {
        $qb = clone $this->qb;
        call_user_func($this->countQueryBuilderModifier, $qb);
        $result = $qb->execute()->fetchColumn();

        return (int) $result;
    }

    public function getIterator()
    {
        $query = $this->em->createNativeQuery($this->qb->getSql(), $this->rsm);
        $query->setParameters($this->qb->getParameters());

        return new \ArrayIterator($query->execute());
    }
}
