<?php

namespace App\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class DatabaseConnection extends Connection
{
    public function __construct(array $params, Driver $driver, $config, $eventManager)
    {
        parent::__construct($params, $driver, $config, $eventManager);
    }

    public function selectDatabase(string $dbName): void
    {
        if ($this->isConnected()) {
            $this->close();
        }
        $params = $this->getParams();
        $params['dbname'] = $dbName;
        parent::__construct($params, $this->_driver, $this->_config, $this->_eventManager);
    }
}
