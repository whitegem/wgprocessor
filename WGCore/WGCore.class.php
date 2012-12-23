<?php

define('IN_WGCORE',1);
define('DS', DIRECTORY_SEPARATOR);
define('WGCORE_VERSION', '0.0.1 Alpha');
define('WGCORE_ROOT', dirname(__FILE__) . DS);

class WGCore {

	private static $instance = NULL;
	private $template = NULL;
	private $runtime;

	private function __construct() {
		$this -> runtime = microtime(true);
		$this -> template = new WGTemplate();
		$this -> template -> left_delimiter = '{{';
		$this -> template -> right_delimiter = '}}';
		$this -> template -> debugging = false;
		$this -> template -> setCompileDir(WGCORE_ROOT . 'compile');
		$this -> template -> setCacheDir(WGCORE_ROOT . 'compile');
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

require_once(WGCORE_ROOT . 'WGTemplate.php');
require_once(WGCORE_ROOT . 'WGError.php');

WGCore::getInstance();
