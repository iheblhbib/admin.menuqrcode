<?php
 
    include('/home5/qdwlxrcz/config.menuqrcode/config.php');
    
    $object = new application(); 

$object->query="SELECT
                    *
                FROM
                    konnect
                WHERE
                   etat = '2' AND  statut in ('1','2') ";

$result = $object->get_result();

foreach ($result as $row) 
{
    $status = $object->getPaymentStatus($row['reference']);
     
    $etat = '';
    
    switch ($status) {
        case 'pending':
            $etat = '1';  
            break;
        case 'failed':
            $etat = '2'; 
            break;
        case 'completed':
            $etat = '3';  
            break;
        case 'canceled':
            $etat = '4';  
            break;
        case 'refunded':
            $etat = '5'; 
            break;
        case 'expired' :
            $etat = '6';
            break;
        default:
            $etat = '2';  
    } 
    
    $object->query="UPDATE konnect set statut = '$etat' WHERE id = ".$row['id']." ";
    
    $object->execute();
}
