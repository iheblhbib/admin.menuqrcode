<?php 
    
    include ('header.php');
?>
 
<main id="main" class="main">
      <div class="pagetitle">
      <h1>Feedback</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li> 
          <li class="breadcrumb-item active">Feedback</li>
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
                        		<h6 class="m-0 font-weight-bold ">Liste des feedback</h6>
                        	</div> 
                        </div>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover  DataTable " id="feedback_table" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>Market</th>
                                        <th>Note</th>
                                       <th>Commentaire</th>	 
                                        <th>IP</th>
                                        <th>Mobile</th>
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
 

<?php
include('footer.php');
?> 

<script>
$(document).ready(function(){
 
  
	var dataTable = $('#feedback_table').DataTable({
        "language": {  url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' },
		"processing" : true,
		"serverSide" : true, 
		"order" : [],
		"ajax" : {
			url:"feedback-action",
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
});
</script>