<!DOCTYPE html>
<html>
  <head>
      <?php include("header.php"); ?>
      <h1>Recent Payments</h1>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
<body>

<?php
$servername = 'localhost:3308';
$database = 'classicmodels';
$username = 'root';
$password = '';
#Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
#Error Checking
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
#Calling Navbar php
include("navbar.php");  
$sql = "SELECT * FROM `payments` ORDER BY `payments`.`paymentDate` DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table id='Table'>";
echo "<tr>

<th>Check Number</th>
<th>Payment Date</th>
<th>Amount</th>
<th>Customer Number</th>
</tr>";
    
  while($row = mysqli_fetch_assoc($result)) {
    echo '<form id="Form" action="payments.php#table3" method="GET"></form>';
    echo "<tr><td>"
        . $row["checkNumber"]. "</td><td>" 
        . $row["paymentDate"]. "</td><td>"
        . $row["amount"]. "</td><td>"  
        . '<button type="submit" form="Form" value="' . htmlspecialchars($row["customerNumber"]) . '" name="button">' .$row["customerNumber"] 
        . "</button>" . "</td></tr>";
  }
    echo "</table>";
    
} 
#Error Checking
else {
echo "0 results";
}
 
if (isset($_GET["button"]))
{
#SQL query calls columns from both the customers and payments table. Subquery which calculates the sum of amount and stores it as "SumOfPayments" where customerNumber = value of button.
   $sql = "SELECT C.phone, C.salesRepEmployeeNumber, C.creditLimit, P.amount, (SELECT round(sum(P.amount),2) as Total FROM customers C, payments P WHERE C.customerNumber = P.customerNumber AND P.customerNumber = '".$_GET["button"]."') AS SumOfPayments FROM customers C, payments P WHERE C.customerNumber = P.customerNumber AND P.customerNumber = ".$_GET["button"]."";

   $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      echo "<br><h2 id=table3>Customer Information</h2><br>";
      echo "<table id='resultTable'>";
      echo "<tr>
      <th>Phone Number</th>
      <th>Sales Rep Employee Number</th>
      <th>Credit Limit</th>
      <th>Amount</th>
      <th>Sum Of Payments</th>
      </tr>";
        # Fetching rows using sql query column names including newly labelled column "SumOfPayments"
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" 
            . $row["phone"]. "</td><td>"
            . $row["salesRepEmployeeNumber"]. "</td><td>" 
            . $row["creditLimit"]. "</td><td>"
            . $row["amount"]. "</td><td>"
            . $row["SumOfPayments"]. "</td></tr>";
      }
        echo '</table>';
    }
}

?>
    
</body>
<!--    Calling footer php-->
    <?php include("footer.php"); ?>
</html>