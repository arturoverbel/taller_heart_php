<?php
 

$request = array();
if ( array_key_exists('PATH_INFO',$_SERVER) && !empty( $_SERVER['PATH_INFO'] )){
  $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}


$table = 'heart';
 
// connect to the mysql database
$link = mysqli_connect('localhost', 'root', 'root', 'project');
mysqli_set_charset($link,'utf8');

$totalArgm = count( $request );
$case = "SELECT";

switch ($totalArgm) {
  case 0:
    $sql = "SELECT * FROM ".$table." ORDER BY id DESC LIMIT 50;";
    break;
  case 3:
    $case = "INSERT";
    $sql = "INSERT INTO ".$table." (date, id_arduino,t1,t2) VALUES ( NOW(), ".$request[0].", ".$request[1].", ".$request[2]." );";
    break;
  default:
    die();
}
 
// excecute SQL statement
$result = mysqli_query($link,$sql);
 
// print results, insert id or affected row count
if ( $case == "SELECT") {
  
  $rows = array();
  while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
  }
  echo json_encode($rows);
} else {
  echo mysqli_insert_id($link);
}
 
// close mysql connection
mysqli_close($link);