<?php include('../../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/../securite.php');
securite_exiger_admin($object);

if (!$object->is_login()) {
    header("location:" . $object->base_url . "");
}

$data = array();

$object->query = "  SELECT
                           *
                    FROM
                        pack
                    WHERE
                        statut ='Activer' ";

$result = $object->get_result();

foreach ($result as $item) {
     
    $object->query = "  SELECT
                                COUNT(*) AS counted
                            FROM
                                paiement
                            WHERE
                                pack = '".$item['id']."'
                                ";
    
    $result = $object->get_result();
    
    foreach ($result as $row) {
        $sub_array = array();
        
        $type = (($item['type'] == 'j') ? ' Jours' : ' Mois' );
        $sub_array['value'] = $row['counted'];
        $sub_array['name']  = $item['libelle'].' ('.$item['duree'].$type.')';
        $data[] = $sub_array;
    } 
}

 


echo json_encode($data);
