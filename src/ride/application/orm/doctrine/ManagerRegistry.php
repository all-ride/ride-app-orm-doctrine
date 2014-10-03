<?php

namespace ride\application\orm\doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use ride\library\config\Config;
use ride\library\system\file\browser\FileBrowser;

class ManagerRegistry {

    /**
     * @var \ride\library\config\Config
     */
    private $config;

    /**
     * @var \ride\library\system\file\browser\FileBrowser
     */
    private $fileBrowser;

    /**
     * @var \ride\application\orm\doctrine\Bootstrapper
     */
    private $bootstrapper;

    /**
     * @var Connection[]
     */
    private static $connections;

    /**
     * @var EntityManager[]
     */
    private static $entityManagers;

    /**
     * @var string
     */
    private static $defaultConnectionName;

    /**
     * @var string
     */
    private static $defaultEntityManagerName;

    /**
     * @var bool
     */
    private static $initialized = false;

    /**
     * @param \ride\library\config\Config                   $config
     * @param \ride\library\system\file\browser\FileBrowser $fileBrowser
     */
    public function __construct(Config $config, FileBrowser $fileBrowser) {
        $this->config       = $config;
        $this->fileBrowser  = $fileBrowser;
        $this->bootstrapper = new Bootstrapper();
    }

    /**
     * @param string|null $name
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager($name = null) {
        $this->initialize();

        if (null === $name) {
            $name = self::$defaultEntityManagerName;
        }

        if (!isset(self::$entityManagers[$name])) {
            throw new \RuntimeException;
        }

        return self::$entityManagers[$name];
    }

    /**
     *
     */
    protected function initialize() {
        if (self::$initialized) {
            return;
        }

        $this->bootstrapper->boot($this->config, $this->fileBrowser);

        self::$connections              = $this->bootstrapper->connections;
        self::$defaultConnectionName    = $this->bootstrapper->defaultConnectionName;
        self::$entityManagers           = $this->bootstrapper->entityManagers;
        self::$defaultEntityManagerName = $this->bootstrapper->defaultEntityManagerName;
        self::$initialized              = true;
    }

}