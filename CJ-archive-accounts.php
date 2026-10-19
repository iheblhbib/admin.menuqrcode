<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'config/PHPMailer/src/PHPMailer.php';
    require 'config/PHPMailer/src/SMTP.php';
     
    $mail = new PHPMailer(true);
    
    include('/home5/qdwlxrcz/config.menuqrcode/config.php');

    
    $object = new application();
    
    $object->query=" SELECT * FROM user WHERE type ='gestionnaire' AND echeance  < CURRENT_DATE()   and lifetime = '1' and statut = 'Activer' ";
    
    $result = $object->get_result();  
    
    $today = date('Y-m-d');
    
    $d1 = new DateTime($today); 
   
    foreach($result as $row )
    {
        if($row['echeance'] < date('Y-m-d'))
        {
             $object->query="UPDATE user  SET
                             statut = 'Desactiver' 
                            WHERE  id = '".$row['id']."'
                            ";
            $object->execute();
            
            $object->query="UPDATE market  SET
                             statut = 'Desactiver' 
                            WHERE  gestionnaire = '".$row['id']."'
                            ";
            $object->execute(); 
            
 $sms = "Cher client,

Votre abonnement menu QR code a expiré, et votre compte est désactivé. Veuillez renouveler dès maintenant pour continuer à profiter de nos services.
 
L'équipe Menu QR Code Tunisie.";
            
            $object->send_SMS('56557032',$row['num'],$sms);
            
        }
    }
