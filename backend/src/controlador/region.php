<?php

header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include "../modelo/config.php";
include "../modelo/utils.php";


$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
  if (isset($_GET['id'])) {
    //Mostrar un post
    $sql = $dbConn->prepare("SELECT region.id as ID, region.reg as REGION, comuna.nombreComuna AS COMUNA from comuna
      inner join region on comuna.idRegion = region.id WHERE idRegion=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $resultados = $sql->fetchAll(PDO::FETCH_ASSOC); // obtenemos todos los resultados

    $agrupados = array();

    foreach ($resultados as $fila) {
      $id = $fila['ID'];
      $region = $fila['REGION'];
      $comuna = $fila['COMUNA'];

      if (!isset($agrupados[$id])) {
        $agrupados[$id] = array(
          'ID' => $id,
          'REGION' => $region,
          'COMUNAS' => array()
        );
      }

      $agrupados[$id]['COMUNAS'][] = $comuna;
    }

    $resultado_final = array_values($agrupados);

    header("HTTP/1.1 200 OK");
    echo json_encode($resultado_final); // mostramos todos los resultados agrupados
    exit();
  } else {
    //Mostrar lista de post
    $sql = $dbConn->prepare("SELECT region.id as ID, region.reg AS REGION, comuna.nombreComuna AS COMUNAS 
      FROM comuna 
      INNER JOIN region ON comuna.idRegion = region.id;");
    $sql->execute();
    $resultados = $sql->fetchAll(PDO::FETCH_ASSOC); // obtenemos todos los resultados

    $agrupados = array();

    foreach ($resultados as $fila) {
      $id = $fila['ID'];
      $region = $fila['REGION'];
      $comuna = $fila['COMUNAS'];

      if (!isset($agrupados[$id])) {
        $agrupados[$id] = array(
          'ID' => $id,
          'REGION' => $region,
          'COMUNAS' => array()
        );
      }

      $agrupados[$id]['COMUNAS'][] = $comuna;
    }

    $resultado_final = array_values($agrupados);

    header("HTTP/1.1 200 OK");
    echo json_encode($resultado_final); // mostramos todos los resultados agrupados
    exit();
  }
  
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO posts
          (title, status, content, user_id)
          VALUES
          (:title, :status, :content, :user_id)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>