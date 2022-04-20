<?php

include("conf.php");
include("./include/Template.php");
include("./include/DB.php");
include("./include/Divisi.php");
include("./include/Bidang.php");
include("./include/Pengurus.php");

//=============================================================
// memanggil class Bidang dan Divisi
$form = new Bidang($db_host, $db_user, $db_pass, $db_name);
$form->open();
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();

// mengambil data divisi
$divisi->getDivisi();

// mengambil data divisi dari tabel divisi dan menyimpan ke dalam option form
$data_option = null;
while ($data_divisi = $divisi->getResult()) {

    $data_option .=
    "<option value=". $data_divisi['id_divisi'] .">". $data_divisi['nama_divisi'] ."</option>";
    
}

$input_form = null;
// jika id_bid tidak kosong maka tampilkan form dalam keaddan inputnya terisi (Form Update)
if (!empty($_GET['id_bid'])) {
    $id_bid = $_GET['id_bid'];
    
    $form->getBidangById($id_bid);
    $data_bid = $form->getResult();
    $jabatan = $data_bid['jabatan'];

    $divisi->getDivisiById($data_bid['id_divisi']);
    $data_div = $divisi->getResult();
    $id_div = $data_div['id_divisi'];
    $div = $data_div['nama_divisi'];

    // menampilkan form
    $input_form .= 
    "
    <input class='form-control' type='hidden' name='id_bidang' value='$id_bid' required>
    <div class='row'>
        <p>Jabatan
        <input class='form-control' type='text' name='jabatan' value='$jabatan' required></p>  
    </div>
    <div class='row'>
        <p>Divisi
            <select class='form-select' name='divisi' required>
                <option value='' disabled selected>Pilih Divisi...</option>
                <option value=$id_div selected hidden>$div</option>
                OPTION_DIVISI
            </select>
        </p>  
    </div>
    "; 
}
else {
    // jika tidak maka tampilkan form dalam keadaan kosong
    $input_form .=
    "
    <div class='row'>
        <p>Jabatan
        <input class='form-control' type='text' name='jabatan' placeholder='Masukan Jabatan...' required></p>  
    </div>
    <div class='row'>
        <p>Divisi
            <select class='form-select' name='divisi' required>
                <option value='' disabled selected>Pilih Divisi...</option>
                OPTION_DIVISI
            </select>
        </p>  
    </div>
    ";
}

// jika nilai simpan ada
if (isset($_POST['simpan'])) {

    // jika nilai id_divisi ada
    if (isset($_POST['id_bidang'])) {
        //memanggil update
        $form->updateBidang($_POST);
        header("location:details.php");
    }
    else {
        //memanggil add
        $form->addBidang($_POST);
        header("location:details.php");
    }
}

// tutup koneksi db
$divisi->close();
$form->close();

$tpl = new Template("template/form_bidang.html");
$tpl->replace("ID_FOR_UPDATE", $input_form);
$tpl->replace("OPTION_DIVISI", $data_option);
$tpl->write();
//=============================================================
?>