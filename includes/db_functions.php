<?php 
include __DIR__ . '/config.php';

function query($query, $params = []) {
    global $conn;

    // Jika tidak ada parameter
    if (empty($params)) {
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Jika menggunakan prepared statement
    $stmt = mysqli_prepare($conn, $query);
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
?>
