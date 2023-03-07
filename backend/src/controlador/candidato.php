<?php

//HABILITA EL ACCESO A ESTE METODO DESDE OTRO LOCALHOST (index.html)
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include "../modelo/config.php";
include "../modelo/utils.php";


$dbConn =  connect($db);

//METODO GET CANDIDATOS
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['id'])) {
    //GET POR ID
    $sql = $dbConn->prepare("SELECT * FROM candidato where id=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
    exit();
  } else {
    //GET POR TODOS LOS REGISTROS
    $sql = $dbConn->prepare("SELECT * FROM candidato");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit();
  }
}

header("HTTP/1.1 400 Bad Request");

?>