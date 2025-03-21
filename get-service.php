<?php
    include 'koneksi.php';

    $id = isset($_GET['id_service']) ? $_GET['id_service'] : ' ';

    $query = mysqli_query($koneksi, "SELECT * FROM services WHERE id = '$id'");
    $row = mysqli_fetch_assoc($query);

    $response = ['status' => 'success','messege'=> 'fetch data services success', 'data' => $row];
    echo json_encode($response);
