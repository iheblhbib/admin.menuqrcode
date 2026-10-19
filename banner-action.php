<?php

include('../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

    if ($_POST["action"] == 'fetch') {
        $order_column = array('b.banner','m.market',  'b.montant','b.debut','b.fin', 'statut');

        $output = array();

        $main_query = " SELECT 
                            b.* ,
                            m.market as libelle
                        FROM 
                            banner b
                            LEFT JOIN market m ON m.id = b.market
                        WHERE 
                            b.statut = 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (b.debut LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR b.fin LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR b.montant LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR b.statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY m.market DESC ';
        }

        $limit_query = '';

        if ($_POST["length"] != -1) {
            $limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $object->query = $main_query . $search_query . $order_query;

        $object->execute();

        $filtered_rows = $object->row_count();

        $object->query .= $limit_query;

        $result = $object->get_result();

        if ($object->autorisation('r', $_SESSION['id'], $page_actuel) != 0) {
            $result = null;
        }

        $object->query = $main_query;

        $object->execute();

        $total_rows = $object->row_count();

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();  
            $row['banner'] = str_replace('../','https://',$row['banner']);
            $sub_array[] = '<a href="'.$row["banner"].'" class="glightbox" data-glightbox="title: '.$row['libelle'].';"  ><img src="'.$row["banner"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
            
            $sub_array[] = empty($row["libelle"]) ? '--' :  ($row["libelle"]);

            $sub_array[] = empty($row["montant"]) ? '0,000' :  ($row["montant"]);  
            $sub_array[] = empty($row["debut"]) ? '--' :  ($row["debut"]); 
            
            $sub_array[] = empty($row["fin"]) ? '--' :  ($row["fin"]);  
            
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {  
                
                $etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' . $row["statut"] . '</button>';
 
                $sub_array[] = '<button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
            }
            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $filtered_rows,
            "data" => $data,
        );

        echo json_encode($output);

    } 
    
    if ($_POST["action"] == 'fetch2') {
        $order_column = array('b.banner','m.market',  'b.montant','b.debut','b.fin', 'statut');

        $output = array();

        $main_query = " SELECT 
                            b.* ,
                            m.market as libelle
                        FROM 
                            banner b
                            LEFT JOIN market m ON m.id = b.market
                        WHERE 
                            b.statut != 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (b.debut LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR b.fin LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR b.montant LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR b.statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY m.market DESC ';
        }

        $limit_query = '';

        if ($_POST["length"] != -1) {
            $limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $object->query = $main_query . $search_query . $order_query;

        $object->execute();

        $filtered_rows = $object->row_count();

        $object->query .= $limit_query;

        $result = $object->get_result();

        if ($object->autorisation('r', $_SESSION['id'], $page_actuel) != 0) {
            $result = null;
        }

        $object->query = $main_query;

        $object->execute();

        $total_rows = $object->row_count();

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();  
            $row['banner'] = str_replace('../','https://',$row['banner']);
            $sub_array[] = '<a href="'.$row["banner"].'" class="glightbox" data-glightbox="title: '.$row['libelle'].';"  ><img src="'.$row["banner"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
            
            $sub_array[] = empty($row["libelle"]) ? '--' :  ($row["libelle"]);

            $sub_array[] = empty($row["montant"]) ? '0,000' :  ($row["montant"]);  
            $sub_array[] = empty($row["debut"]) ? '--' :  ($row["debut"]); 
            
            $sub_array[] = empty($row["fin"]) ? '--' :  ($row["fin"]);  
            
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {  
                
                $etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' . $row["statut"] . '</button>';
 
                $sub_array[] = '<button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
            }
            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $filtered_rows,
            "data" => $data,
        );

        echo json_encode($output);

    }  
    
    if ($_POST["action"] == 'Add') {
        $error = '';

        $success = '';
 
	    $banner = '';
		if($_FILES["banner"]["name"] != '')
		{
			$banner = upload_image();
		}
		else
		{
			$banner = '../app.menuqrcode.tn/img/defaultbanner.webp';
		}
		
        $data = array(
            ':banner'           => $banner,
			':market'	        =>	$object->clean_input($_POST["market"]),
		    ':debut'		    =>   $object->clean_input($_POST["debut"]).' 00:00:00',
		    ':fin'      	    =>	$object->clean_input($_POST["fin"]).' 23:59:59',
			':montant'          => ($_POST["montant"]) ? $object->clean_input($_POST["montant"]) : null, 
		);
        
        $object->query = " INSERT INTO banner  (banner, market,  debut, fin,  montant) 
		                           VALUES (:banner ,  :market, :debut,  :fin, :montant) ";
	
		$object->execute($data); 
		
        if ($object->connect->lastInsertId() != 0) {
            $success = 'Banner Ajouté';
        }else{
            $error = '<div class="alert alert-danger">Erreur d\'insertion</div>'; 
        } 
	 

        $output = array(
            'error' => $error,
            'success' => $success,
            'data' => $data ,
            'id' => $object->connect->lastInsertId()
        );

        echo json_encode($output);

    }

    if ($_POST["action"] == 'fetch_single') {
        $object->query = "  SELECT 
                                *   
                            FROM 
                                banner
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) {
            
            $data['banner']     = $row['banner'];  
            $data['img'] = str_replace('../','https://',$row['banner']); 
            $data['market']     = $row['market'];
            $data['debut']      = date('Y-m-d',strtotime($row['debut']));  
            $data['fin']        = date('Y-m-d',strtotime($row['fin'])); 
            $data['montant']    = $row['montant']; 

        }

        echo json_encode($data);
    } 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = ''; 
        
		$banner = $_POST["hidden_banner_image"];
		if($_FILES["banner"]["name"] != '')
		{
			$banner = upload_image();
		}


        $data = array(
            ':banner'           => $banner,
			':market'	        =>	$object->clean_input($_POST["market"]),
		    ':debut'		    =>   $object->clean_input($_POST["debut"]).' 00:00:00',
		    ':fin'      	    =>	$object->clean_input($_POST["fin"]).' 23:59:59',
			':montant'          => ($_POST["montant"]) ? $object->clean_input($_POST["montant"]) : null, 
            ':id'               => $_POST['hidden_id'],

        );

        $object->query = "UPDATE banner SET
                            			banner = :banner,
                            			market = :market,
                            			debut = :debut,
                            			fin = :fin,
                            			montant = :montant 

                    			WHERE id = :id ";
		$object->execute($data); 


        $success = 'Banner Modifié';
       

        $output = array(
            'error' => $error,
            'success' => $success,
            'id' => $_POST['hidden_id'],
        );

        echo json_encode($output);

    }

    if ($_POST["action"] == 'statut') {
        $data = array(
            ':statut' => $_POST['next_statut'],
        );

        $object->query = "
		UPDATE banner
		SET statut = :statut
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut banner changé à ' . $_POST['next_statut'] . '';
    } 
}

 
// function upload_image()
// {
// 	if(isset($_FILES["banner"]))
// 	{
// 		$filename = $_FILES['banner']['name'];
// 		$extension = pathinfo($filename, PATHINFO_EXTENSION);
// 		$new_name = rand() . '.' . $extension;
// 		$destination = '../app.menuqrcode.tn/img/' . $new_name;
// 		move_uploaded_file($_FILES['banner']['tmp_name'], $destination);
// 		return $destination;
// 	}
// }



function upload_image()
{
    if(isset($_FILES["banner"]))
    {
        $filename = $_FILES['banner']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $new_name = rand() . '.' . $extension;
        $destination = '../app.menuqrcode.tn/img/' . $new_name;
        $source_path = $_FILES['banner']['tmp_name'];

        // Set the desired maximum width and height
        $max_width = 1080;
        $max_height = 1920;

        // Get the original image dimensions
        list($width, $height) = getimagesize($source_path);

        // Calculate the proportional scaling factor
        $scale = min($max_width / $width, $max_height / $height);

        // Calculate the new dimensions
        $new_width = $width * $scale;
        $new_height = $height * $scale;

        // Create a new image with the resized dimensions and a transparent banner
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
