
<?php
$host = "localhost";
$user = "root";     // default user Laragon
$pass = "";         // default password kosong
$db   = "eiger";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
