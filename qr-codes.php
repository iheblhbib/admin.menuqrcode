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
      <h1>Liste QR Code</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>  
          <li class="breadcrumb-item active">Liste QR Code</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des QR Code</h6>
                        	</div> 
                        	
                        	<div class="col" align="right"> 
                        		 <button type="button" name="add_button" id="add_button" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#addModal" ><i class="fal fa-plus"></i> Ajouter</button> 
                        	</div>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <ul class="nav nav-tabs nav-tabs-bordered" id="myTab" role="tablist">
                             
                                <?php 
                                    $display = 'active ';
                                    $selected = 'true' ;
                                    $object->query="SELECT * FROM user WHERE pro = '1' and statut = 'Activer'";
                                    $result = $object->get_result();
                                    foreach($result as $row){ 
                                        
                                ?> 
                                    <li class="nav-item" role="presentation">
                                        <button  class="nav-link <?= $display ?> " data-id="<?= $row['id'] ?>" data-table="dataTable<?= $row['id'] ?>"  id="tab<?= $row['id'] ?>-tab" data-bs-toggle="tab" data-bs-target="#tab<?= $row['id'] ?>tab" type="button" role="tab" aria-controls="tab<?= $row['id'] ?>" aria-selected="<?= $selected ?>" >
                                            <?= ucwords($row['societe']) ?> 
                                        </button>
                                    </li>
                                <?php 
                                $display = ''; 
                                $selected = '';
                                } ?> 
 
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <?php 
                                $display = 'show active '; 
                                $object->query="SELECT * FROM user WHERE pro = '1' and statut = 'Activer'";
                                $result = $object->get_result();
                                foreach($result as $row){  
                            ?> 
                                <div class="tab-pane fade <?= $display ?>"  id="tab<?= $row['id'] ?>tab" role="tabpanel" aria-labelledby="tab<?= $row['id'] ?>-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover  DataTable" id="qrcode-table-<?= $row['id'] ?>" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    <th>Libelle</th>	
                                                    <th>Lien</th>	
                                                    <th>Menu</th>	
                                                    <th>QR Code</th>	
                                                    <th>Point de vente</th>	
                                                    <th>N° Accès</th> 
                                                    <th>Statut</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php 
                                $display = '';  
                            } 
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main> 

    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  ">
            <form method="post" id="add_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout QR Code </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 
                             
                            <div class="col-md-12">
                                <label for="gestionnaire" class="form-label">Employé  </label>
                                 <select type="text" name="gestionnaire" id="gestionnaire" class="form-control form-control-sm selectpicker" required data-live-search="true" title="Sélectionnez un employé">
                                     <?php  
                                        $object->query="SELECT * FROM user WHERE pro = '1' and statut = 'Activer'";
                                        $result = $object->get_result();
                                        foreach($result as $row){  
                                    ?> 
                                    <option value="<?= $row['id'] ?>"><?= $row['societe'] ?></option>
                                      <?php } ?>
                                </select>
                            </div>   
                            
                            <div class="col-md-12">
                                <label for="libelle" class="form-label">Libelle <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" id="libelle" class="form-control form-control-sm" required  data-parsley-trigger="keyup"  >
                            </div> 
                            
                            <div class="col-md-12">
                                <label for="link" class="form-label">Lien <span class="text-danger">*</span></label>
                                <input type="url" name="link" id="link" class="form-control form-control-sm" required  data-parsley-trigger="keyup"  >
                            </div> 
                             

                        </div>                        
                    </div>
                    <div class="modal-footer">
                      	<input type="hidden" name="hidden_id" id="hidden_id" />
              			<input type="hidden" name="action" id="action" value="Add" />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			<button type="submit" name="submit" id="submit_button" class="btn btn-sm  btn-primary" >>Add</button>
              			
                    </div>
                  </div>
            </form>
        </div>
    </div>  

    <div class="modal fade" id="menuModal"  >
        <div class="modal-dialog   small"> 
              <div class="modal-content" id="menuModalContent">
      		</div> 
      	</div>
    </div>

<?php include ('footer.php'); ?>
      
<script>
 

$(document).ready(function(){
    
	$('#add_button').click(function(){
		
		$('#add_form')[0].reset();

		$('#add_form').parsley().reset();

    	$('#modal_title').text('Ajout  QR Code');

    	$('#action').val('Add');

    	$('#submit_button').html('Ajouter');

    	$('#addModal').modal('show');

    	$('#form_message').html(''); 
    	
    	$('#gestionnaire').val($('.nav-link.active').data('id'));
    	
    	$('#gestionnaire').selectpicker('refresh'); 
	});
	
    $('#add_form').parsley();

	$('#add_form').on('submit', function(event){
		event.preventDefault();
		if($('#add_form').parsley().isValid())
		{		
			$.ajax({
				url:"qr-codes-action",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
                contentType:false,
                processData:false, 
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').html('<i class="far fa-spinner fa-spin"></i> Loading ');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').html('Ajouter');
					}
					else
					{
						$('#addModal').modal('hide');
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
		
		$('#add_form')[0].reset();

		$('#add_form').parsley().reset();

		$('#form_message').html('');
        
		$.ajax({

	      	url:"qr-codes-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{ 
                $('#gestionnaire').val(data.gestionnaire);
                
                $('#libelle').val(data.libelle);
                
                $('#link').val(data.link);
                  
            	$('#gestionnaire').selectpicker('refresh'); 

	        	$('#modal_title').text('Modifier QR Code');

	        	$('#action').val('Edit'); 

	        	$('#submit_button').html('Modifier'); 

	        	$('#addModal').modal('show');

	        	$('#hidden_id').val(id);

	      	}

	    })

	});
    
    var lightbox = GLightbox({
        selector: '.glightbox'
    });
    
    <?php  
        $object->query="SELECT * FROM user WHERE pro = '1' and statut = 'Activer'";
        $result = $object->get_result();
        foreach($result as $row){  
    ?> 
  
        var dataTable_<?= $row['id'] ?> = $('#qrcode-table-<?= $row['id'] ?>').DataTable({
           "language": {  url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' }, 
        	"processing" : true,
        	"serverSide" : true, 
        	"order" : [],
        	"ajax" : {
        		url:"qr-codes-action",
        		type:"POST",
        		data:{action:'fetch-<?= $row['id'] ?>'}
        	},
        	"columnDefs":[
        		{
        			"targets":['_all'],
        			"orderable":false, 
        		},
        	],  
        	"drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
        });
    
    <?php  }  ?> 
    
    $(document).on('click','.markets',function(){
        
        var id = $(this).data('id');
        
        $.ajax({
            url:"qr-codes-action",
            method:"POST", 
            data:{
                id:id,  
                action:"fetch_market"
            },
            success:function(data)
            { 
                  var  html = '<select data-container="body" id="list-markets" name="list-markets[]"  class="form-control   " multiple>'+data+'</select>';
                 
                
                   Swal.fire({
                        title: 'Point de vente',
                        html: html,
                        icon: 'question',
                        confirmButtonColor: '#0d6efd',
                        showCancelButton: true,
                        cancelButtonColor: '#6c757d',
                        cancelButtonText: 'Fermer',
                        confirmButtonText: 'Sauvegarder',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            
                            var markets = $('#list-markets').val(); 

                            $.ajax({

                                url:"qr-codes-action",

                                method:"POST",

                                data:{id:id,markets:markets, action:'update'},

                                dataType:'JSON',

                                success:function(data)
                                { 
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.success+'!'
                                    })
                                }
                            })
                        }
                    });
                        
                    setTimeout(function(){ 
                        $('#list-markets').selectpicker();
                    }, 10);
            }
        }); 
    }); 
    
  	$(document).on('click','.menu-link',function(){
    	    
	    var iframe = '<iframe height="800" style="border: 2px solid #0e4194;border-radius: 0.3rem;" src="'+$(this).data('link')+'"></iframe>';
	    
        $('#menuModalContent').html('');
        
        $('#menuModalContent').append(iframe);
        
        $('#menuModal').modal('show'); 
	});
});
 
</script>