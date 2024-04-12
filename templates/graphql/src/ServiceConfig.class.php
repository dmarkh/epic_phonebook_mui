<?php

class ServiceConfig {
    var $cfg = NULL;
    var $destruct = 0;

	function __construct() {
		$this->Init();
	}

    function ServiceConfig() {
		$this->Init();
	}

    static function &Instance () {
        static $instance;
        if ( !isset($instance) ) {
			$c = __CLASS__;
			$instance = new $c;
		}
        return $instance;
    }

    function Init() {
        // $path = dirname(__FILE__); $path = str_replace(basename($path), '', $path); $path .= 'config/service.conf.php';
		require_once( __DIR__ . '/../config/service.conf.php' );
		if ( function_exists( 'get_config' ) ) {
			$this->cfg = get_config();
		} else {
			$this->cfg = array();
		}
    }

    function Get($section, $param = NULL) {
		if (!empty($param)) {
		    return $this->cfg[$section][$param];
		}
		return $this->cfg[$section];
    }

    function ListAll() {
		echo '<pre>'; print_r($this->cfg); echo '</pre>';
	}
}