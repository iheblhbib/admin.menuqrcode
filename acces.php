<?php 

include('header.php'); 

?>

<style>
    .image-employe{
        width: 80px;
    }


    .card{
        cursor: pointer;
        width: 150px;
        height: 150px;
    }

    .row a {
        display: grid;
        place-items: center;
    }

</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Accès</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
            <li class="breadcrumb-item active">Accès</li>
        </ol>
        </nav>
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-xxl-2 col-md-3 hvr-grow-shadow">
            <a href="module"  title="Modules">
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/module.png" class="image-employe" alt="profile-image">
                                <h6 class="text-secondary">Modules</h6> 
                            </div>                            
                        </div>
                    </div>
                </div>
            </a>
        </div> 
        <div class="col-xxl-2 col-md-3 hvr-grow-shadow">
            <a href="route"  title="Routes">
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/url.png" class="image-employe" alt="profile-image">
                                <h6 class="text-secondary">Routes</h6> 
                            </div>                            
                        </div>
                    </div>
                </div>
            </a>
        </div> 
        <div class="col-xxl-2 col-md-3 hvr-grow-shadow">
            <a href="permission"  title="Permission">
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/acces.png" class="image-employe" alt="profile-image">
                                <h6 class="text-secondary">Permissions</h6> 
                            </div>                            
                        </div>
                    </div>
                </div>
            </a>
        </div> 
    </div>
</main>

<?php include('footer.php'); ?>


<script>

$(".accesdiv").removeClass('collapsed');
$(".accesliste").addClass('show');

</script>
 