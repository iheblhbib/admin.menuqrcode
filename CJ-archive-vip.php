<?php
 
    include('/home5/qdwlxrcz/config.menuqrcode/config.php');
    
    $object = new application(); 
    
    $data = array();
     
    $object->query = "  SELECT
                            *
                        FROM
                            vip
                        WHERE
                            date(NOW())   > expire_date  and expire = '2' ";
    
    $result = $object->get_result();
    
    foreach ($result as $row) {
        
         		$data = array(
        			':statut'   =>	'Desactiver',
        			':id'		=> $row['id']
        		); 
        
        		$object->query = "
        		UPDATE vip 
        		SET statut = :statut 
        		WHERE id = :id
        		";
        
        		$object->execute($data);
    }

 

 