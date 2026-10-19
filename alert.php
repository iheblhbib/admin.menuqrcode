<?php 
    
    include ('header.php');
?>
<style>
    .form-control {
        margin-bottom: 10px;
    }
    .ql-editor, .ql-container {
    height: max-content !important;
}
</style>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Alert</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Alert</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des alert</h6>
                        	</div>
                        	<div class="col" align="right">
                        	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                        		 <button type="button" name="add_alert" id="add_alert" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#alertModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        	   <?php }?>
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
                                        <table class="table table-striped table-sm table-hover  DataTable" id="alert_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Message</th>
                                                    <th>Début</th> 
                                                    <th>Fin</th> 
                                                    <th>Ajouté Par</th>
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
                                        <table class="table table-striped table-sm table-hover DataTable" id="alert_archive_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Message</th>
                                                    <th>Début</th> 
                                                    <th>Fin</th> 
                                                    <th>Ajouté Par</th>
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
    <div class="modal fade" id="alertModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="alert_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout alert </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"  style="height: max-content;">
                        <span id="form_texte"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-4  ">
                                <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                <select name="client" id="client" class="form-control form-control-sm" required  data-parsley-trigger="keyup">
                                    <option value="" selected disabled >Choisissez</option>
                                    <?= $object->get_clients_select(); ?>
                                </select>
                            </div>  

                            <div class="col-md-4  ">
                                <label for="forced" class="form-label">Forcé <span class="text-danger">*</span></label>
                                <select name="forced" id="forced" class="form-control form-control-sm" required  data-parsley-trigger="keyup">
                                    <option value="1"  >Non</option> 
                                    <option value="2"  >Oui</option> 
                                </select>
                            </div>  
                             
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <h5 class="text-primary">Durée</h5>
                            
                            <div class="col-md-4">
                                <label for="debut" class="form-label">Début<span class="text-danger">*</span></label>
                                <input type="datetime-local" step="1" name="debut" id="debut" required class="form-control form-control-sm"  data-parsley-trigger="keyup">
                            </div>
                            
                            <div class="col-md-4  ">
                                <label for="fin" class="form-label">Fin  <span class="text-danger">*</span></label>
                                <input type="datetime-local" step="1" name="fin" id="fin" required class="form-control form-control-sm"    data-parsley-trigger="keyup">
                            </div> 
                            
                            <div class="col-md-12">
                                <hr>
                            </div>
                            
                            <h5 class="text-primary">Message</h5>
                            
                            <div class="col-md-12" >
                                <label for="texte" class="form-label">Texte </label>
                                <div class="zone-texte">
                                </div>
                                <textarea name="texte" id="texte" style='display:none'></textarea> 
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

    var texte = new Quill('.zone-texte' , {
          modules: {
            toolbar: [
              [{
                font: []
              }, {
                size: []
              }],
              ["bold", "italic", "underline", "strike"],
              [{
                  color: []
                },
                {
                  background: []
                }
              ],
              [{
                  script: "super"
                },
                {
                  script: "sub"
                }
              ],
              [{
                  list: "ordered"
                },
                {
                  list: "bullet"
                },
                {
                  indent: "-1"
                },
                {
                  indent: "+1"
                }
              ],
              ["direction", {
                align: []
              }],
              ["link", "image", "video"],
              ["clean"]
            ]
          },
          theme: "snow"
        });
 

$(document).ready(function(){ 
  
	var dataTable = $('#alert_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"alert-action",
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
	var dataTable_archive = $('#alert_archive_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"alert-action",
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
 

	$('#add_alert').click(function(){
		
		$('#alert_form')[0].reset();

		$('#alert_form').parsley().reset();

    	$('#modal_title').text('Ajout alert');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#alertModal').modal('show');

    	$('#form_texte').html('');  
    	 
        texte.setContents([{ insert: '\n' }]);

	}); 

	$('#alert_form').parsley();

	$('#alert_form').on('submit', function(event){
		event.preventDefault();
		if($('#alert_form').parsley().isValid())
		{		
		    var editor_content = texte.container.innerHTML
            $('#texte').val($(editor_content).html());
            
			$.ajax({
				url:"alert-action",
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
						$('#form_texte').html(data.error);
						$('#submit_button').val('Ajouter');
					}
					else
					{
						$('#alertModal').modal('hide');
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
		
		$('#alert_form')[0].reset();

		$('#alert_form').parsley().reset();

		$('#form_texte').html(''); 
		
		texte.setContents([{ insert: '\n' }]);
        
		$.ajax({

	      	url:"alert-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	
	        	$('#client').val(data.client);
	        	
	        	$('#debut').val(data.debut); 
	        	
	        	$('#fin').val(data.fin);  
	        	
                $('#forced').val(data.forced);
	        	
                $('#texte').val(data.texte);
	        	
	        	const value = data.texte;
                const delta = texte.clipboard.convert(value)
                
                texte.setContents(delta, 'silent') 
 
	        	$('#modal_title').text('Modifier alert');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#alertModal').modal('show');

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
                    url:"alert-action",
                    method:"POST",
                    data:{id:id, action:'statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'alert '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>