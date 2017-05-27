<?php

	static $server_url = '/server.php/';

   function handleREST($server,$get) {
   $url = (array_key_exists('PATH_INFO',$server) ? $server['PATH_INFO'] : '/');
   $method = $server['REQUEST_METHOD'];
   parse_str(file_get_contents('php://input'),$contentargs);
   $arguments = array_merge($get,$contentargs);
   $accept = array_key_exists('HTTP_ACCEPT',$server) ? $server['HTTP_ACCEPT'] : '*/*';
   $ret = new StdClass;
   $ret->url = $url;
   $ret->method = $method;
   $ret->arguments = $arguments;
   $ret->accept = $accept;
   return $ret;
 }

  $rest = handleREST($_SERVER,$_GET);

   	if(strpos($rest->url,'customer_data')){
   		$xml = simplexml_load_file("code/result1.xml");

   		$path = str_replace($server_url, '', $_SERVER['REQUEST_URI']);

		$elements = explode('/', $path);

		$elements = cleanElements($elements);

		$result = execSimpleRegex($xml,$elements,$rest->arguments);


  	}








     function execSimpleRegex($xml,$element,$arguments){

     	$impl = implode('/', $element);

     	$xpath;


     	if(empty($arguments)){
     		$xpath = '//'.$impl;
     	} else {
     			static $server_url = '/server.php/';
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

		$sxml = simplexml_load_string("<response></response>");


     	foreach ($result as $x){
     		$hate = createHATEOASXmlElements($x);
			sxml_append($sxml, $hate);

     	}

    	 print_r($sxml->asXML());

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