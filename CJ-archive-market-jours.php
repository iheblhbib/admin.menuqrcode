<?php

 
  include('/home5/qdwlxrcz/config.menuqrcode/config.php');

$object = new application(); 

$data = array();



$object->query = "  SELECT
                        id
                    FROM
                        market
                    WHERE
                        gestionnaire IN(
                        SELECT
                            id
                        FROM
                            user
                        WHERE type = 'gestionnaire' AND statut = 'Activer'
                    ) ";

$result = $object->get_result();

foreach ($result as $row) {
    
    $object->query = "  SELECT DISTINCT
                            date(created) as date
                        FROM
                            acces_liste
                        WHERE
                            market = '".$row['id']."'  
                              
                        ORDER BY
                                date DESC 
                        LIMIT 4  ";
    
    $result = $object->get_result();
    
    foreach ($result as $item) {
        
        
        $data = array(
            ':market' => $row['id'],
            ':date' => $item['date'] 
        );
    
        $object->query = "  SELECT 
                                * 
                            FROM 
                                archive_market_jours
    	                    WHERE 
    	                        market = :market  AND   
    	                        date = :date    
    	                        ";
    
        $object->execute($data);
    
        if ($object->row_count() > 0) {
            
                
            $sub_array = array();
        
            $access = $object->CountAccessDuration($row['id'],'day',$item['date']); 
            
            $data = array (
                    ':counted' => $access,
                    ':market' => $row['id'],
                    ':date' => $item['date'],
                    
                );
        
            $object->query="UPDATE archive_market_jours SET 
            
                                counted = :counted WHERE 
                                        market =  :market AND 
                                        date = :date  ";
            
            $object->execute($data);
            
        }else{
            
        
            $sub_array = array();
        
            $access = $object->CountAccessDuration($row['id'],'day',$item['date']); 
            
            $data = array (
                    ':market' => $row['id'],
                    ':date' => $item['date'],
                    ':counted' => $access,
                    
                );
        
            $object->query="INSERT INTO archive_market_jours ( market, date,counted) VALUES  ( :market, :date, :counted) ";
            
            $object->execute($data);
        }
     
    }
}

echo json_encode($data);

 