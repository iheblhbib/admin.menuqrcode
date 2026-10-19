<?php

include('../config.menuqrcode/config.php');

$object = new application();

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

    if ($_POST["action"] == 'fetch') {
        $order_column = array('libelle','description', 'niveau','url',  'statut');

        $output = array();

        $main_query = "  SELECT * FROM theme WHERE statut = 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (libelle LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR url LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR description LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR niveau LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY libelle ASC ';
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

            $sub_array[] = empty($row["libelle"]) ? '--' :  ($row["libelle"]);
            
            $sub_array[] = empty($row["description"]) ? '--' :  ($row["description"]);
            
            $sub_array[] = empty($row["niveau"]) ? '--' :  ($row["niveau"]);  

            $sub_array[] = empty($row["url"]) ? '--' :   '<a href="'.$row["url"].'" target="_blank" >'.($row["url"]).'</a>'; 
           
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
        $order_column = array('libelle','description', 'niveau','url',  'statut');

        $output = array();

        $main_query = "  SELECT * FROM theme WHERE statut != 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (libelle LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR url LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR description LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR niveau LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY libelle ASC ';
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

            $sub_array[] = empty($row["libelle"]) ? '--' :  ($row["libelle"]);
            
            $sub_array[] = empty($row["description"]) ? '--' :  ($row["description"]);
            
            $sub_array[] = empty($row["niveau"]) ? '--' :  ($row["niveau"]);  

            $sub_array[] = empty($row["url"]) ? '--' :  '<a href="'.$row["url"].'" target="_blank" >'.($row["url"]).'</a>'; 
           
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

		$data = array(
			':libelle'	=>	$_POST["libelle"],
			':url'	=>	$_POST["url"],
		);

		$object->query = "
		SELECT * FROM theme 
		WHERE libelle = :libelle and url = :url
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Thème déjà existe</div>';
		}
		else
		{ 
		    
            $data = array(
				':libelle'	        =>	$object->clean_input($_POST["libelle"]),
				':url'	            =>	($_POST["url"]) ? $object->clean_input($_POST["url"]) : null,
				':niveau'            => ($_POST["niveau"]) ? $object->clean_input($_POST["niveau"]) : null, 
				':description'            => ($_POST["description"]) ? $object->clean_input($_POST["description"]) : null, 
			);
            
            $object->query = " INSERT INTO theme  (libelle, url,  niveau, description) 
			                           VALUES (:libelle ,  :url, :niveau, :description) ";
		
			$object->execute($data); 
			
            if ($object->connect->lastInsertId() != 0) {
                $success = 'Thème Ajouté';
            }else{
                $error = '<div class="alert alert-danger">Erreur d\'insertion</div>'; 
            } 
		}

        $output = array(
            'error' => $error,
            'success' => $success, 
        );

        echo json_encode($output);

    }

    if ($_POST["action"] == 'fetch_single') {
        $object->query = "  SELECT 
                                *   
                            FROM 
                                theme
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) {
            $data['libelle'] = $row['libelle']; 
            $data['url'] = $row['url'];
            $data['niveau'] = $row['niveau'];  
            $data['description'] = $row['description'];  

        }

        echo json_encode($data);
    }

 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = '';

        $data = array(
            ':libelle'	        =>	$object->clean_input($_POST["libelle"]),
			':url'	        =>	($_POST["url"]) ? $object->clean_input($_POST["url"]) : null,
            ':id'               => $_POST['hidden_id'],
        );

        $object->query = "  SELECT
                                *
                            FROM
                                theme
                            WHERE
                                libelle = :libelle AND url = :url AND id != :id
		";

        $object->execute($data);

        if ($object->row_count() > 0) {
            $error = '<div class="alert alert-danger">Pseudo déjà existe</div>';
        } else {
 
            $data = array(
				':libelle'	        =>	$object->clean_input($_POST["libelle"]),
				':url'	            =>	($_POST["url"]) ? $object->clean_input($_POST["url"]) : null,
				':niveau'           => ($_POST["niveau"]) ? $object->clean_input($_POST["niveau"]) : null, 
			    ':description'      => ($_POST["description"]) ? $object->clean_input($_POST["description"]) : null, 
                ':id'               => $_POST['hidden_id'],

            );

            $object->query = "UPDATE theme SET
                                			libelle = :libelle,
                                			url = :url,
                                			niveau = :niveau, 
                                			description = :description 

                        			WHERE id = :id ";
			$object->execute($data); 
    

            $success = 'theme Modifié';
        }

        $output = array(
            'error' => $error,
            'success' => $success, 
        );

        echo json_encode($output);

    }

    if ($_POST["action"] == 'statut') {
        $data = array(
            ':statut' => $_POST['next_statut'],
        );

        $object->query = "
		UPDATE theme
		SET statut = :statut
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut theme changé à ' . $_POST['next_statut'] . '';
    }

 
}
