<?php

namespace QuickShot\Common;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;

abstract class AbstractComponent {

	private $logger;
	private $container;
	private $flash;

	public function __construct(Container $container) {
		$this->container = $container;
		$this->logger = $this->getContainer()->get('logger');
		$this->flash = $this->getContainer()->get('flash');
	}

	public function getLogger() {
		return $this->logger;
	}

	public function getContainer() {
		return $this->container;
	}

	protected function debug($message) {
		$this->getLogger()->debug(get_class($this) . " - " . $message);
	}

	protected function info($message) {
		$this->getLogger()->info(get_class($this) . " - " . $message);
	}

	protected function error($message) {
		$this->getLogger()->error(get_class($this) . " - " . $message);
	}

	public function addErrorMessage($message) {
		$this->flash->addMessage("error" , $message);
	}

	public function addSuccessMessage($message) {
		$this->flash->addMessage("success", $message);
	}

	public function addInfoMessage($message) {
		$this->flash->addMessage("info" , $message);
	}

	public function addWarningMessage($message) {
		$this->flash->addMessage("warning" , $message);
	}

	public function hasMessages() {
		return sizeof($this->flash->getMessages()) > 0;
	}

}