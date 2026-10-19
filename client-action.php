<?php

include('../config.menuqrcode/config.php');

$object = new application();

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

    if ($_POST["action"] == 'fetch') {
        $order_column = array('pro','societe',  'name', ' num', 'email',  'pseudo', 'echeance', ' ' , 'statut');

        $output = array();

        $main_query = "  SELECT * FROM user WHERE statut = 'Activer'   and type = 'gestionnaire' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (societe LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR num LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR pseudo LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR echeance LIKE "%' . $_POST["search"]["value"] . '%" '; 
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
            
            $verified = ($row['verified'] == 'oui') ? ' <i class="fa-solid text-primary fa-badge-check"></i>' : '';

            $sub_array[] = ($row["pro"] != '0') ? '<i class="bi bi-building"></i>' : '<i class="bi bi-people"></i>';

            $sub_array[] = empty($row["societe"]) ? '--' :  ($row["societe"]);

            $sub_array[] = empty($row["name"]) ? '--' :  ($row["name"]);
            
            $sub_array[] = (empty($row["num"]) ? '' : (number_format(str_replace(' ', '',$row["num"]), 0, ",", " ") )).$verified ;
            
            $sub_array[] = empty($row["email"]) ? '--' :  ($row["email"]);

            $sub_array[] = empty($row["pseudo"]) ? '--' :  ($row["pseudo"]);
            
            $sub_array[] = ($row['lifetime'] == '2' ) ? 'à vie' : (empty($row["echeance"]) ? '--' :  date('d-m-Y',strtotime($row["echeance"])));
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            {
                $sub_array[] = '--';
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {
                
                $sub_array[] =  '<button style="font-size:x-small"  class="btn btn-primary btn-sm login" name="login" data-id="'.$row['id'].'"'.securite_attributs_connexion($row['id']).'><i class="fad fa-sign-in"></i></button>';
                
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 
    
                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
     

                $sub_array[] = '
                    <button style="font-size:x-small"  class="btn btn-info btn-sm archive_button" name="archive_button" data-id="'.$row['id'].'"><i class="fad fa-eye"></i></button>
                    <button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>
                ';
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
        $order_column = array('pro','societe',  'name', ' num', 'email',  'pseudo', 'echeance', ' ' , 'statut');

        $output = array();

        $main_query = "  SELECT * FROM user WHERE statut != 'Activer' and type = 'gestionnaire' ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (societe LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR num LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR pseudo LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR echeance LIKE "%' . $_POST["search"]["value"] . '%" '; 
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

            $sub_array[] = ($row["pro"] != '0') ? '<i class="bi bi-building"></i>' : '<i class="bi bi-people"></i>';

            $sub_array[] = empty($row["societe"]) ? '--' :  ($row["societe"]);

            $sub_array[] = empty($row["name"]) ? '--' :  ($row["name"]);
            
            $sub_array[] = (empty($row["num"]) ? '' : (number_format(str_replace(' ', '',$row["num"]), 0, ",", " ") )) ;
            
            $sub_array[] = empty($row["email"]) ? '--' :  ($row["email"]);

            $sub_array[] = empty($row["pseudo"]) ? '--' :  ($row["pseudo"]);
            
            $sub_array[] = empty($row["echeance"]) ? '--' :  date('d-m-Y',strtotime($row["echeance"]));
           
            if ($object->autorisation('u', $_SESSION['id'], $page_actuel) != 0) 
            {
                $sub_array[] = '--';
                
                $sub_array[] = '--';
                
                $sub_array[] = '--';

            } else {
                
                $sub_array[] = ' <i class="fad fa-sign-in login" data-id="'.$row['id'].'"'.securite_attributs_connexion($row['id']).'></i>'; 
 
                $statut = ($row["statut"] == 'Activer') ? 'success' : 'danger'; 
    
                $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $statut . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' .$row["statut"]. '</button>';
     

                $sub_array[] = '
                    <button style="font-size:x-small"  class="btn btn-info btn-sm archive_button" name="archive_button" data-id="'.$row['id'].'"><i class="fad fa-eye"></i></button>
                    <button style="font-size:x-small" type="button" name="edit_button" class=" btn btn-circle btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>
                ';
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
			':pro'	=>	$_POST["pro"],
		);

		$object->query = "
		SELECT * FROM user 
		WHERE pseudo = :pseudo and pro = :pro
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
				':societe'	        =>	($_POST["societe"]) ? $object->clean_input($_POST["societe"]) : null,
				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
				':num_mobile'       => ($_POST["num_mobile"]) ? $object->clean_input($_POST["num_mobile"]) : null,
				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),
				':password'	        =>	md5($object->clean_input($_POST["password"])),
				':user_profile'		=>	'img/man.png',
				':type'		        =>	'gestionnaire',
				':pack'	        	=>	($_POST["pack"]) ? $object->clean_input($_POST["pack"]) : null,
				':montant'	       	=>	'0',
				':echeance'	       	=>	$object->clean_input($_POST["echeance"]),
				':statut'		    =>	'Activer',
				':etat'		        =>	'Paye', 
				':pro'			    =>	($_POST["pro"] == 'part') ? '0' : '1',
				':lifetime'	        =>	$object->clean_input($_POST["lifetime"]),
			);
            
            $object->query = " INSERT INTO user  (name, societe, num, num_mobile, email, pseudo, password, user_profile, type, pack, montant, echeance, statut,  etat, pro, lifetime) 
			                           VALUES (:name  , :societe, :num, :num_mobile,  :email, :pseudo, :password, :user_profile, :type, :pack, :montant, :echeance, :statut,  :etat, :pro, :lifetime)			";
		
			$object->execute($data); 
			
            if ($object->connect->lastInsertId() > 0) {
                $success = 'Client Ajouté';
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
            $data['societe'] = $row['societe'];
            $data['num'] = $row['num'];
            $data['num_mobile'] = $row['num_mobile'];
            $data['email'] = $row['email'];
            $data['pseudo'] = $row['pseudo'];
            $data['echeance'] = $row['echeance'];
            $data['lifetime'] = $row['lifetime'];
            $data['pack'] = $row['pack'];
            $data['pro'] = ($row["pro"] == '0') ? 'part' : 'pro';

        }

        echo json_encode($data);
    }

    if ($_POST["action"] == 'login') {
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
            $data['pseudo'] = $row['pseudo'];
            $data['password'] = $row['password'];  
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
    				':societe'	        =>	($_POST["societe"]) ? $object->clean_input($_POST["societe"]) : null,
    				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
    				':num_mobile'       => ($_POST["num_mobile"]) ? $object->clean_input($_POST["num_mobile"]) : null,
    				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
    				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),
    				':password'	        =>	md5($object->clean_input($_POST["password"])),  
    				':echeance'	       	=>	$object->clean_input($_POST["echeance"]), 
    				':pro'			    =>	($_POST["pro"] == 'part') ? '0' : '1',
    				':pack'             => ($_POST["pack"]) ? $object->clean_input($_POST["pack"]) : null,
    				':lifetime'	        =>	$object->clean_input($_POST["lifetime"]),
                    ':id'               => $_POST['hidden_id'],
    
                );
    
                $object->query = "UPDATE user SET
                                    			name = :name,
                                    			societe = :societe,
                                    			num = :num,
                                    			num_mobile = :num_mobile,
                                    			email = :email,
                                    			pseudo= :pseudo,
                                    			password = :password,
                                    			echeance = :echeance, 
                                    			pro = :pro ,
                                    			pack = :pack ,
                                    			lifetime = :lifetime 
    
                            			WHERE id = :id ";
    			$object->execute($data);
                            			
            }else{
                $data = array(
    				':name'	            =>	$object->clean_input($_POST["name"]),
    				':societe'	        =>	($_POST["societe"]) ? $object->clean_input($_POST["societe"]) : null,
    				':num'              => ($_POST["num"]) ? $object->clean_input($_POST["num"]) : null,
    				':num_mobile'       => ($_POST["num_mobile"]) ? $object->clean_input($_POST["num_mobile"]) : null,
    				':email'            => ($_POST["email"]) ? $object->clean_input($_POST["email"]) : null,
    				':pseudo'			=>	$object->clean_input($_POST["pseudo"]),  
    				':echeance'	       	=>	$object->clean_input($_POST["echeance"]), 
    				':pro'			    =>	($_POST["pro"] == 'part') ? '0' : '1', 
    				':pack'             => ($_POST["pack"]) ? $object->clean_input($_POST["pack"]) : null,
    				':lifetime'	       	=>	$object->clean_input($_POST["lifetime"]), 
                    ':id'               => $_POST['hidden_id'],
    
                );
    
                $object->query = "UPDATE user SET
                                    			name = :name,
                                    			societe = :societe,
                                    			num = :num,
                                    			num_mobile = :num_mobile,
                                    			email = :email,
                                    			pseudo= :pseudo, 
                                    			echeance = :echeance, 
                                    			pro = :pro ,
                                    			pack = :pack ,
                                    			lifetime = :lifetime 
    
                            			WHERE id = :id ";
                $object->execute($data);
            }
    

            $success = 'Client Modifié';
        }

        $output = array(
            'error' => $error,
            'success' => $success,
            'id' => $_POST['hidden_id'],
        );

        echo json_encode($output);

    }

	if($_POST["action"] == 'archive')
	{
		$object->query = "
		SELECT p.*, pk.libelle , pk.duree  FROM paiement p LEFT JOIN pack pk ON pk.id = p.pack
		WHERE p.client = '".$_POST["id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{ 
		    $sub_array = array();
			$sub_array['date'] = date('d-m-Y',strtotime($row["date"])); 
			$sub_array['libelle'] = $row['libelle'];
			$sub_array['duree'] = $row['duree']; 
			$sub_array['montant'] = $row['montant'].' TND';   
			$sub_array['remise'] =  ($row['type'] == '1' ) ?   ($row["Remise"].'%') : $row['remise'].' TND';   
			$data[] = $sub_array;
		} 

		echo json_encode($data);
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

        echo 'Statut Client changé à ' . $_POST['next_statut'] . '';
    }

 
}
