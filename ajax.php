<?php
require_once './model/database.php';
$get = $_GET;
switch ($get['data']){
    case 'mahasiswa':
    getMhs($get['query']);
    break;
    default: return;
}
function getMhs ($keyword = null){
    $database = new Database();
    $query = "SELECT * from mahasiswa WHERE nim LIKE '$keyword%'";
    // var_dump($query);
    $database->query($query);
    $mahasiswa = $database->fetch();
    echo json_encode($mahasiswa);
}
?>