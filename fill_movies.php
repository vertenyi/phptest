<?php
function fillWithMovies($conn)
{
    $sql = "INSERT INTO movies (title, genre, release_year, rating) VALUES
        ('The Shawshank Redemption', 'Drama', 1994, 9.3),
        ('The Godfather', 'Crime', 1972, 9.2),
        ('The Dark Knight', 'Action', 2008, 9.0),
        ('The Lord of the Rings: The Return of the King', 'Adventure', 2003, 8.9),
        ('Pulp Fiction', 'Crime', 1994, 8.9),
        ('Forrest Gump', 'Drama', 1994, 8.8),
        ('Inception', 'Action', 2010, 8.8),
        ('The Lord of the Rings: The Fellowship of the Ring', 'Adventure', 2001, 8.8),
        ('Fight Club', 'Drama', 1999, 8.8),
        ('The Matrix', 'Action', 1999, 8.7),
        ('Goodfellas', 'Crime', 1990, 8.7),
        ('The Empire Strikes Back', 'Adventure', 1980, 8.7),
        ('One Flew Over the Cuckoo\'s Nest', 'Drama', 1975, 8.7),
        ('Interstellar', 'Adventure', 2014, 8.6),
        ('City of God', 'Crime', 2002, 8.6),
        ('Spirited Away', 'Animation', 2001, 8.6),
        ('Saving Private Ryan', 'Drama', 1998, 8.6),
        ('The Green Mile', 'Crime', 1999, 8.6),
        ('Life Is Beautiful', 'Comedy', 1997, 8.6),
        ('The Usual Suspects', 'Crime', 1995, 8.5),
        ('Léon: The Professional', 'Crime', 1994, 8.5),
        ('The Lion King', 'Animation', 1994, 8.5),
        ('Gladiator', 'Action', 2000, 8.5),
        ('Terminator 2: Judgment Day', 'Action', 1991, 8.5),
        ('Back to the Future', 'Adventure', 1985, 8.5),
        ('Whiplash', 'Drama', 2014, 8.5),
        ('The Prestige', 'Drama', 2006, 8.5),
        ('The Departed', 'Crime', 2006, 8.5),
        ('The Pianist', 'Biography', 2002, 8.5),
        ('The Intouchables', 'Biography', 2011, 8.5);";
    if ($conn->query($sql) !== TRUE) {
        die("movies tábla feltöltési hiba: " . $conn->error);
    }
}