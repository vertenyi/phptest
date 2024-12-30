<p>
  <a href="index.php">Vissza a főoldalra</a>
</p>

<?php
require_once 'conn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $movie_id = $_POST['movie_id'];



  $sql = "SELECT * FROM rentals WHERE movie_id = '$movie_id' AND return_date IS NULL";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    die("A film már ki van kölcsönözve!");
  }

  // mivel a customer_name jöhetne később loginból, ezért ellenőrizni kell, hogy van-e
  if (!isset($_POST['customer_name'])) {
  ?>
    <form method="POST" action="rent.php">
      <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
      <p><label for="customer_name">Kölcsönző neve:</label>
        <input type="text" id="customer_name" name="customer_name" required>
      </p>
      <p>
        <label for="rental_date">Kölcsönzési dátum:</label>
        <input type="date" name="rental_date" value="<?php echo date('Y-m-d'); ?>">
      </p>
      <button type="submit" class="p-2 m-2 text-white bg-green-500 rounded">Rent</button>
    </form>
  <?php
  }else{

  $customer_name = $_POST['customer_name'];
  $rental_date = $_POST['rental_date']; // ez lehetne date('Y-m-d') is 

  $sql = "INSERT INTO rentals (movie_id, customer_name, rental_date) VALUES ('$movie_id', '$customer_name', '$rental_date')";

  if ($conn->query($sql) !== TRUE) {
    die("Kölcsönzési hiba: " . $conn->error);
  }
  header("Location: index.php");
    exit(); 
  }
}
