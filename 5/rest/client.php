<?php
    $url = (array_key_exists('PATH_INFO',$_SERVER) ? $_SERVER['PATH_INFO'] : '/');
    $param = explode("/",$url);

    $base_host = 'http://wwwlab.cs.univie.ac.at/~a1349252/iop/rest/';
// $base_host = 'http://iop:4444/';

    if($param[1]=='q11'){
        $data = http_build_query(
    array(
      'country' => 'America',
      'city' => 'New York',
      'continent' => 'hell'
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'PUT',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: text/xml\r\n"
      ,
      'content' => $data
    )
  );

  Header('Content-type: text/xml');
  $context = stream_context_create($opts);
  $result = file_get_contents($base_host . 'server.php/customer_data/customer/order_details/order_address/detailed_order_data?potal_code=1861',false,$context);

    print_r($result);


    }

if($param[1]=='q53'){
    $data = http_build_query(
    array(
      'range' => array(2014,2015,2016),
      'types' => array('WARNING','CRITICAL')
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: text/xml\r\n"
      ,
      'content' => $data
    )
  );
  Header('Content-type: text/xml');
    $context = stream_context_create($opts);

  $result = file_get_contents($base_host . 'server.php/rates_and_facilities/rates_of_particular_facility/facility_data',false,$context);

    print_r($result);
}

if($param[1]=='q32'){
    $data = http_build_query(
    array(
      'hash_set' => array(18, 'Tyrol'),
      'date' => '2011-01-01'
    )
  );




  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: text/xml\r\n"
      ,
      'content' => $data
    )
  );
  Header('Content-type: text/xml');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/appointment_data/appointment/appointment_details/customer_info/customer_details/customer_to_export/customer_data/customer/customer_address/postal_code',false,$context);

    print_r($result);
}

if($param[1]=='q34'){
    $data = http_build_query(
    array(
      'symptoms' => array('COOL_FREEZEIN', 'FREEZEIN','ICE'),
      'type' => 'CORPORATE',
      'update_to' => 'CORPORATE_FREEZE'
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'PUT',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: text/xml\r\n"
      ,
      'content' => $data
    )
  );
  Header('Content-type: text/xml');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/appointment_data/appointment/appointment_details/status/symptom',false,$context);

    print_r($result);
}

if($param[1]=='q54'){
    $data = http_build_query(
    array(
      'type' => 'Corporate',
      'date' => '2017-01-01',
      'symptopms' => array(100,90)
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: text/xml\r\n"
      ,
      'content' => $data
    )
  );
  Header('Content-type: text/xml');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/rates_and_facilities/rates_of_particular_facility/facility_data',false,$context);

    print_r($result);
}


if($param[1]=='q21'){
    $data = http_build_query(
    array(
      'blocks' => array('Lower','Upper'),
      'status' => 'ACTIVE'
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: application/json\r\n"
      ,
      'content' => $data
    )
  );


  Header('Content-type: application/json');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/local_facility_data/local_facility/provide_service/provide_service_in/postal_code',false,$context);

    print_r($result);
}

if($param[1]=='q51'){
    $data = http_build_query(
    array(
      'status' => 'INACTIVE',
      'id_range' => array(100,300)
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: application/json\r\n"
      ,
      'content' => $data
    )
  );
  Header('Content-type: application/json');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/rates_and_facilities/rates_of_particular_facility/facility_data/detailed_data/appointment/appointment_data_to_export/appointment_data/appointment/facility',false,$context);

    print_r($result);
}

if($param[1]=='q14'){
    $data = http_build_query(
    array(
      'date' => '2011-01-01',
      'fridge_volume' => 50,
      'gender' => 'female'
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: application/json\r\n"
      ,
      'content' => $data
    )
  );

 


  Header('Content-type: application/json');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/customer_data/customer/order_details/order_address/detailed_order_data/customer_fridges_on_current_address/fridge',false,$context);

    print_r($result);
}


if($param[1]=='q12'){
    $data = http_build_query(
    array(
      'country' => 'Indonesia',
      'age' => 18,
      'elements_to_remove' => array('last_name','first_name')
      )
  );

  $opts = array('http' =>
    array(
      'method' => 'DELETE',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: application/json\r\n"
      ,
      'content' => $data
    )
  );



  Header('Content-type: application/json');
    $context = stream_context_create($opts);


  $result = file_get_contents($base_host . 'server.php/customer_data/customer/order_details/order_address/detailed_order_data/customer_fridges_on_current_address/fridge',false,$context);

    print_r($result);
}


if($param[1]=='q33'){
    $data = http_build_query(
    array(
      'count' => array(1,30)
    )
  );

  $opts = array('http' =>
    array(
      'method' => 'POST',
      'header' =>
        "Content-type: application/x-www-form-urlencoded\r\n" .
        "accept: application/json\r\n"
      ,
      'content' => $data
    )
  );
   Header('Content-type: application/json');
    $context = stream_context_create($opts);



  $result = file_get_contents($base_host . 'server.php/appointment_data/appointment',false,$context);

    print_r($result);
}


 
?>