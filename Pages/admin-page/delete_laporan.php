<?php
include "../config/connection.php";

$type = $_GET['type'] ?? null;
$id = $_GET['id'] ?? null;  

if (!$type || !$id) {
    die("Invalid");
}

if ($type === 'lost') {
    $sql = "DELETE from lost_reports
                WHERE lost_report_id = '$id'";

    if (mysqli_query($conn, $sql))
    header("location:laporan_hilang.php");
    exit();

} else if ($type === 'found') {
    $sql = "DELETE from found_items
                WHERE found_item_id = '$id'";

    if (mysqli_query($conn, $sql))
    header("location:laporan_temuan.php");
    exit();

} else {
    die("Invalid");
}
?>