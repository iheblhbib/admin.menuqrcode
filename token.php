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
      <h1>API Token</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">API Token</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des API Token</h6>
                        	</div>
                        	<div class="col" align="right"> 
                        		 <button type="button" name="add_token" id="add_token" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#tokenModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        
                        	</div>
                        </div>
                    </div>
                    <div class="card-body">  
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  DataTable" id="token_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>API Token</th>
                                        <th>Expiration</th> 
                                        <th>Taille</th> 
                						<th width="10%">Statut</th>
                                        <th width="10%">Action</th>
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
 
    <div class="modal fade" id="tokenModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="token_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout API Token </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-12">
                                <label for="token" class="form-label">API Token</label>
                                <input type="text" name="token" id="token" class="form-control form-control-sm" required  readonly data-parsley-trigger="keyup">
                            </div> 
                            
                          <div class="col-md-12 text-right" >  
                                <button class="btn-sm btn btn-dark " type="button" id="generate">Générer Code</button>
                            </div>  
                            
                            <div class="col-md-4">
                                <label for="taille" class="form-label">Taille</label>
                                <input type="number" name="taille" id="taille" required class="form-control form-control-sm"   data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="expiration" class="form-label">Expiration</label>
                                <input type="date" name="expiration" id="expiration" required class="form-control form-control-sm"   data-parsley-trigger="keyup">
                            </div> 

                        </div>                        
                    </div>
                    <div class="modal-footer">
                      	<input type="hidden" name="hidden_id" id="hidden_id" />
              			<input type="hidden" name="action" id="action" value="Add" />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			<input type="submit" name="submit" id="submit_button" class="btn btn-sm  btn-primary" value="Add" />
              			
                    </div>
                  </div>
            </form>
        </div>
    </div>  



  
  <!-- End #main -->
    <?php
        include ('footer.php');
      ?>
      
<script>

function generateApiKey(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let apiKey = '';

    for (let i = 0; i < length; i++) {
        apiKey += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    $('#token').val(apiKey);
}
 

$(document).ready(function(){ 
    
  	$(document).on('click','#generate',function() { 
  	    var taille = $('#taille').val();
        generateApiKey(taille);
    });
  
	var dataTable = $('#token_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"token-action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],
	});
 
 

	$('#add_token').click(function(){
		
		$('#token_form')[0].reset();

		$('#token_form').parsley().reset();

    	$('#modal_title').text('Ajout token');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#tokenModal').modal('show');
    	
    	$('#taille').val(32);

    	$('#form_message').html(''); 

	}); 

	$('#token_form').parsley();

	$('#token_form').on('submit', function(event){
		event.preventDefault();
		if($('#token_form').parsley().isValid())
		{		
			$.ajax({
				url:"token-action",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
                contentType:false,
                processData:false, 
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Ajouter');
					}
					else
					{
						$('#tokenModal').modal('hide');
						$('.DataTable').DataTable().ajax.reload(); 
                        notificationSwal.fire({
                            icon: 'success',
                            title: data.success,
                        });
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var id = $(this).data('id');
		
		$('#token_form')[0].reset();

		$('#token_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"token-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#taille').val(data.taille);
	        	
	        	$('#token').val(data.token);
	        	
	        	$('#expiration').val(data.expiration);  

	        	$('#modal_title').text('Modifier token');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#tokenModal').modal('show');

	        	$('#hidden_id').val(id);

	      	}

	    })

	});

	$(document).on('click', '.statut_button', function(){

    	var id = $(this).data('id');
        var statut = $(this).data('statut');
        var next_statut = 'Activer';
        if(statut == 'Activer')
        {
            next_statut = 'Desactiver';
        }

        Swal.fire({
            title: 'Es-tu sûr?',
            text: "êtes-vous sûr de "+next_statut+"!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Fermer',
            confirmButtonText: 'Oui, '+next_statut+'!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"token-action",
                    method:"POST",
                    data:{id:id, action:'change_statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'API Token '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>