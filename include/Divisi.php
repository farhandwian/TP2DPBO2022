<?php

class Divisi extends DB
{
    // fungsi mengambil semua data di tabel divisi
    function getDivisi()
    {
        $query = "SELECT * FROM divisi";
        return $this->execute($query);
    }

    // fungsi tambah data divisi baru
    function addDivisi($data)
    {
        $divisi = $data['divisi'];

        $query = "insert into divisi values ('', '$divisi')";
        if ($this->execute($query)) {
            echo
            "
            <div class = 'alert alert-success' style='margin-top: 75px;'> Input Data Succes.</div>
            <a href='details.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
            ";
        } else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Input Data Gagal.</div>";
        }
    }

    // fungsi hapus data divisi
    function deleteDivisi($id_divisi)
    {
        $query = "DELETE FROM divisi WHERE id_divisi = $id_divisi";
        return $this->execute($query);
    }

    // fungsi update data divisi
    function updateDivisi($data)
    {
        $id_divisi = $data['id_divisi'];
        $divisi = $data['divisi'];
        $query = "update divisi set nama_divisi = '$divisi' where id_divisi = '$id_divisi'";
        if ($this->execute($query)) {
            echo
            "
            <div class = 'alert alert-success' style='margin-top: 75px;'> Update Data Succes.</div>
            <a href='details.php'><button class='btn btn-outline-info' type='button'> Kembali ke Menu Utama </button></a>
            ";
        } else {
            echo "<div class = 'alert alert-danger' style='margin-top: 75px;'> Update Data Gagal.</div>";
        }
    }

    // fungsi mengambil divisi by id
    function getDivisiById($id_divisi)
    {
        $query = "SELECT * FROM divisi WHERE id_divisi = $id_divisi";
        return $this->execute($query);
    }
}
