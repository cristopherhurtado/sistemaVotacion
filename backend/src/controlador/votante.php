<?php

//HABILITA EL ACCESO A ESTE METODO DESDE OTRO LOCALHOST (index.html)
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include "../modelo/config.php";
include "../modelo/utils.php";


$dbConn =  connect($db);
//METODO GET VOTANTE
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['id'])) {
    //GET POR ID
    $sql = $dbConn->prepare("SELECT * FROM votante where id=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
    exit();
  } else {
    //GET POR TODOS LOS REGISTROS
    $sql = $dbConn->prepare("SELECT * FROM votante");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit();
  };
};

//METODO POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //Filtra el tipo de datos recibidos "string"
  $nombre = filter_var($_POST['nombre']);
  $alias = filter_var($_POST['alias']);
  $rut = filter_var($_POST['rut']);
  $email = filter_var($_POST['email']);
  $region = filter_var($_POST['region']);
  $comuna = filter_var($_POST['comuna']);
  $candidato = filter_var($_POST['candidato']);
  $web = filter_var($_POST['web']);
  $tv = filter_var($_POST['tv']);
  $rrss = filter_var($_POST['rrss']);
  $amigo = filter_var($_POST['amigo']);

  // Preparar la consulta SQL
  $sql = "INSERT INTO votante (nombre, alias, rut, email, region, comuna, candidato, web, tv, rrss, amigo) 
      VALUES (:nombre, :alias, :rut, :email, :region, :comuna, :candidato, :web, :tv, :rrss, :amigo)";
  $statement = $dbConn->prepare($sql);

  // Asignar valores a los parámetros de la consulta
  $statement->bindParam(":nombre", $nombre);
  $statement->bindParam(":alias", $alias);
  $statement->bindParam(":rut", $rut);
  $statement->bindParam(":email", $email);
  $statement->bindParam(":region", $region);
  $statement->bindParam(":comuna", $comuna);
  $statement->bindParam(":candidato", $candidato);
  $statement->bindParam(":web", $web);
  $statement->bindParam(":tv", $tv);
  $statement->bindParam(":rrss", $rrss);
  $statement->bindParam(":amigo", $amigo);

  // Ejecutar la consulta SQL
  if ($statement->execute()) {
    $postId = $dbConn->lastInsertId();
    $input = array(
      "id" => $postId,
      "nombre" => $nombre,
      "alias" => $alias,
      "rut" => $rut,
      "email" => $email,
      "region" => $region,
      "comuna" => $comuna,
      "candidato" => $candidato,
      "web" => $web,
      "tv" => $tv,
      "rrss" => $rrss,
      "amigo" => $amigo
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($input);
    exit();
  } else {
    header("HTTP/1.1 500 Internal Server Error");
    exit();
  };
};

header("HTTP/1.1 400 Bad Request");

?>