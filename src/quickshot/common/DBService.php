<?php

namespace QuickShot\Common;

use Interop\Container\ContainerInterface as Container;

final class DBService extends \PDO {

	private $container;
    private $logger;
    private $transactionCounter = 0;

    public function __construct(Container $container) {
        try {
            $this->container = $container;
            $this->logger = $container->logger;
            $settings = $container->get("settings")["database"];
            $dsn = sprintf("mysql:dbname=%s;host=%s;port=%s;charset=%s", $settings["name"], $settings["host"], $settings["port"], $settings["charset"]);
            $username = $settings["username"];
            $password = $settings["password"];
            parent::__construct($dsn, $username, $password);    
        } catch(\Exception $e) {
	        $container->logger->debug($e->getMessage()); 
            // $this->logger->critical($e->getMessage());
        }
    }

    public function getLogger() {
        return $this->logger;
    }

    public function transaction() { 
        if(!$this->transactionCounter++) {
            $this->debug("Create new transaction");
            return parent::beginTransaction(); 
        }
       return $this->transactionCounter >= 0; 
    } 

    public function commit() { 
        if(!--$this->transactionCounter) {
            $this->debug("Commit opened transaction");
            return parent::commit(); 
        }
        return $this->transactionCounter >= 0; 
    } 

    public function rollback() { 
        if($this->transactionCounter >= 0) { 
            $this->transactionCounter = 0; 
            $this->debug("Rollback transaction");
            return parent::rollback(); 
        } 
        $this->transactionCounter = 0; 
        return false; 
    }

    public function hasOpenedTransaction() {
    	return $this->transactionCounter > 0;
    }
    
    private function debug($message) {
        $this->getLogger()->debug(get_class($this) . " - " . $message);
    }

}
