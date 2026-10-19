<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'config/PHPMailer/src/PHPMailer.php';
    require 'config/PHPMailer/src/SMTP.php';
    
    
    $mail = new PHPMailer(true);
    
    include('/home5/qdwlxrcz/config.menuqrcode/config.php');

    
    $object = new application();
    
    $object->query="SELECT * FROM user WHERE type ='gestionnaire' AND echeance BETWEEN date(now()) and DATE_ADD(NOW(), INTERVAL 3 DAY) and lifetime = '1' and statut = 'Activer' ";
    
    $result = $object->get_result();  
    
    $today = date('Y-m-d');
    
    $d1 = new DateTime($today);
    
    $todayplus10 = date("Y-m-d", strtotime("+3 days", strtotime(date('Y-m-d'))));
   
    foreach($result as $row )
    {   
        $object->query = "SELECT market FROM market WHERE gestionnaire = '".$row['id']."' ";
        
        $result  = $object->get_result();
        
        $markets = '';
        
        foreach($result as $market)
        {
           $markets .= empty($markets)? '<b>'. $market['market'] .'</b>' : ',<b>'. $market['market'] .'</b>';
        }
  
        if($today <= $row['echeance'] && $row['echeance'] <= $todayplus10)
        {
            $d2 = new DateTime($row['echeance']);
            
            $interval = $d1->diff($d2);
            
            $diffInDays    = $interval->d;

            $subject = 'Rappelle d\'expiration Menu QR Code'; 
            
            if($diffInDays == 0 )
            {
                $dure = 'aujourd\'hui';
            }
            else if($diffInDays == 1)
            {
                $dure = 'dans '.$diffInDays.' Jour';
            }else
            {
                $dure = 'dans '.$diffInDays.' Jours';
            }
            
            // $sms = "Cher Client,\r\n";  
            // $sms .= "\r\n";  
            // $sms .= "Votre abonnement de Menu QR Code expire ".$dure." \r\n"; 
            // $sms .= "\r\n"; 
            // $sms .= "Menu QR Code Tunisie"; 
            
            // $object->send_SMS('56557032', $row["num"] ,$sms); 
          
            
            $message = 'Bonjour,'; 
            $message .= '<br><br>'; 
            
            $message .= "Le compte Menu QR Code de <b>".(ucwords($row['name'])).'</b> expire  <b>'.$dure.'</b>';
            $message .= '<br>';
            $message .=  'Point de Vente : '.$markets;
            $message .= '<br>';
            $message .= ('Téléphone : <b>').number_format($row['num'],'0',',',' ').'</b>';
            $message .= '<br>';
            $message .= '<br>';
            $message .= 'Cordialement,<br>';
            $message .= 'Menu QR Code';
            
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.menuqrcode.tn';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'no-reply@menuqrcode.tn';                     //SMTP username
                $mail->Password   = 'jf@-}iHpT7[d';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('no-reply@menuqrcode.tn', 'Menu QR Code');
                
                $object->query="SELECT * FROM user where statut = 'Activer'  and email is not null  and type != 'gestionnaire' and type != 'employee'  ";
                
                $result = $object->get_result();
                
                foreach($result as $item){
                    $mail->addAddress($item['email'],$item['name']);  
                } 
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Rappelle d\'expiration Menu QR Code';
                $mail->Body    = utf8_decode($message);
            
                $mail->send();
                    echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } 
        
    }
