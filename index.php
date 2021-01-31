<!DOCTYPE html>
<html>
  <head>
<!--      Calling header php-->
      <?php include("header.php"); ?>
      <h1>Product Lines</h1>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head> 
<body>
    <div class="main">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="offices.php">Offices</a></li>
            <li><a href="payments.php">Payments</a></li>
        </ul>
    </div>

    
<?php

$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "classicmodels";

#Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
#Error Checking
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT productLine, textDescription FROM productlines";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $form = '<form action="index.php#table1" method="GET">
    <label for = "products">Please choose a product : </label>
    <select name="Products" id="products">';

    echo "<table><tr><th>Product Lines</th><th>Product Description</th></tr>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["productLine"]."</td><td>"
        .$row["textDescription"]."</td></tr>";
        $test[] = $row["productLine"];
        $form .= "<option value=".$row["productLine"].">".$row["productLine"]."</option>";

    }
    $form .= '</select> <input type="submit" name="option" value ="Submit"></form>';
    echo $form;
    echo "</table>";
    
}
else {
#Error Checking
echo "0 results";
}
if(isset($_GET['option'])){
        $choice = $_GET['Products'];
        #SQL query selecting columns from products
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2 id=table1>Product Information</h2>";
            echo "<table><tr><th>Name</th><th>Line</th><th>Scale</th><th>Vendor</th><th>Description</th><th>Stock</th><th>Buy Price</th><th>MSRP</th></tr>";
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $classicmodel = $row['productLine'];
                #Splits series into tokens using delimiter
                if (strtok($classicmodel, " ") == $choice){
                
                echo "<tr><td>"
                    .$row["productName"]."</td><td>"
                    .$row["productLine"]."</td><td>"
                    .$row["productScale"]."</td><td>"
                    .$row["productVendor"]."</td><td>"
                    .$row["productDescription"]."</td><td>"
                    .$row["quantityInStock"]."</td><td>"
                    .$row["buyPrice"]."</td><td>"
                    .$row["MSRP"]."</td></tr>";
                    }
                
            }
            echo "</table>";
        }
}
        
?>

</body>
<!--Calling the footer php-->
<?php include("footer.php"); ?>
</html>