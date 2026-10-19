<?php

    include 'config/config.php';
    
    $object = new erpXulPrint();

    if(isset($_POST["action"]))
    {
        if($_POST['action'] == 'entreprise')
        {

            $error = '';
    
    		$success = '';
    		
    		$logo = $_POST['hidden_logo'];
        	if($_FILES["logo"]["name"] != '')
        	{
        		$logo = upload_image();
        	}
    
    		$data = array(
               
                ':entreprise'	    =>	empty($object->clean_input($_POST["entreprise"])) ? null : $object->clean_input($_POST["entreprise"]) ,
                ':matriculefiscal'  =>	empty($object->clean_input($_POST["matriculefiscal"])) ? null : $object->clean_input($_POST["matriculefiscal"]) ,
                ':siteweb'	    	=>	empty($object->clean_input($_POST["siteweb"])) ? null : $object->clean_input($_POST["siteweb"]) ,
                ':email'	    	=>	empty($object->clean_input($_POST["email"])) ? null : $object->clean_input($_POST["email"]) ,
                ':adresse'	    	=>	empty($object->clean_input($_POST["adresse"])) ? null : $object->clean_input($_POST["adresse"]) ,
                ':logo'             =>  $logo , 
                ':prix_heure_supp'  =>	empty($object->clean_input($_POST["prix_heure_supp"])) ? null : $object->clean_input($_POST["prix_heure_supp"]) ,
                ':nb_conge'	    	=>	empty($object->clean_input($_POST["nb_conge"])) ? null : $object->clean_input($_POST["nb_conge"]) ,
                ':nb_heure'	    	=>	empty($object->clean_input($_POST["nb_heure"])) ? null : $object->clean_input($_POST["nb_heure"]) ,
                ':prime_assiduite'  =>	empty($object->clean_input($_POST["prime_assiduite"])) ? null : $object->clean_input($_POST["prime_assiduite"]) ,
                ':smtp_email'       =>	empty($object->clean_input($_POST["smtp_email"])) ? null : $object->clean_input($_POST["smtp_email"]) ,
                ':smtp_password'    =>	empty($object->clean_input($_POST["smtp_password"])) ? null : $object->clean_input($_POST["smtp_password"]) ,
                ':smtp_serveur'     =>	empty($object->clean_input($_POST["smtp_serveur"])) ? null : $object->clean_input($_POST["smtp_serveur"]) ,
                ':smtp_port'        =>	empty($object->clean_input($_POST["smtp_port"])) ? null : $object->clean_input($_POST["smtp_port"]) ,
                ':entree'           =>	($object->clean_input($_POST["entree"]) == 'on') ? '2' : '1' ,
                ':temps_entree'     =>	($object->clean_input($_POST["entree"]) != 'on') ? null : $object->clean_input($_POST["temps_entree"]) ,
                ':entree_size'      =>	($object->clean_input($_POST["entree"]) != 'on') ? null : $object->clean_input($_POST["entree_size"]) , 
                ':sortie'           =>	($object->clean_input($_POST["sortie"]) == 'on') ? '2' : '1' ,
                ':temps_sortie'     =>	($object->clean_input($_POST["sortie"]) != 'on') ? null : $object->clean_input($_POST["temps_sortie"]) ,
                ':sortie_size'      =>	($object->clean_input($_POST["sortie"]) != 'on') ? null : $object->clean_input($_POST["sortie_size"]) , 
                ':jourferie_type'   =>	empty($object->clean_input($_POST["jourferie_type"])) ? null : $object->clean_input($_POST["jourferie_type"]) ,
                ':jourferie_value'  =>	empty($object->clean_input($_POST["jourferie_value"])) ? null : $object->clean_input($_POST["jourferie_value"]) ,
                ':prime'            =>  ($object->clean_input($_POST["prime_entreprise"]) == 'on') ? '2' : '1' ,
                ':start_pause'      =>	empty($object->clean_input($_POST["start_pause"])) ? null : $object->clean_input($_POST["start_pause"]) ,
    		);
    
    		$object->query = "
                UPDATE
                    entreprise
                SET
                    entreprise = :entreprise,
                    matriculefiscal = :matriculefiscal,
                    siteweb = :siteweb,
                    email = :email,
                    adresse = :adresse,
                    logo = :logo,
                    prix_heure_supp = :prix_heure_supp,
                    nb_conge = :nb_conge,
                    nb_heure = :nb_heure,
                    prime_assiduite = :prime_assiduite,
                    smtp_email = :smtp_email,
                    smtp_password = :smtp_password,
                    smtp_serveur = :smtp_serveur,
                    smtp_port = :smtp_port,
                    entree = :entree,
                    temps_entree = :temps_entree,
                    entree_size = :entree_size,
                    sortie = :sortie,
                    temps_sortie = :temps_sortie,
                    sortie_size = :sortie_size ,
                    jourferie_type = :jourferie_type ,
                    jourferie_value = :jourferie_value ,
                    prime = :prime ,
                    start_pause = :start_pause 
                WHERE id = 1
                    ";
    		
            $object->execute($data);

            
            $object->query = "
        		SELECT * FROM telephone
        		WHERE entreprise = 1
        		
    		";
    
    		$object->execute();
    
    		if($object->row_count() > 0)
    		{
	    		$data = array(
                    ':telephone'	    =>	empty($object->clean_input($_POST["telephone"])) ? null : $object->clean_input($_POST["telephone"]) ,
                    ':mobile'	    	=>	empty($object->clean_input($_POST["mobile"])) ? null : $object->clean_input($_POST["mobile"]) ,
                    ':fax'	    	    =>	empty($object->clean_input($_POST["fax"])) ? null : $object->clean_input($_POST["fax"])  ,
           
        		);
    
        		$object->query = "
                    UPDATE
                        telephone
                    SET
                        telephone = :telephone,
                        mobile = :mobile,
                        fax = :fax 
                        
                    WHERE entreprise = 1
                        ";
        		
                $object->execute($data);
    		}
    		else
    		{
    		    $data = array(
                    ':user'	            =>	$_POST["user"],
                    ':telephone'	    =>	empty($object->clean_input($_POST["telephone"])) ? null : $object->clean_input($_POST["telephone"]) ,
                    ':mobile'	    	=>	empty($object->clean_input($_POST["mobile"])) ? null : $object->clean_input($_POST["mobile"]) ,
                    ':fax'	    	    =>	empty($object->clean_input($_POST["fax"])) ? null : $object->clean_input($_POST["fax"])  
                     
        		);
    
        		$object->query = "
                		INSERT INTO telephone
                		    (
                                entreprise,
                                telephone,
                                mobile,
                                fax
                            )
                            VALUES(
                                :user,
                                :telephone,
                                :mobile,
                                :fax
                            )
                        ";
        		
                $object->execute($data);
    	    }	
    
    		$success = 'Mis à jour avec succés';
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success,
    			'logo'      => $logo
    		);
    
    		echo json_encode($output);
    	    
    	   
    		
        }
    }


function upload_image()
{
	if(isset($_FILES["logo"]))
	{
		$extension = explode('.', $_FILES['logo']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = 'img/' . $new_name;
		move_uploaded_file($_FILES['logo']['tmp_name'], $destination);
		return $destination;
	}
}


?>