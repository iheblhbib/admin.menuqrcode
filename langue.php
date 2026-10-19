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
      <h1>Langue</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Langue</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des langue</h6>
                        	</div>
                        	<div class="col" align="right">
                        	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                        		 <button type="button" name="add_langue" id="add_langue" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#langueModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        	   <?php }?>
                        	</div>
                        </div>
                    </div>
                    <div class="card-body">  
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  DataTable" id="langue_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>Drapeau</th>
                                        <th>Langue</th>
                                        <th>Code</th> 
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
 
    <div class="modal fade" id="langueModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="langue_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout langue </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-4 hiddenrow">
                                <label for="libelle" class="form-label">Libelle <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" id="libelle" class="form-control form-control-sm" required placeholder="français"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 

                            <div class="col-md-4 hiddenrow">
                                <label for="drapeau" class="form-label">Drapeau <span class="text-danger">*</span></label>
                                <input type="text" name="drapeau" id="drapeau" class="form-control form-control-sm" required placeholder="drapeau"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="code" class="form-label">Code<span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" required class="form-control form-control-sm"  placeholder="fr"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
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
  
	var dataTable = $('#langue_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"langue-action",
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
 
 

	$('#add_langue').click(function(){
		
		$('#langue_form')[0].reset();

		$('#langue_form').parsley().reset();

    	$('#modal_title').text('Ajout langue');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#langueModal').modal('show');

    	$('#form_message').html(''); 

	}); 

	$('#langue_form').parsley();

	$('#langue_form').on('submit', function(event){
		event.preventDefault();
		if($('#langue_form').parsley().isValid())
		{		
			$.ajax({
				url:"langue-action",
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
						$('#langueModal').modal('hide');
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
		
		$('#langue_form')[0].reset();

		$('#langue_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"langue-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#drapeau').val(data.drapeau);
	        	
	        	$('#libelle').val(data.libelle);
	        	
	        	$('#code').val(data.code);  

	        	$('#modal_title').text('Modifier langue');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#langueModal').modal('show');

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
                    url:"langue-action",
                    method:"POST",
                    data:{id:id, action:'change_statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'langue '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>