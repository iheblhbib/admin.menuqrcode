<?php  include('../../config.menuqrcode/config.php');

$object = new application(); 

include_once(__DIR__ . '/../securite.php');
securite_exiger_admin($object);

$data = array();

$_POST['date'] = $_POST['date'].'-01';

$object->query = "  SELECT DISTINCT market , 
                        sum(counted ) as sum 
                    FROM
                        archive_market_mois  
                    WHERE market in (SELECT id from market where gestionnaire in (SELECT id from user where statut = 'Activer' ) ) AND 
                    		month = month('".$_POST['date']."')  AND 
                            year = year('".$_POST['date']."') 
                        GROUP BY market
                    ORDER BY
                            sum   ASC ";

$result = $object->get_result();

foreach ($result as $row) {
    
    $market = json_decode($object->get_market($row['market']));

    $sub_array = array(); 

    $sub_array[] = $market->market;
    $sub_array[] =  $row['sum']; 

    $data[] = $sub_array;
 
}

echo json_encode($data);
