<?php

include("conf.php");
include("./include/Template.php");
include("./include/DB.php");
include("./include/Divisi.php");
include("./include/Bidang.php");
include("./include/Pengurus.php");

//=============================================================
// instansiasi class divisi
$form = new Divisi($db_host, $db_user, $db_pass, $db_name);
$form->open();

$input_form = null;
// jika id_div ada maka tampilkan form yang berisi data yang akan di update
if (!empty($_GET['id_div'])) {
    $id_div = $_GET['id_div'];
    $form->getDivisiById($id_div);
    $data_div = $form->getResult();
    $nama_div = $data_div['nama_divisi'];

    // menampilkan form
    $input_form .= 
    "
    <input class='form-control' type='hidden' name='id_divisi' value=". $id_div ." required>
    <div class='row'>
        <p>
            <input class='form-control' type='text' name='divisi' value='$nama_div'>
        </p>  
    </div>
    "; 
}
else {
    // jika tidak tampilkan form dalam keadaan kosong
    $input_form .=
    "
    <div class='row'>
        <p>Nama Divisi
        <input class='form-control' type='text' name='divisi' placeholder='Masukan Divisi...' required></p>  
    </div>
    ";
}

// jika nilai simpan ada
if (isset($_POST['simpan'])) {

    // jika nilai id_divisi ada
    if (isset($_POST['id_divisi'])) {
        //memanggil update
        $form->updateDivisi($_POST);
    }
    else {
        //memanggil add
        $form->addDivisi($_POST);
    }
}

$form->close();
$tpl = new Template("template/form_divisi.html");
$tpl->replace("ID_FOR_UPDATE", $input_form);
$tpl->write();
//=============================================================
?>