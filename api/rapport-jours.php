<?php  include('../../config.menuqrcode/config.php');

$object = new application(); 

include_once(__DIR__ . '/../securite.php');
securite_exiger_admin($object);

$data = array();

$object->query = " SELECT DISTINCT date , 
                        sum(counted ) as sum 
                    FROM
                        archive_market_jours 
                    WHERE date >= DATE_SUB(NOW(), INTERVAL 31 DAY) 
                        GROUP BY date
                    ORDER BY
                            date  ASC ";

$result = $object->get_result();

foreach ($result as $row) {

    $sub_array = array(); 

    $sub_array[] = $row['date'] ;
    $sub_array[] =  $row['sum']; 

    $data[] = $sub_array;
 
}

echo json_encode($data);
