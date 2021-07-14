<?php

/** 
 * Intialize of salesController to ensure database Connection.
 * @param call is a Filter Class Instance creation
 */

$call = new Filter();
class Filter
{
    function __construct()
    {
        if ($_GET['customer_name']) {
            // Be sure to set up your SQL $conn variable here
            $link=mysqli_connect("127.0.0.1","root","password","rexx");
            if( !$link ) exit( "MySQL error : ". mysqli_connect_error() );
            $sql = "SELECT * FROM bookshop WHERE customer_name = '" . $_GET['customer_name'] . "'";
            $result = mysqli_query($link, $sql);
            $data = [];
            // Save the data into an array.
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
    }
}
?>