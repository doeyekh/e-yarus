<?php 
function getTahun(){
    $db = \Config\Database::connect();
    return $db->table('tahun')->where('status',1)->get()->getRow();
}
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function createRandom($id) {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= $id) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;

    }
    return $pass;
}
?>