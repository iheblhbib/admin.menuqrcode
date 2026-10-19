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
      <h1>Moderateur</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Moderateur</li>
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
                            		<h6 class="m-0 font-weight-bold ">Liste des moderateur</h6>
                            	</div>
                            	<div class="col" align="right">
                            	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                            		 <button type="button" name="add_moderateur" id="add_moderateur" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#moderateurModal" ><i class="fal fa-plus"></i> Ajouter</button>
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
                                        <table class="table table-striped table-sm table-hover  DataTable" id="moderateur_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr> 
                                                    <th>Nom & Prénom</th>
                                                    <th>téléphone</th>
                                                    <th>Email</th>
                                                    <th>Pseudo</th>  
                                                    <th>Statut</th>
                                                    <th>Éditer</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade   archive-overview" id="archive-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover DataTable" id="moderateur_archive_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr> 
                                                    <th>Nom & Prénom</th>
                                                    <th>téléphone</th>
                                                    <th>Email</th>
                                                    <th>Pseudo</th>  
                                                    <th>Statut</th>
                                                    <th>Éditer</th>
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
    <div class="modal fade" id="moderateurModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="moderateur_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout moderateur </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>
 
                            <div class="col-md-4">
                                <label for="name" class="form-label">Nom & Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" required class="form-control form-control-sm"  placeholder="Nom & Prénom"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div>  

                            <div class="col-md-4">
                                <label for="num" class="form-label">Numéro mobile</label>
                                <input type="text" name="num" id="num" class="form-control form-control-sm"  placeholder="+216 22 222 222"  data-parsley-minlength="8" data-parsley-maxlength="13" data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-sm"  placeholder="Email"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <h5 class="text-primary">Information de connexion</h5>

                            <div class="col-md-4">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" name="pseudo" id="pseudo" class="form-control form-control-sm"  data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-sm"  placeholder="******"   data-parsley-minlength="8" data-parsley-maxlength="18" data-parsley-trigger="keyup">
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
  
	var dataTable = $('#moderateur_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"moderateur-action",
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
	var dataTable_archive = $('#moderateur_archive_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"moderateur-action",
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
 

	$('#add_moderateur').click(function(){
		
		$('#moderateur_form')[0].reset();

		$('#moderateur_form').parsley().reset();

    	$('#modal_title').text('Ajout moderateur');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#moderateurModal').modal('show');

    	$('#form_message').html('');
    	
    	$('.type').trigger("change");  

	});

 	$(".type").change(function(){
        
        if($("#part").is(":checked"))
        { 
            $('.hiddenrow').hide();
            
            $('#societe').val(null);

            $('#societe').prop('required',false);

            $('#name').prop('required',true);
            
        }else
        {
             $('.hiddenrow').show();

             $('#societe').prop('required',true);

             $('#name').prop('required',true);
        }
    });

	$('#moderateur_form').parsley();

	$('#moderateur_form').on('submit', function(event){
		event.preventDefault();
		if($('#moderateur_form').parsley().isValid())
		{		
			$.ajax({
				url:"moderateur-action",
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
						$('#moderateurModal').modal('hide');
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
		
		$('#moderateur_form')[0].reset();

		$('#moderateur_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"moderateur-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#name').val(data.name); 
	        	
	        	$('#email').val(data.email);  
                
                $('#num').val(data.num);
                
                $('#pseudo').val(data.pseudo); 

	        	$('#modal_title').text('Modifier moderateur');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#moderateurModal').modal('show');

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
                    url:"moderateur-action",
                    method:"POST",
                    data:{id:id, action:'statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'moderateur '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>