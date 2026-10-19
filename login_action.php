<?php

//login_action.php

include('../config.menuqrcode/config.php');

$object = new application();

if(isset($_POST["pseudo"]))
{
	$error = '';
	$success = '';
	$data = array(
		':pseudo'	=>	$_POST["pseudo"]
	);

	$object->query = "
		SELECT * FROM user
		WHERE pseudo = :pseudo AND type in ('SuperAdmin','moderateur') ";
	
// 	die($object->query);

	$object->execute($data);

	$total_row = $object->row_count();

	if($total_row == 0)
	{
		$error = 'Login incorrecte';
	}
	else
	{
// 		$result = $statement->fetchAll();

		$result = $object->statement_result();

		foreach($result as $row)
		{
			if($row["statut"] == 'Activer')
			{
				if(md5($_POST["password"]) == $row["password"])
				{
		
					$_SESSION['id'] = $row['id']; 
    
                    setcookie("id" , $object->encrypt($_SESSION['id']) , time() + (86400 * 10) );
                    $success = 'Bienvenue';
                    
                    $data = array(
                        ':user'         => $row['id'],
                        ':ip'           => $object->getIPAddress(), 
                        ':browser'      => $object->getBrowser(), 
                    );
                    
            		$object->query = "INSERT INTO login (user, ip ,browser) VALUES (:user, :ip ,:browser) ";
			        $object->execute($data);
            
				}
				else
				{
					$error = 'Mot de Passe incorrecte';
				}
			}
			else
			{
				$error = 'Compte désactivé, contactez admin';
			}
		}

	}

	$output = array(
		'error'		=>	$error,
		'success'	=>	$success
	);

	echo json_encode($output);
}
?>