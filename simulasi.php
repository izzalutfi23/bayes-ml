<?php
require_once 'autoload.php';

$obj = new Bayes();

$jumTrue = $obj->sumTrue();
$jumFalse = $obj->sumFalse();
$jumData = $obj->sumData();

$a1 = $_POST['umur'];
$a2 = $_POST['role'];
$a3 = $_POST['item'];
$a4 = $_POST['kesehatan'];
$a5 = $_POST['micro'];

//TRUE
$umur = $obj->probUmur($a1,1);
$role = $obj->probRole($a2,1);
$item = $obj->probItem($a3,1);
$kesehatan = $obj->probKesehatan($a4,1);
$micro = $obj->probMicro($a5,1);

//FALSE
$umur2 = $obj->probUmur($a1,0);
$role2 = $obj->probRole($a2,0);
$item2 = $obj->probItem($a3,0);
$kesehatan2 = $obj->probKesehatan($a4,0);
$micro2 = $obj->probMicro($a5,0);

//result
$paT = $obj->hasilTrue($jumTrue,$jumData,$umur,$role,$item,$kesehatan,$micro);
$paF = $obj->hasilFalse($jumTrue,$jumData,$umur2,$role2,$item2,$kesehatan2,$micro2);

// if($a2 == "kt"){
//   $a2 = "Kurang Tinggi";
// }else if($a2 == "st"){
//   $a2 = "Sangat Tinggi";
// }

echo "
<div class='jumbotron jumbotron-fluid' id='hslPrekdiksinya'>
  <div class='container'>
    <h1 class='display-4 tebal'>Hasil Prediksi Kemenangan Mobile Legends</h1>
    <p class='lead'>Berikut ini adalah hasil prediksi player dalam bermain game mobile legends menggunakan metode naive bayes.</p>
  </div>
</div>
";

echo "
<div class='card' style='width: 25rem;'>
  <div class='card-header' style='background-color:#336699;color:#fff'>
    <b>Informasi Player</b>
  </div>
  <ul class='list-group list-group-flush'>
    <li class='list-group-item'>umur : &nbsp;&nbsp;<b>$a1</b></li>
    <li class='list-group-item'>role : &nbsp;&nbsp;<b>$a2</b></li>
    <li class='list-group-item'>pemilihan item : &nbsp;&nbsp;<b>$a3</b></li>
    <li class='list-group-item'>status kesehatan : &nbsp;&nbsp;<b>$a4</b></li>
    <li class='list-group-item'>micro dan macro : &nbsp;&nbsp;<b>$a5</b></li>
  </ul>
</div><br>
<hr>
";

echo "<br>
<table class='table table-bordered' style='font-size:18px;text-align:center'>
  <tr style='background-color:#336699;color:#fff'>
    <th>Jumlah True</th>
    <th>Jumlah False</th>
    <th>Jumlah Total Data</th>
  </tr>
  <tr>
    <td>$jumTrue</td>
    <td>$jumFalse</td>
    <td>$jumData</td>
  </tr>
</table>
";

echo "<br>
<table class='table table-bordered' style='font-size:18px;text-align:center'>
  <tr style='background-color:#336699;color:#fff'>
    <th></th>
    <th>True</th>
    <th>False</th>
  </tr>
  <tr>
    <td>pA</td>
    <td>$jumTrue / $jumData</td>
    <td>$jumFalse / $jumData</td>
  </tr>
  <tr>
    <td>Umur</td>
    <td>$umur / $jumTrue</td>
    <td>$umur2 / $jumFalse</td>
  </tr>
  <tr>
    <td>Role</td>
    <td>$role / $jumTrue</td>
    <td>$role2 / $jumFalse</td>
  </tr>
  <tr>
    <td>Pemilihan Item</td>
    <td>$item / $jumTrue</td>
    <td>$item2 / $jumFalse</td>
  </tr>
  <tr>
    <td>Status Kesehatan</td>
    <td>$kesehatan / $jumTrue</td>
    <td>$kesehatan2 / $jumFalse</td>
  </tr>
  <tr>
    <td>Micro dan Macro</td>
    <td>$micro / $jumTrue</td>
    <td>$micro2 / $jumFalse</td>
  </tr>
</table>
";

echo "<br>
  <table class='table table-bordered' style='font-size:18px;text-align:center;'>
    <tr style='background-color:#336699;color:#fff'>
      <th>PREDIKSI Bisa Memenangkan Pertandingan</th>
      <th>PREDIKSI Tidak Memenangkan Pertandingan</th>
    </tr>
    <tr>
      <td>$paT</td>
      <td>$paF</td>
    </tr>
  </table>
";

$result = $obj->perbandingan($paT,$paF);

if($paT > $paF){
  echo "<br>
  <h3 class='tebal'>PREDIKSI <span class='badge badge-success' style='padding:10px'><b>MENANG</b></span> LEBIH BESAR DARI PADA PREDIKSI KALAH</h3><br>";
  echo "<h4><br>PREDIKSI menang sebesar : <b>".round($result[1],2)." %</b> <br>PREDIKSI kalah sebesar : <b>".round($result[2],2)." % </b></h4>";
}else if($paF > $paT){
  echo "<br>
  <h3 class='tebal'>PREDIKSI <span class='badge badge-danger' style='padding:10px'><b>KALAH</b></span> LEBIH BESAR DARI PADA PREDIKSI MENANG</h3><br>";
  echo "<h4><br>PREDIKSI kalah sebesar : <b>".round($result[1],2)." %</b> <br>PREDIKSI menang sebesar : <b>".round($result[2],2)." % </b></h4>";
}


if($result[0] == "MENANG"){
  echo "
  <div class='alert alert-success mt-5' role='aler'>
    <h4 class='alert-heading'>Kesimpulan : $result[0] </h4>
    <p>Selamat! berdasarkan hasil peritungan Naive Bayes, anda diprediksi akan <b>menang!</b></p>
    <hr>
    <p class='mb-0'>- Have a nice day -</p>
  </div>";
}else{
  echo"
  <div class='alert alert-danger mt-5' role='aler'>
  <h4 class='alert-heading'>Kesimpulan : $result[0] </h4>
  <p>Maaf, berdasarkan hasil peritungan Naive Bayes, anda diprediksi akan <b>kalah!</p>
  <hr>
  <p class='mb-0'>- Don't give up ! -</p>
  </div>";
}


 ?>
