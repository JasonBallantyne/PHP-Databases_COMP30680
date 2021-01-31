<!DOCTYPE html>
<html>
  <head>
<!--      Calling header php-->
      <?php include("header.php"); ?>
      <h1>Office Information</h1>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
<body>
 
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
#Calling Navbar php
include("navbar.php");
echo "<table id='mainTable'>";
echo "<tr>
<th>Office Code</th>
<th>City</th>
<th>Address</th>
<th>Phone Number</th>
<th>Employees</th>
</tr>";
# Sql query extrating necessary columns from offices table
$sql = "SELECT officeCode, city, addressLine1, addressLine2, state, country, phone FROM offices";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo '<form id="mainForm" action="offices.php#table2" method="GET"></form>';
    echo "<tr>
    <td>" . $row["officeCode"]. "</td>
    <td>" . $row["city"]. "</td>
    <td>" . $row["addressLine1"]. "  "
    . $row["addressLine2"]."  "
    . $row["state"]."  "
    . $row["country"]. "</td>
    <td>" . $row["phone"]. "</td>
    <td>" . '<button type="submit" form="mainForm" value="' . htmlspecialchars($row["officeCode"]) . '" name="mybutton">' . "Additional Info</button>" . "</td></tr>";
  }
    echo "</table>";

} 
#Error Checking
else {
echo "0 results";
}
  
if (isset($_GET["mybutton"])){
    #Sql query getting columns where officecode = value of the button, ordered by job title
    $sql = "SELECT * FROM employees WHERE officeCode = '".$_GET["mybutton"]."'ORDER BY jobTitle";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      echo "<br><h2 id=table2>Employee Additional Information</h2><br>";
      echo "<table id='resultTable'>";
      echo "<tr>
      <th>Full Name</th>
      <th>Job Title</th>
      <th>Employee Number</th>
      <th>Email Address</th>
      </tr>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["firstName"]. " ". $row["lastName"]. "</td><td>" . $row["jobTitle"]. "</td><td>" . $row["employeeNumber"]. "</td><td>" . $row["email"]. "</td></tr>";
      }
        echo '</table>';
    }
}
?>

</body>
<!--    Calling footer php-->
    <?php include("footer.php"); ?>
</html>