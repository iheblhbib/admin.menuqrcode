<?php

include('/home5/qdwlxrcz/config.menuqrcode/config.php');

$object = new application(); 

$data = array();



$object->query = " SELECT DISTINCT
                        market ,
                        year(created) as year,
                        month(created) as month
                    FROM
                        acces_liste  
                     WHERE     year(created) = year(CURRENT_DATE)  AND  month(created) = month(CURRENT_DATE ) 
                     GROUP BY 
                     	market , 
                        year,
                        month
                    ORDER BY market ";

$result = $object->get_result();

foreach ($result as $row) {
    
    $object->query = "  SELECT DISTINCT
                             year(created) as year,
                            month(created) as month
                        FROM
                            acces_liste
                        WHERE
                            market = '".$row['market']."'  AND  year(created) = year(CURRENT_DATE)  AND  month(created) = month(CURRENT_DATE ) 
                              
                        ORDER BY
                                year, month ASC    ";
    
    $result = $object->get_result();
    
    foreach ($result as $item) {
        
        $data = array(
            ':market' => $row['market'],
            ':month' => str_pad($item['month'], 2, '0', STR_PAD_LEFT),
            ':year' => $item['year'],
        );
    
        $object->query = "  SELECT 
                                * 
                            FROM 
                                archive_market_mois
    	                    WHERE 
    	                        market = :market  AND   
    	                        month = :month  AND   
    	                        year = :year     
    	                        ";
    
        $object->execute($data);
    
        if ($object->row_count() > 0) {
 
            
            $item['month'] = str_pad($item['month'], 2, '0', STR_PAD_LEFT);
        
            $access = $object->CountAccessDuration($row['market'],'mois',$item['year'].'-'.$item['month'].'-01'); 
            
            $data = array (
                    ':counted' => $access,
                    ':market' => $row['market'],
                    ':month' => $item['month'],
                    ':year' => $item['year'],
                    
                );
        
            $object->query = "  UPDATE archive_market_mois
                                SET  
                                    counted = :counted 
        	                    WHERE 
    	                            market = :market  AND   
    	                            month = :month  AND   
    	                            year = :year         ";
        
            $object->execute($data);
        
        }else{
    
            $sub_array = array();
            
            $item['month'] = str_pad($item['month'], 2, '0', STR_PAD_LEFT);
        
            $access = $object->CountAccessDuration($row['market'],'mois',$item['year'].'-'.$item['month'].'-01'); 
            
            $data = array (
                    ':market' => $row['market'],
                    ':month' => $item['month'],
                    ':year' => $item['year'],
                    ':counted' => $access,
                    
                );
        
            $object->query="INSERT INTO archive_market_mois ( market, month,year,counted) VALUES  ( :market, :month, :year, :counted) ";
            
            $object->execute($data);
            
        }
     
    }
}

echo json_encode($data);

 