<?php

class Pengurus extends DB
{
    /* fungsi mengambil semua data di tabel pengurus */
    function getPengurus()
    {
        $query = "SELECT * FROM pengurus";
        return $this->execute($query);
    }

    /* fungsi mengambil data pengurus berdasarkan nim */
    function getPengurusById($nim)
    {
        $query = "SELECT * FROM pengurus WHERE nim = $nim";
        return $this->execute($query);
    }

    /* fungsi tambah pengurus baru */
    function addPengurus($data)
    {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $semester = $data['semester'];
        $bidang_divisi = $data['bidang_divisi'];

        /* upload foto */
        $extensi = array('jpg', 'png');          //ekstensi yang di ijinkan
        $nama_file = $_FILES['foto']['name'];   //mengambil nama file dari input form
        $x = explode('.', $nama_file);
        $extension = strtolower(end($x));
        $size = $_FILES['foto']['size'];            //mengambil ukuran file
        $file_temp = $_FILES['foto']['tmp_name'];

        // jika ekstensi sesuai
        if (in_array($extension, $extensi) === true) {
            // jika ukuran sesuai dengan syarat
            if ($size < 1044070) {
                // masukan foto dari input form ke dalam local
                move_uploaded_file($file_temp, 'assets/' . $nama_file);

                // jalankan query
                $query = "insert into pengurus values ('$nim', '$nama', '$semester', '$nama_file', '$bidang_divisi')";
                if ($this->execute($query)) {
                    echo
                    "
                    <div class = 'alert alert-success' style='margin-top: 75px;'> Input Data Succes.</div>
                    <a href='index.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
                    ";
                } else {
                    echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Input Data Gagal.</div>";
                }
            } else {
                echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> File Terlalu Besar.</div>";
            }
        } else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Extensi Tidak Sesuai.</div>";
        }
    }

    // fungsi untuk update data pengurus
    function updatePengurus($data)
    {
        // mengambil data dari form input
        $nim_id = $data['nim_old'];
        $nim_new = $data['nim'];
        $nama = $data['nama'];
        $semester = $data['semester'];
        $bid_div = $data['bidang_divisi'];

        /* upload foto */
        $extensi = array('jpg', 'png', '');           //ekstensi yang di ijinkan, di sini terdapat ekstensi kosong agar saat update tidak perlu memasukan kembali foto
        $nama_file = $_FILES['foto']['name'];
        $x = explode('.', $nama_file);
        $extension = strtolower(end($x));
        $size = $_FILES['foto']['size'];
        $file_temp = $_FILES['foto']['tmp_name'];

        // jika ekstensi foto sesuai dengan yang telah di syaratkan sebelumnya
        if (in_array($extension, $extensi) === true) {
            // jika size kurang dari syarat
            if ($size < 1044070) {
                // jika size nya lebih dari 0, yaitu dimana ketika user ingin mengupdate foto juga, maka input form akan kosong
                if ($size > 0) {
                    // jika fomr input dari form foto_hapus tidak kosong
                    if (!empty($data['foto_hapus'])) {
                        // hapus foto dari lama dari local
                        unlink("assets/" . $data['foto_hapus']);
                    }
                    // masukan foto baru ke local
                    move_uploaded_file($file_temp, 'assets/' . $nama_file);
                    $query = "update pengurus set nim = '$nim_new', nama = '$nama', semester = '$semester', foto = '$nama_file', id_bidang = '$bid_div' where nim = '$nim_id'";
                }
                // jika size nya 0, yaitu dimana ketika user tidak ingin mengupdate foto, maka input form akan kosong
                else {
                    // jika 
                    $query = "update pengurus set nim = '$nim_new', nama = '$nama', semester = '$semester', id_bidang = '$bid_div' where nim = '$nim_id'";
                }

                if ($this->execute($query)) {
                    echo
                    "
                    <div class = 'alert alert-success' style='margin-top: 75px;'> Update Data Succes.</div>
                    <a href='index.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
                    ";
                } else {
                    echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Update Data Gagal.</div>";
                }
            } else {
                echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> File Terlalu Besar.</div>";
            }
        } else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Extensi Tidak Sesuai.</div>";
        }
    }

    /* Fungsi Menghapus Data Pengurus */
    function deletePengurus($nim)
    {
        $query = "DELETE FROM pengurus WHERE nim = $nim";
        return $this->execute($query);
    }
}
