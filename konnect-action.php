<?php

include('../config.menuqrcode/config.php');

$object = new application(); 
 
if (isset($_POST["action"])) {
 
    if ($_POST["action"] == 'fetch') {
        $order_column = array(  'k.created','u.name', 'k.reference','k.lien','k.statut', ' k.montant');

        $output = array();

        $main_query = " SELECT
                            k.* ,
                            u.name
                        FROM
                            konnect k  
                            LEFT JOIN user u ON u.id = k.user ";

        $search_query = '';

        if (isset($_POST["search"]["value"])) {
            $search_query .= 'WHERE (u.name LIKE "%' . $_POST["search"]["value"] . '%" '; 
            $search_query .= 'OR k.reference LIKE "%' . $_POST["search"]["value"] . '%"  '; 
            $search_query .= 'OR k.montant LIKE "%' . $_POST["search"]["value"] . '%"  '; 
            $search_query .= 'OR k.lien LIKE "%' . $_POST["search"]["value"] . '%"  ) ';
        }

        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = 'ORDER BY k.created   DESC ';
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

        $object->query = $main_query;

        $object->execute();

        $total_rows = $object->row_count();

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();  
	        
            $sub_array[] =  '<input type="hidden" name="ligne_id" value="' . $row["id"] . '">'.date('H:i:s d/m/Y',strtotime($row["created"])); 
            $sub_array[] =  ($row['name']);
            $sub_array[] =  ($row['etat'] == '1' ) ? '--' : ($row['reference']);
            $sub_array[] =  ($row['etat'] == '1' ) ? '--' : '<a href="'.$row['lien'].'" target="_blank">Lien <i class="fa-light fa-link"></i> </a>';
            $sub_array[] =  ($row['etat'] == '1' ) ? '<span class="badge bg-secondary " >Brouillon</spac>' :  '<span class="badge bg-'.$object->getStatusColor($row['statut']).' " >'.ucwords($object->getStatusLibelle($row['statut'])).'</spac>';
            $sub_array[] =  number_format($row['montant']/1000,3,',',' ') .' TND' ; 
            
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

    if($_POST['action'] == 'fetch_single'){
        
            $object->query = "SELECT
                            k.* ,
                            u.name
                        FROM
                            konnect k  
                            LEFT JOIN user u ON u.id = k.user 
                        WHERE k.id = '".$_POST["id"]."'  ";
                        
            $result = $object->get_result();
            
            $data = array();
             
            foreach($result as $row){
                $data['client']     = $row['name'];
                $data['reference']  = ($row['etat'] == '1' ) ? '--' : $row['reference'];
                $data['lien']       = ($row['etat'] == '1' ) ? '--' : $row['lien'];
                $data['nom']        = ($row['etat'] == '1' ) ? '--' : $row['nom'];
                $data['prenom']     = ($row['etat'] == '1' ) ? '--' : $row['prenom'];
                $data['societe']    = ($row['etat'] == '1' ) ? '--' : $row['societe'];
                $data['tel']        = ($row['etat'] == '1' ) ? '--' : $row['tel'];
                $data['email']      = ($row['etat'] == '1' ) ? '--' : $row['email'];
                $data['address']    = ($row['etat'] == '1' ) ? '--' : $row['address'];
                $data['montant']    = number_format($row['montant']/1000,3,',',' ');
                $data['etat']       = ($row['etat'] == '1' ) ? '<span class="badge bg-secondary " >Brouillon</spac>' : '<span class="badge bg-success " >Commandé</spac>'  ; 
                $data['statut']     =  '<span class="badge bg-'.$object->getStatusColor($row['statut']).' " >'.ucwords($object->getStatusLibelle($row['statut'])).'</spac>'; 
                
                $object->query = "  SELECT 
        	                            l.*,
                                        p.libelle as libelle_pack, 
                                        p.tarif as tarif_pack ,
                                        m.libelle as libelle_module ,
                                        m.tarif as tarif_module  
                                    FROM 
                                        konnect_ligne l 
                                        LEFT JOIN konnect k ON k.id = l.konnect
                                        LEFT JOIN module m ON m.id = l.module
                                        LEFT JOIN pack p ON p.id = l.pack
                                    WHERE 
                                        l.konnect = '".$_POST["id"]."'  ";
                                        
                $result = $object->get_result();
                
                $sub_array = array(); 
                foreach($result as $row){
                    
                    $sub_data = array(); 
                    $sub_data['produit']    = ($row['type'] == 'pack') ? 'Pack : '.ucwords($row['libelle_pack']) : 'Module : '.ucwords($row['libelle_module']); 
                    $sub_data['tarif']      = number_format( (($row['type'] == 'pack') ? $row['tarif_pack'] : $row['tarif_module']) ,3,',',' ')  ; 
                    $sub_array[] = $sub_data;
                }
                $data['ligne'] = $sub_array;
            }
            
            echo json_encode($data);
    }
 
   
}
