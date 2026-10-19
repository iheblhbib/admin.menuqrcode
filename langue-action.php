<?php

include('../config.menuqrcode/config.php');

$object = new application();

if(isset($_POST["action"]))
    {
    	if($_POST["action"] == 'fetch')
    	{
    		$order_column = array('drapeau','libelle','code','statut','created');
    
    		$output = array();
    
    		$main_query = " SELECT 
                    		    * 
                    		FROM 
                    		    langue ";
            
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= 'WHERE (libelle LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR drapeau LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR code LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR statut LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR created LIKE "%'.$_POST["search"]["value"].'%") ';
    		}
    
    		if(isset($_POST["order"]))
    		{
    			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    		}
    		else
    		{
    			$order_query = 'ORDER BY statut ASC ';
    		}
    
    		$limit_query = '';
    
    		if($_POST["length"] != -1)
    		{
    			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    		}
    
    		$object->query = $main_query . $search_query . $order_query;
    
    		$object->execute();
    		
    		$filtered_rows = $object->row_count();
    
    		$object->query .= $limit_query;
    
    		$result = $object->get_result();
    
    		$object->query = $main_query;
    
    		$object->execute();
    
    		$total_rows = $object->row_count();
    
    		$data = array();
    
    
    		foreach($result as $row)
    		{	

    			$sub_array = array();
    			
	            $sub_array[] = empty($row["drapeau"]) ? '--' :  ($row["drapeau"]); 
    			
	            $sub_array[] = empty($row["libelle"]) ? '--' :  ($row["libelle"]); 
                
                $sub_array[] = empty($row["code"]) ? '--' :  ($row["code"]);  
               
                if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
                { 
                    
                    $sub_array[] = '--';
                    
                    $sub_array[] = '--';
    
                } else {  
                    
                    $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 
    
                    $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
     
                    $sub_array[] = '<button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
                }
                $data[] = $sub_array;
    		}
    
    		$output = array(
    			"draw"    			=> 	intval($_POST["draw"]),
    			"recordsTotal"  	=>  $total_rows,
    			"recordsFiltered" 	=> 	$filtered_rows,
    			"data"    			=> 	$data
    		);
    			
    		echo json_encode($output);
    
    	}
    	
    
    	if($_POST["action"] == 'Add')
    	{
    		$error = '';
    
    		$success = '';
    
    		$data = array(
    			':libelle'	=>	$_POST["libelle"]
    		);
    
    		$object->query = "
    		SELECT * FROM langue 
    		WHERE libelle = :libelle 
    		";
    
    		$object->execute($data);
    
    		if($object->row_count() > 0)
    		{
    			$error = '<div class="alert alert-danger">Langue déjà existe</div>';
    		}
    		else
    		{
                
                    $data = array(
    				':libelle'	 =>	$object->clean_input($_POST["libelle"]),
    				':drapeau'	 =>	$object->clean_input($_POST["drapeau"]),
    				':code'	    =>	$object->clean_input($_POST["code"]),
    			);
                
                $object->query = "
    			INSERT INTO langue 
    			(libelle,drapeau, code) 
    			VALUES (:libelle, :drapeau, :code)
    			";
    		
    			$object->execute($data);
    			
			    $object->query = "
    			    INSERT INTO langue_category(langue, category, code)
                    SELECT
                        l.id,
                        c.id,
                        l.code
                    FROM
                        langue l,
                        category c
                    WHERE
                        c.market in (select id from market where pro = '1') AND c.id NOT IN(
                        SELECT
                            category
                        FROM
                            langue_category
                        WHERE
                            langue = l.id
                    )
    			";
    		
    			$object->execute(); 
        		    		
			    $object->query="INSERT INTO market_langue (market,langue)
                        		SELECT m.id , l.id from market m , langue l where l.etat = '0'
                        		AND l.id NOT IN (Select langue 
                        								FROM market_langue
                        								WHERE market = m.id )";
        	    $object->execute();
                
    			$success = 'Langue Ajouté';
    		}
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
    
    	}
    
    	if($_POST["action"] == 'fetch_single')
    	{
    		$object->query = "
    		SELECT * FROM langue 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$result = $object->get_result();
    
    		$data = array();
    
    		foreach($result as $row)
    		{
    			$data['drapeau'] = $row['drapeau'];
    			$data['libelle'] = $row['libelle'];
    			$data['code'] = $row['code'];
    		}
    
    		echo json_encode($data);
    	}
    
    	if($_POST["action"] == 'Edit')
    	{
    		$error = '';
    
    		$success = '';
    
    		$data = array( 
    			':libelle'	=>	$_POST["libelle"],
    			':code'	    =>	$_POST["code"],
    			':id'		=>	$_POST['hidden_id']
    		);
    
    		$object->query = "
    		SELECT * FROM langue 
    		WHERE libelle = :libelle 
    		AND id != :id
    		";
    
    		$object->execute($data);
    
    		if($object->row_count() > 0)
    		{
    			$error = '<div class="alert alert-danger">Langue déjà existe</div>';
    		}
    		else
    		{


    				$data = array(
    					':libelle'		=>	$object->clean_input($_POST["libelle"]),
    					':drapeau'		=>	$object->clean_input($_POST["drapeau"]),
    					':code'		=>	$object->clean_input($_POST["code"]),

    				);
    				$object->query = "
    				UPDATE langue 
        				SET 
        				libelle = :libelle,
        				drapeau = :drapeau,
        				code = :code
    				WHERE id = '".$_POST['hidden_id']."'
    				";
    	
    				$object->execute($data);
    	
    				$success = 'Langue modifié';
    			
    		}
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
    	}
    	
	if($_POST["action"] == 'change_statut')
	{
		$data = array(
			':statut'		=>	$_POST['next_statut']
		);

		$object->query = "
		UPDATE langue 
		SET statut = :statut 
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo 'Langue  '.$_POST['next_statut'].'';
	}
    	

}   


?>