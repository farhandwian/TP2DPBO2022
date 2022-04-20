<?php

include("conf.php");
include("./include/Template.php");
include("./include/DB.php");
include("./include/Divisi.php");
include("./include/Bidang.php");
include("./include/Pengurus.php");

//=============================================================
/* TABEL PENGURUS */
$pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
$pengurus->open();
$bidang = new Bidang($db_host, $db_user, $db_pass, $db_name);
$bidang->open();
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();

// jika nim kosong
if (!empty($_GET['nim'])) {
    //ambil nim dan ambil data pengurus by nim
    $nim = $_GET['nim'];
    $pengurus->getPengurusById($nim);
} else {
    echo "<div class='alert alert-danger'> DATA TIDAK ADA.</div>";
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    // menghapus foto dari local file
    $pengurus->getPengurusById($id);
    $foto_hapus = $pengurus->getResult();
    unlink("assets/" . $foto_hapus['foto']);

    //hapus pengurus
    $pengurus->deletePengurus($id);
    header("location:index.php");
} else if (!empty($_GET['id_edit'])) {
    //memanggil update
    $id_upd = $_GET['id_edit'];
    header("location:form.php?nim_old=$id_upd");
}

/* menampilkan data pengurus */
$data_pengurus = null;
while (list($nim, $nama, $semester, $foto, $id_bidang) = $pengurus->getResult()) {
    // memanggil data nama bidang dari tabel bidang
    $bidang->getBidangById($id_bidang);
    $data_bidang = $bidang->getResult();

    // mengambil nama divisi dari tabel divisi
    $divisi->getDivisiById(isset($data_bidang['id_divisi']) ? $data_bidang['id_divisi'] : 0);
    $data_divisi = $divisi->getResult();

    $temp_divisi = isset($data_divisi['nama_divisi']) ? $data_divisi['nama_divisi'] : 0;
    $temp_bidang = isset($data_bidang['jabatan']) ? $data_bidang['jabatan'] : 0;


    $data_pengurus .=
        "
    <div class='row justify-content-between'>
        <div class='col-md-4'>
        <div class='card bg-black'>
            <img class='m-auto' src='./assets/" . $foto . "' alt='" . $nama . "' width='100%' />
        </div>
        </div>
        <div class='col-md-8'>
        <div class='card'>
            <div class='card-body'>
            <table class='text-start'>
                <tr>
                <th scope='row' class='w-25'>NIM</th>
                <td>: " . $nim . "</td>
                </tr>
                <tr>
                <th scope='row'>Nama</th>
                <td>: " . $nama . "</td>
                </tr>
                <tr>
                <th scope='row'>masa jabatan</th>
                <td>: " . $semester . "</td>
                </tr>
                <tr>
                <th scope='row'>Divisi</th>
                <td>: " . $temp_divisi . "</td>
                </tr>
                <tr>
                <th scope='row'>Jabatan</th>
                <td>: " . $temp_bidang . "</td>
                </tr>
            </table>
            </div>
        </div>
        </div>
    </div>
    
    <div class='float-end' style='margin-top:10px;'>
    <a href='detail_pengurus.php?id_edit=" . $nim .  "' class='btn btn-outline-success'>Edit</a>
    <a class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#exampleModal'> Hapus </a>
    </div>
    
    <!-- Modal -->
            <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Hapus Data</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        Apakah anda yakin ingin menghapus data?
                    </div>
                    <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    <a href='detail_pengurus.php?id_hapus=" . $nim . "'><button type='button' class='btn btn-danger'>Yes</button></a>
                    </div>
                </div>
                </div>
            </div>
    ";
}

// close koneksi db
$divisi->close();
$bidang->close();
$pengurus->close();
// menyimpan kode ke dalam html
$tpl = new Template("template/detail_pengurus.html");
$tpl->replace("DATA_PENGURUS", $data_pengurus);
$tpl->write();
//=============================================================
