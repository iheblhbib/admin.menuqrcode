<?php

include('../config.menuqrcode/config.php');

$object = new application();

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

    if ($_POST["action"] == 'fetch') {
        $order_column = array(   'name', ' num', 'email',  'pseudo', ' ' , 'statut');

        $output = array();

        $main_query = "  SELECT * FROM user WHERE statut = 'Activer'   and type = 'moderateur' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND ( name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR num LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR pseudo LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY id DESC ';
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

            $sub_array[] = empty($row["name"]) ? '--' :  ($row["name"]);
            
            $sub_array[] = (empty($row["num"]) ? '' : (number_format(str_replace(' ', '',$row["num"]), 0, ",", " ") )) ;
            
            $sub_array[] = empty($row["email"]) ? '--' :  ($row["email"]);

            $sub_array[] = empty($row["pseudo"]) ? '--' :  ($row["pseudo"]); 
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else { 
 
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 
    
                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
      
                $sub_array[] = ' <button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button> ';
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
        $order_column = array(   'name', ' num', 'email',  'pseudo', ' ' , 'statut');

        $output = array();

        $main_query = "  SELECT * FROM user WHERE statut != 'Activer'   and type = 'moderateur' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND ( name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR num LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR pseudo LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR statut LIKE "%' . $_POST["search"]["value"] . '%") ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY id DESC ';
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

            $sub_array[] = empty($row["name"]) ? '--' :  ($row["name"]);
            
            $sub_array[] = (empty($row["num"]) ? '' : (number_format(str_replace(' ', '',$row["num"]), 0, ",", " ") )) ;
            
            $sub_array[] = empty($row["email"]) ? '--' :  ($row["email"]);

            $sub_array[] = empty($row["pseudo"]) ? '--' :  ($row["pseudo"]); 
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            { 
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else { 
 
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 
    
                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
      
                $sub_array[] = ' <button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button> ';
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
			':pseudo'	=>	$_POST["pseudo"], 
		);

		$object->query = "
		SELECT * FROM user 
		WHERE pseudo = :pseudo  
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Pseudo déjà existe</div>';
		}
		else
		{ 
		    
            $data = array(
				':name'	            =>	$object->clean_input($_POST["name"]), 
				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),
				':password'	        =>	md5($object->clean_input($_POST["password"])),
				':user_profile'		=>	'../app.menuqrcode.tn/img/businessman.png',
				':type'		        =>	'moderateur', 
				':statut'		    =>	'Activer',  
			);
            
            $object->query = " INSERT INTO user  (name,   num, email, pseudo, password, user_profile, type, statut ) 
			                           VALUES (:name,:num, :email, :pseudo, :password, :user_profile, :type,   :statut )			";
		
			$object->execute($data); 
			
            if ($object->connect->lastInsertId() != 0) {
                $success = 'Moderateur Ajouté';
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
                                user
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) {
            $data['name'] = $row['name'];  
            $data['num'] = $row['num'];
            $data['email'] = $row['email'];
            $data['pseudo'] = $row['pseudo'];  
        }

        echo json_encode($data);
    }

 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = '';

        $data = array(
            ':pseudo' => $_POST["pseudo"],
            ':id' => $_POST['hidden_id'],
        );

        $object->query = "  SELECT
                                *
                            FROM
                                user
                            WHERE
                                pseudo = :pseudo AND id != :id
		";

        $object->execute($data);

        if ($object->row_count() > 0) {
            $error = '<div class="alert alert-danger">Pseudo déjà existe</div>';
        } else {
            
            if($_POST["password"])
            {
                $data = array(
    				':name'	            =>	$object->clean_input($_POST["name"]), 
    				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
    				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
    				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),
    				':password'	        =>	md5($object->clean_input($_POST["password"])),   
                    ':id' => $_POST['hidden_id'],
    
                );
    
                $object->query = "UPDATE user SET
                                    			name = :name, 
                                    			num = :num,
                                    			email = :email,
                                    			pseudo= :pseudo,
                                    			password = :password 
    
                            			WHERE id = :id ";
    			$object->execute($data);
                            			
            }else{
                $data = array(
    				':name'	            =>	$object->clean_input($_POST["name"]),  
    				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
    				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
    				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),    
                    ':id' => $_POST['hidden_id'],
    
                );
    
                $object->query = "UPDATE user SET
                                    			name = :name, 
                                    			num = :num,
                                    			email = :email,
                                    			pseudo= :pseudo 
    
                            			WHERE id = :id ";
                $object->execute($data);
            }
    

            $success = 'Moderateur Modifié';
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
            ':statut' => $_POST['next_statut'],
        );

        $object->query = "
		UPDATE user
		SET statut = :statut
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut Moderateur changé à ' . $_POST['next_statut'] . '';
    }

 
}
