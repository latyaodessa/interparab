<?php
    
   function my_simple_crypt( $string, $action = 'e' ) {
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}

    $url = (array_key_exists('PATH_INFO',$_SERVER) ? $_SERVER['PATH_INFO'] : '/');
    $param = explode("/",$url);
    ini_set("soap.wsdl_cache_enabled","0");
    $client = new SoapClient('soap.wsdl',array('trace'=>1));
    $result = '';

  if ($param[1] == 'q11') {
    $result = $client->getCustomerAddress(1861,'Austria');
  }
  if ($param[1] == 'q53') {
    $years[] = array(2014,2015,2016);
    $types[] = array('WARNING','CRITICAL');

    $result = $client->getFacilitiesInRange($years,$types);
  }
  if ($param[1] == 'q32') {

     $params = new StdClass;
      $param1 = new StdClass;
 
      $param1->city = 'Tyrol';
      $param1->age= 18;
 
 
      $params->param = $param1;

        $d = mktime(12,0,0,7,4,2011);
        
        $time = date("c", $d);

      $result = $client->getTyrolCustomers($params,$time);
     }

     if ($param[1] == 'q34') {

          $params = new StdClass;
          $param1 = new StdClass;
     
          $param1->encrypted1 = my_simple_crypt( 'COOL_FREEZEIN', 'e' );
          $param1->encrypted2 = my_simple_crypt( 'FREEZEIN', 'e' );
          $param1->encrypted3 = my_simple_crypt( 'ICE', 'e' );
 
      $params->param = $param1;

      $satus = my_simple_crypt( 'CORPORATE', 'e' );

        $result = $client->getCorporateAppointments($params,$satus);
     }

      if ($param[1] == 'q54') {
        $d = mktime(12,0,0,7,4,2017);
        
        $time = date("c", $d);
         $result = $client->getSypmtomData('Corporate',$time);
      }

      if ($param[1] == 'q21') {

        $blocks[] = array('Lower','Upper');

         $result = $client->getFacilitiesFromBlocks($blocks,'ACTIVE');
      }

   header('content-type: text/plain');

   print_r($result);

    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;

  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastRequest());
  print $doc->saveXML();

    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;

  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastResponse());
  print $doc->saveXML();
?>