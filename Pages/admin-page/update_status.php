<?php
session_start();
include "../config/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Parameter tidak lengkap");
}

$id = intval($_GET['id']);
$action = $_GET['action'];

$check = mysqli_query($conn, "
    SELECT ps.schedule_id, ps.status, m.matching_id
    FROM pickup_schedules ps
    JOIN matchings m ON ps.matching_id = m.matching_id
    WHERE ps.schedule_id = $id
");

if (mysqli_num_rows($check) == 0) {
    die("Data tidak ditemukan");
}

$data = mysqli_fetch_assoc($check);
$current_status = $data['status'];

if ($action == "kembalikan") {
    if ($current_status != "Dijadwalkan") {
        die("Status tidak valid untuk aksi ini");
    }
    mysqli_query($conn, "
        UPDATE pickup_schedules 
        SET status = 'Barang Dikembalikan', updated_at = NOW()
        WHERE schedule_id = $id
    ");
    mysqli_query($conn, "
        UPDATE found_items fi
        JOIN matchings m ON fi.found_item_id = m.found_item_id
        JOIN pickup_schedules ps ON ps.matching_id = m.matching_id
        SET fi.status = 'Diserahkan'
        WHERE ps.schedule_id = $id
    ");
    mysqli_query($conn, "
        UPDATE lost_reports lr
        JOIN matchings m ON lr.lost_report_id = m.lost_report_id
        JOIN pickup_schedules ps ON ps.matching_id = m.matching_id
        SET lr.status = 'Selesai'
        WHERE ps.schedule_id = $id
    ");
}

elseif ($action == "terima") {
    if ($current_status != "Barang Dikembalikan") {
        die("Status tidak valid untuk aksi ini");
    }
    mysqli_query($conn, "
        UPDATE pickup_schedules 
        SET status = 'Diterima Pelapor', updated_at = NOW()
        WHERE schedule_id = $id
    ");
}
header("Location: pengembalian_barang.php");
exit();