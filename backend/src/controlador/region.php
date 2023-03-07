<?php

//HABILITA EL ACCESO A ESTE METODO DESDE OTRO LOCALHOST (index.html)
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

include "../modelo/config.php";
include "../modelo/utils.php";


$dbConn =  connect($db);
//METODO GET REGION
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['id'])) {
    //GET POR ID (CONVIERTE UN ARRAY PARA AGRUPAR LAS COMUNAS)
    $sql = $dbConn->prepare("SELECT region.id as ID, region.reg as REGION, comuna.nombreComuna AS COMUNA from comuna
      inner join region on comuna.idRegion = region.id WHERE idRegion=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $resultados = $sql->fetchAll(PDO::FETCH_ASSOC);

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
      };

      $agrupados[$id]['COMUNAS'][] = $comuna;
    };

    $resultado_final = array_values($agrupados);

    header("HTTP/1.1 200 OK");
    echo json_encode($resultado_final);
    exit();
  } else {
    //GET POR TODOS LOS REGISTROS (CONVIERTE UN ARRAY PARA AGRUPAR LAS COMUNAS)
    $sql = $dbConn->prepare("SELECT region.id as ID, region.reg AS REGION, comuna.nombreComuna AS COMUNAS 
      FROM comuna 
      INNER JOIN region ON comuna.idRegion = region.id;");
    $sql->execute();
    $resultados = $sql->fetchAll(PDO::FETCH_ASSOC);

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
      };

      $agrupados[$id]['COMUNAS'][] = $comuna;
    };

    $resultado_final = array_values($agrupados);

    header("HTTP/1.1 200 OK");
    echo json_encode($resultado_final);
    exit();
  }
};

header("HTTP/1.1 400 Bad Request");

?>