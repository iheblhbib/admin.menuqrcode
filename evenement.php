<?php 
    
    include ('header.php'); 
?>
<style>
    .table {
        white-space: initial;
    }
    
    .ql-editor, .ql-container {
        height: max-content !important;
    }
</style>
<main id="main" class="main">
      <div class="pagetitle">
      <h1>Événements</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li> 
          <li class="breadcrumb-item active">Événements</li>
        </ol>
      </nav>
    </div> 
     
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                 <div class="card shadow mb-4 small">
                    <div class="card-header py-3">
                    	<div class="row">
                        	<div class="col">
                        		<h6 class="m-0 font-weight-bold ">Liste des événements</h6>
                        	</div> 
                    		<div class="col" align="right"> 
                        		    <button type="button" name="add_evenement" id="add_evenement" class="btn btn-primary  btn-sm"><i class="fas fa-plus"></i> Ajouter</button>
                         
                        	</div>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <ul class="nav nav-tabs nav-tabs-bordered"> 
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#actif-overview"><i class="fal fa-user-check"></i> Actif</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#archive-overview"><i class="fal fa-archive"></i> Archive</button>
                            </li> 
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active actif-overview" id="actif-overview">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-hover  DataTable" id="evenement_table" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr> 	
                                                <th>Image</th> 
                                                <th>Titre</th> 
                                                <th  width="50%">Texte</th> 
                                                <th>Date Début </th>
                                                <th>Date Fin </th> 
                                                <th>Statut</th>          
                                                <th width="5%">Actions</th> 
                                            </tr>
                                        </thead>
                                        <tbody >
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade  archive-overview" id="archive-overview">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-hover  DataTable" id="evenement_table2" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr> 	
                                                <th>Image</th> 
                                                <th>Titre</th> 
                                                <th  width="50%">Texte</th> 
                                                <th>Date Début </th>
                                                <th>Date Fin </th> 
                                                <th>Statut</th>          
                                                <th width="5%">Actions</th> 
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
            </div>
        </div>
    </section>
 
</main>
 
<?php
include('footer.php');
?> 
    <div class="modal fade" id="evenementModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg small">
            <form method="post" id="evenement_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout Événement </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: max-content;">
                        <span id="form_message"></span>

                        <div class="row"> 
                        
                          <div class="col-md-12 ">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control form-control-sm files"   data-parsley-trigger="keyup">
                                <span id="image_uploaded_image"></span>   
                            </div>  

                            <div class="col-md-12 ">
                                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" name="titre" id="titre" class="form-control form-control-sm" required placeholder="titre"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div>   
                            
                             <div class="col-md-6 ">
                                <label for="debut" class="form-label">Date Début <span class="text-danger">*</span></label>
                                <input type="datetime-local" step="1" name="debut" id="debut" class="form-control form-control-sm" required   data-parsley-trigger="keyup">
                            </div> 
                            
                             <div class="col-md-6 ">
                                <label for="fin" class="form-label">Date Fin <span class="text-danger">*</span></label>
                                <input type="datetime-local" step="1" name="fin" id="fin" class="form-control form-control-sm" required   data-parsley-trigger="keyup">
                            </div> 
  
                            
                             <div class="col-md-12" >
                                <label for="texte" class="form-label">Texte </label> 
                                <textarea name="texte" id="texte" class="form-control form-control-sm" rows="3"></textarea> 
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

<script>

$('.selectpicker').selectpicker();
 
    
$(document).ready(function(){ 
  
	var dataTable = $('#evenement_table').DataTable({
	       "language": {
        url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        }, 
		"processing" : true,
		"serverSide" : true, 
    	"rowReorder": 
    	{
            selector: 'td:nth-child(1)'
        },
		"order" : [],
		"ajax" : {
			url:"evenement-action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],    	"drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
	});
  
	var dataTable2 = $('#evenement_table2').DataTable({
	       "language": {
        url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        }, 
		"processing" : true,
		"serverSide" : true,  
		"order" : [],
		"ajax" : {
			url:"evenement-action",
			type:"POST",
			data:{action:'fetch2'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],    	"drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
	});
	
	
 

	$('#add_evenement').click(function(){
		
		$('#evenement_form')[0].reset();

		$('#evenement_form').parsley().reset();

    	$('#modal_title').text('Ajout Événement');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#evenementModal').modal('show');

    	$('#form_message').html('');
    	
    	$('#image').attr('required',true);  

        $('#image_uploaded_image').html(''); 

	});

    $('#image').change(function(){
        var extension = $('#image')
                        .val()
                        .split('.')
                        .pop()
                        .toLowerCase();
                        
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','webp']) == -1)
            { 
                $('#div_notification').html("Fichier image non valide");
						
      	        show_notifcation();
                $('#image').val('');
                return false;
            }
        }
    });
  

	$('#evenement_form').parsley();

	$('#evenement_form').on('submit', function(event){
		event.preventDefault();
		if($('#evenement_form').parsley().isValid())
		{		
		     
			$.ajax({
				url:"evenement-action",
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
						$('#submit_button').val('Add');
					}
					else
					{
						$('#evenementModal').modal('hide');
						notificationSwal.fire({
                            icon: 'success',
                            title: data.data,
                        });

						$('.dataTable').DataTable().ajax.reload();
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var id = $(this).data('id');
		
		$('#evenement_form')[0].reset();

		$('#evenement_form').parsley().reset();

		$('#form_message').html(''); 

		$.ajax({

	      	url:"evenement-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{   
	        	$('#debut').val(data.debut);

                $('#fin').val(data.fin); 

	        	$('#titre').val(data.titre);  
                
                $('#texte').val(data.texte);  
                
                $('#image').attr('required',false);  
                
                $('#image_uploaded_image').html('<img src="'+data.image+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_image" value="'+data.image+'" />');

	        	$('#modal_title').text('Modifier Événement');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Modifier');

	        	$('#evenementModal').modal('show');

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
            		url:"evenement-action",
    
            		method:"POST",
    
            		data:{id:id, action:'change_statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'Événement '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
	
 
});
</script>