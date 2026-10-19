<?php

include('../config.menuqrcode/config.php'); // adapte le chemin si besoin pour la section superadmin

$object = new application();

$page_actuel = $object->get_page_url();

$rating = ['--', '1/5 😔',
                 '2/5 😟',
                 '3/5 😐',
                 '4/5 😊',
                 '5/5 😀' ];


if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$search        = isset($_POST['search']) ? trim($_POST['search']) : '';
		$rating_filter = (isset($_POST['rating_filter']) && $_POST['rating_filter'] !== '') ? intval($_POST['rating_filter']) : null;
		$market_filter = (isset($_POST['market_filter']) && $_POST['market_filter'] !== '') ? intval($_POST['market_filter']) : null;
		$sort          = isset($_POST['sort']) ? $_POST['sort'] : 'date_desc';
		$start         = isset($_POST['start']) ? intval($_POST['start']) : 0;
		$length        = isset($_POST['length']) ? intval($_POST['length']) : 9;
		$draw          = isset($_POST['draw']) ? intval($_POST['draw']) : 0;

		$sort_map = array(
			'date_desc'   => 'f.created DESC',
			'date_asc'    => 'f.created ASC',
			'rating_desc' => 'f.rating DESC',
			'rating_asc'  => 'f.rating ASC',
			'market_asc'  => 'm.market ASC',
			'market_desc' => 'm.market DESC',
		);
		$order_by = isset($sort_map[$sort]) ? $sort_map[$sort] : $sort_map['date_desc'];

		$main_query = "
		SELECT 
		    f.*,
		    m.market as libelle
		FROM 
		    feedback f
		    LEFT JOIN market m ON m.id = f.market ";

		$where  = array();
		$params = array();

		if($search !== '')
		{
			$where[] = "(m.market LIKE :search OR f.name LIKE :search OR f.email LIKE :search OR f.commentaire LIKE :search OR f.ip LIKE :search)";
			$params[':search'] = '%'.$search.'%';
		}

		if($rating_filter !== null)
		{
			$where[] = "f.rating = :rating_filter";
			$params[':rating_filter'] = $rating_filter;
		}

		if($market_filter !== null)
		{
			$where[] = "f.market = :market_filter";
			$params[':market_filter'] = $market_filter;
		}

		$where_query = count($where) > 0 ? ' WHERE '.implode(' AND ', $where).' ' : ' ';
		$order_query = 'ORDER BY '.$order_by.' ';

		// Filtered count
		$object->query = $main_query . $where_query . $order_query;
		$object->execute($params);
		$filtered_rows = $object->row_count();

		// Page of results
		$object->query = $main_query . $where_query . $order_query . 'LIMIT '.$start.', '.$length;
		$object->execute($params);
		$result = $object->statement_result();

		// Total (all markets, no filters)
		$object->query = $main_query;
		$object->execute();
		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$ratingVal = intval($row['rating']);

			$userAgent = $row['browser'];
			preg_match('/\((.*?)\)/', $userAgent, $matches);
			$device = isset($matches[1]) ? $matches[1] : 'N/A';

			$data[] = array(
				'id'           => $row['id'],
				'market_id'    => $row['market'],
				'market'       => $row['libelle'] ? $row['libelle'] : 'Marché supprimé',
				'date_full'    => ucwords($object->dateToFrench($row['created'], 'l j F Y')).' à '.date('H:i', strtotime($row['created'])),
				'name'         => $row['name'] ? $row['name'] : 'Anonyme',
				'email'        => $row['email'] ? $row['email'] : '',
				'rating'       => $ratingVal,
				'rating_label' => $ratingVal > 0 ? $rating[$ratingVal] : 'Pas de note',
				'commentaire'  => $row['commentaire'] ? $row['commentaire'] : '',
				'device'       => $device,
				'ip'           => $row['ip'] ? $row['ip'] : '--',
			);
		}

		$output = array(
			"draw"    			=> 	$draw,
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'stats')
	{
		$object->query = "SELECT f.rating, COUNT(*) as cnt FROM feedback f GROUP BY f.rating";
		$object->execute();
		$result = $object->statement_result();

		$distribution = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
		$total = 0;
		$sum = 0;

		foreach($result as $row)
		{
			$r   = intval($row['rating']);
			$cnt = intval($row['cnt']);
			$total += $cnt;

			if($r >= 1 && $r <= 5)
			{
				$distribution[$r] = $cnt;
				$sum += $r * $cnt;
			}
		}

		$average = $total > 0 ? round($sum / $total, 1) : 0;

		$object->query = "
			SELECT m.market as libelle, COUNT(*) as cnt
			FROM feedback f
			LEFT JOIN market m ON m.id = f.market
			GROUP BY f.market
			ORDER BY cnt DESC
			LIMIT 1";
		$object->execute();
		$topResult = $object->statement_result();

		$top_market       = (count($topResult) > 0 && $topResult[0]['libelle']) ? $topResult[0]['libelle'] : '--';
		$top_market_count = (count($topResult) > 0) ? intval($topResult[0]['cnt']) : 0;

		echo json_encode(array(
			'total'            => $total,
			'average'          => $average,
			'distribution'     => $distribution,
			'top_market'       => $top_market,
			'top_market_count' => $top_market_count
		));
	}

	if($_POST["action"] == 'markets')
	{
		$object->query = "
			SELECT DISTINCT m.id, m.market
			FROM feedback f
			LEFT JOIN market m ON m.id = f.market
			WHERE m.market IS NOT NULL
			ORDER BY m.market ASC";
		$object->execute();
		$result = $object->statement_result();

		echo json_encode($result);
	}
}

?>
