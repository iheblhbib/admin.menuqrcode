<?php 
    
    include ('header.php');
?>
<style>
    .form-control {
        margin-bottom: 10px;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Konnect Paiement </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item"><a href="konnect">Konnect</a></li>
                <li class="breadcrumb-item active">Konnect Paiement </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4 small">
                    <div class="card-header py-3">
                    	<div class="row">
                        	<div class="col">
                        		<h6 class="m-0 font-weight-bold ">Liste des paiement</h6>
                        	</div> 
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  " id="konnect_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr> 
                                        <th>Date d'ajout</th>  
                                        <th>Client</th> 
                                        <th>Réference</th> 
                                        <th>Lien</th> 
                                        <th>Statut</th> 
                                        <th>Montant</th>   
                                    </tr>
                                </thead>
                                <tbody >
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </main> 
  
<?php
    include ('footer.php');
?>
      
<script> 

$(document).ready(function(){ 
 
	var dataTable = $('#konnect_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"paging" : false,
		"order" : [], 
		"ajax" : {
			url:"konnect-action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		], "drawCallback": function(settings) {  
                // $('#konnect_table td:nth-last-child(3)').attr('style', 'text-align:left !important;');
                // $('#konnect_table th:nth-last-child(3)').attr('style', 'text-align:left !important;');
            },
	}); 
	
    $(document).on('click', '#konnect_table tr', function() {
        var button = $(this).find('td').eq(0).html();
        
        var id  =  $(button).val();
        
        if(id != null){
            
            $.ajax({

    	      	url:"konnect-action",
    
    	      	method:"POST",
    
    	      	data:{id:id, action:'fetch_single'},
    
    	      	dataType:'JSON',
    
    	      	success:function(data)
    	      	{   
                    var ligne = '';
    	      	    if(data.ligne){
        	      	     ligne =`<h3 class="text-primary">Informations de ligne Commande</h3>
        	      	                <table class="table table-bordered table-sm table-hover table-striped">
        	      	                    <thead>
        	      	                        <tr>
        	      	                            <th>Produit</th> 
        	      	                            <th>Tarif</th> 
        	      	                        </tr>
        	      	                    </thead>
        	      	                    <tbody>
        	      	                    `;
        	      	    $.each(data.ligne, function (index, value) { 
        	      	        ligne += `
        	      	            <tr>
        	      	                 <td>`+value.produit+`</td> 
        	      	                 <td>`+value.tarif+` TND</td>  
              	                </tr>
        	      	        ` ;
        	      	    });
        	      	    ligne += `</tbody>
        	      	            </table>
        	      	            `;
    	      	    }
    	      	    Swal.fire({
                        html:
                        '<h3 class="text-primary">Informations du Commande</h3>'+
                        '<table class="text-capitalize table table-bordered table-sm table-hover table-striped">'+
                        '<tr><th width="30%">Client</th><td>'+data.client+'</td></tr>'+ 
                        '<tr><th width="30%">Réference</th><td>' + data.reference + '</td></tr>' +
                        '<tr><th width="30%">Lien</th><td><a target="_blank" href="'+ data.lien + '"> Lien </a></td></tr>' + 
                        '<tr><th width="30%">Etat Commande</th><td>' + data.etat + '</td></tr>' +
                        '<tr><th width="30%">Statut Commande</th><td>' + data.statut + '</td></tr>' +
                        '</table>' + 
                        '<h3 class="text-primary">Informations de Paiement</h3>'+
                        '<table class="text-capitalize table table-bordered table-sm table-hover table-striped">'+
                        '<tr><th width="30%">Nom</th><td>'+data.nom+'</td></tr>'+
                        '<tr><th width="30%">Prénom</th><td>' + data.prenom + '</td></tr>' +
                        '<tr><th width="30%">Société</th><td>' + data.societe + '</td></tr>' +
                        '<tr><th width="30%">Téléhpone</th><td>' + data.tel + '</td></tr>' +
                        '<tr><th width="30%">Email</th><td>' + data.email + '</td></tr>' +
                        '<tr><th width="30%">Adresse de livraison</th><td>' + data.address + '</td></tr>' +
                        '<tr><th width="30%">Total Commande</th><td>' + data.montant + ' TND </td></tr>' +
                        '</table>' +ligne,
                        confirmButtonText: 'Fermer',
                        confirmButtonColor: '#6c757d',
                    })
                    setTimeout(function(){
                        $('.swal2-popup.swal2-modal.swal2-show').width("1000px");
                    }, 10);	   
    	      	} 
    	    })
        }
    });
    
    
 
     

});


</script>