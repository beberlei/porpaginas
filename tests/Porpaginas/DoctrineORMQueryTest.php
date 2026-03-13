<?php

namespace Porpaginas;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Porpaginas\Doctrine\ORM\ORMQueryResult;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

class DoctrineORMQueryTest extends ResultTestCase
{
    /** @return Result<DoctrineOrmEntity> */
    protected function createResultWithItems(int $count): Result
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

    private function setupEntityManager(): EntityManager
    {
        $paths = [];
        $isDevMode = false;

        // the connection configuration
        $dbParams = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $createConfigMethod = 'createAttributeMetadataConfig';
        // @phpstan-ignore-next-line compatibility with Doctrine ORM versions that do not have this method
        if (method_exists(ORMSetup::class, $createConfigMethod)) {
            $config = ORMSetup::{$createConfigMethod}($paths, $isDevMode);
        } else {
            $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        }

        $enableNativeLazyObjectsMethod = 'enableNativeLazyObjects';
        // @phpstan-ignore-next-line compatibility with Doctrine ORM versions that do not have this method
        if (\PHP_VERSION_ID >= 80400 && method_exists($config, $enableNativeLazyObjectsMethod)) {
            $config->{$enableNativeLazyObjectsMethod}(true);
        } else {
            $config->setProxyDir(sys_get_temp_dir());
            $config->setProxyNamespace('Proxies');
        }

        $connection = DriverManager::getConnection($dbParams, $config);
        $entityManager = new EntityManager($connection, $config);

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema([$entityManager->getClassMetadata(__NAMESPACE__ . '\\DoctrineOrmEntity')]);

        return $entityManager;
    }
}

#[Entity]
class DoctrineOrmEntity
{
    #[Id]
    #[Column(type: "integer")]
    #[GeneratedValue]
    private int $id;
}
