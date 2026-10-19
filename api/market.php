<?php include('../../config.menuqrcode/config.php');

    $object = new application();
    
    if (!$object->is_login()) {
        header("location:" . $object->base_url . "");
    }
      
    
    $object->query="SELECT 
                        * 
                    FROM 
                        market 
                    WHERE 
                        gestionnaire = '".$_POST['id']."' 
                    ORDER BY 
                        market ASC";
     
    $result = $object->get_result();
    
    $data = array();
    
    foreach($result as $row)
    {
        $sub_array = array();
        
        foreach ($row as $key => $value) {
            $value = (strpos($value, "../") === 0) ? str_replace('../',"https://",$value) : $value;
            $sub_array[$key] = $value ;
        } 
        
        $data[] = $sub_array;
    }
    
    echo json_encode($data);

?>
