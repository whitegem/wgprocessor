<?php

define('IN_WGPROCESSOR',1);
define('DS', DIRECTORY_SEPARATOR);
define('WGPROCESSOR_VERSION', '0.0.1 Alpha');
define('WGPROCESSOR_ROOT', dirname(__FILE__) . DS);
//error_reporting(0);

class WGCore {

	private static $instance = NULL;
	private $template = NULL;
	private $runtime = 0.0;

	private function __construct() {
		$this -> runtime = microtime(true);
		$this -> template = new WGTemplate();
		$this -> template -> left_delimiter = '{{';
		$this -> template -> right_delimiter = '}}';
		$this -> template -> debugging = false;
		$this -> template -> setCompileDir(WGPROCESSOR_ROOT . 'compile');
		$this -> template -> setCacheDir(WGPROCESSOR_ROOT . 'compile');
		WGTemplate::muteExpectedErrors();
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

require_once(WGPROCESSOR_ROOT . 'WGException.php');
require_once(WGPROCESSOR_ROOT . 'WGError.php');
require_once(WGPROCESSOR_ROOT . 'WGConfig.php');
require_once(WGPROCESSOR_ROOT . 'WGTemplate.php');

WGCore::getInstance();
var_dump(WGConfig::getInstance() -> MySQL -> getName());