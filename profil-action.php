<?php 

include('../config.menuqrcode/config.php'); 
    
    $object = new application(); 

include_once(__DIR__ . '/securite.php');
securite_exiger_admin($object);

    if(isset($_POST["action_profil"]))
    {
        if($_POST['action_profil'] == 'update')
        {
            $error = '';
    
    		$success = ''; 
    		
    		$data = array(
               
                ':name'	        =>	$object->clean_input($_POST["name_profil"]),
                ':num'          =>	empty($object->clean_input($_POST["num_profil"])) ? null : $object->clean_input($_POST["num_profil"]) ,
                ':email'	    =>	empty($object->clean_input($_POST["email_profil"])) ? null : $object->clean_input($_POST["email_profil"]) , 
                ':id'	        =>	$_SESSION["id"] ,
               
    		);
    
    		$object->query = "
    		    UPDATE
                    user
                SET
                    name = :name,
                    num = :num,
                    email = :email 
                WHERE id = :id
                    ";
    		
            $object->execute($data);
 
    		$success = 'Mis à jour avec succés';
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success 
    		);
    
    		echo json_encode($output);
        }
    }
    
    if(isset($_POST["action_password"]))
    {
        if($_POST['action_password'] == 'update')
        {
            $error = '';
    
    		$success = '';
    
    		$data = array(
                ':password'     =>	md5($object->clean_input($_POST["password_profil"])),
                ':id'	        =>	$_SESSION["id"] ,
               
    		);
    
    		$object->query = "
    		    UPDATE
                    user
                SET
                    password = :password
                WHERE id = :id
                    ";
    		
            $object->execute($data);
 
    		$success = 'Mot de passe changé';
    
    		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
        }
    } 