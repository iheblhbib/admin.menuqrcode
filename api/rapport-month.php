<?php  include('../../config.menuqrcode/config.php');

$object = new application(); 

include_once(__DIR__ . '/../securite.php');
securite_exiger_admin($object);

$data = array();

$object->query = "  SELECT DISTINCT month ,
                        year , 
                        sum(counted ) as sum 
                    FROM
                        archive_market_mois  
                    WHERE
                        year >= YEAR(CURDATE()) - 2  
                    GROUP BY 
                            month , year
                    ORDER BY
                            year , month   ASC ";

$result = $object->get_result();

foreach ($result as $row) {

    $sub_array = array(); 

    $sub_array[] = $row['year'].'-'.$row['month'];
    $sub_array[] =  $row['sum']; 

    $data[] = $sub_array;
 
}

echo json_encode($data);
