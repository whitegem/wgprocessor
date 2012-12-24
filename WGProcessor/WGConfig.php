<?php

class WGConfigNode {

	private $instance = NULL;

	public function __construct($xmlInstance) {
		$this -> instance = $xmlInstance;
	}

	public function __get($node) {
		$ret = $this -> instance -> $node;
		if ($ret -> getName() == '') {
			$curname = $this -> instance -> getName();
			throw new WGException(('Current Node <' . $curname . '> has no child named <' . $node . '>'));
		}
		return new self($ret);
	}

	public function __toString() {
		return (string)$this -> instance;
	}
}

class WGConfig {

	private static $instance = NULL;
	private $root = NULL;

	private function __construct() {
		$this -> root = new WGConfigNode(simplexml_load_file(WGPROCESSOR_ROOT . 'config.xml'));
	}

	public static function getInstance() {
		if(self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __get($node) {
		return $this -> root -> __get($node);
	}
}