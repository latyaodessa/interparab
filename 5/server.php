<?php

   $url = (array_key_exists('PATH_INFO',$_SERVER) ? $_SERVER['PATH_INFO'] : '/');
   $param = explode("/",$url);

  class Nina {

     function getCustomerAddress($postal_code, $city){
       Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result1.xml");
            $result = $xml->xpath('//customer/descendant::order_details/order_address[detailed_order_data/@potal_code="'. $postal_code . '" and detailed_order_data/country/text()="'. $city . '"]');
            return($result[0]->asXML());
     }


/// CHANGE TO DATE
     function getFacilitiesInRange($date, $stays_type){
     $xml = simplexml_load_file("code/result5.xml");

     $years = array();
     $stays_type_ar = array();
    
      foreach ($date as $key => $value) {
        array_push($years, 'contains(text(),"'. $value .'")');
      }

     foreach ($stays_type as $key => $value) {
        array_push($stays_type_ar, 'contains(text(),"'. $value .'")');
      }

      $years_separated = implode(" or ", $years);
      $types_separated = implode(" or ", $stays_type_ar);

      // $xpath = '//rates_of_particular_facility//real_date['. $years_separated .']/following-sibling::facility//status_type['. $types_separated .']/ancestor:: facility_data/@ facility_id';
      
      $xpath = '//rates_of_particular_facility//real_date[contains(text(),"2014") or contains(text(),"2015") or contains(text(),"2016")]/following-sibling::facility//status_type[contains(text(),"WARNING") or contains(text(),"CRITICAL")]/ancestor:: facility_data/@ facility_id';      
     $result = $xml->xpath($xpath);

      $xml = new SimpleXMLElement('<facilities/>');

  
      foreach ($result as $key => $value) {

      $facilitity_id = (string)$value['facility_id'];

        $facility = $xml->addChild('facility');
            $facility->addChild('facility_id', $facilitity_id);

     }


        Header('Content-type: text/xml');
     return($xml->asXML());
     }

function getTyrolCustomers($params){

              $city = $params->param->city;
              $age = $params->param->age;


            Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result3.xml"); 
            $xpath = '//postal_code/city[text()="'.$city.'"]/ancestor::customer_details[@age>'.$age.']/ancestor::appointment//status//symptom_from[contains(text(),"2011")]/ancestor::appointment';
            $result = $xml->xpath($xpath);
            return($result[0]->asXML());
     }

  }



  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $test = new Nina;
    header('content-type: text/plain');
    if ($param[1] == 'q11') {
        print_r($test->getCustomerAddress(1861,'Austria'));
     }
    if ($param[1] == 'q53') {
        print_r($test->getFacilitiesInRange([2014,2015,2016],['WARNING','CRITICAL']));
     }
    if ($param[1] == 'q32') {

      $params = new StdClass;
 
      $params->city = 'Tyrol';
      $params->age= 18;
 
 

        print_r($test->getTyrolCustomers($params));
     }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ini_set("soap.wsdl_cache_enabled","0");
    $server = new SoapServer('soap.wsdl');
    $server->setClass('Nina');
    $server->handle();
    exit;
  }
?>