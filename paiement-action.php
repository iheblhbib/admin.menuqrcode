<?php

include('../config.menuqrcode/config.php');

$object = new application();

if(isset($_POST["action"]))
    {
    	if($_POST["action"] == 'fetch')
    	{
    		$order_column = array('p.date','u.name','u.name','pk.libelle','p.remmise','p.montant');
    
    		$output = array();
    
    		$main_query = " SELECT 
                    		    p.*,
                                pk.libelle,
                                pk.duree,
                                u.name
                    		FROM 
                    		    paiement p 
                                LEFT JOIN pack  pk ON pk.id = p.pack 
                                LEFT JOIN user u ON u.id = p.client
                                 ";
            
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= 'WHERE (p.date LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR u.name LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR pk.libelle LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR p.remise LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR p.montant LIKE "%'.$_POST["search"]["value"].'%") ';
    		}
    
    		if(isset($_POST["order"]))
    		{
    			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    		}
    		else
    		{
    			$order_query = 'ORDER BY p.date DESC ';
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
    			
	            $sub_array[] =  date('d-m-Y',strtotime($row["date"])); 
                
                $sub_array[] =  ucwords($row["name"]);  
                
                $sub_array[] =  html_entity_decode($object->get_market_paiement($row['id']));  
                
                $sub_array[] =  ucwords($row["libelle"]);  
                
                $sub_array[] =  ($row['type_remise'] == '1' ) ?   ($row["remise"].'%') : $row['remise'].' TND';  
                
                $sub_array[] =   ($row["montant"]).' TND';  
               
                if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
                {  
                    
                    $sub_array[] = '--';
    
                } else {  
                     
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
				':date'	            =>	$object->clean_input($_POST["date"]),
				':client'	        =>	$object->clean_input($_POST["client"]),
				':pack'	            =>	$object->clean_input($_POST["pack"]),
				':pack_montant'	    =>	$object->clean_input($_POST["pack_montant"]),
				':montant'	        =>	$object->clean_input($_POST["montant"]),
				':remise'	        =>	($_POST["remise"]) ? $object->clean_input($_POST["remise"]) : '0.000',
				':type_remise'	    =>	$object->clean_input($_POST["type_remise"]),
				':user'	            =>	$_SESSION['id'],
			);
            
            $object->query = "
			INSERT INTO paiement (  date, client, pack, pack_montant, montant, remise, type_remise,  user)   
		                VALUES   (  :date, :client, :pack, :pack_montant, :montant, :remise, :type_remise,  :user)
			";
		
			$object->execute($data);
			
			$paiement = $object->connect->lastInsertId();
			
            if ($paiement != 0) {
                $success = 'Paiement Ajouté';
                if($_POST['market'] != '')
                    foreach ($_POST['market'] as $market) {
                        $data = array(
                            ':paiement' => $paiement,
                            ':market' => $market,
                        );

                        $object->query = "INSERT paiement_market ( paiement ,  market  )
                                                        VALUES  ( :paiement ,  :market  )";

                        $object->execute($data);
                    }
                       
    			$client = json_decode($object->get_user($_POST["client"]));
    			
    			$pack = json_decode($object->get_pack($_POST["pack"]));
			    
				if( date('Y-m-d') > $client->echeance )
				{
				    if($pack->type == 'j'){
				        $date_final = date('Y-m-d', strtotime('+'.$pack->duree.' day', strtotime(date('Y-m-d'))) );
				    }
				    else{
				        $date_final = date('Y-m-d', strtotime('+'.$pack->duree.' month', strtotime(date('Y-m-d'))) );
				    }
				}
				else
				{
				    
				     if($pack->type == 'j'){
				         $date_final = date('Y-m-d', strtotime('+'.$pack->duree.' day', strtotime($client->echeance)) );
				     }
				     else{
				         $date_final = date('Y-m-d', strtotime('+'.$pack->duree.' month', strtotime($client->echeance)) );
				     }
				}
    		    
    		    $data = array(
    		          ':echeance' => $date_final,
    		          ':id' => $_POST["client"],
    		          );
    		
    			$object->query = "UPDATE user  
    								SET statut = 'Activer', 
    									echeance = :echeance 
    								WHERE  id = :id ";
    								
    			$object->execute($data);
                    
            } else {
                $error = '<div class="alert alert-danger">Erreur d\'insertion</div>';
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
    		SELECT * FROM paiement 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$result = $object->get_result();
    
    		$data = array();
    
    		foreach($result as $row)
    		{ 
    			$data['date'] = $row['date'];
    			$data['client'] = $row['client'];
    			$data['pack'] = $row['pack'];
    			$data['pack_montant'] = $row['pack_montant'];
    			$data['montant'] = $row['montant'];
    			$data['remise'] = $row['remise'];
    			$data['type_remise'] = $row['type_remise'];
    		}
    		
	        $object->query = "  SELECT
                                     *
                                FROM
                                    paiement_market
                                WHERE
                                    paiement = '" . $_POST["id"] . "' ";

            $result = $object->get_result();
    
            $sub_array = array();
    
            foreach ($result as $row) {
                $sub_array[] = $row['market'];
            }
    
            $data['market'] = $sub_array;
    
    		echo json_encode($data);
    	}
    
    	if($_POST["action"] == 'Edit')
    	{
    		$error = '';
    
    		$success = '';
     
			$data = array(
				':date'	            =>	$object->clean_input($_POST["date"]),
				':client'	        =>	$object->clean_input($_POST["client"]),
				':pack'	            =>	$object->clean_input($_POST["pack"]),
				':pack_montant'	    =>	$object->clean_input($_POST["pack_montant"]),
				':montant'	        =>	$object->clean_input($_POST["montant"]),
				':remise'	        =>	($_POST["remise"]) ? $object->clean_input($_POST["remise"]) : '0.000',
				':type_remise'	    =>	$object->clean_input($_POST["type_remise"]),
				':user'	            =>	$_SESSION['id'],
				':id'	            =>	$_POST['hidden_id'],
			);
			$object->query = " UPDATE paiement 
                        				SET 
                        				date = :date,
                        				client = :client,
                        				pack = :pack,
                        				pack_montant = :pack_montant,
                        				montant = :montant,
                        				remise = :remise,
                        				type_remise = :type_remise,
                        				user = :user  
                        			WHERE id = :id ";

			$object->execute($data);
			
			$object->query = "DELETE FROM  paiement_market WHERE paiement = '".$_POST['hidden_id']."' ";
        
            $object->execute();
			
            if($_POST['market'] != '')
                foreach ($_POST['market'] as $market) {
                    $data = array(
                        ':paiement' => $_POST['hidden_id'],
                        ':market' => $market,
                    );
        
                    $object->query = "INSERT paiement_market ( paiement ,  market  )
                                                    VALUES  ( :paiement ,  :market  )";
        
                    $object->execute($data);
                }

			$success = 'Paiement modifié';
    			
    	 
    
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
		UPDATE paiement 
		SET statut = :statut 
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo 'paiement  '.$_POST['next_statut'].'';
	}
    	

}   


?>