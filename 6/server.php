<?php

   function handleREST($server,$get) {
   $url = (array_key_exists('PATH_INFO',$server) ? $server['PATH_INFO'] : '/');
   $method = $server['REQUEST_METHOD'];
   parse_str(file_get_contents('php://input'),$contentargs);
   $arguments = $get;
   $accept = array_key_exists('HTTP_ACCEPT',$server) ? $server['HTTP_ACCEPT'] : '*/*';
   $ret = new StdClass;
   $ret->url = $url;
   $ret->method = $method;
   $ret->arguments = $arguments;
   $ret->accept = $accept;
   $ret->contentargs = $contentargs;
   return $ret;
 }
 	$file = "lagerverwaltung.json";

 	$rest = handleREST($_SERVER,$_GET);


    $url = (array_key_exists('PATH_INFO',$_SERVER) ? $_SERVER['PATH_INFO'] : '/');
    $param = explode("/",$url);

  		 // Header('Content-type: application/json');



     if ($param[1] == 'order' && $rest->method=='GET') {

     	 $object = new stdClass();
     	 $object->fridge_case = getTypeOfFridge();
  		 $object->bulb = getBulbWats();
  		 $object->shelf = getShelfsSize();
  		 $object->icemaker = getRandomBoolean();

   		print_r(json_encode($object,JSON_PRETTY_PRINT));

  }

     if ($param[1] == 'report' && $rest->method=='GET') {

     	 $object = new stdClass();

     	 $proccesses = array("10 Put fridge in the right position",
     	 					"15 Open Fridge and check what's inside",
     	 					"20 Turn on Bulb",
     	 					"25 Put new Bulb",
     	 					"30 Check what's sizes fo we have",
     	 					"35 Put a first main shelf",
     	 					"40 Put a secondary shelf",
     	 					"45 Adjust Shelf",
     	 					"50 Put rest shelfs",
     	 					"55 Turn off bulb",
     	 					"60 Check icemaker",
     	 					"65 Install icemaker",
     	 					"70 Turn on icemaker",
     	 					"75 Make some ice",
     	 					"80 Make smaller ice",
     	 					"85 Make bigger ice",
     	 					"90 Plug in fridge",
     	 					"95 Plug in icemaker",
     	 					"100 Close fridge");

     		if($param[2] != null){
     	
     			$percent = $param[2] * 10;
     				$text = getText($proccesses, $percent);
     				
 				 $object = generateReport($text,$percent);
     		} else {
     			$object = array();
     			for ($x = 10; $x <= 100; $x+=5) {
					   $text = getText($proccesses, $x);
					   array_push($object, generateReport($text,$x));
					} 
     		}
  
   				print_r(json_encode($object, JSON_PRETTY_PRINT));

  }


  if($param[1] == 'lagerverwaltung' && $rest->method=='GET') {
  	// $object = generateInventory();
  	//   print_r(json_encode($object));

  	$response = file_get_contents($file);
	$json_a = json_decode($response, true);


	if($param[2] != null){
		$response = json_encode($json_a[$param[2]],JSON_PRETTY_PRINT);
		if($param[3] != null) {
			$response = json_encode($json_a[$param[2]][$param[3]],JSON_PRETTY_PRINT);
		}
	}

  	print_r($response);

  }

    if($param[1] == 'lagerverwaltung' && $rest->method=='PUT') {

    	 	$response = file_get_contents($file);
			$json_a = json_decode($response, true);

    	if($param[2] != null && $param[3] != null){
    		$json_a[$param[2]][$param[3]] = (int)$rest->contentargs['wert'];
		
	}

	file_put_contents($file, json_encode($json_a, JSON_PRETTY_PRINT));

    }


  function generateInventory(){
  		$object = new stdClass();
		
		$fridge_case = array("top_freezer", "bottom_freezer", "side-by-side", "built-in", "compact","large","mini");

		foreach ($fridge_case as $key => $value) {
					$object->fridge_case->$value = getShelfsSize();
		}

		 $bulbs = array("20W","40W","60W","80W","100W","120W","140W");

		 foreach ($bulbs as $key => $value) {
					$object->bulb->$value = getShelfsSize();
		}

		$shelf = array(10,20,30,40,50,60,70);
 		foreach ($shelf as $key => $value) {
					$object->shelf->$value = getShelfsSize();
		}


		$ice = array("xxl_cubes", "xl_cubes", "l_cubes", "m_cubes", "s_cubes", "xs_cubes", "xxs_cubes");

		 foreach ($ice as $key => $value) {
					$object->icemaker->$value = getShelfsSize();
		}


  		return $object;  	}

  	function getText($proccesses, $percent){
 		foreach ($proccesses as $key => $value) {
     				 	if (strpos($value, (string)$percent) !== false) {
							    return str_replace((string)$percent . ' ','',$value);
							}
     				 }
  	}

  	function generateReport($text,$percent){
  		$object = new stdClass();
  		$object->fortschritt = $text;
  		$object->Prozent = $percent;
  		return $object;
  	}




    function getTypeOfFridge() {
		$types = array("Top freezer", "Bottom freezer", "Side-by-side", "Built-in", "Compact","Large","Mini");
   		 return $types[array_rand($types,1)];
}

	function getBulbWats(){
	    $types = array("20W","40W","60W","80W","100W","120W","140W");
	    return $types[array_rand($types,1)];
	}

	function getShelfsSize(){
		   $types = array(10,20,30,40,50,60,70);
    	return $types[array_rand($types,1)];
	}

	function getRandomBoolean(){
	      $types = array("XXL Cubes", "XL Cubes", "L Cubes", "M Cubes", "S Cubes", "XS Cubes", "XXS Cubes");
    	return $types[array_rand($types,1)];
	}


?>