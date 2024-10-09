<?php
date_default_timezone_set("Asia/Manila");
// echo "The date and time is " . date("Y-m-d h:i a");
$result['date']=date("Y-m-d");
$result['time']=date("h:i:s A");
$result['datetime']=date("Y-m-dH:i:s");
echo json_encode($result);
?>
