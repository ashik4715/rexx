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
$connect = new mysqli($servername, $username, $password, $dbname);

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

        $sql = "CREATE TABLE bookshop (
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

    function read()
    {
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rexx Systems Coding Challange</title>

    <style>
        #shop {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #shop td,
        #shop th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #shop tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #shop tr:hover {
            background-color: #ddd;
        }

        #shop th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>

</head>

<body>
    <?php
    /**
     * database query for displaying all rows into html table
     * @param sql1
     */
    $sql1 = "SELECT * from `bookshop`;";
    $result1 = $connect->query($sql1);
    while ($rows = $result1->fetch_array()) {
    ?>
        <table id="shop" style="width:100%">
            <tr>
                <th>Sale ID</th>
                <th>Customer Name</th>
                <th>Customer Mail</th>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Product Price</th>
                <th>Sale Date</th>
            </tr>
            <tr>
                <td><?php echo $rows["sale_id"] ?></td>
                <td><?php echo $rows["customer_name"] ?></td>
                <td><?php echo $rows["customer_mail"] ?></td>
                <td><?php echo $rows["product_name"] ?></td>
                <td><?php echo $rows["product_id"] ?></td>
                <td><?php echo $rows["product_price"] ?></td>
                <td><?php echo $rows["sale_date"] ?></td>
            </tr>
            <tr>
                <td colspan="7">Total Price : </td>
            </tr>
        </table>

</body>

</html>
<?php
    }
?>