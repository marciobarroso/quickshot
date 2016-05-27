<?php
namespace QuickShot\Common\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;

use QuickShot\Common\AbstractComponent;

abstract class AbstractAction extends AbstractComponent {

	private $view;
	private $router;

	public function __construct(Container $container) {
		parent::__construct($container);
		$this->view = $this->getContainer()->get('view');
		$this->router = $this->getContainer()->get("router");
	}

	public function getView() {
		return $this->view;
	}

	public function getPolicies() {
		return $this->policies;
	}

	public function getPathFor($name) {
		return $this->router->pathFor($name);
	}

	public function redirect(Response $response, $routeName) {
		$uri = $this->router->pathFor($routeName);
		return $response->withRedirect($uri);   
	}
}