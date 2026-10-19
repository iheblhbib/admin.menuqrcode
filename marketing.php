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
      <h1>Galerie</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li> 
          <li class="breadcrumb-item active">Galerie</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des Galerie</h6>
                        	</div> 
                    		<div class="col" align="right"> 
                        		    <button type="button" name="add_marketing" id="add_marketing" class="btn btn-primary  btn-sm"><i class="fas fa-plus"></i> Ajouter</button>
                         
                        	</div>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <ul class="nav nav-tabs nav-tabs-bordered"> 
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#actif-overview"><i class="fal fa-check"></i> Actif</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#archive-overview"><i class="fal fa-archive"></i> Archive</button>
                            </li> 
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active actif-overview" id="actif-overview">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-hover  DataTable" id="marketing_table" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr> 	
                                                <th>Titre</th> 
                                                <th>Fichier</th>  
                                                <th>Statut</th>           
                                            </tr>
                                        </thead>
                                        <tbody >
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade  archive-overview" id="archive-overview">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-hover  DataTable" id="marketing_table_archive" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr> 	
                                                <th>Titre</th> 
                                                <th>Fichier</th>  
                                                <th>Statut</th> 
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
    <div class="modal fade" id="marketingModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg small">
            <form method="post" id="marketing_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout Fichier </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: max-content;">
                        <span id="form_message"></span>

                        <div class="row"> 
                        
                          <div class="col-md-12 ">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" name="titre" id="titre" class="form-control form-control-sm files"   data-parsley-trigger="keyup"> 
                            </div>  
                          <div class="col-md-12 ">
                                <label for="file" class="form-label">Fichier</label>
                                <input type="file" name="file" id="file" class="form-control form-control-sm files"   data-parsley-trigger="keyup"> 
                            </div>  
                            
                        </div>                        
                    </div>
                    <div class="modal-footer">    
                      	<input type="hidden" name="hidden_id" id="hidden_id" />
              			<input type="hidden" name="action" id="action" value="Add" />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			<button type="submit" name="submit" id="submit_button" class="btn btn-sm  btn-primary" >Add</button> 
              			
                    </div>
                  </div>
            </form>
        </div>
    </div>  

<script> 
 
    
$(document).ready(function(){ 
  
	var dataTable = $('#marketing_table').DataTable({
	    "language": { url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' }, 
		"processing" : true,
		"serverSide" : true,  
		"order" : [],
		"ajax" : {
			url:"marketing-action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		], "drawCallback": function(settings) {
            var lightbox = GLightbox({
              selector: '.glightbox'
            });
		}
	});
  
	var dataTable_archive = $('#marketing_table_archive').DataTable({
	    "language": { url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' }, 
		"processing" : true,
		"serverSide" : true,  
		"order" : [],
		"ajax" : {
			url:"marketing-action",
			type:"POST",
			data:{action:'fetch_archive'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		], "drawCallback": function(settings) {
            var lightbox = GLightbox({
              selector: '.glightbox'
            });
		}
	});
	
	
 

	$('#add_marketing').click(function(){
		
		$('#marketing_form')[0].reset();

		$('#marketing_form').parsley().reset();

    	$('#modal_title').text('Ajout Galerie');

    	$('#action').val('Add');

    	$('#submit_button').html('Ajouter');

    	$('#marketingModal').modal('show');

    	$('#form_message').html('');    

	});

    // $('#image').change(function(){
    //     var extension = $('#image')
    //                     .val()
    //                     .split('.')
    //                     .pop()
    //                     .toLowerCase();
                        
    //     if(extension != '')
    //     {
    //         if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','webp']) == -1)
    //         { 
    //             $('#div_notification').html("Fichier image non valide");
						
    //   	        show_notifcation();
    //             $('#image').val('');
    //             return false;
    //         }
    //     }
    // });
  

	$('#marketing_form').parsley();

	$('#marketing_form').on('submit', function(event){
		event.preventDefault();
		if($('#marketing_form').parsley().isValid())
		{		
		     
			$.ajax({
				url:"marketing-action",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
                contentType:false,
                processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').html('<i class="fa-duotone fa-spinner fa-spin-pulse"></i>');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').html('Add');
					}
					else
					{
						$('#marketingModal').modal('hide');
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
            		url:"marketing-action",
    
            		method:"POST",
    
            		data:{id:id, action:'change_statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'Fichier '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
	
 
});
</script>