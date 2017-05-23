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

function getTyrolCustomers($params, $date){

              $city = $params->param->city;
              $age = $params->param->age;
              $year = date('Y',strtotime($date));


            Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result3.xml"); 
            $xpath = '//postal_code/city[text()="'.$city.'"]/ancestor::customer_details[@age>'.$age.']/ancestor::appointment//status//symptom_from[contains(text(),"'.$year.'")]/ancestor::appointment';
            $result = $xml->xpath($xpath);
            return($result[0]->asXML());
     }


 function getCorporateAppointments($params, $status){
            $dec1 = my_simple_crypt($params->param->encrypted1, 'd');
            $dec2 = my_simple_crypt($params->param->encrypted2, 'd');
            $dec3 = my_simple_crypt($params->param->encrypted3, 'd');

            $dec_status = my_simple_crypt($status, 'd');

            Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result3.xml"); 
            $xpath = '//symptom[contains(@symptom_type,"'.$dec1.'") or contains(@symptom_type,"'.$dec2.'") or contains(@symptom_type,"'.$dec3 .'")]/ancestor::appointment[appointment_type/text()="'.$dec_status.'"]';
            $result = $xml->xpath($xpath);

            return json_encode($result);
    }

     function getSypmtomData($type, $date){
            $year = date('Y',strtotime($date));
            Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result5.xml"); 
            $xpath = '//facility_data[facility_type/text()="'.$type.'"]/descendant::symptom/*[../symptom_from[contains(text(),"'.$year.'")]]';
            $result = $xml->xpath($xpath);

            $xml = new SimpleXMLElement('<symptom/>');
            array_walk_recursive($result, array ($xml, 'addChild'));
             
            return($xml->asXML());
     }

          function getFacilitiesFromBlocks($blocks, $status){

             $bl = array();

              foreach ($blocks as $key => $value) {
                array_push($bl, 'contains(text(),"'. $value .'")');
              }

              $bl_separated = implode(" or ", $bl);

              Header('Content-type: text/xml');
            $xml = simplexml_load_file("code/result2.xml"); 
            $xpath = '//provide_service_in//city['.$bl_separated.']/ancestor::*/local_facility[contains(@facility_status,"'.$status.'")]';
            
            $result = $xml->xpath($xpath);

            return json_encode($result);
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
      $param1 = new StdClass;
 
      $param1->city = 'Tyrol';
      $param1->age= 18;
 
 
      $params->param = $param1;

        $d = mktime(12,0,0,7,4,2011);
        
        $time = date("c", $d);


        print_r($test->getTyrolCustomers($params, $time));
     }

      if ($param[1] == 'q34') {
            $params = new StdClass;
          $param1 = new StdClass;
     
          $param1->encrypted1 = my_simple_crypt( 'COOL_FREEZEIN', 'e' );
          $param1->encrypted2 = my_simple_crypt( 'FREEZEIN', 'e' );
          $param1->encrypted3 = my_simple_crypt( 'ICE', 'e' );
 
      $params->param = $param1;

      $satus = my_simple_crypt( 'CORPORATE', 'e' );


        print_r($test->getCorporateAppointments($params,$satus));
     }

     if ($param[1] == 'q54') {
         $d = mktime(12,0,0,7,4,2017);
        
        $time = date("c", $d);
        print_r($test->getSypmtomData('Corporate',$time));
     }
     if ($param[1] == 'q21') {
       
        print_r($test->getFacilitiesFromBlocks(['Lower','Upper'],'ACTIVE'));
     }

  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ini_set("soap.wsdl_cache_enabled","0");
    $server = new SoapServer('soap.wsdl');
    $server->setClass('Nina');
    $server->handle();
    exit;
  }


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

?>