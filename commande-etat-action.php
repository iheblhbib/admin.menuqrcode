<?php

include('../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);
 

if (isset($_POST["action"])) {
 
    if ($_POST["action"] == 'fetch') {
        $order_column = array('order_etat', 'libelle', 'statut');

        $output = array();

        $main_query = "
		SELECT * FROM commande_etat    
		";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= ' WHERE (libelle LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY order_etat   ASC ';
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

	        $sub_array[] = '<span style=" cursor: move;" data-id="'.$row["id"].'"><i class="fad fa-arrows-alt"></i></span>';
	        
            $sub_array[] = $row['libelle'];
            
            $sub_array[] = '<span class="badge bg-'.$row['color'].'">&nbsp;&nbsp;</span>'; 
            
            $sub_array[] = ($row['visible'] == '1' ) ? '<span class="text-success">Oui</span>' : '<span class="text-danger">Non</span>'; 
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) {
                $sub_array[] = '--';
                
                $sub_array[] = '--'; 

            } else {
                $etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';

                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-status="' . $row["statut"] . '">' . $row["statut"] . '</button>';

                $sub_array[] = ' <button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
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
            ':libelle' => $_POST["libelle"],
        );

        $object->query = "
		SELECT * FROM commande_etat
		WHERE libelle = :libelle
		";

        $object->execute($data);

        if ($object->row_count() > 0) {
            $error = '<div class="alert alert-danger">Etat déjà existe</div>';
        } else {

            $data = array( 
                ':libelle' => empty($object->clean_input($_POST["libelle"])) ? null : $object->clean_input($_POST["libelle"]),
                ':color' => empty($object->clean_input($_POST["color"])) ? null : $object->clean_input($_POST["color"]),
                ':order_etat' => $object->get_count('commande_etat') + 1, 
                ':visible' =>  $object->clean_input($_POST["visible"]),

            );

            $object->query = "INSERT INTO commande_etat (libelle,color, order_etat , visible)
                                VALUES( :libelle,:color,:order_etat, :visible)";

            $object->execute($data);

            if ($object->connect->lastInsertId() != 0) {
                $success = 'Etat Ajouté';
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
                                commande_etat
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) { 
            $data['libelle'] = $row['libelle']; 
            $data['color'] = $row['color']; 
            $data['visible'] = $row['visible']; 
        }

        echo json_encode($data);
    }

 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = '';

        $data = array(
            ':libelle' => $_POST["libelle"],
            ':id' => $_POST['hidden_id'],
        );

        $object->query = "  SELECT
                                *
                            FROM
                                `commande_etat`
                            WHERE
                                libelle = :libelle AND id != :id
		";

        $object->execute($data);

        if ($object->row_count() > 0) {
            $error = '<div class="alert alert-danger">Etat déjà existe</div>';
        } else {
            $data = array(
                 ':libelle' => empty($object->clean_input($_POST["libelle"])) ? null : $object->clean_input($_POST["libelle"]),
                 ':color' => empty($object->clean_input($_POST["color"])) ? null : $object->clean_input($_POST["color"]),
                 ':visible' =>  $object->clean_input($_POST["visible"]),
                ':id' => $_POST['hidden_id'],

            );

            $object->query = "UPDATE commande_etat SET 
                                			libelle= :libelle ,
                                			color = :color,
                                			visible = :visible

                        			WHERE id = :id ";

            $object->execute($data);

            $success = 'Etat Modifié';
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
		UPDATE commande_etat
		SET statut = :status
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut etat changé à ' . $_POST['next_status'] . '';
    }
    
    
    if($_POST["action"] == 'update_order')
	{
	    for($i=0; $i<count($_POST["id_table"]); $i++)
        {
         $object->query = " UPDATE commande_etat 
            SET order_etat = '".$_POST["newpos"][$i]."' 
            WHERE id  = '".$_POST["id_table"][$i]."'";
        
         $object->execute();
        }
        
        echo json_encode('success');
	}
 
   
}
