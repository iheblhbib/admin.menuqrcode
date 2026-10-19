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
      <h1>Paiements</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Paiements</li>
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
                        	<div class="col" align="right">
                        	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                        		 <button type="button" name="add_paiement" id="add_paiement" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#paiementModal" ><i class="fal fa-plus"></i> Ajouter</button>
                        	   <?php }?>
                        	</div>
                        </div>
                    </div>
                    <div class="card-body">  
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  DataTable" id="paiement_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client</<h> 
                                        <th>Markets</<h> 
                                        <th>Pack</th> 
                                        <th>Remise</th> 
                                        <th>Montant</th>  
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
 
    <div class="modal fade" id="paiementModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg small">
            <form method="post" id="paiement_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout paiement </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                            
                            <h5 class="text-primary">Informations Client</h5>

                            <div class="col-md-4  ">
                                <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm selectpicker"  name="client" id="client"  required  data-parsley-trigger="keyup" data-live-search="true" title="Sélectionnez un client" data-size="5" >
                                    <?= $object->get_gestionnaires_select(); ?>
                                </select>
                            </div> 
                            
                            <div class="col-md-4">
                                <label for="market" class="form-label">Market <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm selectpicker updateMontant" id="market" name="market[]" required multiple data-parsley-trigger="keyup" data-live-search="true" title="Sélectionnez les market" data-size="5" >
                                   
                                </select>
                            </div> 
                            <div class="col-md-12">
                                <hr>
                            </div> 
                            <h5 class="text-primary">Informations Pack</h5>
                            
                            <div class="col-md-4  ">
                                <label for="pack" class="form-label">Pack <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm selectpicker updateMontant"  name="pack" id="pack"  required  data-parsley-trigger="keyup" data-live-search="true" title="Sélectionnez un pack" data-size="5" >
                                    <?= $object->get_pack_select(); ?>
                                </select>
                            </div> 
                            
                            <div class="col-md-4  ">
                                <label for="montantPack" class="form-label">Montant Pack </label>
                                <input disabled class="form-control form-control-sm  "  name="montantPack" id="montantPack"     data-parsley-trigger="keyup"/> 
                                <input type="hidden" class="form-control form-control-sm  "  name="pack_montant" id="pack_montant"     data-parsley-trigger="keyup"/> 
                            </div> 
                            
                            <div class="col-md-4  ">
                                <label for="pack_duree" class="form-label">Durée Pack</label>
                                <input disabled class="form-control form-control-sm  "  name="pack_duree" id="pack_duree"     data-parsley-trigger="keyup"/> 
                            </div> 
                            
                            <div class="col-md-12">
                                <hr>
                            </div> 
                            <h5 class="text-primary">Informations Paiement</h5>
                            
                            <div class="col-md-3 ">
                                <label for="type_remise" class="form-label">Type Remise  </label>
                                <select   class="form-control form-control-sm  updateMontant"  name="type_remise" id="type_remise"     data-parsley-trigger="keyup" > 
                                    <option value="1">Pourcentage</option>
                                    <option value="2">Montant</option>
                                </select>
                            </div> 
                            
                            <div class="col-md-3 ">
                                <label for="remise" class="form-label">Remise  </label>
                                <input   class="form-control form-control-sm  updateMontant"  name="remise" id="remise"   value="0"  data-parsley-trigger="keyup"/>  
                            </div> 
                            
                            <div class="col-md-3  ">
                                <label for="montantShowen" class="form-label">Total  </label>
                                <input disabled class="form-control form-control-sm  "  name="montantShowen" id="montantShowen"     data-parsley-trigger="keyup"/> 
                                <input type="hidden" class="form-control form-control-sm  "  name="montant" id="montant"     data-parsley-trigger="keyup"/> 
                            </div> 
                            
                            <div class="col-md-3  ">
                                <label for="date" class="form-label">Date  </label>
                                <input type="date" class="form-control form-control-sm  " value="<?= date('Y-m-d'); ?>"  name="date" id="date"     data-parsley-trigger="keyup"/>  
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
    
    $(document).on('change','#client',function(){
        
        var id = $(this).val();
       
        $.ajax({
            
            url:"api/market.php",
            
            method:"POST",
            
            data : {id:id},
            
            dataType:'json',
            
            success:function(data)
            {
                var all_cat = JSON.parse(JSON.stringify(data));
                var html = '';
                
                    $.each(all_cat, function( index, value ) { 

                        html +=  '<option value="'+value.id+'" selected>'+value.market+'</option>';
                }); 

                
                $('#market').empty();
                $('#market').append($.parseHTML(html));
                $('#market').selectpicker('refresh'); 
                $('#market').trigger('change');					
            }
        })
    });
    
    $(document).on('change','.updateMontant',function(){
        var id =   $("#pack").val();
        var tarif=   $("#pack option:selected").data("tarif");
        var duree=   $("#pack option:selected").data("duree");
        var type=    ($("#pack option:selected").data("type") == 'm') ? ' Mois' : ' Jours';
        
        if(id){
            $('#montantPack').val(tarif);
            $('#pack_montant').val(tarif);
            $('#pack_duree').val(duree + type);
            
            
            var markets = $('#market option:selected').length;
            
            markets = (markets) ? markets : 0 ;
            
            var remise = $('#remise').val();
            
            remise = (remise) ? remise : 0 ;
            
            var type_remise = $('#type_remise').val();
            
            if(type_remise == '1'){
                var total = (markets * tarif) ; 
                total -= (total * remise)/100  ;
            }else{
                var total = (markets * tarif) - remise ; 
            }
              
            $('#montantShowen').val(total);
            $('#montant').val(total);
        }
    });
  
	var dataTable = $('#paiement_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"paiement-action",
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
 
 

	$('#add_paiement').click(function(){
		
		$('#paiement_form')[0].reset();

		$('#paiement_form').parsley().reset();

    	$('#modal_title').text('Ajout paiement');

    	$('#action').val('Add');

    	$('#submit_button').val('Ajouter');

    	$('#paiementModal').modal('show');

    	$('.selectpicker').selectpicker('refresh');  

	}); 

	$('#paiement_form').parsley();

	$('#paiement_form').on('submit', function(event){
		event.preventDefault();
		if($('#paiement_form').parsley().isValid())
		{		
			$.ajax({
				url:"paiement-action",
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
						$('#paiementModal').modal('hide');
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
		
		$('#paiement_form')[0].reset();

		$('#paiement_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"paiement-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{  
	        	$('#date').val(data.date);
	        	
	        	$('#client').val(data.client).trigger('change');  
	        	
	        	$('#pack').val(data.pack);  
	        	
	        	$('#pack_montant').val(data.pack_montant);  
	        	
	        	$('#montant').val(data.montant);   
	        	
	        	$('#remise').val(data.remise);  
	        	
                $('#market').val(data.market).trigger('change'); 
	        	
	        	$('#type_remise').val(data.type_remise);  
	        	
	        	$('.updateMontant').trigger('change');
	        	
	        	$('.selectpicker').selectpicker('refresh');  
	        	
	        	$('#pack_montant').val(data.pack_montant);  
	        	
	        	$('#montant').val(data.montant);   
	        	
	        	$('#montantShowen').val(data.montant);
	        	
	        	$('#montantPack').val(data.pack_montant); 
	        	  
	        	$('#modal_title').text('Modifier paiement');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').val('Modifier'); 

	        	$('#paiementModal').modal('show');

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
                    url:"paiement-action",
                    method:"POST",
                    data:{id:id, action:'change_statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'paiement '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
 

});
 
</script>