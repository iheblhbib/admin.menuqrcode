<?php  
    include('../config.menuqrcode/config.php'); 
    include_once(__DIR__ . '/securite.php');
    
    $object = new application(); 
     
    // seuls les super admins et modérateurs entrent dans l'administration
    if(!securite_est_admin($object))
    {
        header("location:".$object->admin_url."login");
        exit();
    }
     
    if(!$object->is_user_actif($_SESSION['id']))
    {
        header("location:".$object->admin_url."logout");
        exit();
    }
    
    $page_actuel = $object->get_page_url();

    $title = $object->get_page_libelle($page_actuel);
    
    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: ".$object->admin_url.$page_actuel);
        
        exit();
    }   
    $user = json_decode($object->get_user($_SESSION['id']));  
?> 
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        
        <title> Menu QR Code | Administration</title>
        
          <meta content="Boostez votre restaurant ou café en Tunisie avec des menus digitalisés par QR code ! Simplifiez les commandes et impressionnez vos clients grâce à notre solution innovante. Découvrez la révolution numérique des menus dès maintenant !" name="description">
        <meta content="digital menu, dynamic QR code, restaurant, online ordering, food, drinks, meals, menu, scanning, technology,menu numérique, QR code dynamique, restaurant, commande en ligne, alimentation, nourriture, boissons, repas, carte, numérisation, technologie" name="keywords">
        
         
  <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png"> 
    <link rel="icon" type="image/png"  href="assets/img/favicon.ico"> 
    <link rel="manifest" href="assets/img/site.webmanifest">
         
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
         
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
        <link href="vendor/parsley/parsley.css" rel="stylesheet"/>
    
        <link href='vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
        <link href='vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
        <link href='vendor/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
        <link href='vendor/fullcalendar/packages/list/main.css' rel='stylesheet' />
         
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap5.min.css">
        <link rel="stylesheet" href="vendor/datatables/rowgroup/1.2.0/rowGroup.dataTables.css">
        <link rel="stylesheet" href="vendor/datatables/select/1.6.0/css/select.bootstrap5.css"> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
         
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
     
        <link href="assets/css/new-style.css" rel="stylesheet">
       
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css"> 
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FD9CWFEKGK"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date()); 
            gtag('config', 'G-FD9CWFEKGK');
        </script> 
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4637955071361573" crossorigin="anonymous"></script>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-211033766-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());  
            gtag('config', 'UA-211033766-1');
        </script>
        
        <style> 
            .page<?=  $page_actuel ?> {
                color: #ffffff !important;
                background: #2c5199 !important; 
                border-radius: 5px !important;
            }
            
            .table {
                white-space: normal !important;
            }
     
        </style>
    </head>

<body> 
    <header id="header" class="header fixed-top d-flex align-items-center"> 
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo text-center">
                <img src="img/menuqrcode.png"> 
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <i class="bi bi-arrows-fullscreen fullscreen_button" style="font-size: 27px; padding-left: 10px; cursor: pointer; color: #012970;"></i> 
        </div> 
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center"> 
                <li class="nav-item dropdown pe-3"> 
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> 
                        <img src="<?= $user->user_profile ?>" alt="Profile" class="rounded-circle">  
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user->name; ?></span>
                    </a>  
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $user->name; ?></h6>
                            <span><?= $user->type ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> 
                        <li>
                            <a class="dropdown-item d-flex align-items-center" id="go-profil" data-id="<?= $user->id ?>" href="#">
                                <i class="fal fa-user"></i>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" id="go-password" data-id="<?= $user->id ?>" href="#">
                                <i class="fa-light fa-key-skeleton"></i>
                                <span>Mot de passe</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> 
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" id="buttonlogoutModal" data-toggle="modal" data-target="#logoutModal">
                                <i class="fal fa-sign-out"></i>
                                <span>Se déconnecter</span>
                            </a>
                        </li> 
                    </ul> 
                </li>  
            </ul>
        </nav>  
    </header>  
    <aside id="sidebar" class="sidebar"> 
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed pageindex " href="/">
                    <img src="img/dashboard.png" class="image-header" alt="profile-image"> 
                    <span>Dashboard</span> 
                </a>
            </li> 
            
             <li class="nav-heading">Menu QR Code</li>
             
            <li class="nav-item">
                <a class="nav-link collapsed pageclient" href="client">
                    <img src="img/client.png" class="image-header" alt="profile-image"> 
                    <span>Clients</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagemarket" href="market">
                    <img src="img/market.png" class="image-header" alt="profile-image"> 
                    <span>Markets</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pageqr-codes" href="qr-codes">
                    <img src="img/qr-code-2.png" class="image-header" alt="profile-image"> 
                    <span>QR Codes</span> 
                </a>
            </li> 
            
             <li class="nav-heading">Paiements</li>
             
            <li class="nav-item">
                <a class="nav-link collapsed pagepaiement" href="paiement">
                    <img src="img/symbole-du-dollar.png" class="image-header" alt="profile-image"> 
                    <span>Paiement</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagekonnect" href="konnect">
                    <img src="img/konnect.png" class="image-header" alt="profile-image"> 
                    <span>Konnect</span> 
                </a>
            </li> 
            
            <li class="nav-heading">Paramètres</li>
            
            <li class="nav-item">
                <a class="nav-link collapsed pagefeedback" href="feedback">
                    <img src="img/feedback.png" class="image-header" alt="profile-image"> 
                    <span>Feedback</span> 
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link collapsed pagealert" href="alert">
                    <img src="img/portable.png" class="image-header" alt="profile-image"> 
                    <span>Alerts</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagepack" href="pack">
                    <img src="img/pack.png" class="image-header" alt="profile-image"> 
                    <span>Packs</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagelangue" href="langue">
                    <img src="img/arabe.png" class="image-header" alt="profile-image"> 
                    <span>Langues</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagebanner" href="banner">
                    <img src="img/pub.png" class="image-header" alt="profile-image"> 
                    <span>Banniers</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pageallergens" href="allergens">
                    <img src="img/sans-gluten.png" class="image-header" alt="profile-image"> 
                    <span>Allergens</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagemenus" href="menus">
                    <img src="img/modele.png" class="image-header" alt="profile-image"> 
                    <span>Liens des menus</span> 
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link collapsed pagemoderateur" href="moderateur">
                    <img src="img/ressources-humaines.png" class="image-header" alt="profile-image"> 
                    <span>Moderateurs</span> 
                </a>
            </li>  
            <li class="nav-item">
                <a class="nav-link collapsed pagecommande-etat" href="commande-etat">
                    <img src="img/commande.png" class="image-header" alt="profile-image"> 
                    <span>Etat Commandes</span> 
                </a>
            </li>  
      
            
            <li class="nav-heading">Droit d'Accès</li>
            
              <li class="nav-item">
                <a class="nav-link collapsed pagemodule" href="module">
                    <img src="img/module.png" class="image-header" alt="profile-image"> 
                    <span>Modules </span> 
                </a>
            </li> 
              <li class="nav-item">
                <a class="nav-link collapsed pageroute" href="route">
                    <img src="img/url.png" class="image-header" alt="profile-image"> 
                    <span>Routes</span> 
                </a>
            </li> 
              <li class="nav-item">
                <a class="nav-link collapsed pagepermission" href="permission">
                    <img src="img/acces.png" class="image-header" alt="profile-image"> 
                    <span>Permissions</span> 
                </a>
            </li> 
     
            <li class="nav-heading">Affiliate</li>
            <li class="nav-item">
                <a class="nav-link collapsed pageevenement" href="evenement">
                    <img src="img/defi.png" class="image-header" alt="profile-image"> 
                    <span>Événements</span> 
                </a>
            </li>  
              <li class="nav-item">
                <a class="nav-link collapsed pagetoken" href="token">
                    <img src="img/api.png" class="image-header" alt="profile-image"> 
                    <span>API Tokens</span> 
                </a>
            </li> 
              <li class="nav-item">
                <a class="nav-link collapsed pagemarketing" href="marketing">
                    <img src="img/photos.png" class="image-header" alt="profile-image"> 
                    <span>Galerie Marketing</span> 
                </a>
            </li> 
        </ul> 
    </aside>
