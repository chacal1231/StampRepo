<?php

$link=mysqli_connect('127.0.0.1','root','jesus00**','gps'); 
$data = array();
$result = mysqli_query($link,"SELECT * FROM gps");
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

?>