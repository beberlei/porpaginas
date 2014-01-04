<?php

namespace Porpaginas;

use Porpaginas\Doctrine\ORM\ORMQueryResult;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;

class DoctrineORMQueryTest extends AbstractResultTestCase
{
    protected function createResultWithItems($count)
    {
        $entityManager = $this->setupEntityManager();

        for ($i = 0; $i < $count; $i++) {
            $entityManager->persist(new DoctrineOrmEntity());
        }
        $entityManager->flush();
        $entityManager->clear();

        $query = $entityManager->createQuery('SELECT e FROM Porpaginas\DoctrineOrmEntity e');

        return new ORMQueryResult($query);
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
            $entityManager->getClassMetadata(__NAMESPACE__ . '\\DoctrineOrmEntity')
        ));

        return $entityManager;
    }
}

/**
 * @Entity
 */
class DoctrineOrmEntity
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;
}
