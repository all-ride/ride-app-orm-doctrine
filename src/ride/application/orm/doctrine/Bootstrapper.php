<?php

namespace ride\application\orm\doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use ride\library\config\Config;
use ride\library\system\file\browser\FileBrowser;
use ride\library\system\file\File;

class Bootstrapper {

    private $commentedTypes = array();

    public $connections = array();

    public $defaultConnectionName = '';

    public $entityManagers = array();

    public $defaultEntityManagerName = '';

    public function boot(Config $config, FileBrowser $fileBrowser) {
        //$this->initTypes($config);
        $this->initConnections($config);
        $this->initEntityManagers($config, $fileBrowser);
    }

    protected function initTypes(Config $config) {
        foreach ($config->get('doctrine.dbal.types', array()) as $name => $typeConfig) {
            if (Type::hasType($name)) {
                Type::overrideType($name, $typeConfig['class']);
            } else {
                Type::addType($name, $typeConfig['class']);
            }

            if (isset($typeConfig['commented']) && $typeConfig['commented']) {
                $this->commentedTypes[] = $name;
            }
        }
    }

    protected function initConnections(Config $config) {
        $prefix = 'doctrine.dbal.connections';

        foreach ($config->get($prefix, array()) as $name => $connConfig) {
            $parts = parse_url($connConfig['dsn']);

            $this->connections[$name] = $connection = DriverManager::getConnection(array(
                'dbname'   => ltrim($parts['path'], '/'),
                'user'     => $parts['user'],
                'password' => $parts['pass'],
                'host'     => $parts['host'],
                'driver'   => 'pdo_' . $parts['scheme'],
            ));

            /*$platform = $connection->getDatabasePlatform();

            foreach ($config->get($prefix . '.' . $name . '.mapping_types', array()) as $dbType => $doctrineType) {
                $platform->registerDoctrineTypeMapping($dbType, $doctrineType);
            }

            foreach ($this->commentedTypes as $type) {
                $platform->markDoctrineTypeCommented($type);
            }*/
        }

        if ($defaultConnectionName = $config->get('doctrine.dbal.default_connection', false)) {
            if (!isset($this->connections[$defaultConnectionName])) {
                throw new \RuntimeException;
            }

            $this->defaultConnectionName = $defaultConnectionName;
        } else {
            $this->defaultConnectionName = key($this->connections);
        }
    }

    protected function initEntityManagers(Config $config, FileBrowser $fileBrowser) {
        $prefix = 'doctrine.orm.entity_managers';

        $ormConfig = Setup::createAnnotationMetadataConfiguration(
            $this->getEntityPaths($fileBrowser), false, null, null, false
        );

        foreach ($config->get($prefix, array()) as $name => $emConfig) {
            if (!$connectionName = $config->get($prefix . '.' . $name . '.connection', false)) {
                $connectionName = $this->defaultConnectionName;
            }

            $this->entityManagers[$name] = $em = EntityManager::create($this->connections[$connectionName], $ormConfig);

            /*foreach ($config->get($prefix . '.' . $name . '.hydrators', array()) as $hydratorName => $hydratorClass) {
                $em->getConfiguration()->addCustomHydrationMode($hydratorName, $hydratorClass);
            }

            foreach ($config->get($prefix . '.' . $name . '.dql.string_functions', array()) as $mappingName => $className) {
                $em->getConfiguration()->addCustomStringFunction($mappingName, $className);
            }

            foreach ($config->get($prefix . '.' . $name . '.dql.numeric_functions', array()) as $mappingName => $className) {
                $em->getConfiguration()->addCustomNumericFunction($mappingName, $className);
            }

            foreach ($config->get($prefix . '.' . $name . '.dql.datetime_functions', array()) as $mappingName => $className) {
                $em->getConfiguration()->addCustomDatetimeFunction($mappingName, $className);
            }

            foreach ($config->get($prefix . '.' . $name . '.filters', array()) as $filterName => $filter) {
                $em->getConfiguration()->addFilter($filterName, $filter['class']);
            }*/
        }

        if ($defaultEntityManagerName = $config->get('doctrine.orm.default_entity_manager', false)) {
            if (!isset($this->entityManagers[$defaultEntityManagerName])) {
                throw new \RuntimeException;
            }

            $this->defaultEntityManagerName = $defaultEntityManagerName;
        } else {
            $this->defaultEntityManagerName = key($this->entityManagers);
        }
    }

    /**
     * @param \ride\library\system\file\browser\FileBrowser $fileBrowser
     * @return array
     */
    protected function getEntityPaths(FileBrowser $fileBrowser) {
        $files = array();

        foreach ($fileBrowser->getIncludeDirectories() as $file) {
            /** @var File $file */
            $src = $file->getChild('src');

            if ($src->exists() && $src->isDirectory() && $src->isReadable()) {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($src->getAbsolutePath()),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($iterator as $f) {
                    /** @var \SplFileInfo $f */
                    if ($f->getBasename() === 'entity') {
                        $files[] = $f->getPathname();
                    }
                }
            }
        }

        return $files;
    }
}