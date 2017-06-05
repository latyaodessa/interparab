<?php

	static $server_url = '/~a1349252/iop/rest/server.php/';
	// static $server_url = '/server.php/';

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

  $rest = handleREST($_SERVER,$_GET);

  /// XML1

   	if(strpos($rest->url,'customer_data')){
   		$xml = simplexml_load_file("code/result1.xml");
   		$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
		$elements = explode('/', $path);
		$elements = cleanElements($elements);
		$result = execSimpleRegex($xml,$elements,$rest->arguments);

		if($rest->method == 'PUT'){
				$lastelement = preg_replace('/[^.]*\//', '', $rest->url);
				foreach ($rest->contentargs as $key => $v) {
					$result->$lastelement->$key = $v;
				}
		}

			if($rest->method == 'POST'){
				$year = date('Y',strtotime($rest->contentargs['date']));
				$xp = $rest->url . '[contains(@year_of_production,"'.$year.'") and number(fridge_volume)<'.$rest->contentargs['fridge_volume'].']/ancestor::customer[*/preceding-sibling::gender/text()="'.$rest->contentargs['gender'].'"]';
				$result = $xml->xpath($xp);
				$result = wrapResonse($result);
		}


		if($rest->method == 'DELETE'){
			$xp = $rest->url . '[prod_country/text()="'.$rest->contentargs['country'].'"]/ancestor::customer[@age>'.$rest->contentargs['age'].']';
			$result = $xml->xpath($xp);
			$result = wrapResonse($result);

			$tag1 = $rest->contentargs['elements_to_remove'][0];
			$tag2 = $rest->contentargs['elements_to_remove'][1];

			$res = array();

			foreach ($result as $key => $value) {
				unset($value->$tag1);
				unset($value->$tag2);
				array_push($res, $value);
			
			}

				$result = wrapResonse($res);

		}


	if($rest->accept == 'application/json'){
			print_r(json_encode($result));
		} else {
			print_r($result->asXML());

		}

  	}



	/// XML2
    	if(strpos($rest->url,'local_facility_data')){
   		$xml = simplexml_load_file("code/result2.xml");
   		$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
		$elements = explode('/', $path);
		$elements = cleanElements($elements);
		$result = execSimpleRegex($xml,$elements,$rest->arguments);


				if($rest->method == 'POST' && !empty($rest->contentargs['blocks'])){


					$blocks = array();

					 foreach ($rest->contentargs['blocks'] as $key => $value) {
     	  		 array_push($blocks, 'contains(text(),"'. $value .'")');
    	  			}

    	  			$blocks_separated = implode(" or ", $blocks);


				$xp = $rest->url.'/city['.$blocks_separated.']/ancestor::*/local_facility[contains(@facility_status,"'.$rest->contentargs['status'].'")]';
				$result = $xml->xpath($xp);
				$result = wrapResonse($result);

	}

		print_r(json_encode($result));

   	}


   	/// XML3
    	if(strpos($rest->url,'appointment_data')){
   		$xml = simplexml_load_file("code/result3.xml");
   		$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
		$elements = explode('/', $path);
		$elements = cleanElements($elements);
		$result = execSimpleRegex($xml,$elements,$rest->arguments);

		if($rest->method == 'POST' && !empty($rest->contentargs['hash_set'])){


			$year = date('Y',strtotime($rest->contentargs['date']));
			$xp = $rest->url . '/city[text()="'.$rest->contentargs['hash_set'][1].'"]/ancestor::customer_details[@age>'.$rest->contentargs['hash_set'][0].']/ancestor::appointment//status//symptom_from[contains(text(),"'.$year.'")]/ancestor::appointment';
			$result = $xml->xpath($xp);
			$result = wrapResonse($result);
		}

		if($rest->method == 'PUT' && !empty($rest->contentargs['symptoms'])){


		$symptopms = array();
    
      foreach ($rest->contentargs['symptoms'] as $key => $value) {
        array_push($symptopms, 'contains(@symptom_type,"'. $value .'")');
      }

      		$symptopms_separated = implode(" or ", $symptopms);

      		$xp = $rest->url . '['.$symptopms_separated.']/ancestor::appointment[appointment_type/text()="'.$rest->contentargs['type'].'"]';
			$result = $xml->xpath($xp);
			$res = array();
			foreach ($result as $key => $value) {
				$value->appointment_type = $rest->contentargs['update_to'];
				array_push($res, $value);
			}

			$result = wrapResonse($res);
			
		}

			if($rest->method == 'POST' && !empty($rest->contentargs['count'])){
			$xp = $rest->url . '[count(//appointment/child::appointment_details)>'.$rest->contentargs['count'][0].']/descendant::customer[age/text()>'.$rest->contentargs['count'][1].']';
			$result = $xml->xpath($xp);
			$result = wrapResonse($result);
		}

			if($rest->accept == 'application/json'){
			print_r(json_encode($result));
		} else {
			print_r($result->asXML());

		}

   	}



	/// XML5

if(strpos($rest->url,'rates_and_facilities')){
   		$xml = simplexml_load_file("code/result5.xml");
   		$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
		$elements = explode('/', $path);
		$elements = cleanElements($elements);
		$result = execSimpleRegex($xml,$elements,$rest->arguments);


		if($rest->method == 'POST' && !empty($rest->contentargs['range']) && !empty($rest->contentargs['types'])){
			$range = array();
    		 $types = array();
    
     	 foreach ($rest->contentargs['range'] as $key => $value) {
     	   array_push($range, 'contains(text(),"'. $value .'")');
    	  }
     	 foreach ($rest->contentargs['types'] as $key => $value) {
     	   array_push($types, 'contains(text(),"'. $value .'")');
    	  }

   			   $range_separated = implode(" or ", $range);
    		  $types_separated = implode(" or ", $types);

    		  $xp = $rest->url . '//real_date['.$range_separated.']/following-sibling::facility//status_type['.$types_separated.']/ancestor:: facility_data';

			$result = $xml->xpath($xp);

			$result = wrapResonse($result);

		}


		if($rest->method == 'POST' && !empty($rest->contentargs['symptopms'])){
			$year = date('Y',strtotime($rest->contentargs['date']));
			$xp = $rest->url . '[facility_type/text()="'.$rest->contentargs['type'].'"]/descendant::symptom/*[../symptom_from[contains(text(),"'.$year.'")]]';
			$result = $xml->xpath($xp);
			$result = wrapResonse($result);
		}

			if($rest->method == 'POST' && !empty($rest->contentargs['id_range'])){


			$xp = $rest->url . '[facility_id/text() >'.$rest->contentargs['id_range'][0].' and facility_id/text()<'.$rest->contentargs['id_range'][1].' and facility_status/text()="'.$rest->contentargs['status'].'"]/ancestor:: rates_of_particular_facility//facility_rate';
			$result = $xml->xpath($xp);
			$result = wrapResonse($result);
		}



		if($rest->accept == 'application/json'){
			print_r(json_encode($result));
		} else {
			print_r($result->asXML());

		}


   	}


     function execSimpleRegex($xml,$element,$arguments){

     	$impl = implode('/', $element);

     	$xpath;


     	if(empty($arguments)){
     		$xpath = '//'.$impl;
     	} else {
     			static $server_url = '/~a1349252/iop/rest/server.php/';
     			// static $server_url = '/server.php/';

     		   	$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
				$elements = explode('/', $path);
				$new_arr = array();
				foreach ($elements as $a) {
					if(strpos($a,'?')){
						array_push($new_arr, str_replace('?','[@',$a).']');
					}
					else array_push($new_arr,$a);
				}

     	$impl = implode('/', $new_arr);
     	$xpath = '//'.$impl;
     	}
  
     	$result = $xml->xpath($xpath);

		$sxml = wrapResonse($result);
     	return $sxml;

     }

     function wrapResonse($result){
     	$sxml = simplexml_load_string("<response></response>");


     	foreach ($result as $x){
     		$hate = createHATEOASXmlElements($x);
			sxml_append($sxml, $hate);

     	}
     	return $sxml;
     }

     function hasChild($xml){
     	 if($xml->count() == 0) return false ;
     	 return true;
     }

     function rekursionGegChildren($xml){
     		foreach ($xml->children() as $child){
     			foreach ($child->attributes() as $attr){
     				print_r($child->getName());
  					print_r($attr->getName());
  					print_r((string)$attr);
  				}
			if(hasChild($child)){
				rekursionGegChildren($child);
			}

				
		}
	
     }


		function sxml_append(SimpleXMLElement $to, SimpleXMLElement $from) {
		    $toDom = dom_import_simplexml($to);
		    $fromDom = dom_import_simplexml($from);
		    $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
		}

	function cleanElements($elements){
		$elm = array();
			foreach ($elements as $el) {
				array_push($elm,preg_replace('/\?.*/', '', $el));
			}
			return $elm;
	}


     function createHATEOASXmlElements($xml){

	     	$cld = array();
            foreach ($xml->children() as $child){
            	array_push($cld, $child->getName());
				}
		
			foreach ($cld as $key => $value) {
            	$link = $xml->addChild('link');
			    $link->addAttribute('rel', $value);
			    $link->addAttribute('href', $_SERVER['REQUEST_URI'] . '/' . $value);
			}
  				 return($xml);
     }

  
?>