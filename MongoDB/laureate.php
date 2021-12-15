<?php
// get the id parameter from the request
$id = intval($_GET['id']);

// set the Content-Type header to JSON, so that the client knows that we are returning a JSON data
header('Content-Type: application/json');

$filter = ['id' => strval($id)];
$options = ["projection" => ['_id' => 0]];

$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery("nobel.laureates", $query);
$row = $rows->toArray();
$obj = current($row);

if (empty($row)) {
    print("There is no document having id = $id");
    exit(0);
}

echo json_encode($obj);
?>