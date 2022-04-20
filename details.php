<?php

include("conf.php");
include("./include/Template.php");
include("./include/DB.php");
include("./include/Divisi.php");
include("./include/Bidang.php");
include("./include/Pengurus.php");

//=============================================================
/* Instansiasi Class */
$pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
$pengurus->open();
$bidang = new Bidang($db_host, $db_user, $db_pass, $db_name);
$bidang->open();
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();

// menamgbil data dari tabel divisi, bidang, dan pengurus
$divisi->getDivisi();
$bidang->getBidang();
$pengurus->getPengurus();

/* TABEL Divisi */
//mengecek apakah ada id_hapus_div, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus_div'])) {
    //memanggil hapus
    $id_hapus_div = $_GET['id_hapus_div'];

    $divisi->deleteDivisi($id_hapus_div);
    header("location:details.php");
} else if (!empty($_GET['id_edit_div'])) {
    //memanggil update
    $id_upd_div = $_GET['id_edit_div'];
    header("location:form_divisi.php?id_div=$id_upd_div");
}

// menampilkan data divisi
$data_div = null;
$no = 1;
while (list($id_divisi, $nama_divisi) = $divisi->getResult()) {

    $data_div .=
        "<tr>
        <td>" . $no . "</td>
        <td>" . $nama_divisi . "</td>
        <td>
        <a href='details.php?id_edit_div=" . $id_divisi .  "' class='btn btn-outline-success'> Update </a>
        <a href='details.php?id_hapus_div=" . $id_divisi . "' class='btn btn-outline-danger'> Hapus </a>
        </td>
    </tr>";
    $no++;
}

/* TABEL Bidang Divisi */
//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus_bid'])) {
    //memanggil hapus
    $id_bid = $_GET['id_hapus_bid'];

    $bidang->deleteBidang($id_bid);
    header("location:details.php");
} else if (!empty($_GET['id_edit_bid'])) {
    //memanggil update
    $id_upd_bid = $_GET['id_edit_bid'];
    header("location:form_bidang.php?id_bid=$id_upd_bid");
}

// menampilkan data bidang
$data_bid = null;
$no = 1;
while (list($id_bidang, $jabatan, $id_divisi) = $bidang->getResult()) {

    $divisi->getDivisiById($id_divisi);
    $data_divisi = $divisi->getResult();

    $data_bid .=
        "<tr>
        <td>" . $no . "</td>
        <td>" . $jabatan . "</td>
        <td>" . $data_divisi['nama_divisi'] . "</td>
        <td>
        <a href='details.php?id_edit_bid=" . $id_bidang .  "' class='btn btn-outline-success'> Update </a>
        <a href='details.php?id_hapus_bid=" . $id_bidang . "' class='btn btn-outline-danger'> Hapus </a>
        </td>
    </tr>";
    $no++;
}

/* TABEL PENGURUS */
//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil hapus
    $id = $_GET['id_hapus'];

    // hapus foto dari local
    $pengurus->getPengurusById($id);
    $foto_hapus = $pengurus->getResult();
    unlink("assets/" . $foto_hapus['foto']);

    $pengurus->deletePengurus($id);
    header("location:details.php");
} else if (!empty($_GET['id_edit'])) {
    //memanggil update
    $id_upd = $_GET['id_edit'];
    header("location:form.php?nim_old=$id_upd");
}

// menampilkan data pengurus
$data_pengurus = null;
while (list($nim, $nama, $semester, $foto, $id_bidang) = $pengurus->getResult()) {
    $bidang->getBidangById($id_bidang);
    $data_bidang = $bidang->getResult();

    $divisi->getDivisiById($data_bidang['id_divisi']);
    $data_divisi = $divisi->getResult();

    $data_pengurus .=
        "<tr>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $semester . "</td>
        <td>" . $foto . "</td>
        <td>" . $data_divisi['nama_divisi'] . "</td>
        <td>" . $data_bidang['jabatan'] . "</td>
        <td>
        <a href='details.php?id_edit=" . $nim .  "' class='btn btn-outline-success'> Update </a>
        <a href='details.php?id_hapus=" . $nim . "' class='btn btn-outline-danger'> Hapus </a>
        </td>
    </tr>";
}

// menutup koneksi db
$divisi->close();
$bidang->close();
$pengurus->close();

// menulis kode php ke template html
$tpl = new Template("template/details.html");
$tpl->replace("DATA_DIVISI", $data_div);
$tpl->replace("DATA_BIDANG", $data_bid);
$tpl->replace("DATA_PENGURUS", $data_pengurus);
$tpl->write();
//=============================================================
