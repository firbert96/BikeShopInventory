<?php
    class Database{
        protected $db;

		function __construct() {
			$this->db = mysqli_connect(
				"localhost",
				"root",
				"",	
				"bike_shop_inventory"
			);
			if (!$this->db){
				die("ERROR: Unable to connect");
			}
		}

		function get_error() {
			return $this->db->error;
		}

		function sanitize($value){
			return $this->db->real_escape_string($value);
		}
    }
?>