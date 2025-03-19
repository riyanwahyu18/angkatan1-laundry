<?php
    $host_koneksi = "localhost"; //bawaaan
    $host_username = "root"; // bawaan mysql
    $host_password = ""; //boleh kosong karena default
    $host_database = "angkatan1_laundry"; //sesuai nama di database yang dibuat

    $koneksi = mysqli_connect($host_koneksi, $host_username, $host_password, $host_database);
    if (!$koneksi){
        echo "Koneksi Tidak Berhasil";
    }
?>