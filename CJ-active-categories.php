<?php
 
    include('/home5/qdwlxrcz/config.menuqrcode/config.php');
    
    $object = new application(); 
    
    $table = ['categorie_sub_sub','categorie_sub','categorie','article',];
    
    for($i = 0 ; $i < count($table) ; $i++){
          
        $object->query = "  SELECT
                                *
                            FROM
                                statut_$table[$i]
                            WHERE
                                etat = '1'  ";
        
        $result = $object->get_result();
        
        foreach ($result as $row) {
            
     		$data = array(
    			':statut'   =>	'Activer',
    			':id'		=> $row['categorie']
    		); 
    
    		$object->query = "
    		UPDATE $table[$i] 
    		SET statut = :statut 
    		WHERE id = :id
    		";
    
    		$object->execute($data);
    
     		$data = array(
    			':etat'     =>	'2',
    			':id'	    => $row['id']
    		); 
    
    		$object->query = "
    		UPDATE statut_$table[$i] 
    		SET etat = :etat 
    		WHERE id = :id
    		";
    
    		$object->execute($data);
        }
        
    }
     

 

 