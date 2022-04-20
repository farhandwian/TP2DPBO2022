<?php

class Bidang extends DB
{
    /* mengambil data bidang */
    function getBidang()
    {
        $query = "SELECT * FROM bidang_divisi";
        return $this->execute($query);
    }

    /* Fungsi ambil bidang by id */
    function getBidangById($id_bidang)
    {
        $query = "SELECT * FROM bidang_divisi WHERE id_bidang = $id_bidang";
        return $this->execute($query);
    }

    /* Fungsi Input data bidang baru */
    function addBidang($data){
        $jabatan = $data['jabatan'];
        $bidang_divisi = $data['divisi'];
        $query = "insert into bidang_divisi values ('', '$jabatan', '$bidang_divisi')";
        if ($this->execute($query)) {
            echo 
            "
            <div class = 'alert alert-success' style='margin-top: 75px;'> Input Data Succes.</div>
            <a href='details.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
            ";
        }else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Input Data Gagal.</div>";
        }
    }

    /* Fungsi update data bidang divisi */
    function updateBidang($data)
    {
        $id_bidang = $data['id_bidang'];
        $jabatan = $data['jabatan'];
        $divisi = $data['divisi'];
        $query = "update bidang_divisi set jabatan = '$jabatan', id_divisi = '$divisi' where id_bidang = '$id_bidang'";
        if ($this->execute($query)) {
            echo 
            "
            <div class = 'alert alert-success' style='margin-top: 75px;'> Update Data Succes.</div>
            <a href='details.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
            ";
        }else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Update Data Gagal.</div>";
        }
    }

    /* Fungsi delete data bidang divisi */
    function deleteBidang($id_bidang)
    {
        $query = "DELETE FROM bidang_divisi WHERE id_bidang = $id_bidang";
        return $this->execute($query);
    } 
}

?>