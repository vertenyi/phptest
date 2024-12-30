<?php
require_once 'conn.php';

$limit = 10; // Number of entries to show in a page.

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $limit;

$count = "SELECT COUNT(id) FROM movies";
$count_result = mysqli_query($conn, $count);
$res = mysqli_fetch_row($count_result);
$order = isset($_GET['order']) ? $_GET['order'] : 'id';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'asc';
$total_records = $res[0];
$total_pages = ceil($total_records / $limit);

require_once 'htmlhead.php';
?>
<main x-data="{ start:1950, end:2024, minrate:0, maxrate:10 }">
    <h2 class="p-4 m-4 text-xl text-center">Movies</h2>
    <div class="flex justify-center">Idő intervallum: <!-- last minute megoldás ezért ezzel egyenlőre nem számol a lapozó -->
        <input type="number" x-model="start" min="1950" max="2024" class="px-2 py-1 mx-4 border border-gray-600"> - 
        <input type="number" x-model="end" min="1950" max="2024" class="px-2 py-1 mx-4 border border-gray-600">
    </div>
    <div class="flex justify-center">Értékelés intervallum: <!-- last minute megoldás ezért ezzel egyenlőre nem számol a lapozó -->
        <input type="number" x-model="minrate" min="0" max="10" step="0.1" class="px-2 py-1 mx-4 border border-gray-600"> - 
        <input type="number" x-model="maxrate" min="0" max="10" step="0.1" class="px-2 py-1 mx-4 border border-gray-600">
    </div>
    <?php

    echo '<h3 class="p-4 m-4 text-lg text-center">Összesen ' . $total_records . ' Film, Oldalak: ' . $page . './' . $total_pages . ' - ';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<a href="index.php?page=' . $i . '&order=' . $order . '&direction=' . $direction . '" class="text-xl cursor-pointer pagination ' . ($i == $page ? 'underline font-bold text-green-600' : '') . '"> ' . $i . ' </a>';
    }
    echo "<h3>";
    /* $sql = "SELECT * FROM movies ORDER BY $order $direction LIMIT $start_from, $limit"; */
    $sql = "SELECT movies.*, rentals.rental_date, rentals.return_date, rentals.customer_name 
        FROM movies 
        LEFT JOIN rentals ON movies.id = rentals.movie_id AND rentals.return_date IS NULL 
        ORDER BY $order $direction 
        LIMIT $start_from, $limit";
        
    $rs_result = mysqli_query($conn, $sql);
    ?>

    <!-- <p class="text-center">
        <a href="rentals.php" class="p-2 m-2 text-white bg-blue-500 rounded">Rentals</a>
    </p> -->
    <p class="pt-4 text-center">Fejlécre kattintással rendezhető</p>
    <table class="mx-auto mt-4 mb-16 border-2 border-gray-300">
        <tr>
            <th>
                <a href="index.php?order=id&direction=<?php echo (isset($_GET['direction']) && $_GET['direction'] == 'desc') ? 'asc' : 'desc'; ?>&page=<?php echo $page; ?>">
                    ID
                </a>
            </th>
            <th>
                <a href="index.php?order=title&direction=<?php echo (isset($_GET['direction']) && $_GET['direction'] == 'desc') ? 'asc' : 'desc'; ?>&page=<?php echo $page; ?>">
                    Title
                </a>
            </th>
            <th>
                <a href="index.php?order=genre&direction=<?php echo (isset($_GET['direction']) && $_GET['direction'] == 'desc') ? 'asc' : 'desc'; ?>&page=<?php echo $page; ?>">
                    Genre
                </a>
            </th>
            <th>
                <a href="index.php?order=release_year&direction=<?php echo (isset($_GET['direction']) && $_GET['direction'] == 'desc') ? 'asc' : 'desc'; ?>&page=<?php echo $page; ?>">
                    Year
                </a>
            </th>
            <th>
                <a href="index.php?order=rating&direction=<?php echo (isset($_GET['direction']) && $_GET['direction'] == 'desc') ? 'asc' : 'desc'; ?>&page=<?php echo $page; ?>">
                    Rating
                </a>
            </th>
            <th>Rent</th>
            <th>Return</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($rs_result)) {
        ?>
            <!-- <tr class="border border-gray-300 hover:bg-gray-200" x-show="start <= <?php echo $row["release_year"]; ?> && end >= <?php echo $row["release_year"]; ?>"> -->
            <tr class="border border-gray-300 hover:bg-gray-200" :class="start <= <?php echo $row["release_year"]; ?> && end >= <?php echo $row["release_year"]; ?> 
                                && minrate <= <?php echo $row["rating"]; ?> && maxrate >= <?php echo $row["rating"]; ?>
                                ? '' : 'text-gray-300'">    
                <td class="p-2"><?php echo $row["id"]; ?></td>
                <td class="p-2"><?php echo $row["title"]; ?></td>
                <td class="p-2"><?php echo $row["genre"]; ?></td>
                <td class="p-2"><?php echo $row["release_year"]; ?></td>
                <td class="p-2"><?php echo $row["rating"]; ?></td>
                <td class="p-2">
                    <?php 
                    if($row["rental_date"] && !$row["return_date"]){
                        echo $row["customer_name"];} else {
                    ?>
                    <form method="POST" action="rent.php">
                        <input type="hidden" name="movie_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" class="p-2 m-2 text-white bg-green-500 rounded">Kölcsönöz</button>
                    </form>
                    <?php } ?>
                </td>
                <td class="p-2">
                <?php 
                    if($row["rental_date"] && !$row["return_date"]){
                    ?>
                    <form method="POST" action="return.php">
                        <input type="hidden" name="movie_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" class="p-2 m-2 text-white bg-red-500 rounded">Visszavesz</button>
                    </form>
                    <?php } ?>
                </td>
            </tr>
        <?php
        };
        ?>
    </table>
</main>
<?php
require_once 'htmlfoot.php';
?>