<?php
require_once 'conn.php'; 

function createDatabaseAndTables()
{
    // Ellenőrizzük, hogy létezik-e az adatbázis
    $sql = "SHOW DATABASES LIKE '$db_name'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) { // Az adatbázis NEM létezik
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
        echo "Az adatbázis már létezik.";
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

    $conn->close();
}