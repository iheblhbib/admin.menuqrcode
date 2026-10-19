<?php
/**
 * api-admin.php — API du dashboard SUPER ADMIN "menu QR" (toutes les markets)
 * -----------------------------------------------------------------------------
 * Endpoints (GET) :
 *   ?action=summary&days=30
 *   ?action=access_series&days=30&granularity=day|month
 *   ?action=revenue_series
 *   ?action=packs_distribution
 *   ?action=ratings_distribution&days=30
 *   ?action=top_markets&days=30&limit=8
 *   ?action=latest_feedback&limit=8
 *   ?action=latest_logins&limit=8
 *   ?action=expiring_subscriptions&within_days=180&limit=8
 *
 * ⚠️ SÉCURITÉ : ce fichier expose des données agrégées sur TOUS les markets.
 * Ajoute ta vérification de session / rôle super-admin juste après le
 * require ci-dessous, avant toute requête (voir le commentaire).
 *
 * ⚠️ Hypothèses sur le schéma (à corriger si besoin) :
 * - `market`.`market` = le nom du market, utilisé comme clé de jointure avec
 *   `acces_liste`.`market` / `feedback`.`market` (même principe que pour le
 *   dashboard client dans api.php).
 * - `paiement`.`date` = date réelle de la transaction (utilisée pour filtrer
 *   par période). `paiement`.`created` = date d'enregistrement en base.
 *   Inverse les deux dans revenue_series/summary si c'est le contraire chez toi.
 * - `user`.`echeance` = date d'expiration de l'abonnement du client.
 *
 * Adapte le require ci-dessous au chemin réel de ta classe "application".
 */


include('../../config.menuqrcode/config.php'); 
include_once(__DIR__ . '/../securite.php');

// réservé aux administrateurs connectés
securite_exiger_admin(new application());

header('Content-Type: application/json; charset=utf-8');

/* ------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------ */

function clean_param($value) {
    $value = trim((string) $value);
    return preg_replace('/[^A-Za-z0-9 _\-\.@]/', '', $value);
}

function fail($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['success' => false, 'error' => $message]);
    exit;
}

function run_query($sql) {
    $object = new application();
    $object->query = $sql;
    $object->execute();
    $result = $object->statement_result();
    return is_array($result) ? $result : [];
}

/* ------------------------------------------------------------
 * Paramètres communs
 * ------------------------------------------------------------ */

$action      = isset($_GET['action']) ? clean_param($_GET['action']) : '';
$days        = isset($_GET['days']) ? intval($_GET['days']) : 30;
$limit       = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$granularity = isset($_GET['granularity']) ? clean_param($_GET['granularity']) : 'day';
$withinDays  = isset($_GET['within_days']) ? intval($_GET['within_days']) : 180;

if ($days <= 0 || $days > 730) $days = 30;
if ($limit <= 0 || $limit > 50) $limit = 10;
if (!in_array($granularity, ['day', 'month'], true)) $granularity = 'day';
if ($withinDays <= 0 || $withinDays > 365) $withinDays = 180;

/* ------------------------------------------------------------
 * Router
 * ------------------------------------------------------------ */

switch ($action) {

    case 'summary': {
        $clients = run_query("SELECT COUNT(*) AS total FROM `user` WHERE statut = 'Activer' AND type = 'gestionnaire' ");
        $markets = run_query("SELECT COUNT(*) AS total FROM `market` WHERE statut = 'Activer' AND gestionnaire in (SELECT id FROM `user` WHERE statut = 'Activer' AND type = 'gestionnaire' ) ");

        $access = run_query("
            SELECT COUNT(*) AS total
            FROM `acces_liste`
            WHERE `created` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
        ");

        $revenue = run_query("
            SELECT SUM(`montant`) AS total
            FROM `paiement`
            WHERE `date` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
        ");

        $login = run_query("
            SELECT COUNT(*) AS total
            FROM `login`
            WHERE `created` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
        ");

        $feedback = run_query("
            SELECT ROUND(AVG(`rating`), 2) AS moyenne
            FROM `feedback`
            WHERE `created` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
        ");

        echo json_encode([
            'success'       => true,
            'periode_jours' => $days,
            'clients'       => isset($clients[0]['total']) ? (int) $clients[0]['total'] : 0,
            'markets'       => isset($markets[0]['total']) ? (int) $markets[0]['total'] : 0,
            'acces'         => isset($access[0]['total']) ? (int) $access[0]['total'] : 0,
            'revenu'        => isset($revenue[0]['total']) ? (float) $revenue[0]['total'] : 0,
            'connexions'    => isset($login[0]['total']) ? (int) $login[0]['total'] : 0,
            'note_moyenne'  => isset($feedback[0]['moyenne']) ? (float) $feedback[0]['moyenne'] : 0,
        ]);
        break;
    }

    case 'access_series': {
        if ($granularity === 'month') {
            $rows = run_query("
                SELECT DATE_FORMAT(`created`, '%Y-%m') AS periode, COUNT(*) AS total
                FROM `acces_liste`
                WHERE `created` >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(`created`, '%Y-%m')
                ORDER BY periode ASC
            ");
        } else {
            $rows = run_query("
                SELECT DATE(`created`) AS periode, COUNT(*) AS total
                FROM `acces_liste`
                WHERE `created` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
                GROUP BY DATE(`created`)
                ORDER BY periode ASC
            ");
        }
        echo json_encode(['success' => true, 'granularity' => $granularity, 'data' => $rows]);
        break;
    }

    case 'revenue_series': {
        $rows = run_query("
            SELECT DATE_FORMAT(`date`, '%Y-%m') AS periode, SUM(`montant`) AS total
            FROM `paiement`
            WHERE `date` >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(`date`, '%Y-%m')
            ORDER BY periode ASC
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'packs_distribution': {
        $rows = run_query("
                SELECT
                     p.libelle as pack ,
                    COUNT(*) AS total
                FROM
                     user u 
                    LEFT JOIN pack p ON p.id = u.pack 
                    WHERE u.statut = 'Activer' 
                GROUP BY
                     u.pack 
                ORDER BY
                    total
                DESC 
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'ratings_distribution': {
        $rows = run_query("
            SELECT `rating`, COUNT(*) AS total
            FROM `feedback`
            WHERE `created` >= DATE_SUB(NOW(), INTERVAL {$days} DAY)
            GROUP BY `rating`
            ORDER BY `rating` ASC
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'top_markets': {
        $rows = run_query("
                    SELECT
                        m.market,
                        COUNT(*) AS total
                    FROM
                        acces_liste a 
                        LEFT JOIN market m ON m.id = a.market
                    WHERE
                        a.created >= DATE_SUB(NOW(), INTERVAL 10 DAY)
                    GROUP BY
                        market
                    ORDER BY
                        total
                    DESC
                    LIMIT {$limit}
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'latest_feedback': {
        $rows = run_query("
                            SELECT
                                 m.market ,
                                 f.name ,
                                 f.rating ,
                                 f.commentaire ,
                                 f.created 
                            FROM
                                feedback f
                                LEFT JOIN market m ON m.id = f.market
                            ORDER BY
                                f.created
                            DESC
                            LIMIT {$limit}
                        ");
                        
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'latest_logins': {
        $rows = run_query("
                        SELECT
                            u.name as user,
                            l.ip,
                            l.browser,
                            l.created
                        FROM
                            login l
                            LEFT JOIN user u ON u.id = l.user
                        ORDER BY
                            l.created
                        DESC
                        LIMIT {$limit}
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    case 'expiring_subscriptions': {
        $rows = run_query("
                    SELECT  
                    	u.name,
                        u.societe,
                        u.email,
                        u.num_mobile,
                        p.libelle as pack,
                        u.echeance
                    FROM
                        user u
                    LEFT JOIN pack p ON
                        p.id = u.pack
                    WHERE
                        u.echeance IS NOT NULL AND u.echeance >= CURDATE() AND u.echeance <= DATE_ADD(CURDATE(), INTERVAL {$withinDays} DAY) AND u.lifetime = '1'
                    ORDER BY
                        u.echeance ASC 
                   LIMIT {$limit}  
        ");
        echo json_encode(['success' => true, 'data' => $rows]);
        break;
    }

    default:
        fail('Action inconnue : "' . $action . '".', 404);
}