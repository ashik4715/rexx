<?php

/** 
 * Intialize of salesController to ensure database Connection.
 * @param servername is the Servername of Apache Localserver
 * @param username is the name of database username
 * @param password is the database password
 * @param dbname is the database name
 * @param salesController is intial method call for database connection
 */

$servername = "127.0.0.1";
$username = "root";
$password = "password";
$dbname = "rexx";
$salesController = new SalesController($servername, $username, $password, $dbname);

class SalesController
{
    private $conn = "";

    /** 
     * Constructor function for SalesController Class
     * @param sql 
     */
    function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            echo "Database successfully connected. \n";
        }
        
        $sql = "CREATE TABLE BookShop (
            sale_id MEDIUMINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(100) NOT NULL,
            customer_mail VARCHAR(100) NOT NULL,
            product_id MEDIUMINT(8) UNSIGNED NOT NULL,
            product_name VARCHAR(100) NOT NULL,
            product_price VARCHAR(1000) NOT NULL,
            sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table BookShop created successfully \n";
        } else {
            echo "Error creating table: " . $this->conn->error;
        }
    }

    function read(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $name = $_POST['fname'];
            if (empty($name)) {
              echo "Name is empty";
            } else {
              echo $name;
            }
          }
    }
}
