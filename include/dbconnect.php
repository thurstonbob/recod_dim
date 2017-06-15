<?
$servername = "livenne";
$username = "u400274";
$password = "drap26drwz";
$dbname = "tas";
setlocale(LC_MONETARY, 'fr_FR');
//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$conn->query('SET NAMES utf8');
?>
