<?php

include('../config.menuqrcode/config.php');

include "config/phpqrcode/qrlib.php"; 

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = '../app.menuqrcode.tn/archive_qrcode/';

//html PNG location prefix
$PNG_WEB_DIR = '../app.menuqrcode.tn/archive_qrcode/';

if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
    

$object = new application();

$page_actuel = $object->get_page_url();

if (isset($_POST["action"])) {   

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('m.id','m.id','m.market','u.name','m.address','m.id','m.id','m.niveau','m.statut','m.id','m.id',);

		$output = array();
		
		$plus = '';
		
		$main_query = " SELECT 
		                        m.*,
		                        u.name
		                  FROM 
		                     market m
		                     LEFT JOIN user u ON u.id = m.gestionnaire
		                  WHERE 
		                         
		                        m.gestionnaire in ( 
        		                                    SELECT 
        		                                        id  
        	                                        FROM 
        	                                            user 
            		                                WHERE 
            		                                    type = 'gestionnaire'  and 
            		                                    
            		                                    statut = 'Activer'
    		                                    ) and m.statut = 'Activer'  ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND (u.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.market LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.address LIKE "%'.$_POST["search"]["value"].'%" '; 
			$search_query .= 'OR m.niveau LIKE "%'.$_POST["search"]["value"].'%"  )';
		}

        $order_query = '';
        
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY m.id DESC ';
		}

		
		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query; 

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{ 
			$row['logo'] = str_replace('../','https://',$row['logo']);
			
			$row['background'] = str_replace('../','https://',$row['background']);
			
			$row['qrcode'] = str_replace('../','https://',$row['qrcode']);
			
			$etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';
 
            $sub_array = array();
            
            
            
            $sub_array[] = '<a href="'.$row["logo"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["logo"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			
			$sub_array[] = $object->clean_input($row["market"]);
			
			$sub_array[] = $object->clean_input($row["name"]); 
			
			$sub_array[] = $object->clean_input($row["address"]);  
			
			$sub_array[] = '<a title="Menu" target="_blank" style="font-size: x-large;" href="https://menuqrcode.tn/qrcode?data='.($object->encrypt($row["id"])).'"><i class="fal fa-link"></i></a>'; 
			
			$sub_array[] = '<a title="Menu" class=" menu-link" style="font-size: x-large;" data-link="https://menuqrcode.tn/qrcode?data='.($object->encrypt($row["id"])).'"><i class="fal fa-bars"></i></a>'; 
			
			$sub_array[] = empty($row['qrcode']) ? '' : '<a href="'.$row["qrcode"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["qrcode"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			
			
            
            $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' . $row["statut"] . '</button>';
            
            $sub_array[] = '<button style="font-size:x-small"  class=" btn  btn-primary btn-sm login" data-id="'.$row['id'].'" data-gestionnaire="'.$row['gestionnaire'].'"><i class="fad fa-sign-in"></i></button>';

            $langues = ($row['multi_langue'] == '1') ? '<button style="font-size:x-small" type="button" name="language_button" class="btn  btn-sm   btn-primary  language_button" data-id="'.$row["id"].'"><i class="fad fa-language"></i></button>' : '' ;
            
            $sub_array[] = $langues.'<button style="font-size:x-small" type="button" name="edit_button" class=" btn  btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
			
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_disabled')
	{
		$order_column = array('m.id','m.id','m.market','u.name','m.address','m.id','m.id','m.niveau','m.statut','m.id','m.id',);

		$output = array();
		
		$plus = '';
		
		$main_query = " SELECT 
		                        m.*,
		                        u.name
		                  FROM 
		                     market m
		                     LEFT JOIN user u ON u.id = m.gestionnaire
		                  WHERE 
		                      m.statut != 'Activer'
    		                                      ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND (u.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.market LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.address LIKE "%'.$_POST["search"]["value"].'%" '; 
			$search_query .= 'OR m.niveau LIKE "%'.$_POST["search"]["value"].'%"  )';
		}

        $order_query = '';
        
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY m.id DESC ';
		}

		
		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query; 

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
		     
			$row['background'] = str_replace('../','https://',$row['background']);
			$row['logo'] = str_replace('../','https://',$row['logo']);
			
			$row['qrcode'] = str_replace('../','https://',$row['qrcode']);
			
			$etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';
 
            $sub_array = array();
            
            
            $sub_array[] = '<a href="'.$row["logo"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["logo"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			$sub_array[] = $object->clean_input($row["market"]);
			$sub_array[] = $object->clean_input($row["name"]); 
			$sub_array[] = $object->clean_input($row["address"]);  
			$sub_array[] = '<a title="Menu" class=" btn  btn-sm   btn-light" target="_blank" href="'.$object->get_url_menu_selected($row["id"])."?data=".($object->encrypt($row["id"])).'"><i class="fal fa-link"></i></a>'; 
			$sub_array[] = empty($row['qrcode']) ? '' :  '<a href="'.$row["qrcode"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["qrcode"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			
            $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' . $row["statut"] . '</button>';
            $sub_array[] = '<button style="font-size:x-small"  class=" btn  btn-primary btn-sm login" data-id="'.$row['id'].'" data-gestionnaire="'.$row['gestionnaire'].'"><i class="fad fa-sign-in"></i></button>';

            $langues = ($row['multi_langue'] == '1') ? '<button style="font-size:x-small" type="button" name="language_button" class="btn  btn-sm   btn-primary  language_button" data-id="'.$row["id"].'"><i class="fad fa-language"></i></button>' : '' ;
            $sub_array[] = $langues.'<button style="font-size:x-small" type="button" name="edit_button" class=" btn  btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
			
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_archive')
	{
		$order_column = array('');

		$output = array();
		
		$plus = '';
		
		$main_query = " SELECT 
		                        m.*,
		                        u.name
		                  FROM 
		                     market m
		                     LEFT JOIN user u ON u.id = m.gestionnaire
		                  WHERE 
		                         
		                        m.gestionnaire in ( 
        		                                    SELECT 
        		                                        id  
        	                                        FROM 
        	                                            user 
            		                                WHERE 
            		                                    type = 'gestionnaire'  and 
            		                                    
            		                                    statut != 'Activer'
    		                                    ) ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND (u.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.market LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.address LIKE "%'.$_POST["search"]["value"].'%" '; 
			$search_query .= 'OR m.niveau LIKE "%'.$_POST["search"]["value"].'%"  )';
		}

        $order_query = '';
        
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY m.id DESC ';
		}

		
		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query; 

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
		     
			$row['background'] = str_replace('../','https://',$row['background']);
			$row['logo'] = str_replace('../','https://',$row['logo']);
			
			$row['qrcode'] = str_replace('../','https://',$row['qrcode']);
			
			$etat = ($row["statut"] == 'Activer') ? 'success' : 'danger';
 
            $sub_array = array();
            
            
            $sub_array[] = '<a href="'.$row["logo"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["logo"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			$sub_array[] = $object->clean_input($row["market"]);
			$sub_array[] = $object->clean_input($row["name"]); 
			$sub_array[] = $object->clean_input($row["address"]);  
			$sub_array[] = '<a title="Menu" class=" btn  btn-sm   btn-light" target="_blank" href="'.$object->get_url_menu_selected($row["id"])."?data=".($object->encrypt($row["id"])).'"><i class="fal fa-link"></i></a>'; 
			$sub_array[] = empty($row['qrcode']) ? '' :  '<a href="'.$row["qrcode"].'" class="glightbox" data-glightbox="title: '.$row['market'].';"  ><img src="'.$row["qrcode"].'" alt="image" class="img-fluid img-thumbnail" width="75" height="75"></a>';
			
            $sub_array[] = '<button style="font-size:x-small" type="button" name="statut_button" class="  btn btn-' . $etat . '  btn-sm statut_button"  data-id="' . $row["id"] . '"data-statut="' . $row["statut"] . '">' . $row["statut"] . '</button>';
            $sub_array[] = '<button style="font-size:x-small"  class=" btn  btn-primary btn-sm login" data-id="'.$row['id'].'" data-gestionnaire="'.$row['gestionnaire'].'"><i class="fad fa-sign-in"></i></button>';

            $langues = ($row['multi_langue'] == '1') ? '<button style="font-size:x-small" type="button" name="language_button" class="btn  btn-sm   btn-primary  language_button" data-id="'.$row["id"].'"><i class="fad fa-language"></i></button>' : '' ;
            $sub_array[] = $langues.'<button style="font-size:x-small" type="button" name="edit_button" class=" btn  btn-warning btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fad fa-edit"></i></button>';
			
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}
	  
    if ($_POST["action"] == 'Add') {
        $error = '';

        $success = '';
 
		$logo = '';
		if($_FILES["logo"]["name"] != '')
		{
			$logo = upload_logo();
		}
		else
		{
			$logo = '../app.menuqrcode.tn/img/no-photo.webp';
		}

		$background = '';
		if($_FILES["background"]["name"] != '')
		{
			$background = upload_background();
		}
		else
		{
			$background =  '../app.menuqrcode.tn/img/904258097.webp';
		}
		
        $data = array(
            ':gestionnaire'         =>	$object->clean_input($_POST["gestionnaire"]),
            ':market'               =>	$object->clean_input($_POST["market"]),
            ':multi_langue'         =>  ($object->clean_input($_POST["multi_langue"])) ,            
            ':logo'                 =>  $logo,
            ':address'              =>	($object->clean_input($_POST["address"])) ? $object->clean_input($_POST["address"]) : null,
            ':description'          =>	($object->clean_input($_POST["description"])) ? $object->clean_input($_POST["description"]) : null,
            ':facebook'             =>	($object->clean_input($_POST["facebook"])) ? $object->clean_input($_POST["facebook"]) : null,
            ':instagram'            =>	($object->clean_input($_POST["instagram"])) ? $object->clean_input($_POST["instagram"]) : null,
            ':tiktok'               =>	($object->clean_input($_POST["tiktok"])) ? $object->clean_input($_POST["tiktok"]) : null,
            ':youtube'              =>	($object->clean_input($_POST["youtube"])) ? $object->clean_input($_POST["youtube"]) : null,
            ':twitter'              =>	($object->clean_input($_POST["twitter"])) ? $object->clean_input($_POST["twitter"]) : null,
            ':whatsapp'             =>	($object->clean_input($_POST["whatsapp"])) ? $object->clean_input($_POST["whatsapp"]) : null, 
            ':tripadvisor'          =>	($object->clean_input($_POST["tripadvisor"])) ? $object->clean_input($_POST["tripadvisor"]) : null, 
            ':google'               =>	($object->clean_input($_POST["google"])) ? $object->clean_input($_POST["google"]) : null, 
            ':theme'                =>	$object->clean_input($_POST["theme"]), 
            ':niveau'               =>  $object->clean_input($_POST["niveau"]),
            ':pro'                  =>  ($object->clean_input($_POST["pro"])) ,            
            ':apercu'               =>  ($object->clean_input($_POST["apercu"])) ,            
            ':tel'                  =>  ($object->clean_input($_POST["tel"])) ? $object->clean_input($_POST["tel"]) : null,
            ':email'                =>  ($object->clean_input($_POST["email"])) ? $object->clean_input($_POST["email"]) : null,
            ':siteweb'                =>  ($object->clean_input($_POST["siteweb"])) ? $object->clean_input($_POST["siteweb"]) : null,
            ':background'           =>  $background,
            ':background_color0'    =>  ($object->clean_input($_POST["background_color0"])) ? $object->clean_input($_POST["background_color0"]) : '#cda45e',  
            ':background_color1'    =>  ($object->clean_input($_POST["background_color1"])) ? $object->clean_input($_POST["background_color1"]) : '#cda45e',  
            ':background_color2'    =>  ($object->clean_input($_POST["background_color2"])) ? $object->clean_input($_POST["background_color2"]) : '#cda45e', 
            ':background_color3'    =>  ($object->clean_input($_POST["background_color3"])) ? $object->clean_input($_POST["background_color3"]) : '#cda45e', 
            ':background_color4'    =>  ($object->clean_input($_POST["background_color4"])) ? $object->clean_input($_POST["background_color4"]) : '#cda45e', 
            ':text_color0'          =>  ($object->clean_input($_POST["text_color0"])) ? $object->clean_input($_POST["text_color0"]) : '#000000',
            ':text_color1'          =>  ($object->clean_input($_POST["text_color1"])) ? $object->clean_input($_POST["text_color1"]) : '#000000',
            ':text_color2'          =>  ($object->clean_input($_POST["text_color2"])) ? $object->clean_input($_POST["text_color2"]) : '#000000', 
            ':text_color3'          =>  ($object->clean_input($_POST["text_color3"])) ? $object->clean_input($_POST["text_color3"]) : '#000000', 
            ':text_color4'          =>  ($object->clean_input($_POST["text_color4"])) ? $object->clean_input($_POST["text_color4"]) : '#000000', 
            ':wifi'                 =>  ($object->clean_input($_POST["wifi"])) ,            
            ':wifi_ssid'            =>  ($object->clean_input($_POST["wifi_ssid"])) ? $object->clean_input($_POST["wifi_ssid"]) : null,       
            ':wifi_password'        =>  ($object->clean_input($_POST["wifi_password"])) ? $object->clean_input($_POST["wifi_password"]) : null,                   
            ':feedback'             =>  ($object->clean_input($_POST["feedback"])) ,            
            ':event'                =>  ($object->clean_input($_POST["event"])) ,            
            ':design_qrcode'        =>  ($object->clean_input($_POST["design_qrcode"])) ,               
            ':ingredient'           =>  ($object->clean_input($_POST["ingredient"])) ,            
            ':commande'             =>  ($object->clean_input($_POST["commande"])) ,            
            ':utilisateur'          =>  ($object->clean_input($_POST["utilisateur"])) ,            
            ':vip'                  =>  ($object->clean_input($_POST["vip"])) ,            
            ':varie'                =>  ($object->clean_input($_POST["varie"])) ,            
		);
        
        $object->query = " INSERT INTO market(
                                    gestionnaire,
                                    market,
                                    multi_langue,
                                    logo,
                                    address,
                                    description,
                                    facebook,
                                    instagram,
                                    tiktok,
                                    youtube,
                                    twitter,
                                    whatsapp,
                                    tripadvisor,
                                    google,
                                    theme,
                                    niveau,
                                    pro,
                                    apercu,
                                    tel,
                                    email,
                                    siteweb,
                                    background,
                                    background_color0,
                                    background_color1,
                                    background_color2,
                                    background_color3,
                                    background_color4,
                                    text_color0,
                                    text_color1,
                                    text_color2,
                                    text_color3,
                                    text_color4,
                                    wifi,
                                    wifi_ssid,
                                    wifi_password,
                                    feedback,
                                    event,
                                    design_qrcode,
                                    ingredient,
                                    commande,
                                    utilisateur,
                                    vip,
                                    varie
                                )
                                VALUES(
                                    :gestionnaire,
                                    :market,
                                    :multi_langue,
                                    :logo,
                                    :address,
                                    :description,
                                    :facebook,
                                    :instagram,
                                    :tiktok,
                                    :youtube,
                                    :twitter,
                                    :whatsapp,
                                    :tripadvisor,
                                    :google,
                                    :theme,
                                    :niveau,
                                    :pro,
                                    :apercu,
                                    :tel,
                                    :email,
                                    :siteweb,
                                    :background,
                                    :background_color0,
                                    :background_color1,
                                    :background_color2,
                                    :background_color3,
                                    :background_color4,
                                    :text_color0,
                                    :text_color1,
                                    :text_color2,
                                    :text_color3,
                                    :text_color4,
                                    :wifi,
                                    :wifi_ssid,
                                    :wifi_password,
                                    :feedback,
                                    :event,
                                    :design_qrcode,
                                    :ingredient,
                                    :commande,
                                    :utilisateur,
                                    :vip,
                                    :varie
                                )";
	
		$object->execute($data); 
		
		$market = $object->connect->lastInsertId();
		
        if ( $market > 0) {
            $success = 'Market Ajouté';
            
    		$object->query="INSERT INTO assoc_moder (market,user)
                        		SELECT s.id , u.id from market s , user u where u.type = 'moderateur'
                        		AND u.id NOT IN (Select user 
                        								FROM assoc_moder
                        								WHERE market =s.id )";
    		$object->execute();
    		
			$object->query="INSERT INTO market_langue (market,langue)
                        		SELECT m.id , l.id from market m , langue l where l.etat = '0'
                        		AND l.id NOT IN (Select langue 
                        								FROM market_langue
                        								WHERE market = m.id )";
        	$object->execute();
        	 
			$object->query="INSERT INTO qrcodes (market) VALUES ('".$market."') ";
			
        	$object->execute();
        	
        	if($_POST['pro'] != '1'){
        	
    			//*************************************************************
    		
        		// creation de qr code du market
        		
        		//************************************************************* 
        		
        		$filename = 'logo.png';
        
                $errorCorrectionLevel = 'L';
                
                $matrixPointSize = 10;
     
                $link = $object->menu_url.'qrcode?data='.$object->encrypt($market);
                
                $filename = $PNG_TEMP_DIR.'qrcode'.md5($link.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                
                QRcode::png($link, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
                
                $object->query = "UPDATE market SET qrcode= '".$PNG_WEB_DIR.basename($filename)."'   WHERE id =  '".$market."' ";
                
                $object->execute();
        	}else{
        	    
                $object->query = "SELECT * FROM qrcode WHERE gestionnaire = '".$_POST["gestionnaire"]."' ";
                
                $listeQRCode = $object->get_result();
                
                foreach($listeQRCode as $OneQRCode){
                    
                    $data = array(
                        ':market' => $market,
                        ':qrcode' => $OneQRCode['id'], 
                        );
                         
                    $object->query = " INSERT INTO market_qrcode(
                                                market,
                                                qrcode
                                            )
                                            VALUES(
                                                :market,
                                                :qrcode 
                                            )";
            	
            		$object->execute($data);  
                }
        	    
        	}
        
		
        }else{
            $error = '<div class="alert alert-danger">Erreur d\'insertion</div>'; 
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
                                market
		                    WHERE 
                                id = '" . $_POST["id"] . "'
		";
		
		

        $result = $object->get_result();

        $data = array();

        foreach ($result as $row) {
               
            $data['background']         = str_replace('../','https://',$row['background']); 
            $data['logo']               = str_replace('../','https://',$row['logo']); 
            $data['gestionnaire']       = $object->clean_input($row['gestionnaire']);
            $data['market']             = $object->clean_input($row['market']);
            $data['multi_langue']       = $object->clean_input($row['multi_langue']);
            $data['address']            = $object->clean_input($row['address']);
            $data['description']        = $object->clean_input($row['description']);
            $data['facebook']           = $object->clean_input($row['facebook']);
            $data['instagram']          = $object->clean_input($row['instagram']);
            $data['tiktok']             = $object->clean_input($row['tiktok']);
            $data['youtube']            = $object->clean_input($row['youtube']);
            $data['twitter']            = $object->clean_input($row['twitter']);
            $data['whatsapp']           = $object->clean_input($row['whatsapp']);
            $data['tripadvisor']        = $object->clean_input($row['tripadvisor']);
            $data['google']             = $object->clean_input($row['google']);
            $data['theme']              = $object->clean_input($row['theme']);
            $data['niveau']             = $object->clean_input($row['niveau']);
            $data['pro']                = $object->clean_input($row['pro']);
            $data['apercu']             = $object->clean_input($row['apercu']);
            $data['tel']                = $object->clean_input($row['tel']);
            $data['email']              = $object->clean_input($row['email']);
            $data['siteweb']            = $object->clean_input($row['siteweb']);
            $data['background_color0']  = $object->clean_input($row['background_color0']);
            $data['background_color1']  = $object->clean_input($row['background_color1']);
            $data['background_color2']  = $object->clean_input($row['background_color2']);
            $data['background_color3']  = $object->clean_input($row['background_color3']);
            $data['background_color4']  = $object->clean_input($row['background_color4']);
            $data['text_color0']        = $object->clean_input($row['text_color0']);
            $data['text_color1']        = $object->clean_input($row['text_color1']);
            $data['text_color2']        = $object->clean_input($row['text_color2']);
            $data['text_color3']        = $object->clean_input($row['text_color3']);
            $data['text_color4']        = $object->clean_input($row['text_color4']);
            $data['wifi']               = $object->clean_input($row['wifi']);
            $data['wifi_ssid']          = $object->clean_input($row['wifi_ssid']);
            $data['wifi_password']      = $object->clean_input($row['wifi_password']);
            $data['feedback']           = $object->clean_input($row['feedback']);
            $data['event']              = $object->clean_input($row['event']);
            $data['design_qrcode']      = $object->clean_input($row['design_qrcode']);
            $data['ingredient']         = $object->clean_input($row['ingredient']);
            $data['commande']           = $object->clean_input($row['commande']);
            $data['utilisateur']        = $object->clean_input($row['utilisateur']);
            $data['vip']                = $object->clean_input($row['vip']);
            $data['varie']              = $object->clean_input($row['varie']);
 
        }

        echo json_encode($data);
    } 

    if ($_POST["action"] == 'Edit') {
        $error = '';

        $success = '';  
		$logo = $_POST["hidden_market_logo"];
		if($_FILES["logo"]["name"] != '')
		{
			$logo = upload_logo();
		}else{
		    $logo    = str_replace('https://','../',$_POST["hidden_market_logo"]);  
		}

		$background =  $_POST["hidden_market_background"];
		if($_FILES["background"]["name"] != '')
		{
			$background = upload_background();
		} else{
		    $background    = str_replace('https://','../',$_POST["hidden_market_background"]);  
		}
		
        $data = array(
            ':gestionnaire'         =>	$object->clean_input($_POST["gestionnaire"]),
            ':market'               =>	$object->clean_input($_POST["market"]),
            ':multi_langue'         =>  ($object->clean_input($_POST["multi_langue"])) ,            
            ':logo'                 =>  $logo,
            ':address'              =>	($object->clean_input($_POST["address"])) ? $object->clean_input($_POST["address"]) : null,
            ':description'          =>	($object->clean_input($_POST["description"])) ? $object->clean_input($_POST["description"]) : null,
            ':facebook'             =>	($object->clean_input($_POST["facebook"])) ? $object->clean_input($_POST["facebook"]) : null,
            ':instagram'            =>	($object->clean_input($_POST["instagram"])) ? $object->clean_input($_POST["instagram"]) : null,
            ':tiktok'               =>	($object->clean_input($_POST["tiktok"])) ? $object->clean_input($_POST["tiktok"]) : null,
            ':youtube'              =>	($object->clean_input($_POST["youtube"])) ? $object->clean_input($_POST["youtube"]) : null,
            ':twitter'              =>	($object->clean_input($_POST["twitter"])) ? $object->clean_input($_POST["twitter"]) : null,
            ':whatsapp'             =>	($object->clean_input($_POST["whatsapp"])) ? $object->clean_input($_POST["whatsapp"]) : null, 
            ':tripadvisor'          =>	($object->clean_input($_POST["tripadvisor"])) ? $object->clean_input($_POST["tripadvisor"]) : null, 
            ':google'               =>	($object->clean_input($_POST["google"])) ? $object->clean_input($_POST["google"]) : null, 
            ':theme'                =>	$object->clean_input($_POST["theme"]), 
            ':niveau'               =>  $object->clean_input($_POST["niveau"]),
            ':pro'                  =>  ($object->clean_input($_POST["pro"])) ,            
            ':apercu'               =>  ($object->clean_input($_POST["apercu"])) ,            
            ':tel'                  =>  ($object->clean_input($_POST["tel"])) ? $object->clean_input($_POST["tel"]) : null,
            ':email'                =>  ($object->clean_input($_POST["email"])) ? $object->clean_input($_POST["email"]) : null,
            ':siteweb'                =>  ($object->clean_input($_POST["siteweb"])) ? $object->clean_input($_POST["siteweb"]) : null,
            ':background'           =>  $background,
            ':background_color0'    =>  ($object->clean_input($_POST["background_color0"])) ? $object->clean_input($_POST["background_color0"]) : '#cda45e',  
            ':background_color1'    =>  ($object->clean_input($_POST["background_color1"])) ? $object->clean_input($_POST["background_color1"]) : '#cda45e',  
            ':background_color2'    =>  ($object->clean_input($_POST["background_color2"])) ? $object->clean_input($_POST["background_color2"]) : '#cda45e', 
            ':background_color3'    =>  ($object->clean_input($_POST["background_color3"])) ? $object->clean_input($_POST["background_color3"]) : '#cda45e', 
            ':background_color4'    =>  ($object->clean_input($_POST["background_color4"])) ? $object->clean_input($_POST["background_color4"]) : '#cda45e', 
            ':text_color0'          =>  ($object->clean_input($_POST["text_color0"])) ? $object->clean_input($_POST["text_color0"]) : '#000000',
            ':text_color1'          =>  ($object->clean_input($_POST["text_color1"])) ? $object->clean_input($_POST["text_color1"]) : '#000000',
            ':text_color2'          =>  ($object->clean_input($_POST["text_color2"])) ? $object->clean_input($_POST["text_color2"]) : '#000000', 
            ':text_color3'          =>  ($object->clean_input($_POST["text_color3"])) ? $object->clean_input($_POST["text_color3"]) : '#000000', 
            ':text_color4'          =>  ($object->clean_input($_POST["text_color4"])) ? $object->clean_input($_POST["text_color4"]) : '#000000', 
            ':wifi'                 =>  ($object->clean_input($_POST["wifi"])) ,            
            ':wifi_ssid'            =>  ($object->clean_input($_POST["wifi_ssid"])) ? $object->clean_input($_POST["wifi_ssid"]) : null,       
            ':wifi_password'        =>  ($object->clean_input($_POST["wifi_password"])) ? $object->clean_input($_POST["wifi_password"]) : null,                   
            ':feedback'             =>  ($object->clean_input($_POST["feedback"])) ,            
            ':event'                =>  ($object->clean_input($_POST["event"])) ,            
            ':design_qrcode'        =>  ($object->clean_input($_POST["design_qrcode"])) ,            
            ':ingredient'           =>  ($object->clean_input($_POST["ingredient"])) ,            
            ':commande'             =>  ($object->clean_input($_POST["commande"])) ,            
            ':utilisateur'          =>  ($object->clean_input($_POST["utilisateur"])) ,            
            ':vip'                  =>  ($object->clean_input($_POST["vip"])) ,            
            ':varie'                  =>  ($object->clean_input($_POST["varie"])) ,            
            ':id'                   =>  ($object->clean_input($_POST["hidden_id"])) ,            
		);

        $object->query = "UPDATE market SET
                        			gestionnaire = :gestionnaire,
                                    market = :market,
                                    multi_langue = :multi_langue,
                                    logo = :logo,
                                    address = :address,
                                    description = :description,
                                    facebook = :facebook,
                                    instagram = :instagram,
                                    tiktok = :tiktok,
                                    youtube = :youtube,
                                    twitter = :twitter,
                                    whatsapp = :whatsapp,
                                    tripadvisor = :tripadvisor,
                                    google = :google,
                                    theme = :theme,
                                    niveau = :niveau,
                                    pro = :pro,
                                    apercu = :apercu,
                                    tel = :tel,
                                    email = :email,
                                    siteweb = :siteweb,
                                    background = :background,
                                    background_color0 = :background_color0,
                                    background_color1 = :background_color1,
                                    background_color2 = :background_color2,
                                    background_color3 = :background_color3,
                                    background_color4 = :background_color4,
                                    text_color0 = :text_color0,
                                    text_color1 = :text_color1,
                                    text_color2 = :text_color2,
                                    text_color3 = :text_color3,
                                    text_color4 = :text_color4,
                                    wifi = :wifi,
                                    wifi_ssid = :wifi_ssid,
                                    wifi_password = :wifi_password,
                                    feedback = :feedback,
                                    event = :event,
                                    design_qrcode = :design_qrcode,
                                    ingredient = :ingredient,
                                    commande = :commande,
                                    utilisateur = :utilisateur,
                                    vip = :vip,
                                    varie = :varie
                    			WHERE id = :id ";
		$object->execute($data); 


        $success = 'Market Modifié';
       

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
		UPDATE market
		SET statut = :statut
		WHERE id = '" . $_POST["id"] . "'
		";

        $object->execute($data);

        echo 'Statut banner changé à ' . $_POST['next_statut'] . '';
    }
    
    if($_POST["action"] == 'langue')
	{ 
		$object->query  = " SELECT
                                langue,
                                etat
                            FROM
                                market_langue
                            WHERE
                                market = '".$_POST['market']."' 
							";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
		    $langue = json_decode($object->get_langue($row['langue']));
			$sub_array = array();	 
			$sub_array[] = ($row['langue']);
			$sub_array[] = $row['etat'];
			$sub_array[] = ucwords($langue->libelle);

			$data[] = $sub_array;
		}

		echo json_encode($data); 
	}
	
	if($_POST["action"] == 'save_langue')
	{
	    $error = '';

		$success = '';

		$object->query= "UPDATE market_langue
                		SET etat = '2' 
                		WHERE market = ".$_POST['market']." 
                		";
                		
		$object->execute();
		
		if(!empty($_POST['aIds'])) {

			foreach($_POST['aIds'] as $row => $val){
	
				$object->query= "UPDATE market_langue
				SET etat = '1' 
				WHERE market = ".$_POST['market']." AND langue = '".$val."' 
					";
					
				$object->execute();
			}				
			
			$success = ' Mis à jour avec succés ';
				

		}    		
		
		$output = array(
    			'error'		=>	$error,
    			'success'	=>	$success
    		);
    
    		echo json_encode($output);
	}
 

 
}

 
// function upload_logo()
// {
// 	if(isset($_FILES["logo"]))
// 	{
// 		$filename = $_FILES['logo']['name'];
// 		$extension = pathinfo($filename, PATHINFO_EXTENSION);
// 		$new_name = rand() . '.' . $extension;
// 		$destination = '../app.menuqrcode.tn/img/' . $new_name;
// 		move_uploaded_file($_FILES['logo']['tmp_name'], $destination);
// 		return $destination;
// 	}
// }

function upload_logo()
{
    if(isset($_FILES["logo"]))
    {
        $filename = $_FILES['logo']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $new_name = rand() . '.' . $extension;
        $destination = '../app.menuqrcode.tn/img/' . $new_name;
        $source_path = $_FILES['logo']['tmp_name'];

        // Set the desired maximum width and height
        $max_width = 800;
        $max_height = 600;

        // Get the original image dimensions
        list($width, $height) = getimagesize($source_path);

        // Calculate the proportional scaling factor
        $scale = min($max_width / $width, $max_height / $height);

        // Calculate the new dimensions
        $new_width = $width * $scale;
        $new_height = $height * $scale;

        // Create a new image with the resized dimensions and a transparent background
        $resized_image = imagecreatetruecolor($new_width, $new_height);
        imagesavealpha($resized_image, true);
        $transparent_color = imagecolorallocatealpha($resized_image, 0, 0, 0, 127);
        imagefill($resized_image, 0, 0, $transparent_color);

        // Load the original image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $source_image = imagecreatefromjpeg($source_path);
        } elseif ($extension === 'png') {
            $source_image = imagecreatefrompng($source_path);
        } elseif ($extension === 'webp') {
            $source_image = imagecreatefromwebp($source_path);
        } else {
            // Unsupported image format
            return false;
        }

        // Enable alpha blending for transparent images
        imagealphablending($resized_image, true);
        imagesavealpha($resized_image, true);

        // Resize the image
        imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Save the resized image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            imagejpeg($resized_image, $destination);
        } elseif ($extension === 'png') {
            imagepng($resized_image, $destination);
        } elseif ($extension === 'webp') {
            imagewebp($resized_image, $destination);
        }

        // Free up memory
        imagedestroy($resized_image);
        imagedestroy($source_image);

        return $destination;
    }
}


function upload_background()
{
    if(isset($_FILES["background"]))
    {
        $filename = $_FILES['background']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $new_name = rand() . '.' . $extension;
        $destination = '../app.menuqrcode.tn/img/' . $new_name;
        $source_path = $_FILES['background']['tmp_name'];

        // Set the desired maximum width and height
        $max_width = 1080;
        $max_height = 1920;

        // Get the original image dimensions
        list($width, $height) = getimagesize($source_path);

        // Calculate the proportional scaling factor
        $scale = min($max_width / $width, $max_height / $height);

        // Calculate the new dimensions
        $new_width = $width * $scale;
        $new_height = $height * $scale;

        // Create a new image with the resized dimensions and a transparent background
        $resized_image = imagecreatetruecolor($new_width, $new_height);
        imagesavealpha($resized_image, true);
        $transparent_color = imagecolorallocatealpha($resized_image, 0, 0, 0, 127);
        imagefill($resized_image, 0, 0, $transparent_color);

        // Load the original image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $source_image = imagecreatefromjpeg($source_path);
        } elseif ($extension === 'png') {
            $source_image = imagecreatefrompng($source_path);
        } elseif ($extension === 'webp') {
            $source_image = imagecreatefromwebp($source_path);
        } else {
            // Unsupported image format
            return false;
        }

        // Enable alpha blending for transparent images
        imagealphablending($resized_image, true);
        imagesavealpha($resized_image, true);

        // Resize the image
        imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Save the resized image based on its extension
        if ($extension === 'jpg' || $extension === 'jpeg') {
            imagejpeg($resized_image, $destination);
        } elseif ($extension === 'png') {
            imagepng($resized_image, $destination);
        } elseif ($extension === 'webp') {
            imagewebp($resized_image, $destination);
        }

        // Free up memory
        imagedestroy($resized_image);
        imagedestroy($source_image);

        return $destination;
    }
}

 
// function upload_background()
// {
// 	if(isset($_FILES["background"]))
// 	{
// 		$filename = $_FILES['background']['name'];
// 		$extension = pathinfo($filename, PATHINFO_EXTENSION);
// 		$new_name = rand() . '.' . $extension;
// 		$destination = '../app.menuqrcode.tn/img/' . $new_name;
// 		move_uploaded_file($_FILES['background']['tmp_name'], $destination);
// 		return $destination;
// 	}
// }
