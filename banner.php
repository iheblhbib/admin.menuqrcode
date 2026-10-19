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
      <h1>Banner</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Banner</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des banner</h6>
                        	</div>
                        	<div class="col" align="right">
                        	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                        		 <button type="button" name="add_banner" id="add_banner" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#bannerModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        	   <?php }?>
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
                                        <table class="table table-striped table-sm table-hover  DataTable" id="banner_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Banner</th>
                                                    <th>Market</th>
                                                    <th>Tarif</th>
                                                    <th>Début</th> 
                                                    <th>Fin</th> 
                                                    <th>Statut</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade   archive-overview" id="archive-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover DataTable" id="banner_archive_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Banner</th>
                                                    <th>Market</th>
                                                    <th>Tarif</th>
                                                    <th>Début</th> 
                                                    <th>Fin</th> 
                                                    <th>Statut</th>
                                                    <th>Action</th>
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
   <!--modal-->
    <div class="modal fade" id="bannerModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="banner_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout banner </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-4  ">
                                <label for="market" class="form-label">Market <span class="text-danger">*</span></label>
                                <select name="market" id="market" class="form-control form-control-sm" required  data-parsley-trigger="keyup">
                                    <?= $object->get_markets(); ?>
                                </select>
                            </div> 

                            <div class="col-md-4  ">
                                <label for="montant" class="form-label">Montant </label>
                                <input type="text" name="montant" id="montant" class="form-control form-control-sm"   placeholder="500"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                             
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <h5 class="text-primary">Durée</h5>
                            
                            <div class="col-md-4">
                                <label for="debut" class="form-label">Début<span class="text-danger">*</span></label>
                                <input type="date" name="debut" id="debut" required class="form-control form-control-sm"  placeholder="12"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div>
                            
                            <div class="col-md-4  ">
                                <label for="fin" class="form-label">Fin  <span class="text-danger">*</span></label>
                                <input type="date" name="fin" id="fin" required class="form-control form-control-sm"  placeholder="500"   data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-12">
                                <hr>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="banner" class="form-label">Photo</label>
                                <input class="form-control form-control-sm" type="file" name="banner" id="banner">
                                 <span id="banner_uploaded_image"></span>
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
 

$(document).ready(function(){ 
  
	var dataTable = $('#banner_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"banner-action",
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
	var dataTable_archive = $('#banner_archive_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"banner-action",
			type:"POST",
			data:{action:'fetch2'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],  "drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
	});
 

	$('#add_banner').click(function(){
		
		$('#banner_form')[0].reset();

		$('#banner_form').parsley().reset();

    	$('#modal_title').text('Ajout banner');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#bannerModal').modal('show');

    	$('#form_message').html(''); 
    	
        $('#banner_uploaded_image').html('');

	}); 

	$('#banner_form').parsley();

	$('#banner_form').on('submit', function(event){
		event.preventDefault();
		if($('#banner_form').parsley().isValid())
		{		
			$.ajax({
				url:"banner-action",
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
						$('#bannerModal').modal('hide');
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
		
		$('#banner_form')[0].reset();

		$('#banner_form').parsley().reset();

		$('#form_message').html('');
		
        $('#banner_uploaded_image').html('');
        
		$.ajax({

	      	url:"banner-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#market').val(data.market);
	        	
	        	$('#debut').val(data.debut); 
	        	
	        	$('#fin').val(data.fin);  
	        	
	        	$('#montant').val(data.montant);  
	        	
	        	$('#banner_uploaded_image').html('<img src="'+data.img+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_banner_image" value="'+data.banner+'" />');
 
	        	$('#modal_title').text('Modifier banner');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#bannerModal').modal('show');

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
                    url:"banner-action",
                    method:"POST",
                    data:{id:id, action:'statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'banner '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>