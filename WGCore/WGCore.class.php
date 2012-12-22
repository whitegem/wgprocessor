<?php

define('IN_WGCORE',1);
define('DS', DIRECTORY_SEPARATOR);
define('WGCORE_VERSION', '0.0.1 Alpha');
define('WGCORE_ROOT', dirname(__FILE__) . DS);

require_once(WGCORE_ROOT . 'template'. DS . 'Smarty.class.php');

class WGCore {

	private static $instance = NULL;
	private $template = NULL;

	private function __construct() {
		$this -> template = new Smarty();
	}

	public static function getInstance() {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getTemplate() {
		return $this -> template;
	}
}

set_error_handler(array('Error_Handler', 'handleError'));

$WGCore = WGCore::getInstance();

A;