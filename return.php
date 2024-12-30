<p>
  <a href="index.php">Vissza a főoldalra</a>
</p>
<?php
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $return_date = date('Y-m-d');

    $sql = "UPDATE rentals SET return_date='$return_date' WHERE movie_id='$movie_id' AND return_date IS NULL";

    if ($conn->query($sql) !== TRUE) {
        die("hiba: " . $conn->error);
    }
    header("Location: index.php");
    exit();
}