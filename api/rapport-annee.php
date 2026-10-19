<?php  include('../../config.menuqrcode/config.php');

$object = new application(); 

include_once(__DIR__ . '/../securite.php');
securite_exiger_admin($object);

$data = array();

$object->query = "  SELECT DISTINCT  year , 
                        sum(counted ) as sum 
                    FROM
                        archive_market_mois  
                        GROUP BY  year
                    ORDER BY
                            year   ASC ";

$result = $object->get_result();

foreach ($result as $row) {

    $sub_array = array(); 

    $sub_array[] = $row['year'] ;
    $sub_array[] =  $row['sum']; 

    $data[] = $sub_array;
 
}

echo json_encode($data);
