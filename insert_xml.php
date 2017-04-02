<?php

    $amount_to_insert = 1000;
    $db_connection = pg_connect("host=localhost dbname=fridge_service user=postgres password=");

for ($i=1; $i<=$amount_to_insert;$i++) {

  $result = pg_query($db_connection, "select * from customer AS c 
    									join customer_address AS cp ON c.customer_id = cp.customer_id 
    									join postal_code as pc ON cp.postal_code = pc.postal_code
    									where c.customer_id = $i");
  
  if(pg_fetch_all($result)){

$res = pg_fetch_all($result)[0];



$xml = new SimpleXMLElement('<customer_data/>');

$customer = $xml->addChild('customer');
$customer -> addChild('customer_id',trim($res['customer_id']));
$customer -> addChild('fridge_id',trim($res['fridge_id']));
$customer -> addChild('first_name',trim($res['first_name']));
$customer -> addChild('last_name',trim($res['last_name']));
$customer -> addChild('gender',trim($res['gender']));
$customer -> addChild('age',trim($res['age']));
$customer -> addChild('title',trim($res['title']));
$customer -> addChild('phone',trim($res['phone']));
$customer -> addChild('email',trim($res['email']));


$customer_address = $customer->addChild('customer_address');
$customer_address -> addChild("street",trim($res['street']));
$customer_address -> addChild("hause",trim($res['hause']));
$customer_address -> addChild("flat",trim($res['flat']));
$customer_address -> addChild("porch",trim($res['porch']));


$postal_code = $customer_address->addChild('postal_code');
$postal_code -> addChild("postal_code",trim($res['postal_code']));
$postal_code -> addChild("country",trim($res['country']));
$postal_code -> addChild("city",trim($res['city']));
$postal_code -> addChild("continent",trim($res['continent']));
$postal_code -> addChild("type",trim($res['type']));

$asXml = '\'' . $xml->asXML() . '\'';
$dom = dom_import_simplexml($xml);
$xmlParesed = '\'' .  $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement) . '\'';

pg_query($db_connection, "UPDATE customer SET customer_to_export = $xmlParesed where customer_id = $i");

  }
  
}


    for ($i=1; $i<=$amount_to_insert;$i++) {


  $result = pg_query($db_connection, "select * from appointment as a 
  										join local_facility as lf ON a.facility_id = lf.facility_id
  										join repair_status as rp ON a.appointment_id = rp.appointment_id
  										join symptom as s ON a.appointment_id = s.appointment_id
  										where a.appointment_id = $i");


    if(pg_fetch_all($result)){

		$res = pg_fetch_all($result)[0];
		$xml = new SimpleXMLElement('<appointment_data/>');

		$appointment = $xml->addChild('appointment');
		$appointment -> addChild('appointment_id',trim($res['appointment_id']));
		$appointment -> addChild('appointment_type',trim($res['appointment_type']));
		$appointment -> addChild('special_handling',trim($res['special_handling']));
		$appointment -> addChild('esimated_date',trim($res['esimated_date']));
		$appointment -> addChild('real_date',trim($res['real_date']));
		$appointment -> addChild('customer_id',trim($res['customer_id']));

		$facility = $appointment -> addChild('facility');

		$facility -> addChild('facility_id',trim($res['facility_id']));
		$facility -> addChild('local_facility_name',trim($res['local_facility_name']));
		$facility -> addChild('facility_type',trim($res['facility_type']));
		$facility -> addChild('facility_status',trim($res['facility_status']));

		$repair = $facility -> addChild('repair');
		$repair -> addChild('status',trim($res['status']));
		$repair -> addChild('status_type',trim($res['status_type']));
		$repair -> addChild('repared',trim($res['repared']));
		$repair -> addChild('spendet_time',trim($res['spendet_time']));
		$repair -> addChild('esitmated_time',trim($res['esitmated_time']));

		$symptom = $repair -> addChild('symptom');
		$symptom -> addChild('symptom_type',trim($res['symptom_type']));
		$symptom -> addChild('symptom_description',trim($res['symptom_description']));
		$symptom -> addChild('caused_by',trim($res['caused_by']));
		$symptom -> addChild('assumption',trim($res['assumption']));
		$symptom -> addChild('symptom_from',trim($res['symptom_from']));


		$asXml = '\'' . $xml->asXML() . '\'';

		$dom = dom_import_simplexml($xml);
		$xmlParesed = '\'' .  $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement) . '\'';

		pg_query($db_connection, "UPDATE appointment SET appointment_data_to_export = $xmlParesed where customer_id = $i");

}


}

  


?>