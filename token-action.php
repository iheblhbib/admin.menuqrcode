<?php

include('../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);

if(isset($_POST["action"]))
    {
    	if($_POST["action"] == 'fetch')
    	{
    		$order_column = array('token','taille','expiration','statut','created');
    
    		$output = array();
    
    		$main_query = " SELECT 
                    		    * 
                    		FROM 
                    		    token ";
            
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= 'WHERE (token LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR expiration LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR taille LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR statut LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR created LIKE "%'.$_POST["search"]["value"].'%") ';
    		}
    
    		if(isset($_POST["order"]))
    		{
    			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    		}
    		else
    		{
    			$order_query = 'ORDER BY created ASC ';
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
    			
	            $sub_array[] = empty($row["token"]) ? '--' :  ($row["token"]); 
                
                $sub_array[] = empty($row["expiration"]) ? '--' :  ($row["expiration"]);  
                
                $sub_array[] = empty($row["taille"]) ? '--' :  ($row["taille"]);  
               
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
				':token'	    =>	$object->clean_input($_POST["token"]),
				':expiration'   =>	($_POST["expiration"]) ? $object->clean_input($_POST["expiration"]) : null,
				':taille'	    =>	($_POST["taille"]) ? $object->clean_input($_POST["taille"]) : null,
			);
            
            $object->query = "
			INSERT INTO token  (token,expiration, taille) 
			            VALUES (:token, :expiration , :taille ) ";
		
			$object->execute($data);
			  
			$success = 'API Tokens Ajouté';
    	  
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
    
    	}
    
    	if($_POST["action"] == 'fetch_single')
    	{
    		$object->query = "
    		SELECT * FROM token 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$result = $object->get_result();
    
    		$data = array();
    
    		foreach($result as $row)
    		{
    			$data['token'] = $row['token'];
    			$data['expiration'] = $row['expiration'];
    			$data['taille'] = $row['taille'];
    		}
    
    		echo json_encode($data);
    	}
    
    	if($_POST["action"] == 'Edit')
    	{
    		$error = '';
    
    		$success = '';
    
    		$data = array(
    		    ':token'	    =>	$object->clean_input($_POST["token"]),
				':expiration'   =>	($_POST["expiration"]) ? $object->clean_input($_POST["expiration"]) : null,
				':taille'	    =>	($_POST["taille"]) ? $object->clean_input($_POST["taille"]) : null,
    			':id'		    =>	$_POST['hidden_id']
    		); 
    		
			$object->query = " UPDATE token 
                    				SET 
                    				token = :token,
                    				expiration = :expiration,
                    				taille = :taille
                    			WHERE id = :id ";

			$object->execute($data);

			$success = 'API Tokens modifié';
    		 
    
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
		UPDATE token 
		SET statut = :statut 
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo 'API Tokens  '.$_POST['next_statut'].'';
	}
    	

}   


?>