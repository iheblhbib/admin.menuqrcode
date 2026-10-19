<?php

include('../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

    if ($_POST["action"] == 'fetch') {
        $order_column = array('libelle','duree',  'tarif', 'statut');

        $output = array();

        $main_query = "  SELECT * FROM pack WHERE statut = 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (libelle LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR duree LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR tarif LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY tarif DESC ';
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

            $sub_array[] = empty($row["duree"]) ? '--' :  ($row["duree"]).' ('.$row['type'].')'; 
            
            $sub_array[] = empty($row["tarif"]) ? '--' :  ($row["tarif"]);  
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {  
                
                $etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-status="' . $row["statut"] . '">' . $row["statut"] . '</button>';
 
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
        $order_column = array('libelle','duree',  'tarif', 'statut');

        $output = array();

        $main_query = "  SELECT * FROM pack WHERE statut != 'Activer' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (libelle LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR duree LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR tarif LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY tarif DESC ';
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

            $sub_array[] = empty($row["duree"]) ? '--' :  ($row["duree"]).' ('.$row['type'].')'; 
            
            $sub_array[] = empty($row["tarif"]) ? '--' :  ($row["tarif"]);  
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {  
                
                $etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-status="' . $row["statut"] . '">' . $row["statut"] . '</button>';
 
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
			':duree'	=>	$_POST["duree"],
			':type'	=>	$_POST["type"],
		);

		$object->query = "
		SELECT * FROM pack 
		WHERE libelle = :libelle 
		        and duree = :duree
		        and type = :type
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Pack déjà existe</div>';
		}
		else
		{ 
		    
            $data = array(
				':libelle'	        =>	$object->clean_input($_POST["libelle"]),
				':duree'	        =>	($_POST["duree"]) ? $object->clean_input($_POST["duree"]) : null,
				':type'	            =>	($_POST[type]) ? $object->clean_input($_POST["type"]) : null,
				':tarif'            => ($_POST["tarif"]) ? $object->clean_input($_POST["tarif"]) : null, 
			);
            
            $object->query = " INSERT INTO pack  (libelle, duree,type,  tarif) 
			                           VALUES (:libelle ,  :duree, :type, :tarif) ";
		
			$object->execute($data); 
			
            if ($object->connect->lastInsertId() != 0) {
                $success = 'Pack Ajouté';
            }else{
                $error = '<div class="alert alert-danger">Erreur d\'insertion</div>'; 
            } 
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
                                pack
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) {
            $data['libelle'] = $row['libelle']; 
            $data['duree'] = $row['duree'];
            $data['tarif'] = $row['tarif'];  
            $data['type'] = $row['type'];  

        }

        echo json_encode($data);
    }

 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = '';

        $data = array(
            ':libelle'	        =>	$object->clean_input($_POST["libelle"]),
			':duree'	        =>	($_POST["duree"]) ? $object->clean_input($_POST["duree"]) : null,
			':type'	            =>	($_POST["type"]) ? $object->clean_input($_POST["type"]) : null,
            ':id'               => $_POST['hidden_id'],
        );

        $object->query = "  SELECT
                                *
                            FROM
                                pack
                            WHERE
                                libelle = :libelle 
                                AND duree = :duree 
                                AND type = :type 
                                AND id != :id
		";

        $object->execute($data);

        if ($object->row_count() > 0) {
            $error = '<div class="alert alert-danger">Pseudo déjà existe</div>';
        } else {
 
            $data = array(
				':libelle'	        =>	$object->clean_input($_POST["libelle"]),
				':duree'	        =>	($_POST["duree"]) ? $object->clean_input($_POST["duree"]) : null,
				':tarif'            => ($_POST["tarif"]) ? $object->clean_input($_POST["tarif"]) : null, 
				':type'            => ($_POST["type"]) ? $object->clean_input($_POST["type"]) : null, 
                ':id'               => $_POST['hidden_id'],

            );

            $object->query = "UPDATE pack SET
                                			libelle = :libelle,
                                			duree = :duree,
                                			tarif = :tarif ,
                                			type = :type 

                        			WHERE id = :id ";
			$object->execute($data); 
    

            $success = 'Pack Modifié';
        }

        $output = array(
            'error' => $error,
            'success' => $success,
            'id' => $_POST['hidden_id'],
        );

        echo json_encode($output);

    }

    if ($_POST["action"] == 'statut') {
        $data = array(
            ':status' => $_POST['next_status'],
        );

        $object->query = "
		UPDATE pack
		SET statut = :status
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut Pack changé à ' . $_POST['next_status'] . '';
    }

 
}
