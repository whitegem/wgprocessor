<?php

class WGError {

	const DEBUG = 1;
	const NOTICE = 2;
	const WARNING = 3;
	const ERROR = 4;
	const NONE = 5;

	//private static $reportlevel = self::NOTICE;
	private static $reportlevel = self::DEBUG;
	//private static $level = self::WARNING;
	private static $level = self::DEBUG;
	private static $debuginfo = array();
	// Warning: The error equal or higher than $level will stop the execution, and display the error.

	private function __construct() {
	}

	private static function errno2level($errno) {
		switch($errno) {
			case E_RECOVERABLE_ERROR:
			case E_USER_ERROR:
			case E_ERROR:
				return 4;
			case E_USER_WARNING:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
			case E_WARNING:
				return 3;
			case E_USER_NOTICE:
			case E_NOTICE:
				return 2;
			default:
				return 1;
		}
	}

	private static function printError($level, $errstr, $errfile, $errline) {
		switch($level) {
			case self::DEBUG:
				$l = 'DEBUG';
				break;
			case self::NOTICE:
				$l = 'NOTICE';
				break;
			case self::WARNING:
				$l = 'WARNING';
				break;
			case self::ERROR:
				$l = 'ERROR';
				break;
			default:
				$l = 'ERROR';
		}
		$template = WGCore::getInstance() -> getTemplate();
		$stack = debug_backtrace();
		$template -> assign('stack', $stack);
		$template -> assign('level', $l);
		$template -> assign('errmsg', $errstr);
		$template -> assign('errfile', $errfile);
		$template -> assign('errline', $errline);
		//print 'OK';
		$template -> display(WGCORE_ROOT . 'error.tpl');
		die();
	}

	public static function handleError($errno, $errstr, $errfile, $errline) {
		$level = self::errno2level($errno);
		if($level >= self::$level) {
			self::printError($level, $errstr, $errfile, $errline);
		}
		elseif($level >= self::$reportlevel) {
			self::$debuginfo[] = array($level, $errstr);
		}
	}

	public static function handleException($exception) {
		$exceptionName = get_class($exception);
		$msg = "Uncaught exception [$exceptionName]: " . $exception -> getMessage();
		$line = $exception -> getLine();
		$file = $exception -> getFile();
		$stack = $exception -> getTrace();
		$template = WGCore::getInstance() -> getTemplate();
		$template -> assign('stack', $stack);
		$template -> assign('level', 'Exception');
		$template -> assign('errmsg', $msg);
		$template -> assign('errfile', $file);
		$template -> assign('errline', $line);
		$template -> display(WGCORE_ROOT . 'error.tpl');
		die();
	}

	public static function handleFatal() {
		$err = error_get_last();
		if($err) {
			self::handleError($err['type'], $err['message'], $err['file'], $err['line']);
		}
	}

	public static function setReportingLevel($level) {
		$level = intval($level);
		if($level > 5 || $level < 1) {
			return false;
		}
		self::$level = $level;
		return true;
	}

	public static function triggerError($level, $errstr) {
		$stack = debug_backtrace();
		$caller = array_shift($stack);
		$errfile = $caller['file'];
		$errline = $caller['line'];
		$level = self::errno2level($level);
		if($level >= self::$level) {
			self::printError($level, $errstr, $errfile, $errline);
		}
		elseif($level >= self::$reportlevel) {
			self::$debuginfo[] = array($level, $errstr);
		}
	}

	public static function getFunctionName($stack) {
		if (! isset($stack['function'])) return 'Unknown';
		if (isset($stack['class'])) return $stack['class'] . $stack['type'] . $stack['function'] . '()';
		return $stack['function'] . '()';
	}

	public static function getFunctionLocation($stack) {
		if (! isset($stack['file'])) {
			print_r($stack);
			return 'Unknown';
		}
		if (! isset($stack['line'])) return $stack['file'] . ':0';
		return $stack['file'] . ':' . $stack['line'];
	}

}

set_error_handler(array('WGError', 'handleError'));
set_exception_handler(array('WGError', 'handleException'));
register_shutdown_function(array('WGError', 'handleFatal'));