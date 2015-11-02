<?php

namespace Porpaginas\Doctrine\ORM\RSM;

use Porpaginas\Doctrine\ORM\RSM\Result;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Porpaginas\AbstractResultTestCase;

class QueryTest extends AbstractResultTestCase
{
    protected function createResultWithItems($count)
    {
        $entityManager = $this->setupEntityManager();

        for ($i = 0; $i < $count; $i++) {
            $entityManager->persist(new DoctrineOrmRsmEntity());
        }
        $entityManager->flush();
        $entityManager->clear();

        $qb = $entityManager->getConnection()->createQueryBuilder()
            ->from('DoctrineOrmRsmEntity', 'e')
            ->addOrderBy('e.id IS NOT NULL', 'DESC')
        ;
        $rsm = new ResultSetMappingBuilder($entityManager, ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata('Porpaginas\Doctrine\ORM\RSM\DoctrineOrmRsmEntity', 'e');
        $qb->select($rsm->generateSelectClause());

        return new Result($entityManager, $rsm, $qb, function($qb) {
            return $qb->select('count(*)');
        });
    }

    private function setupEntityManager()
    {
        $paths = array();
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema(array(
            $entityManager->getClassMetadata(__NAMESPACE__ . '\\DoctrineOrmRsmEntity')
        ));

        return $entityManager;
    }
}

/**
 * @Entity
 */
class DoctrineOrmRsmEntity
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;
}
