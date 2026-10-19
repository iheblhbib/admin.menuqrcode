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
      <h1>pack</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">pack</li>
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
                            		<h6 class="m-0 font-weight-bold ">Liste des pack</h6>
                            	</div>
                            	<div class="col" align="right">
                            	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                            		 <button type="button" name="add_pack" id="add_pack" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#packModal" ><i class="fal fa-plus"></i> Ajouter</button>
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
                                        <table class="table table-striped table-sm table-hover  DataTable" id="pack_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Libelle</th>
                                                    <th>Durée</th>
                                                    <th>Tarif</th>
                                                    <th>Statut</th>
                                                    <th width="5%">Actions</th> 
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade   archive-overview" id="archive-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover DataTable" id="pack_archive_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Libelle</th>
                                                    <th>Durée</th>
                                                    <th>Tarif</th>
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
   <!--modal-->
    <div class="modal fade" id="packModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="pack_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout pack </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-4 hiddenrow">
                                <label for="libelle" class="form-label">Libelle <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" id="libelle" class="form-control form-control-sm" required placeholder="Jucy"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="duree" class="form-label">Durée (N° Mois) <span class="text-danger">*</span></label>
                                <input type="text" name="duree" id="duree" required class="form-control form-control-sm"  placeholder="12"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div>
                            
                            <div class="col-md-4  ">
                                <label for="tarif" class="form-label">Type  <span class="text-danger">*</span></label>
                                <select name="type" id="type" required class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    <option value="m">Mois</option>
                                    <option value="j">Jours</option>
                                </select>
                            </div> 
                            
                            <div class="col-md-4  ">
                                <label for="tarif" class="form-label">Tarif  <span class="text-danger">*</span></label>
                                <input type="text" name="tarif" id="tarif" required class="form-control form-control-sm"  placeholder="500"   data-parsley-trigger="keyup">
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
  
	var dataTable = $('#pack_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"pack-action",
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
	var dataTable_archive = $('#pack_archive_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"pack-action",
			type:"POST",
			data:{action:'fetch2'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],
	});
 

	$('#add_pack').click(function(){
		
		$('#pack_form')[0].reset();

		$('#pack_form').parsley().reset();

    	$('#modal_title').text('Ajout pack');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#packModal').modal('show');

    	$('#form_message').html(''); 

	}); 

	$('#pack_form').parsley();

	$('#pack_form').on('submit', function(event){
		event.preventDefault();
		if($('#pack_form').parsley().isValid())
		{		
			$.ajax({
				url:"pack-action",
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
						$('#packModal').modal('hide');
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
		
		$('#pack_form')[0].reset();

		$('#pack_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"pack-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#libelle').val(data.libelle);
	        	
	        	$('#duree').val(data.duree); 
	        	
	        	$('#type').val(data.type); 
	        	
	        	$('#tarif').val(data.tarif);  

	        	$('#modal_title').text('Modifier pack');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#packModal').modal('show');

	        	$('#hidden_id').val(id);

	      	}

	    })

	});

	$(document).on('click', '.statut_button', function(){

    	var id = $(this).data('id');
        var status = $(this).data('status');
        var next_status = 'Activer';
        if(status == 'Activer')
        {
            next_status = 'Desactiver';
        }

        Swal.fire({
            title: 'Es-tu sûr?',
            text: "êtes-vous sûr de "+next_status+"!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Fermer',
            confirmButtonText: 'Oui, '+next_status+'!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"pack-action",
                    method:"POST",
                    data:{id:id, action:'statut', status:status, next_status:next_status},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'pack '+next_status+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>