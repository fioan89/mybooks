<?php
require_once 'config.php';

    class DBManager {
    	private $con;
		private static $instance;
		
		private function __construct() {
			// DBHOST, DBUSER, DBPW constants are defined in
			// config.php file.
			$this->con = mysql_connect(DBHOST, DBUSER, DBPW);
			if (!$this->con) {
				print("Could not connect to mysql server!");
			}	
		}
		
		public static function getInstance() {
			if (is_null(self::$instance)) {
				self::$instance = new self();
				return self::$instance;
			}
			return self::$instance;
		}
		
		public function getConnection() {
			return $this->con;
		}
    }
?>