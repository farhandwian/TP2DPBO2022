<?php

include("conf.php");
include("./include/Template.php");
include("./include/DB.php");
include("./include/Divisi.php");
include("./include/Bidang.php");
include("./include/Pengurus.php");

//=============================================================
// instansiasi class
$form = new Pengurus($db_host, $db_user, $db_pass, $db_name);
$form->open();
$bidang = new Bidang($db_host, $db_user, $db_pass, $db_name);
$bidang->open();
$bidang->getBidang();
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();

// mengambil data dari tabel divisi
$data_option = null;
while ($data_bidang = $bidang->getResult()) {

    $divisi->getDivisiById($data_bidang['id_divisi']);
    $data_divisi = $divisi->getResult();

    // menyimpan jabatan dan nama divisi ke dalam option form 
    $data_option .=
        "<option value=" . $data_bidang['id_bidang'] . ">" . $data_bidang['jabatan'] . " - " . $data_divisi['nama_divisi'] . "</option>";
}

$input_form = null;
// jika nim_old tidak kosong tampilkan form dalam keaadan input yang berisi data yang akan di update
if (!empty($_GET['nim_old'])) {
    $nim_old = $_GET['nim_old'];

    // mengambil data pengurus berdasarkan nim lama
    $form->getPengurusById($nim_old);
    $data = $form->getResult();
    $nim = $data['nim'];
    $nama = $data['nama'];
    $semester = $data['semester'];
    $foto = $data['foto'];

    // mengambil data nama bidang
    $bidang->getBidangById($data['id_bidang']);
    $data_bidang = $bidang->getResult();
    $id_bidang = $data_bidang['id_bidang'];
    $jabatan = $data_bidang['jabatan'];

    // mengambil data nama divisi
    $divisi->getDivisiById($data_bidang['id_divisi']);
    $data_divisi = $divisi->getResult();
    $nama_div = $data_divisi['nama_divisi'];

    $input_form .=
        "<input class='form-control' type='hidden' name='nim_old' value='$nim_old' required>  
    <div class='row'>
        <p>NIM
            <input class='form-control' type='text' name='nim' value='$nim' required>
        </p>  
    </div>
    <div class='row'>
        <p>Nama
        <input class='form-control' type='text' name='nama' value='$nama' required></p>  
    </div>
    <div class='row'>
        <p>semester
        <input class='form-control' type='text' name='semester' value='$semester' required></p>  
    </div>
    <div class='row'>
        <p>Foto
        <input class='form-control' type='hidden' name='foto_hapus' value='$foto'>  
        <input class='form-control' type='file' name='foto'></p>  
    </div>
    <div class='row'>
        <p>Bidang Divisi
            <select class='form-select' name='bidang_divisi' required>
                <option value='' disabled>Pilih Bidang Divisi...</option>
                <option value=$id_bidang selected hidden>$jabatan - $nama_div</option>
                OPTION_BIDANG
            </select>
        </p>  
    </div>";
} else {
    // jika tidak ada maka tampilkan form kosong
    $input_form .=
        "
    <div class='row'>
        <p>NIM
        <input class='form-control' type='text' name='nim' placeholder='Masukan NIM...' required></p>  
    </div>
    <div class='row'>
        <p>Nama
        <input class='form-control' type='text' name='nama' placeholder='Masukan Nama...' required></p>  
    </div>
    <div class='row'>
        <p>semester
        <input class='form-control' type='text' name='semester' placeholder='Masukan semester' required></p>  
    </div>
    <div class='row'>
        <p>Foto
        <input class='form-control' type='file' name='foto' required></p>  
    </div>
    <div class='row'>
        <p>Bidang Divisi
            <select class='form-select' name='bidang_divisi' required>
                <option value='' disabled selected>Pilih Bidang Divisi...</option>
                OPTION_BIDANG
            </select>
        </p>  
    </div>";
}


if (isset($_POST['simpan'])) {

    if (isset($_POST['nim_old'])) {
        //memanggil update
        $form->updatePengurus($_POST);
    } else {
        //memanggil add
        $form->addPengurus($_POST);
    }
}

// tutup koneksi db
$divisi->close();
$bidang->close();
$form->close();

$tpl = new Template("template/form.html");
$tpl->replace("INPUT_PENGURUS", $input_form);
$tpl->replace("OPTION_BIDANG", $data_option);
$tpl->write();
//=============================================================
