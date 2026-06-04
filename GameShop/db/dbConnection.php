<?php
    class DBConn {

        private static $servername = "localhost";
        private static $username = "root";
        private static $password = "";
        private static $dbname = "GameShop";

        private static $conn;

        public static function getConn() {
            if(!isset(self::$conn)) {
                self::$conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

                if (self::$conn->connect_error) {
                    die("Connection failed: " . self::$conn->connect_error);
                }
            }
            return self::$conn;
        }
    }
?>