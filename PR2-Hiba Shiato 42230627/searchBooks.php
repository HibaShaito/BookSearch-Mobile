<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$search_query = addslashes(strip_tags($_GET['query']));

$con = mysqli_connect("fdb1028.awardspace.net", // Replace with your actual hostname
                     "4558232_hiba",           // Replace with your database username
                     "6Alah1is@the-key-",      // Replace with your database password
                     "4558232_hiba");         // Replace with your database name

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// SQL query to fetch books with author and subject information
$sql = "SELECT books.id, books.title, authors.name AS author, subjects.name AS subject, books.book_picture
        FROM books
        INNER JOIN authors ON books.author_id = authors.id
        INNER JOIN subjects ON books.subject_id = subjects.id
        WHERE books.title LIKE '%$search_query%' 
        OR authors.name LIKE '%$search_query%' 
        OR subjects.name LIKE '%$search_query%'";

if ($result = mysqli_query($con, $sql)) {
    $emparray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $emparray[] = $row;
    }

    echo(json_encode($emparray)); // Return result as JSON
    // Free result set
    mysqli_free_result($result);
    mysqli_close($con);
}
?>
