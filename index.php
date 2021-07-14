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
            $refined_product_name = $this->conn->real_escape_string($product_name);
            $product_price = $val['product_price'];
            $sale_date = $val['sale_date'];
            $queryJSON = "INSERT INTO bookshop 
            VALUES (
                '" . $sale_id . "',
                '" . $customer_name . "',
                '" . $customer_mail . "',
                '" . $product_id . "',
                '" . $refined_product_name . "',
                '" . $product_price . "',
                '" . $sale_date . "'
                )";
            mysqli_query($this->conn, $queryJSON);
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

        th,
        td,
        p,
        input {
            font: 14px Verdana;
        }

        table,
        th,
        td {
            border: solid 1px #DDD;
            border-collapse: collapse;
            padding: 2px 3px;
            text-align: center;
        }

        th {
            font-weight: bold;
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
            if ($printOnce == 0) {
            ?>
                <tr>
                    <th>Sale ID</th>
                    <th>Customer Name</th>
                    <th>Customer Mail</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Sale Date</th>
                </tr>
            <?php
            }
            ?>
            <tr id="size">
                <td class="sale_id" id='<?php echo $rows["sale_id"] ?>'><?php echo $rows["sale_id"] ?></td>
                <td class="customer_name" id='<?php echo $rows["customer_name"] ?>'><?php echo $rows["customer_name"] ?></td>
                <td class="customer_mail" id='<?php echo $rows["customer_mail"] ?>'><?php echo $rows["customer_mail"] ?></td>
                <td class="product_id" id='<?php echo $rows["product_id"] ?>'><?php echo $rows["product_id"] ?></td>
                <td class="product_name" id='<?php echo $rows["product_name"] ?>'><?php echo $rows["product_name"] ?></td>
                <td class="product_price" id='<?php echo $rows["product_price"] ?>'><?php echo $rows["product_price"] ?></td>
                <td class="sale_date" id='<?php echo $rows["sale_date"] ?>'><?php echo $rows["sale_date"] ?></td>
            </tr>
            <tr>
            <?php
            $sum += $rows['product_price'];
            $printOnce++;
        }
            ?>
            <td colspan="7">Total Price : <?php echo $sum ?></td>
            </tr>
        </table>
        <p id="showData"></p>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
</script>

<script>
    // $(document).ready(function() {

    $(".customer_name").click(function() {
        var val = $(this).attr('id');
        // alert("customername :: " + val);

        $.get('filter.php', {
            'customer_name': val
        }, function(data) {
            var jsonData = (JSON.parse(data));
            // turn the data string into JSON

            // JSON to Array
            var resultJsonArray = Object.values(jsonData);

            // EXTRACT VALUE FOR HTML HEADER. 
            var col = [];
            for (var i = 0; i < resultJsonArray.length; i++) {
                for (var key in resultJsonArray[i]) {
                    if (col.indexOf(key) === -1) {
                        col.push(key);
                    }
                }
            }
            // Delete exiting table rows.
            $("#shop tr>td").remove();
            var table = document.createElement("table");

            // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

            var tr = table.insertRow(-1); // TABLE ROW.

            for (var i = 0; i < col.length; i++) {
                var th = document.createElement("th"); // TABLE HEADER.
                th.innerHTML = col[i];
                tr.appendChild(th);
            }
            for (var i = 0; i < resultJsonArray.length; i++) {

                tr = table.insertRow(-1);

                for (var j = 0; j < col.length; j++) {
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = resultJsonArray[i][col[j]];
                }
            }

            // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
            var divContainer = document.getElementById("showData");
            divContainer.innerHTML = "";
            divContainer.appendChild(table);

        });
    });
    // });
</script>