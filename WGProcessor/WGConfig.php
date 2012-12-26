<?php

class WGConfigNode { // Can call all function in SimpleXMLIterator

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

	public function __call($name, $args) {
		if(! method_exists($this -> instance, $name)) {
			throw new WGException('WGConfigNode has no method called ' . $name);
		}
		return call_user_func_array(array(&$this -> instance, $name), $args);
	}

	public function asArray() {
		// Warning: It will return a string if it has no child node!
		echo 'OK, ' . $this -> instance -> getName();
		$this -> instance -> rewind();
		if($this -> instance -> getName() == 'Directory') {
			var_dump($this -> instance);
			var_dump($this -> hasChildren());
		}
		if ($this -> instance -> hasChildren()) {
			$ret = array();
			for($this -> instance -> rewind(); $this -> instance -> valid(); $this -> instance -> next()){
				foreach($this -> instance -> getChildren() as $name => $cls) {
					$t = new self($cls);
					if(isset($ret[$name])) {
						if(!is_array($ret[$name][0]))
							$ret[$name] = array(0 => $ret[$name]);
						$ret[$name][] = $t -> asArray();
					} else
						$ret[$name] = $t -> asArray();
				}
			}
			var_dump($ret);
			return $ret;
		}
		var_dump((string) $this -> instance);
		return (string)$this -> instance;
	}
}

class WGConfig {

	private static $instance = NULL;
	private $root = NULL;

	private function __construct() {
		$this -> root = new WGConfigNode(simplexml_load_file(WGPROCESSOR_ROOT . 'config.xml', 'SimpleXMLIterator'));
	}

	public static function getInstance() {
		if(self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __get($node) {
		if ($node == '') return $this -> root;
		return $this -> root -> __get($node);
	}

	public function __call($name, $args) {
		return call_user_func_array(array(&$this -> root, $name), $args);
	}
}