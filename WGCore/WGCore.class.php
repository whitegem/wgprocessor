<?php

error_reporting(0);

define('IN_WGCORE',1);
define('DS', DIRECTORY_SEPARATOR);
define('WGCORE_VERSION', '0.0.1 Alpha');
define('WGCORE_ROOT', dirname(__FILE__) . DS);

require_once(WGCORE_ROOT . 'template'. DS . 'Smarty.class.php');
require_once(WGCORE_ROOT . 'modules'. DS . 'error_handler.php');

class WGCore {

	private static $instance = NULL;
	private $template = NULL;
	private $runtime;

	private function __construct() {
		$this -> runtime = microtime(true);
		$this -> template = new Smarty();
		$this -> template -> left_delimiter = '{{';
		$this -> template -> right_delimiter = '}}';
		$this -> template -> debugging = false;
		$this -> template -> setCompileDir(WGCORE_ROOT . 'compile');
		$this -> template -> setCacheDir(WGCORE_ROOT . 'compile');
		Smarty::muteExpectedErrors();
	}

	public static function getInstance() {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getTemplate() {
		$this -> template -> assign('WGCore', $this);
		return $this -> template;
	}

	public function getRuntime() {
		return microtime(true) - $this -> runtime;
	}
}

$WGCore = WGCore::getInstance();

set_error_handler(array('Error_Handler', 'handleError'));
set_exception_handler(array('Error_Handler', 'handleException'));
register_shutdown_function(array('Error_Handler', 'handleFatal'));

throw new Exception('Test');