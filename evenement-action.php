<?php

include('../config.menuqrcode/config.php');

$object = new application(); 

$page_actuel = $object->get_page_url();

if(isset($_POST["action"]))
    {
    	if($_POST["action"] == 'fetch')
    	{
    		$order_column = array(  'image','titre','texte','debut', 'fin', 'statut');
    
    		$output = array();
    
    		$main_query = "
    		SELECT * FROM evenement WHERE  statut = 'Activer' 
    		";
    
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= ' AND (fin LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR debut LIKE "%'.$_POST["search"]["value"].'%"  ) ';
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
    			
				$row['image'] = str_replace('../','https://',$row['image']);   
				
	            $sub_array[] = '<a href="'.$row["image"].'" class="glightbox" data-glightbox="title: '.$row['titre'].'; "  ><img src="'.$row["image"].'" style="background-color: #2c5199;" alt="image" class="img-fluid img-thumbnail" width="50" height="50"></a>';
                $sub_array[] = html_entity_decode($row["titre"]);
    			$sub_array[] = html_entity_decode($row["texte"]);
    			$sub_array[] = $row["debut"];
    			$sub_array[] = $row["fin"]; 
    			
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
              
    			$sub_array[] = '<button style="font-size:x-small" type="button" name="edit_button" title="Éditer" class="btn btn-circle btn-sm btn-warning  edit_button" data-id="'.$row["id"].'"><i class="fas fa-edit"></i></button>'; 
        
    			
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
    	if($_POST["action"] == 'fetch2')
    	{
    		$order_column = array( 'image','titre','texte','debut', 'fin', 'statut');
    
    		$output = array();
    
    		$main_query = "
    		SELECT * FROM evenement WHERE  statut != 'Activer' 
    		";
    
    		$search_query = '';
    
    		if(isset($_POST["search"]["value"]))
    		{
    			$search_query .= ' AND (fin LIKE "%'.$_POST["search"]["value"].'%" ';
    			$search_query .= 'OR debut LIKE "%'.$_POST["search"]["value"].'%"  ) ';
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
    			
				$row['image'] = str_replace('../','https://',$row['image']);  
	            $sub_array[] = '<a href="'.$row["image"].'" class="glightbox" data-glightbox="title: '.$row['titre'].'; "  ><img src="'.$row["image"].'" style="background-color: #2c5199;" alt="image" class="img-fluid img-thumbnail" width="50" height="50"></a>';
                $sub_array[] = html_entity_decode($row["titre"]);
    			$sub_array[] = html_entity_decode($row["texte"]);
    			$sub_array[] = $row["debut"];
    			$sub_array[] = $row["fin"]; 
    			
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger';
               
                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
              
    			$sub_array[] = '<button style="font-size:x-small" type="button" name="edit_button" title="Éditer" class="btn btn-circle btn-sm btn-warning  edit_button" data-id="'.$row["id"].'"><i class="fas fa-edit"></i></button>'; 
              
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
    

			$image = '';
			if($_FILES["image"]["name"] != '')
			{
				$image = upload_image();
			}
			else
			{
				$image = 'img/defaultimage.jpg';
			}
			
                $data = array( 
				':titre'		=>   $object->clean_input($_POST["titre"]),
				':texte'		=>   $object->clean_input($_POST["texte"]),
				':debut'		=>   $object->clean_input($_POST["debut"]),
				':fin'      	=>	$object->clean_input($_POST["fin"]) , 
				':image'		=>	$image 
			);
            
            
            $object->query = "
			INSERT INTO evenement 
			       (   titre,   texte,  debut,  fin,  image ) 
			VALUES (  :titre , :texte, :debut, :fin, :image )
			";
      
			$object->execute($data);


			$success = 'Événements Ajouté';
    		
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
    
    	}
    
    	if($_POST["action"] == 'fetch_single')
    	{
    		$object->query = "
    		SELECT * FROM evenement 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$result = $object->get_result();
    
    		$data = array();
    
    		foreach($result as $row)
    		{  
    		    
    			$data['debut'] = $row['debut'];
    			$data['fin'] = $row['fin']; 
    			$data['image'] = str_replace('../','https://',$row['image']); ;
    			$data['titre'] = html_entity_decode($row['titre']);
    			$data['texte'] = html_entity_decode($row['texte']);
    		}
    
    		echo json_encode($data);
    	}
    
    	if($_POST["action"] == 'Edit')
    	{
    		$error = '';
    
    		$success = '';
     
    		
		    $image = $_POST["hidden_image"];
    		if($_FILES["image"]["name"] != '')
    		{
    			$image = upload_image();
    		}else{
    		    $image    = str_replace('https://','../',$_POST["hidden_image"]);  
    		} 
    
    	
			$data = array( 
		    	':titre'		=>   $object->clean_input($_POST["titre"]),
				':texte'		=>   $object->clean_input($_POST["texte"]),
		        ':debut'        =>	$object->clean_input($_POST["debut"]) ,
				':fin'          =>	$object->clean_input($_POST["fin"]) , 
				':image'		=>	$image
			
			);

			$object->query = "
			UPDATE evenement 
			SET  
			titre = :titre, 
			texte = :texte, 
			debut = :debut, 
			fin = :fin, 
			image = :image
			WHERE id = '".$_POST['hidden_id']."'
			";
            
			$object->execute($data);

			$success = 'Événements modifié';
    
    
    	
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
    
    	}
    
    	if($_POST["action"] == 'delete')
    	{
    
    		$object->query = "
    		DELETE FROM evenement   
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$object->execute();
    
    		echo 'Événements supprimé';
    	}
    	
		if($_POST["action"] == 'change_statut')
    	{
    		$data = array(
    			':statut'		=>	$_POST['next_statut']
    		); 
    
    		$object->query = "
    		UPDATE evenement 
    		SET statut = :statut 
    		WHERE id = '".$_POST["id"]."'
    		";
    
    		$object->execute($data);
    
    		echo 'Événements '.$_POST['next_statut'].'';
    	}
    	
   

    
 
    }
    
 
    
    function upload_image()
{
    if(isset($_FILES["image"]))
    {
        $filename = $_FILES['image']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $new_name = rand() . '.' . $extension;
        $destination = '../app.menuqrcode.tn/img/' . $new_name;
        $source_path = $_FILES['image']['tmp_name'];

        // Set the desired maximum width and height
        $max_width = 800;
        $max_height = 600;

        // Get the original image dimensions
        list($width, $height) = getimagesize($source_path);

        // Calculate the proportional scaling factor
        $scale = min($max_width / $width, $max_height / $height);

        // Calculate the new dimensions
        $new_width = $width * $scale;
        $new_height = $height * $scale;

        // Create a new image with the resized dimensions and a transparent background
        $resized_image = imagecreatetruecolor($new_width, $new_height);
        imagesavealpha($resized_image, true);
        $transparent_color = imagecolorallocatealpha($resized_image, 0, 0, 0, 127);
        imagefill($resized_image, 0, 0, $transparent_color);

        // Load the original image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $source_image = imagecreatefromjpeg($source_path);
        } elseif ($extension === 'png') {
            $source_image = imagecreatefrompng($source_path);
        } elseif ($extension === 'webp') {
            $source_image = imagecreatefromwebp($source_path);
        } else {
            // Unsupported image format
            return false;
        }

        // Enable alpha blending for transparent images
        imagealphablending($resized_image, true);
        imagesavealpha($resized_image, true);

        // Resize the image
        imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Save the resized image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            imagejpeg($resized_image, $destination);
        } elseif ($extension === 'png') {
            imagepng($resized_image, $destination);
        } elseif ($extension === 'webp') {
            imagewebp($resized_image, $destination);
        }

        // Free up memory
        imagedestroy($resized_image);
        imagedestroy($source_image);

        return $destination;
    }
}
    



?>