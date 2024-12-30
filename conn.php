<?php
$env = parse_ini_file('env.ini', true);

if ($env === false) {
    die("Hiba az env.ini fájl beolvasása közben!");
}

$db_name = $env['database']['DB_NAME'];
$db_user = $env['database']['DB_USER'];
$db_password = $env['database']['DB_PASSWORD'];
$db_host = $env['database']['DB_HOST'] ?? "localhost";

if (empty($db_name) || empty($db_user)) {
    die("Hiányzó változók az env.ini fájlban! Ellenőrizze a fájlt.");
}

// Kapcsolódás a MySQL szerverhez (anélkül, hogy kiválasztanánk az adatbázist)
$conn = new mysqli($db_host, $db_user, $db_password);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ellenőrizzük, hogy létezik-e az adatbázis
$sql = "SHOW DATABASES LIKE '$db_name'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // Adatbázis létrehozása
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if ($conn->query($sql) !== TRUE) {
        die("Adatbázis létrehozási hiba: " . $conn->error);
    }

    // Adatbázis kiválasztása
    $conn->select_db($db_name);

    // Táblák létrehozása (a korábbi kód)
    $sql = "CREATE TABLE IF NOT EXISTS movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            genre VARCHAR(255),
            release_year INT,
            rating FLOAT
        )";
    if ($conn->query($sql) !== TRUE) {
        die("movies tábla létrehozási hiba: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS rentals (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            customer_name VARCHAR(255) NOT NULL,
            rental_date DATE NOT NULL,
            return_date DATE,
            FOREIGN KEY (movie_id) REFERENCES movies(id)
        )";
    if ($conn->query($sql) !== TRUE) {
        die("rentals tábla létrehozási hiba: " . $conn->error);
    }

    echo "Az adatbázis és a táblák sikeresen létre lettek hozva.";
} else {
    /* echo "Az adatbázis már létezik."; */
}
$conn->select_db($db_name);

// Ellenőrizzük, hogy a movies tábla üres-e
$count = "SELECT COUNT(*) as count FROM movies";
$result = $conn->query($count);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    require_once 'fill_movies.php';
    fillWithMovies($conn);
}
