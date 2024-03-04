<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors',1);
 
 
//*********************                *******************//
//*********************     LETTURA    *******************//
//*********************                *******************//


try {
    $hostname = "localhost";
    $dbname = "persefone_be";
    $user = "root";
    $pass = "Pesefone1049";
    $db = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

$hotel_id=$_GET['hotel_id'];
  //https://admin.booking-engine.it/persefone__xml.php?hotel_id=4&function=offers_json
if ($_GET['function'] == 'offers_json') {

    foreach ($db->query("SELECT * FROM offers where hotel_id = '$hotel_id'") as $array) {
       
        $data['id'] = $array['id'];
        $data['name'] = pulizia($array['name']);
        $data['name_it'] = pulizia($array['name_it']);
        $data['valid_from'] = $array['valid_from'];
        $data['valid_to'] = $array['valid_to'];
        $data['description'] = $array['description'];
        $data['description_it'] = $array['description_it'];
        $data['discount_percentage'] = $array['discount_percentage'];
        $data['room_list'] = $array['room_list'];
        $data['days_of_week'] = $array['days_of_week'];
        $data['mobile_offer'] = $array['mobile_offer'];
        $valori[] = $data;
    }

  
    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'data' => $valori));
}

//https://admin.booking-engine.it/persefone__xml.php?hotel_id=2&function=add_offer&hotel_id=2&name=nomeen&name_it=nomeit&valid_from=2022-10-10&valid_to=2022-12-10&description=desc&description_it=xxxx&discount_percentage=8
if($_GET['function']=="add_offer"){

   
    $name_it = isset($_GET['name_it']) ? $_GET['name_it'] : '';
    $name = isset($_GET['name']) ? $_GET['name'] : $name_it;
    $hotel_id= isset($_GET['hotel_id']) ? $_GET['hotel_id'] : '';
    $valid_from=$_GET['valid_from'];
    $valid_to=$_GET['valid_to'];
    $description_it = isset($_GET['description_it']) ? $_GET['description_it'] : '';
    $description = isset($_GET['description']) ? $_GET['description'] : $description_it;
    $discount_percentage = isset($_GET['discount_percentage']) ? $_GET['discount_percentage'] : 0;
    //$room_list='[{"room_list":"1"},{"room_list":"2"},{"room_list":"5"},{"room_list":"6"},{"room_list":"7"},{"room_list":"10"},{"room_list":"11"},{"room_list":"17"},{"room_list":"596"},{"room_list":"597"},{"room_list":"598"},{"room_list":"599"},{"room_list":"600"}]';
    $room_list= isset($_GET['room_list']) ? $_GET['room_list'] : '';
    $mobile_offer = isset($_GET['mobile_offer']) ? $_GET['mobile_offer'] : '';
    $days_of_week='[{"days_of_week":"Monday"},{"days_of_week":"Tuesday"},{"days_of_week":"Wednesday"},{"days_of_week":"Thursday"},{"days_of_week":"Friday"},{"days_of_week":"Saturday"},{"days_of_week":"Sunday"}]';
    $image="1665133901_offer.png";
    $exclusive_days="[]";

    $minadults=1;
    $maxadults=99;

    $created_at=$updated_at=date('Y-m-d H:i:s');

    if(strlen($name)>0 && strlen($hotel_id)>0 && strlen($hotel_id)>0 && strlen($valid_from)>0 && strlen($valid_to)>0 && strlen($description)>0 && strlen($description_it)>0 && strlen($discount_percentage)>0 && strlen($room_list)>0){
       
        $operazione = $db->prepare("insert into offers (exclusive_days,created_at,updated_at,min_no_of_adults,max_no_of_adults,image,name,name_it,hotel_id,valid_from,valid_to,description,description_it,discount_percentage,room_list,days_of_week,mobile_offer) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        if ($operazione->execute(
                    array(
                        $exclusive_days,$created_at,$updated_at,$minadults,$maxadults,$image,$name,$name_it,$hotel_id,$valid_from,$valid_to,$description,$description_it,$discount_percentage,$room_list,$days_of_week,$mobile_offer
                    )
        )) {
            $successo="true";
        } else  $successo="false";


    }else{
        $successo="false";
    }

    header('Content-Type: text/json');
    echo json_encode(array('success' =>  $successo,'message'=>"x"));

}

if($_GET['function']=="edit_offer"){

   
    $hotel_id= isset($_GET['hotel_id']) ? $_GET['hotel_id'] : '';
    $valid_from=$_GET['valid_from'];
    $valid_to=$_GET['valid_to'];
    $discount_percentage = isset($_GET['discount_percentage']) ? $_GET['discount_percentage'] : 0;
    $id=$_GET['id'];
   
    if(strlen($hotel_id)>0 && strlen($valid_from)>0 && strlen($valid_to)>0 &&  $id>0){
    
        $operazione = $db->prepare("update offers set valid_from=?,valid_to=?,discount_percentage=? where id=?");
        if ($operazione->execute(
                    array(
                         $valid_from,$valid_to,$discount_percentage,$id
                    )
        )) {
            $successo="true";
        } else  $successo="false";


    }else{
        $successo="false";
    }

    header('Content-Type: text/json');
    echo json_encode(array('success' =>  $successo,'message'=>"x"));

}

 //https://admin.booking-engine.it/persefone__xml.php?hotel_id=4&function=lista_camere_json
if ($_GET['function'] == 'roomtypes_json') {

    foreach ($db->query("SELECT * FROM room_types where hotel_id = '$hotel_id'") as $array) {
        
        //print_r($array);
        $data['id'] = $array['id'];
        $data['name'] = pulizia($array['name']);
        $data['name_it'] = pulizia($array['name_it']);
        $data['short_description_it'] = pulizia($array['short_description_it']);
        $data['long_description_it'] = pulizia($array['long_description_it']);
        $data['room_image'] = pulizia($array['room_image']);

        $valori[] = $data;
    }

  
    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'data' => $valori));
}

if ($_GET['function'] == 'ratetypes_json') {

    foreach ($db->query("SELECT * FROM rate_types where hotel_id = '$hotel_id'") as $array) {
        
       // print_r($array);
        $data['id'] = $array['id'];
        $data['name'] = pulizia($array['name']);
        $valori[] = $data;
    }
 
    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'data' => $valori));
}


if ($_GET['function'] == 'update_extraprices') {

    $id2=$_GET['id'];
    $ext_adult1_rate=$_GET['ext_adult1_rate'];
    $ext_adult2_rate=$_GET['ext_adult2_rate'];
    $ext_adult3_rate=$_GET['ext_adult3_rate'];
    $ext_adult4_rate=$_GET['ext_adult4_rate'];
    $ext_adult1_rate_percentage=$_GET['ext_adult1_rate_percentage'];
    $ext_adult2_rate_percentage=$_GET['ext_adult2_rate_percentage'];
    $ext_adult3_rate_percentage=$_GET['ext_adult3_rate_percentage'];
    $ext_adult4_rate_percentage=$_GET['ext_adult4_rate_percentage'];

    $operazione = $db->prepare("update rate_plans set 
    ext_adult1_rate=? ,ext_adult2_rate=?,ext_adult3_rate=?,ext_adult4_rate=?,
    ext_adult1_rate_percentage=?,ext_adult2_rate_percentage=?,ext_adult3_rate_percentage=?,ext_adult4_rate_percentage=?
    
    where id=?");
    if ($operazione->execute(
            array(
                $ext_adult1_rate,$ext_adult2_rate,$ext_adult3_rate,$ext_adult4_rate,
                $ext_adult1_rate_percentage,$ext_adult2_rate_percentage,$ext_adult3_rate_percentage,$ext_adult4_rate_percentage,
                $id2
            )
    )) {
        $successo="true";
    } else  $successo="false";

    header('Content-Type: text/json');
    echo json_encode(array('success' => $successo));

}

if ($_GET['function'] == 'rateplans_json') {

    foreach ($db->query("SELECT * FROM rate_plans where hotel_id = '$hotel_id' order by room_type_id") as $array) {
        
        //print_r($array);
        $data['id'] = $array['id'];
        $data['name'] = pulizia($array['name']);
        $data['name_it'] = pulizia($array['name_it']);
        $data['room_type_id'] = pulizia($array['room_type_id']);
        $data['rate_type_id'] = pulizia($array['rate_type_id']);
        
         $data['ext_adult1_rate']= pulizia($array['ext_adult1_rate']);
         $data['ext_adult2_rate']= pulizia($array['ext_adult2_rate']);
         $data['ext_adult3_rate']= pulizia($array['ext_adult3_rate']);
         $data['ext_adult4_rate']= pulizia($array['ext_adult4_rate']);
         $data['ext_adult1_rate_percentage']= pulizia($array['ext_adult1_rate_percentage']);
         $data['ext_adult2_rate_percentage']= pulizia($array['ext_adult2_rate_percentage']);
         $data['ext_adult3_rate_percentage']= pulizia($array['ext_adult3_rate_percentage']);
         $data['ext_adult4_rate_percentage']= pulizia($array['ext_adult4_rate_percentage']);
        $valori[] = $data;
    }

  
    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'data' => $valori));
}



if ($_GET['function'] == 'inventory_json') {
    $from=$_GET['from'];
    $to=$_GET['to'];
    $hotel_id=(int)$hotel_id;

    foreach ($db->query("SELECT 
    room_types.name as nomecamera,room_types.name_it as nomecamerait,room_types.id as idt 
    FROM room_types  WHERE
    room_types.hotel_id= '$hotel_id' order by name_it") as $array) {
        $tuttelecamere[]=array(
            "id" => $array['idt'],
            "nomecamerait" => $array['nomecamerait'] 
        );
    }

    if(strlen($from)>0 && strlen($to)>0 && validateDate($from) && validateDate($to)){
        $to2=  date('Y-m-d',strtotime("$to "));      //da controllare meglio -1 days
        $from2=  date('Y-m-d',strtotime("$from"));
        foreach ($db->query("SELECT * FROM inventory_masters where hotel_id = '$hotel_id' and date between '$from2' and '$to2' ") as $array) {
                $dispo[$array['room_type_id']][$array['date']]=$array['availability'];
        }

    }

    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'rooms' => $tuttelecamere, 'availabilty' => $dispo));


}



if ($_GET['function'] == 'price_json') {

    error_reporting(0);
 
    $from=$_GET['from'];
    $to=$_GET['to'];
    $adults= isset($_GET['adults']) ? $_GET['adults'] : 0;
    $etabambini = isset($_GET['etabambini']) ? $_GET['etabambini'] : '';

    if(strlen($etabambini)>0){
        list($bambino1,$bambino2,$bambino3,$bambino4)=explode(",",$etabambini);
    }
 
    $hotel_id=(int)$hotel_id;

 

    foreach ($db->query("SELECT child_age from hotels where id = '$hotel_id' ") as $array) {
        $jsonage=$array['child_age'];
        $etadecodificata=json_decode($jsonage,1);
        $etadelbambino1start=$etadecodificata[0]['start_age'];
        $etadelbambino1end=$etadecodificata[0]['end_age'];
        $etadelbambino2start=$etadecodificata[1]['start_age'];
        $etadelbambino2end=$etadecodificata[1]['end_age'];
        $etadelbambino3start=$etadecodificata[2]['start_age'];
        $etadelbambino3end=$etadecodificata[2]['end_age'];
        //print_r($etadecodificata);
        //[{"start_age":"0","end_age":"2"},{"start_age":"3","end_age":"7"},{"start_age":"8","end_age":"18"} 
        //$etaconfig1=
    }

foreach ($db->query("SELECT  room_types.id as  idr, 
    room_types.base_adults , max_adults
    FROM room_types  WHERE
    room_types.hotel_id= '$hotel_id' ") as $array) {

    if($array['base_adults']>0)
        $baseadulti[$array['idr']]=$array['base_adults'];
        $maxadulti[$array['idr']]=$array['max_adults'];
    }

  

    foreach ($db->query("SELECT 
room_types.name as nomecamera,room_types.name_it as nomecamerait,room_types.id as idt,
room_types.room_image,
rate_types.name as nometariffa,rate_types.id as idr,rate_types.name_it as nometariffait,
rate_plans.id as idrt,
room_types.short_description_it, room_types.short_description,
room_types.name_it,
room_types.base_adults,
room_types.max_adults,
rate_plans.child_age1_rate,
rate_plans.child_age2_rate,
rate_plans.child_age3_rate,
rate_plans.child_age1_rate_percentage,
rate_plans.child_age2_rate_percentage,
rate_plans.child_age3_rate_percentage,
rate_plans.ext_adult1_rate,
rate_plans.ext_adult2_rate,
rate_plans.ext_adult3_rate,
rate_plans.ext_adult1_rate_percentage,
rate_plans.ext_adult2_rate_percentage,
rate_plans.ext_adult3_rate_percentage

FROM room_types,rate_types,rate_plans WHERE
room_types.hotel_id= '$hotel_id'
and rate_plans.room_type_id =  room_types.id
and rate_plans.rate_type_id = rate_types.id") as $array) {

 
    $tuttelecamere[$array['idt']][]=array(

        "idt" => $array['idt'],
        "nomecamera" => $array['nomecamera'],
        "nomecamerait" => $array['nomecamerait'],
        "room_images" => $array['room_image'],
        "nometariffa" => $array['nometariffa'],
        "nometariffait" => $array['nometariffait'],
        "idr" => $array['idr'],
        "idrt" => $array['idrt'],
        "short_description_it" => $array['short_description_it'],
        "short_description" => $array['short_description'],
        "name_it" => $array['name_it'],
        "max_adults" => $array['max_adults'],
        "base_adults" => $array['base_adults'] 
    );

    

    //camera - tariffa
    $prezziextradefault[$array['idt']][$array['idrt']]['child_age1_rate']=$array['child_age1_rate'];
    $prezziextradefault[$array['idt']][$array['idrt']]['child_age2_rate']=$array['child_age2_rate'];
    $prezziextradefault[$array['idt']][$array['idrt']]['child_age3_rate']=$array['child_age3_rate'];

    $prezziextradefault[$array['idt']][$array['idrt']]['child_age1_rate_percentage']=$array['child_age1_rate_percentage'];
    $prezziextradefault[$array['idt']][$array['idrt']]['child_age2_rate_percentage']=$array['child_age2_rate_percentage'];
    $prezziextradefault[$array['idt']][$array['idrt']]['child_age3_rate_percentage']=$array['child_age3_rate_percentage'];

    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult1_rate']=$array['ext_adult1_rate'];
    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult2_rate']=$array['ext_adult2_rate'];
    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult3_rate']=$array['ext_adult3_rate'];

    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult1_rate_percentage']=$array['ext_adult1_rate_percentage'];
    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult2_rate_percentage']=$array['ext_adult2_rate_percentage'];
    $prezziextradefault[$array['idt']][$array['idrt']]['ext_adult3_rate_percentage']=$array['ext_adult3_rate_percentage'];
 
}
 
 
     //dispo
    $nondispo=[];
    if(strlen($from)>0 && strlen($to)>0 && validateDate($from) && validateDate($to)){
        $to2=  date('Y-m-d',strtotime("$to -1 days"));      //da controllare meglio
        $from2=  date('Y-m-d',strtotime("$from"));
        foreach ($db->query("SELECT * FROM inventory_masters where hotel_id = '$hotel_id' and date between '$from2' and '$to2' ") as $array) {
            if($array['availability']==0){
                $nondispo[$array['room_type_id']]=0;
            }
        }

        foreach($tuttelecamere   as $idt => $ciao){
            if(isset($nondispo[$idt])){
                unset($tuttelecamere[$idt]);
            }

            //echo $maxadulti[$idt].">$adults<br>";

            if($maxadulti[$idt] < $adults){
                unset($tuttelecamere[$idt]);
            }
        }
    }

 

    //prezzo
    $prezzo=[];
    if(strlen($from)>0 && strlen($to)>0 && validateDate($from) && validateDate($to)){
        $to=  date('Y-m-d',strtotime("$to -1 days"));      //da controllare meglio
        $from=  date('Y-m-d',strtotime("$from"));

        foreach ($db->query("SELECT * FROM rate_restriction_masters where hotel_id = '$hotel_id' and date between '$from' and '$to' ") as $array) {
           // echo "<pre>";
            //print_r($array);
           // echo "</pre>";

            
            $extra_adult_1_amount  = $array['extra_adult_1_amount']; 
            $extra_adult_2_amount  = $array['extra_adult_2_amount']; 
            $extra_adult_3_amount  = $array['extra_adult_3_amount']; 
            $extra_adult_4_amount  = $array['extra_adult_4_amount']; 

            $child_age_1_rate  = $array['child_age_1_rate']; 
            $child_age_2_rate  = $array['child_age_2_rate']; 
            $child_age_3_rate  = $array['child_age_3_rate']; 
            $child_age_4_rate  = $array['child_age_4_rate']; 

             

            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age1_rate']>0){
                $child_age_1_rate = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age1_rate'];
            }
            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age2_rate']>0){
                $child_age_2_rate = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age2_rate'];
            }
            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age3_rate']>0){
                $child_age_3_rate = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['child_age3_rate'];
            }

            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult1_rate']>0){
                $extra_adult_1_amount = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult1_rate'];
            }
            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult2_rate']>0){
                $extra_adult_2_amount = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult2_rate'];
            }
            if($prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult3_rate']>0){
                $extra_adult_3_amount = $prezziextradefault[$array['room_type_id']][$array['rate_plan_id']]['ext_adult3_rate'];
            }
     
            $single_amount = $array['single_amount']; 
            $base_amount = $array['base_amount'];

          //  echo "RID: ".$array['room_type_id']."\n";

            if(isset($baseadulti[$array['room_type_id']])){
                $labaseadulti=$baseadulti[$array['room_type_id']]; 
            }else{
                //echo"base adulti non config ".$array['room_type_id']."<br>";
                $labaseadulti=$adults;
             } 
 
            //if(isset($prezzo[$array['room_type_id']][$array['rate_plan_id']])){

               // echo "ADULTI:$adults \n";
               
                if($adults<=0){
                    $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$base_amount;
                }else if($adults==1){
                    $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$single_amount;
                }else{
                   // echo "ADULTI: $adults \n";
                  //  echo "$labaseadulti <= $adults \n";
                    if($labaseadulti==$adults){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$base_amount;
                    }else{
                        $inpiu= ($adults-$labaseadulti);
                        // echo "IN PIU $inpiu ".$array['room_type_id']."\n";
                   //     echo "INPIU: $inpiu \n";
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$base_amount;
                        if($inpiu>0) $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$extra_adult_1_amount;
                        if($inpiu>1) $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$extra_adult_2_amount;
                        if($inpiu>2) $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$extra_adult_3_amount;
                        if($inpiu>3) $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$extra_adult_4_amount;
                    }
                }
/*
                $etadelbambino1start=$etadecodificata[0]['start_age'];
                $etadelbambino1end=$etadecodificata[0]['end_age'];
                $etadelbambino2start=$etadecodificata[1]['start_age'];
                $etadelbambino2end=$etadecodificata[1]['end_age'];
                $etadelbambino3start=$etadecodificata[2]['start_age'];
                $etadelbambino4end=$etadecodificata[2]['end_age'];

                $child_age_1_rate  = $array['child_age_1_rate']; 
                $child_age_2_rate  = $array['child_age_2_rate']; 
                $child_age_3_rate  = $array['child_age_3_rate']; 
                $child_age_4_rate  = $array['child_age_4_rate']; 
*/




                //bambini
                if(strlen($bambino1)>0){
                    
                    //fascia 1
                    if($bambino1>=$etadelbambino1start && $bambino1<=$etadelbambino1end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_1_rate;
                        
                    }
                    //fascia 2
                    if($bambino1>=$etadelbambino2start && $bambino1<=$etadelbambino2end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_2_rate;
                        
                    }
                    //fascia 2
                    if($bambino1>=$etadelbambino3start && $bambino1<=$etadelbambino3end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_3_rate;
                    }
                }
                if(strlen($bambino2)>0){
                    //fascia 1
                    if($bambino2>=$etadelbambino1start && $bambino2<=$etadelbambino1end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_1_rate;
                    }
                    //fascia 2
                    if($bambino2>=$etadelbambino2start && $bambino2<=$etadelbambino2end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_2_rate;
                    }
                    //fascia 2
                    if($bambino2>=$etadelbambino3start && $bambino2<=$etadelbambino3end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_3_rate;
                    }
                }
                if(strlen($bambino3)>0){
                    //fascia 1
                    if($bambino3>=$etadelbambino1start && $bambino3<=$etadelbambino1end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_1_rate;
                    }
                    //fascia 2
                    if($bambino3>=$etadelbambino2start && $bambino3<=$etadelbambino2end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_2_rate;
                    }
                    //fascia 2
                    if($bambino3>=$etadelbambino3start && $bambino3<=$etadelbambino3end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_3_rate;
                    }
                }
                if(strlen($bambino4)>0){
                    //fascia 1
                    if($bambino4>=$etadelbambino1start && $bambino4<=$etadelbambino1end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_1_rate;
                    }
                    //fascia 2
                    if($bambino4>=$etadelbambino2start && $bambino4<=$etadelbambino2end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_2_rate;
                    }
                    //fascia 2
                    if($bambino4>=$etadelbambino3start && $bambino4<=$etadelbambino3end){
                        $prezzo[$array['room_type_id']][$array['rate_plan_id']]+=$child_age_3_rate;
                    }
                }
 
                 
                //echo $array['date'].$array['base_amount']."\n";
           // }else $prezzo[$array['room_type_id']][$array['rate_plan_id']]=$base_amount; 
            
        }
    }else $errori="date non valide"; 

    //offerte
    $offerte=[];
    foreach ($db->query("SELECT * FROM offers where hotel_id = '$hotel_id'") as $array) {
       
        $data['id'] = $array['id'];
        $data['name'] = pulizia($array['name']);
        $data['valid_from'] = $array['valid_from'];
        $data['valid_to'] = $array['valid_to'];
        $data['description'] = $array['description'];
        $data['discount_percentage'] = $array['discount_percentage'];
        $data['room_list'] = $array['room_list'];
        $data['days_of_week'] = $array['days_of_week'];
        $offerte[] = $data;
    }

    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'rooms' => $tuttelecamere, 'price' => $prezzo, 'offers' => $offerte,'errors' => $errori));

 

}



if ($_GET['function'] == 'roomsetup_json') {
 
    $hotel_id=(int)$hotel_id;

    foreach ($db->query("SELECT 
        room_types.name as nomecamera,room_types.name_it as nomecamerait,room_types.id as idt,
        room_types.room_image,
        rate_types.name as nometariffa,rate_types.id as idr,rate_types.name_it as nometariffait,
        rate_plans.id as idrt,
        room_types.short_description_it, room_types.short_description,
        room_types.name_it,
        room_types.max_adults
        FROM room_types,rate_types,rate_plans WHERE
        room_types.hotel_id= '$hotel_id'
        and rate_plans.room_type_id =  room_types.id
        and rate_plans.rate_type_id = rate_types.id") as $array) {

            $tuttelecamere[]=array(

                "idt" => $array['idt'],
                "nomecamerait" => $array['nomecamerait'],
                "nometariffait" => $array['nometariffait'],
                "idr" => $array['idr'],
                "idrt" => $array['idrt'],
                "name_it" => $array['name_it'],
                "max_adults" => $array['max_adults']

            );
 
    }

    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'rooms' => $tuttelecamere));

}


//https://admin.booking-engine.it/persefone__xml.php?function=rates_json&from=2022-02-21&to=2022-02-28&hotel_id=2
if ($_GET['function'] == 'rates_json') {
 
    $from= isset($_GET['from']) ? $_GET['from'] : '';
    $to= isset($_GET['to']) ? $_GET['to'] : '';
    

    $hotel_id=(int)$hotel_id;

    

    foreach ($db->query("SELECT 
        room_types.name as nomecamera,room_types.name_it as nomecamerait,room_types.id as idt,
        room_types.room_image,
   
        rate_types.name as nometariffa,rate_types.id as idr,rate_types.name_it as nometariffait,
        rate_plans.id as idrt,
        room_types.short_description_it, room_types.short_description,
        room_types.name_it,
        room_types.max_adults
        FROM room_types,rate_types,rate_plans WHERE
        room_types.hotel_id= '$hotel_id'
        and rate_plans.room_type_id =  room_types.id
        and rate_plans.rate_type_id = rate_types.id") as $array) {

            $tuttelecamere[$array['idt']][]=array(

                "idt" => $array['idt'],
                "nomecamerait" => $array['nomecamerait'],
                "nometariffait" => $array['nometariffait'],
                "idr" => $array['idr'],
                "idrt" => $array['idrt'],
                "name_it" => $array['name_it'],
                "max_adults" => $array['max_adults']

            );
 
    }
  
    

     //dispo
    $nondispo=[];
    if(strlen($from)>0 && strlen($to)>0 && validateDate($from) && validateDate($to)){
        foreach ($db->query("SELECT * FROM inventory_masters where hotel_id = '$hotel_id' and date between '$from' and '$to' ") as $array) {
            if($array['availability']==0){
                $nondispo[$array['room_type_id']]=0;
            }
        }

        foreach($tuttelecamere   as $idt => $ciao){
            if(isset($nondispo[$idt])){
                unset($tuttelecamere[$idt]);
            }
        }
    }

    //prezzo
    $prezzo=[];  
    $valori=[];
    if(strlen($from)>0 && strlen($to)>0 && validateDate($from) && validateDate($to)){
        $to=  date('Y-m-d',strtotime("$to -1 days"));
        $from=  date('Y-m-d',strtotime("$from -1 days"));
        foreach ($db->query("SELECT * FROM rate_restriction_masters where hotel_id = '$hotel_id' and date between '$from' and '$to' ") as $array) {
  
            //if(isset($prezzo[$array['room_type_id']][$array['rate_plan_id']])){
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['base_amount']=$array['base_amount'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['extra_adult_1_amount']=$array['extra_adult_1_amount'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['extra_adult_2_amount']=$array['extra_adult_2_amount'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['extra_adult_3_amount']=$array['extra_adult_3_amount'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['extra_adult_4_amount']=$array['extra_adult_4_amount'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['child_age_1_rate']=$array['child_age_1_rate'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['child_age_2_rate']=$array['child_age_2_rate'];
                $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['child_age_3_rate']=$array['child_age_3_rate'];
               // $valori[$array['room_type_id']][$array['rate_plan_id']][$array['date']]['child_age_4_rate']=$array['child_age_4_rate'];

           // }
            
        }
    }

 
    header('Content-Type: text/json');
    echo json_encode(array('success' => true, 'rooms' => $tuttelecamere, 'prezzo' => $valori));


}

if ($_GET['function'] == 'update_inventory') {

    $from=$_GET['from'];
    $to=$_GET['to'];
    $hotel_id=(int)$hotel_id;
    $room_type_id=(int)$_GET['room_type_id'];
    $inventory=  $_GET['inventory'];

   
    $operazione = $db->prepare("update inventory_masters set availability=? where hotel_id=? and  room_type_id=?  and date between ? and ?");
    if ($operazione->execute(
                    array(
                        $inventory,$hotel_id,$room_type_id,$from,$to
                    )
    )) {
        $successo="true";
    } else  $successo="false";


 
}

//https://admin.booking-engine.it/persefone__xml.php?function=update_rates&from=2022-02-21&to=2022-02-28&hotel_id=2&base_amount=434&room_type_id=1&rate_plan_id=2
if ($_GET['function'] == 'update_rates') {

    $from=$_GET['from'];
    $to=$_GET['to'];
    $hotel_id=(int)$hotel_id;
    $room_type_id=$_GET['room_type_id'];
    $rate_plan_id=$_GET['rate_plan_id'];

    
    $base_amount= isset($_GET['base_amount']) ? $_GET['base_amount'] : '';
    $extra_adult_1_amount= isset($_GET['extra_adult_1_amount']) ? $_GET['extra_adult_1_amount'] : '';
    $extra_adult_2_amount= isset($_GET['extra_adult_2_amount']) ? $_GET['extra_adult_2_amount'] : '';
    $extra_adult_3_amount= isset($_GET['extra_adult_3_amount']) ? $_GET['extra_adult_3_amount'] : '';
    $extra_adult_4_amount= isset($_GET['extra_adult_4_amount']) ? $_GET['extra_adult_4_amount'] : '';

    $child_age_1_rate= isset($_GET['child_age_1_rate']) ? $_GET['child_age_1_rate'] : '';
    $child_age_2_rate= isset($_GET['child_age_2_rate']) ? $_GET['child_age_2_rate'] : '';
    $child_age_3_rate= isset($_GET['child_age_3_rate']) ? $_GET['child_age_3_rate'] : '';

    if(strlen($base_amount)>0){
        $operazione = $db->prepare("update rate_restriction_masters set base_amount=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $base_amount,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($extra_adult_1_amount)>0){
        $operazione = $db->prepare("update rate_restriction_masters set extra_adult_1_amount=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $extra_adult_1_amount,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($extra_adult_2_amount)>0){
        $operazione = $db->prepare("update rate_restriction_masters set extra_adult_2_amount=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $extra_adult_2_amount,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($extra_adult_3_amount)>0){
        $operazione = $db->prepare("update rate_restriction_masters set extra_adult_3_amount=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $extra_adult_3_amount,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($extra_adult_4_amount)>0){
        $operazione = $db->prepare("update rate_restriction_masters set extra_adult_4_amount=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $extra_adult_4_amount,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($child_age_1_rate)>0){
        $operazione = $db->prepare("update rate_restriction_masters set child_age_1_rate=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $child_age_1_rate,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($child_age_2_rate)>0){
        $operazione = $db->prepare("update rate_restriction_masters set child_age_2_rate=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $child_age_2_rate,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }
    if(strlen($child_age_3_rate)>0){
        $operazione = $db->prepare("update rate_restriction_masters set child_age_3_rate=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
        if ($operazione->execute(
                        array(
                            $child_age_3_rate,$hotel_id,$room_type_id,$rate_plan_id,$from,$to
                        )
        )) {
            $successo="true";
        } else  $successo="false";
    }

    /*
        $operazione = $db->prepare("update rate_restriction_masters set base_amount=?,extra_adult_1_amount=?,extra_adult_2_amount=?,extra_adult_3_amount=?,child_age_1_rate=?, 
    child_age_2_rate=?,child_age_3_rate=? where hotel_id=? and  room_type_id=? and rate_plan_id=? and date between ? and ?");
    if ($operazione->execute(
                    array(
                        $base_amount,$extra_adult_1_amount,$extra_adult_2_amount,$extra_adult_3_amount,
                        $child_age_1_rate,$child_age_2_rate,$child_age_3_rate,
                        $hotel_id,$room_type_id,$rate_plan_id,$from,$to
                    )
    )) {
        $successo="true";
    } else  $successo="false"; 
    */

  
    header('Content-Type: text/json');
    echo json_encode(array('success' =>  $successo));

}
?>
 

<?php
 
 function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

//funzioni di servizio
function pulizia($string)
{
    $string = str_replace("\n", '', $string);
    $string = str_replace("\r", '', $string);
//$string=str_replace(" ","",$string);   //modificato il  3 settembre 2012
    $string = str_replace('<', '', $string);
    $string = str_replace('>', '', $string);
    $string = str_replace('&', '', $string);
    $string = str_replace('%', '', $string);
    $string = str_replace('+', '', $string);
    $string = str_replace('#', '', $string);
 

    return $string;
}
 
?>
