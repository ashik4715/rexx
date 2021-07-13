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
$salesController->read();

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
            product_price VARCHAR(100) NOT NULL,
            sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table BookShop created successfully \n";
        } else {
            echo "Error creating table: " . $this->conn->error . "\n";
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

        // get containts from sales JSON
        $jsonContents = file_get_contents('sales.json');

        // decode JSON data to PHP array
        $data = json_decode($jsonContents, true);

        // fetch sales details and assign to variables for database insertion
        // Insert the fetched Data into Database 
        foreach ($data as $val) {
            $sale_id = $val["sale_id"];
            $customer_name = $val["customer_name"];
            $customer_mail = $val["customer_mail"];
            $product_id = $val["product_id"];
            $product_name = $val['product_name'];
            $product_price = $val['product_price'];
            $sale_date = $val['sale_date'];
            $queryJSON = "INSERT INTO bookshop 
            VALUES (
                '" . $sale_id . "',
                '" . $customer_name . "',
                '" . $customer_mail . "',
                '" . $product_id . "',
                '" . $product_name . "',
                '" . $product_price . "',
                '" . $sale_date . "'
                )";
            mysqli_query($this->conn, $queryJSON);
        }
        print_r($data);
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
     * @param sql1 to print all existing data of database
     * @param printOnce is to print only once of HTML Table Head Rows
     */
    $printOnce = 0;
    $sql1 = "SELECT * from `bookshop`;";
    $result1 = $connect->query($sql1);
    while ($rows = $result1->fetch_array()) {
    ?>
        <table id="shop" style="width:100%">
            <?php
            if ($printOnce==0) {
            ?>
                <tr>
                    <th>Sale ID</th>
                    <th>Customer Name</th>
                    <th>Customer Mail</th>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Product Price</th>
                    <th>Sale Date</th>
                </tr>
            <?php
            }
            ?>
            
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
    $printOnce++;
    }
?>