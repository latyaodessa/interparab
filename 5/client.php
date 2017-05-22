<?php
    
   class SomeObject1 { 
        public $obj1property1; 
        public $obj1property2; 
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

      $result = $client->getTyrolCustomers($params);
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