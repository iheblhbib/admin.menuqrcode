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
        <h1>État Commande</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
                <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
                <li class="breadcrumb-item active">État Commande</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des état</h6>
                        	</div>
                        	<div class="col" align="right">
                        	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                        		 <button type="button" name="add_etat" id="add_etat" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#etatModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        	   <?php }?>
                        	</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  text-center" id="etat_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Libelle</th>
                                        <th>Couleur</th>
                                        <th>Visible</th>
                                        <th>Statut</th> 
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </main>
   <!--modal-->
    <div class="modal fade" id="etatModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  small">
            <form method="post" id="etat_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout etat </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row">
 
                            
                            <h5 class="text-primary">Informations</h5>

                            <div class="col-md-12 ">
                                <label for="libelle" class="form-label">Libelle <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" id="libelle" class="form-control form-control-sm" required  data-parsley-trigger="keyup">
                            </div>
                            
                            <div class="col-md-6 ">
                                <label for="visible" class="form-label">Visisble dans tous<span class="text-danger">*</span></label>
                                <select  name="visible" id="visible" class="form-control form-control-sm"   > 
                                    <option value="1">Oui</option>
                                    <option value="2">Non</option>     
                                </select>
                            </div> 
                            
                            <div class="col-md-6 ">
                                <label for="color" class="form-label">Couleur <span class="text-danger">*</span></label>
                                <select  name="color" id="color" class="form-control form-control-sm"   >
                                    <option value="">None</option>
                                    <option value="dark">Noir</option>
                                    <option value="primary">Bleu</option>    
                                    <option value="danger">Rouge</option>    
                                    <option value="success">Vert</option>    
                                    <option value="info">Blue Ciel</option>    
                                    <option value="warning">Jaune</option>    
                                    <option value="secondary">Gris</option>    
                                    <option value="bordeaux">Rouge Bordeaux</option>    
                                    <option value="orange">Orangé</option>    
                                    <option value="rose">Rose</option>    
                                    <option value="violet">Violet</option>    
                                    <option value="light">Blanc</option>    
                                </select>
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

$(".commandediv").removeClass('collapsed');
$(".commandeliste").addClass('show');

$(document).ready(function(){ 




	var dataTable = $('#etat_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"paging" : false,
		"order" : [],
		 "rowReorder": 
        {
            selector: 'td:nth-child(1)'
        },
		"ajax" : {
			url:"commande-etat-action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		], "drawCallback": function(settings) {  
                $('#etat_table td:nth-last-child(3)').attr('style', 'text-align:left !important;');
                $('#etat_table th:nth-last-child(3)').attr('style', 'text-align:left !important;');
            },
	});
	
    dataTable.on( 'row-reordered', function ( e, diff, edit ) {
        
        var id_table = new Array();
        var newpos = new Array();
        
        diff.forEach((item, index)=>{
            id_table.push($(item.oldData).data('id'));
            newpos.push(item.newPosition);
        });

        $.ajax({

            url:"commande-etat-action",

            method:"POST",

            data:{id_table:id_table,newpos:newpos, action :'update_order'},

            dataType:'JSON',

            success:function(data)
            {
                dataTable.ajax.reload();
                notificationSwal.fire({
                    icon: 'success',
                    title: 'Enregistré avec succès'
                });
            }
        })           
    });



	$('#add_etat').click(function(){
		
		$('#etat_form')[0].reset();

		$('#etat_form').parsley().reset();

    	$('#modal_title').text('Ajout etat');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#etatModal').modal('show');

    	$('#form_message').html(''); 

	});


	$('#etat_form').parsley();

	$('#etat_form').on('submit', function(event){
		event.preventDefault();
		if($('#etat_form').parsley().isValid())
		{		
			$.ajax({
				url:"commande-etat-action",
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
						$('#etatModal').modal('hide');
						dataTable.ajax.reload(); 
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
		
		$('#etat_form')[0].reset();

		$('#etat_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"commande-etat-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
	        	$('#libelle').val(data.libelle); 
	        	
	        	$('#color').val(data.color);  
	        	
	        	$('#visible').val(data.visible);  
	        	
	        	$('#modal_title').text('Modifier etat');

	        	$('#action').val('Edit');
 
	        	$('#submit_button').val('Modifier'); 
	        	
	        	$('#etatModal').modal('show');

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
                    url:"commande-etat-action",
                    method:"POST",
                    data:{id:id, action:'statut', status:status, next_status:next_status},
                    success:function(data){
                        dataTable.ajax.reload(); 
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'etat '+next_status+'!',
                        });
                    }
                });
            }
        });   
        
  	});





});


</script>