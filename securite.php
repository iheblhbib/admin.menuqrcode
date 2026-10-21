<?php
/*
 * Contrôles de sécurité communs de l'administration.
 * À inclure après config.php, une fois $object = new application() créé.
 * Le même fichier existe dans l'espace client (app.menuqrcode) pour la partie jeton.
 * Compatible PHP 7.3.
 */

/*
 * Clé secrète partagée entre l'admin et l'espace client.
 * Si config.php définit MENUQR_SECRET, on l'utilise ; sinon on dérive la clé du contenu
 * de config.php (fichier commun aux deux sites, hors dépôt, qui contient déjà des secrets).
 */
function securite_secret()
{
    if (defined('MENUQR_SECRET') && MENUQR_SECRET !== '') {
        return MENUQR_SECRET;
    }
    $reflexion = new ReflectionClass('application');
    return hash_file('sha256', $reflexion->getFileName());
}

/* Signature du lien « se connecter en tant que » généré dans l'admin. */
function securite_signature_connexion($id, $market, $expire)
{
    return hash_hmac('sha256', 'connexion|' . $id . '|' . $market . '|' . $expire, securite_secret());
}

/* Champs à joindre au formulaire de connexion « en tant que » vers l'espace client (valables 2 heures). */
function securite_jeton_connexion($id, $market = '')
{
    $expire = time() + 2 * 3600;
    return array(
        'expire'    => $expire,
        'signature' => securite_signature_connexion($id, $market, $expire),
    );
}

/* Attributs data-expire et data-signature pour un bouton « se connecter en tant que ». */
function securite_attributs_connexion($id, $market = '')
{
    $jeton = securite_jeton_connexion($id, $market);
    return ' data-expire="' . $jeton['expire'] . '" data-signature="' . $jeton['signature'] . '"';
}

/*
 * Adresse de l'espace client, pour les boutons « se connecter en tant que ».
 * Si config.php définit MENUQR_APP_URL, on l'utilise ; sinon, en local Laragon
 * (admin.menuqrcode.tn.test) on vise app.menuqrcode.tn.test, et en ligne app.menuqrcode.tn.
 */
function securite_url_espace_client()
{
    if (defined('MENUQR_APP_URL') && MENUQR_APP_URL !== '') {
        return rtrim(MENUQR_APP_URL, '/');
    }
    $hote = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';
    if (substr($hote, -5) === '.test') {
        return 'https://app.menuqrcode.tn.test';
    }
    return 'https://app.menuqrcode.tn';
}

/* Arrête la requête avec un message JSON (les pages d'action sont appelées en AJAX). */
function securite_refuser($code, $message)
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('error' => $message, 'success' => ''));
    exit;
}

/* Vrai si l'utilisateur connecté est un super admin ou un modérateur. */
function securite_est_admin($object)
{
    if (!$object->is_login()) {
        return false;
    }
    $type = strtolower((string) $object->get_type($_SESSION['id']));
    return in_array($type, array('superadmin', 'moderateur'), true);
}

/* À appeler en haut de chaque page d'action de l'administration. */
function securite_exiger_admin($object)
{
    if (!securite_est_admin($object)) {
        securite_refuser(401, 'Session expirée, reconnectez-vous.');
    }
}

/*
 * Vérifie un fichier envoyé et renvoie un nom aléatoire sûr (avec extension en minuscules),
 * ou false si l'extension n'est pas autorisée ou si une image n'en est pas une.
 */
function securite_nom_fichier($fichier, $extensions)
{
    if (!isset($fichier['tmp_name'], $fichier['name']) || !is_uploaded_file($fichier['tmp_name'])) {
        return false;
    }

    $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $extensions, true)) {
        return false;
    }

    $images = array('jpg', 'jpeg', 'png', 'webp', 'gif');
    if (in_array($extension, $images, true) && @getimagesize($fichier['tmp_name']) === false) {
        return false;
    }

    if ($extension === 'pdf') {
        $debut = file_get_contents($fichier['tmp_name'], false, null, 0, 5);
        if ($debut !== '%PDF-') {
            return false;
        }
    }

    return bin2hex(random_bytes(12)) . '.' . $extension;
}
