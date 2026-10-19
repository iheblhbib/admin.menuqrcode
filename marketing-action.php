<?php

include('../config.menuqrcode/config.php');

$object = new application(); 

$page_actuel = $object->get_page_url();

if(isset($_POST["action"]))
    {
    	if($_POST["action"] == 'fetch')
    	{
    		$order_column = array(  'titre','file', 'statut');
    
    		$output = array();
    
    		$main_query = " SELECT * FROM marketing WHERE  statut = 'Activer'  ";
    
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= ' AND (titre LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR file LIKE "%'.$_POST["search"]["value"].'%"  ) ';
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
    			
				$row['file'] = str_replace('../','https://',$row['file']);   
				
                $sub_array[] = html_entity_decode($row["titre"]);
	            
	            $sub_array[] = '<a href="'.$row["file"].'" class="glightbox" data-glightbox="title: '.$row['titre'].'; "  ><img src="'.$row["file"].'" style="background-color: #2c5199;" alt="image" class="img-fluid img-thumbnail" width="50" height="50"></a>';
      	     //   $sub_array[] = '<a href="'.$row["file"].'"  target="_blank" ><i class="fa-light fa-link"></i></a>';
 
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
               
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
  
    	if($_POST["action"] == 'fetch_archive')
    	{
    		$order_column = array(  'titre','file', 'statut');
    
    		$output = array();
    
    		$main_query = " SELECT * FROM marketing WHERE  statut != 'Activer'  ";
    
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= ' AND (titre LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR file LIKE "%'.$_POST["search"]["value"].'%"  ) ';
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
    			
				$row['file'] = str_replace('../','https://',$row['file']);   
				
                $sub_array[] = html_entity_decode($row["titre"]);
	            
	            $sub_array[] = '<a href="'.$row["file"].'" class="glightbox" data-glightbox="title: '.$row['titre'].'; "  ><img src="'.$row["file"].'" style="background-color: #2c5199;" alt="image" class="img-fluid img-thumbnail" width="50" height="50"></a>';
	           // $sub_array[] = '<a href="'.$row["file"].'"  target="_blank" ><i class="fa-light fa-link"></i></a>';
      
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
            
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
     
            if ($_FILES["file"]["name"] != '') {
                $upload_path = '../app.menuqrcode.tn/galerie/';
            
                $name = $_FILES['file']['name'];
                
                if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['file']['tmp_name'];
                    $new_name = uniqid() . '_' . $name;
                    $target_path = $upload_path . $new_name;
            
                    if (move_uploaded_file($tmp_name, $target_path)) {
            
                        $data = array( 
                            ':titre' => ($_POST['titre']) ? $object->clean_input($_POST['titre']) : null,
                            ':file' => $target_path, 
                        );
            
                        $object->query=" INSERT INTO marketing( 
                                                titre, 
                                                file 
                                            )
                                            VALUES(
                                                :titre,  
                                                :file 
                                            ) ";
                        
                        $object->execute($data);
                        
                        if($object->connect->lastInsertId() > 0 ) {
                            $success = 'Fichier Ajouté';
                        }else{
                            $errors =  "Erreur d'insertion";
                        }
			
                    } else {
                        $errors = "Error uploading file: $name";
                    }
                } else {
                    $errors = "Error uploading file: $name";
                }
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
    		SELECT * FROM marketing 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$result = $object->get_result();
    
    		$data = array();
    
    		foreach($result as $row)
    		{   
    			$data['titre'] = html_entity_decode($row['titre']);  
    			$data['file'] = str_replace('../','https://',$row['file']); ;
    		}
    
    		echo json_encode($data);
    	}
 
    	
		if($_POST["action"] == 'change_statut')
    	{
    		$data = array(
    			':statut'		=>	$_POST['next_statut']
    		); 
    
    		$object->query = "
    		UPDATE marketing 
    		SET statut = :statut 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$object->execute($data);
    
    		echo 'Fichier '.$_POST['next_statut'].'';
    	}
    	
   

    
 
    }
    
  



?>