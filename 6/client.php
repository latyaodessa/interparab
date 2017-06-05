<?php
 $data = http_build_query(
   array(
     'wert' => '99'
   )
 );
 $opts = array('http' =>
   array(
     'method' => 'PUT',
     'header' =>
       "Content-type: application/x-www-form-urlencoded\r\n" .
       "accept: application/json\r\n"
     ,
     'content' => $data
   )
 );
 header('content-type: text/plain');
 $context = stream_context_create($opts);
 $result = file_get_contents('http://iop:4444/server.php/lagerverwaltung/bulb/40W',false,$context);
 
 print_r($result);
?>