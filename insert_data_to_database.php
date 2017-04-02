<?php

    $amount_to_insert = 1000;

    $db_connection = pg_connect("host=localhost dbname=fridge_service user=postgres password=");


//GENERAL FUNCTIONS //
    function addBrackets($string){
  return '\'' . $string . '\'' ;
}
function getYearMounthDay(){
    $year = rand(2010,2017);
    $mounth = rand(1,12);
    if($mounth == 2){
        $day = rand(1,28);
    } else {
       $day = rand(1,30);
    }
    return addBrackets($year . "-" . $mounth . "-" . $day);
}

function getTime(){
    $hours = rand(0,12);
    $minutes = rand(0,59);
    $seconds = rand(0,59);
  return addBrackets($hours . ":" . $minutes . ":" . $seconds);
}

// INSERT INTO FRIDGE //



function getTypeOfFridge() {
$types = array("Top freezer", "Bottom freezer", "Side-by-side", "Built-in", "Compact");
    return addBrackets($types[array_rand($types,1)]);
}

function getProdCountry(){
    $types = array("China","Japan","Germany","Indonesia","Russia","Vietnam");
    return addBrackets($types[array_rand($types,1)]);
}

function getColorOfFridge(){
    $types = array("black","red","white","silver","white","pink","brown");
    return addBrackets($types[array_rand($types,1)]);
}

function getFridgeVolume(){
    return rand(0,1000)/10;
}

for ($i=1; $i<=$amount_to_insert;$i++) {
        $type = getTypeOfFridge();
        $prodDate = getYearMounthDay();
        $color = getColorOfFridge();
        $country = getProdCountry();
        $volume = getFridgeVolume();

    pg_query($db_connection, "INSERT INTO fridge VALUES ($i,$type,$prodDate,$color,$country,$volume)");
}


// INSERT INTO catalog_address

function getCity(){
    $types = array("Vienna","Lower Austria EAST","Lower Austria WEST","Upper Austria","Salzburg","Tyrol","Burgenland","Styria","Carinthia");
    return addBrackets($types[array_rand($types,1)]);
}
function getTypeOfCode(){
    $types = array("private","commercial");
    return addBrackets($types[array_rand($types,1)]);
}

for ($i=1; $i<=$amount_to_insert;$i++) {
    $postal_code = $i+999;
    $city = getCity();
    $type = getTypeOfCode();

    pg_query($db_connection, "INSERT INTO postal_code VALUES ($postal_code,'Austria',$city,'Europe',$type)");
}


/// INSERT INTO CUSTOMER

function getCustomers(){
    $response = file_get_contents('https://uinames.com/api/?amount=500&ext');
    $res =  json_decode($response);
    // var_dump($res);
    return $res;
}

//!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!
$customers = getCustomers();


function getFetchedCustomers($customer_list){
    return $customer_list[array_rand($customer_list,1)];
}


for ($i=1; $i<=$amount_to_insert;$i++) {
             $fridge_id = rand(1,$amount_to_insert);

             $cust = getFetchedCustomers($customers);

             $first_name = addBrackets($cust->name);
             $last_name = addBrackets($cust->surname);
             $gender = addBrackets($cust->gender);
             $age = $cust->age;
             $title = addBrackets($cust->title);
             $phone = addBrackets($cust->phone);
             $email = addBrackets($cust->email);
             $password = addBrackets($cust->password);
            
          pg_query($db_connection, "INSERT INTO customer VALUES ($i,$fridge_id,$first_name,$last_name,$gender,$age,$title,$phone,$email,$password,null)");
}

// INSERT INTO customer_address

function getStreet(){
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return addBrackets(ucfirst($randomString . " " . "Street"));

}

for ($i=1; $i<=$amount_to_insert;$i++) {
             $postal_code = rand(1000,999+$amount_to_insert);  
             $street = getStreet();
             $flat = rand(1,100);
             $hause = rand(1,50);
             $porch = rand(0,1);

          pg_query($db_connection, "INSERT INTO customer_address VALUES ($i,$postal_code,$street,$hause,$flat,$porch)");
}



// INSERT INTO local_facility

function getFacilitiesType() {
$types = array("Corporate","Private","Mixed");
    return addBrackets($types[array_rand($types,1)]);
}

function getFacilitiesStatus() {
$types = array("ACTIVE","INACTIVE");
    return addBrackets($types[array_rand($types,1)]);
}

for ($i=1; $i<=$amount_to_insert;$i++) {
             $postal_code = rand(1000,999+$amount_to_insert);  
             $customer_id = rand(1,$amount_to_insert);
             $faciluty_type = getFacilitiesType();
             $facility_name = addBrackets("Local Facility " . $i . " " . "GMBH");
             $faciluty_status = getFacilitiesStatus();

          pg_query($db_connection, "INSERT INTO local_facility VALUES ($i,$postal_code,$customer_id,$facility_name,$faciluty_type,$faciluty_status)");
}

// INSERT INTO appointment

function getAppointmentType() {
$types = array("PRIVATE","CORPORATE");
    return addBrackets($types[array_rand($types,1)]);
}
function isSpecialHandlingNeeded(){
    $types = array("As quick as possible","Quality Inspection","DEFAULT");
    return addBrackets($types[array_rand($types,1)]);
}

for ($i=1; $i<=$amount_to_insert;$i++) {
             $customer_id = rand(1,$amount_to_insert);
             $facility_id = rand(1,$amount_to_insert);
             $type = getAppointmentType();
             $spec = isSpecialHandlingNeeded();
             $esimated = getYearMounthDay();
             $real = getYearMounthDay();


          pg_query($db_connection, "INSERT INTO appointment VALUES ($i,$facility_id,$type,$spec,$esimated,$real,$customer_id,null)");
}

// INSERT INTO facility_rate

function getRateDescription() {
$types = array("GOOD","NOT GOOD","Liked it","Was cool","Funny Guy","Pretty Quick","OMG SO BAD FUUUU");
    return addBrackets($types[array_rand($types,1)]);
}

function getRateType(){
$types = array("POSITIVE","NEGATIVE");
    return addBrackets($types[array_rand($types,1)]);
}
function getRecommend(){
$types = array("YES","NO","NOT SURE","MORE YES","MORE NO");
    return addBrackets($types[array_rand($types,1)]);
}


for ($i=1; $i<=$amount_to_insert;$i++) {

        $rate = rand(1,5);
        $rate_description = getRateDescription();
        $recoment = getRecommend();
        $type = getRateType();

          pg_query($db_connection, "INSERT INTO facility_rate VALUES ($i,$rate,$rate_description,$type,$recoment)");
}


// INSERT INTO repair_status
function getRepaired(){
$types = array("YES","NO","NOT SURE");
    return addBrackets($types[array_rand($types,1)]);
}
function getRepairedStatus(){
$types = array("NEED HELP","NEED TOOLS","ALL OK","NEED TO TAKE FRIDGE");
    return addBrackets($types[array_rand($types,1)]);
}
function getRepairedStatusType(){
$types = array("DEFAULT","CRITICAL","WARNING");
    return addBrackets($types[array_rand($types,1)]);
}

for ($i=1; $i<=$amount_to_insert;$i++) {
            $status_type = getRepairedStatusType();
            $repaired = getRepaired();
            $timestamp_estimated = getTime();
            $timestamp_real = getTime();
             $status = getRepairedStatus();

          pg_query($db_connection, "INSERT INTO repair_status VALUES ($i,$status,$status_type,$status, $timestamp_real,$timestamp_estimated)");
}



// INSERT INTO symptom

function getSymptomType(){
$types = array("ELECTRONICAL","FREEZING","COOL_FREEZEIN","ICE","OUTESIDE DAMAGE");
    return addBrackets($types[array_rand($types,1)]);
}
function getSymptomDescription(){
$types = array("Doesnt really work","FRIDGE IS ON FIREEEE","UNKNOWN","Dosnt turn on","Doesnt give me a cool vibes");
    return addBrackets($types[array_rand($types,1)]);
}
function getSymptomCausedBy(){
$types = array("Cat","Dog","UNKNOWN","Baby","Wife");
    return addBrackets($types[array_rand($types,1)]);
}
function getSymptomAssumpton(){
$types = array("UNKNOWN","Too high woltage","Drop fridge","Dance on Fridge","Too many beer there");
    return addBrackets($types[array_rand($types,1)]);
}

for ($i=1; $i<=$amount_to_insert;$i++) {
            $symptom_type = getSymptomType();
            $symptom_description = getSymptomDescription();
            $caused_by = getSymptomCausedBy();
            $assumption = getSymptomAssumpton();
            $symption_from = getYearMounthDay();

          pg_query($db_connection, "INSERT INTO symptom VALUES ($i,$symptom_type,$symptom_description,$caused_by,$assumption,$symption_from)");
}

?>