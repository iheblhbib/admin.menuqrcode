<?php
 

include('../config.menuqrcode/config.php');
    
$object = new application(); 

$page_actuel = $object->get_page_url();

// $rating = ['--','☆','☆☆','☆☆☆','☆☆☆☆','☆☆☆☆☆']; 
$rating = ['--', '<i class="fa-duotone fa-star-half"></i>',
                 '<i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i>',
                 '<i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i>',
                 '<i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i>',
                 '<i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i><i class="fa-duotone fa-star-half"></i>' ];
 

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('m.market', 'f.rating','f.ip','f.commentaire','f.browser',);

		$output = array();
		
		$main_query = "
		SELECT 
		    f.*,
		    m.market as libelle
		FROM 
		    feedback f
		    left join market m on m.id = f.market ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' WHERE (m.market LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR f.browser LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR f.rating LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR f.commentaire LIKE "%'.$_POST["search"]["value"].'%" )';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY f.id DESC ';
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
			$sub_array = array(); 
			$sub_array[] = ($row["libelle"]) ;  
			$sub_array[] = ($row["rating"]) ? '<h5 class="text-primary" >'.($rating[$row["rating"]]).'</h5>'  : '<h5 class="text-primary" ><i class="fa-duotone fa-ban"></i></h5>' ;  
			$sub_array[] = ($row["commentaire"]) ? ($row["commentaire"]) : '--'  ;  
			$sub_array[] = $row["ip"]  ;  
			
    	                $userAgent = $row['browser'];
            preg_match('/\((.*?)\)/', $userAgent, $matches);
            $device = isset($matches[1]) ? $matches[1] : 'N/A';
    
            $sub_array[] = $device;
                
// 			$sub_array[] = $object->getTypeBrowser($row["browser"]) ;  
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
	if($_POST["action"] == 'feedback'){
	    
	    $data = array(
	            ':market'       =>  $object->decrypt($_POST['market']),
	            ':rating'       =>  $_POST['rating'],
	            ':commentaire'  =>  $_POST['commentaire'],
	            ':ip'           =>  $object->getIPAddress(),
                ':browser'      =>  $object->getBrowser()
	        );
	        
	    $object->query ="INSERT INTO feedback (  market, rating, commentaire,  ip, browser ) VALUES (  :market, :rating, :commentaire,  :ip, :browser ) ";
	    
	    $object->execute($data);
	    
    	$id = $object->connect->lastInsertId();
    	
    	$success = '';
    	
    	$error = '';
    	
    	if($id > 0){
    	   $success = 'success'; 
    	}else{
    	    $error = 'error';
    	}
    	
    	$output= array(
    	    'success' => $success,
    	    'error'     => $error
    	    );
    	    
    	    echo json_encode($output);
	}
}

 

?>