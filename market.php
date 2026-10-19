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
      <h1>Market</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">Market</li>
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
                            		<h6 class="m-0 font-weight-bold ">Liste des Market</h6>
                            	</div>
                            	<div class="col" align="right">
                            	    <?php if($object->autorisation('c',$user->id,$page_actuel) == 0){?>
                            		 <button type="button" name="add_market" id="add_market" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#marketModal" ><i class="fal fa-plus"></i> Ajouter</button>
                            	   <?php }?>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-bordered"> 
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#actif-overview"><i class="fa-light fa-check-to-slot"></i> Actif</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#disabled-overview"><i class="fa-light fa-xmark-to-slot"></i> Désactiver</button>
                                </li> 
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#archive-overview"><i class="fal fa-archive"></i> Archive</button>
                                </li> 
                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active actif-overview" id="actif-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover  DataTable" id="market_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    
                                                    <th>Logo</th>
        											<th >Market</th>
                                                    <th>Client</th>		
                                                    <th>Adresse</th> 
                                                    <th>Lien</th>  
                                                    <th>Menu</th>  
                                                    <th>QR Code</th>  
                                                    <th>Statut</th> 
                                                    <th>Admin</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade   archive-overview" id="archive-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover DataTable" id="market_archive_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    
                                                    <th>Logo</th>
        											<th >Market</th>
                                                    <th>Client</th>		
                                                    <th>Adresse</th> 
                                                    <th>Menu</th>  
                                                    <th>QR Code</th>  
                                                    <th>Statut</th>
                                                    <th>Admin</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade   disabled-overview" id="disabled-overview">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover DataTable" id="market_disabled_table" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr>
                                                    
                                                    <th>Logo</th>
        											<th >Market</th>
                                                    <th>Client</th>		
                                                    <th>Adresse</th> 
                                                    <th>Menu</th>  
                                                    <th>QR Code</th> 
                                                    
                                                    <th>Statut</th>
                                                    <th>Admin</th>
                                                    <th>Actions</th>
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
  
    <div class="modal fade" id="menuModal"  >
        <div class="modal-dialog   small"> 
              <div class="modal-content" id="menuModalContent">
      		</div> 
      	</div>
    </div>
        
   <!--modal-->
    <div class="modal fade" id="marketModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl  small">
            <form method="post" id="market_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal_title"> Ajout market </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>
                        <div class="row ">

                            <div class="col-md-4">
                                <label for="market" class="form-label">Libelle <span class="text-danger">*</span></label>
                                <input type="text" name="market" placeholder="libelle" id="market" class="form-control form-control-sm" required   data-parsley-trigger="keyup">
                            </div> 
                            
                             <div class="col-md-4">
                                <label for="gestionnaire" class="form-label">Client <span class="text-danger">*</span></label>
                                <select name="gestionnaire" id="gestionnaire" class="form-control form-control-sm selectpicker"  data-live-search="true" title="Sélectionnez un client" data-size="5"  required>
                                    <?= $object->get_gestionnaires();?>
                                </select>

                            </div>
                            
                            <div class="col-md-4">
                                <label for="varie" class="form-label">Variation <span class="text-danger">*</span></label>
                                <select name="varie" id="varie" class="form-control form-control-sm" required data-parsley-trigger="keyup">
                                    <option value="single">Single Type</option>
                                    <option value="multiple">Multiple Type</option>
                                </select> 
                            </div>

                        </div>
                        
                        <ul class="nav nav-tabs nav-tabs-bordered" id="myTab" role="tablist">
                            
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="info-gene-tab" data-bs-toggle="tab" data-bs-target="#info-gene" type="button" role="tab" aria-controls="info-gene" aria-selected="true">Informations générales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="info-res-soc-tab" data-bs-toggle="tab" data-bs-target="#info-res-soc" type="button" role="tab" aria-controls="info-res-soc" aria-selected="false">Réseaux sociaux</button>
                            </li>
                            <li class="nav-item " role="presentation">
                              <button class="nav-link" id="info-theme-tab" data-bs-toggle="tab" data-bs-target="#info-theme" type="button" role="tab" aria-controls="info-theme" aria-selected="false">Thème & Style</button>
                            </li>
                            <li class="nav-item " role="presentation">
                              <button class="nav-link" id="info-modules-tab" data-bs-toggle="tab" data-bs-target="#info-modules" type="button" role="tab" aria-controls="info-modules" aria-selected="false">Modules</button>
                            </li> 
        
                        </ul>
                        
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="info-gene" role="tabpanel" aria-labelledby="info-gene-tab">
                                <div class="row">
    
                                    <h5 class="text-primary">Informations de contact</h5>
    
        
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input class="form-control form-control-sm" type="file" name="logo" id="logo" accept=".jpg, .jpeg, .png, .webp">
                                         <span id="market_uploaded_logo"></span>
                                    </div>
        
        
                                    <div class="col-md-4">
                                        <label for="tel" class="form-label">Téléphone </label>
                                        <input type="text" name="tel"  id="tel" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div>
        
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">E-mail </label>
                                        <input type="email" name="email"  id="email" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div>
        
                                    <div class="col-md-6">
                                        <label for="siteweb" class="form-label">Site Web </label>
                                        <input type="text" name="siteweb"  id="siteweb" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div>
                                    
                                    <h5 class="text-primary">Adresse</h5>
    
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">adresse</label>
                                        <textarea    name="address" id="address" class="form-control form-control-sm"     data-parsley-trigger="keyup"></textarea>
                                    </div>
    
                                    <div class="col-md-12" style="    margin-bottom: 80px;">
                                        <label for="description" class="form-label">Description</label>
                                        <div class="quill-editor-description">
                                        </div>
                                        <textarea name="description" id="description" style='display:none'></textarea> 
                                    </div>
                                </div>
                            
                            </div>
                            <div class="tab-pane fade  " id="info-res-soc" role="tabpanel" aria-labelledby="info-res-soc-tab">
                                <div class="row">
    
                                    <h5 class="text-primary">Réseaux sociaux</h5> 
         
                                    <div class="col-md-12">
                                        <label for="facebook" class="form-label"><i class="fab fa-facebook"></i> Facebook </label>
                                        <input type="text" name="facebook"  id="facebook" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div>
        
                                    <div class="col-md-12">
                                        <label for="instagram" class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                                        <input type="text" name="instagram"  id="instagram" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="tiktok" class="form-label"><i class="fab fa-tiktok"></i> Tiktok</label>
                                        <input type="text" name="tiktok"  id="tiktok" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="youtube" class="form-label"><i class="fab fa-youtube"></i> Youtube</label>
                                        <input type="text" name="youtube"  id="youtube" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="twitter" class="form-label"><i class="fab fa-twitter"></i> Twitter</label>
                                        <input type="text" name="twitter"  id="twitter" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="whatsapp" class="form-label"><i class="fab fa-whatsapp"></i> WhatsApp</label>
                                        <input type="text" name="whatsapp"  id="whatsapp" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="tripadvisor" class="form-label"><img src="./assets/img/tripadvisor.svg" width="24" /> TripAdvisor</label>
                                        <input type="text" name="tripadvisor"  id="tripadvisor" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                    <div class="col-md-12">
                                        <label for="google" class="form-label"><i class="fab fa-google"></i> Google</label>
                                        <input type="text" name="google"  id="google" class="form-control form-control-sm"   data-parsley-trigger="keyup">
                                    </div> 
                                </div>
                            </div>
                            <div class="tab-pane fade  " id="info-modules" role="tabpanel" aria-labelledby="info-modules">
                                <div class="row">
    
                                    <h5 class="text-primary">Modules</h5> 

         
                                    <div class="col-md-3">
                                        <label for="multi_langue" class="form-label">Multi Langue </label>
                                        <select name="multi_langue" id="multi_langue" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="0"> Non </option>
                                            <option value="1"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="pro" class="form-label">Professionnel</label>
                                        <select name="pro" id="pro" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="0"> Non </option>
                                            <option value="1"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3 apercu">
                                        <label for="apercu" class="form-label">Aperçu page d'accueil</label>
                                        <select name="apercu" id="apercu" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="0"> Non </option>
                                            <option value="1"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="commande" class="form-label">Commande </label>
                                        <select name="commande" id="commande" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="utilisateur" class="form-label">Multi utilisateur </label>
                                        <select name="utilisateur" id="utilisateur" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="feedback" class="form-label">Feedback </label>
                                        <select name="feedback" id="feedback" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="event" class="form-label">Événement </label>
                                        <select name="event" id="event" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="design_qrcode" class="form-label">Desgin QR Code </label>
                                        <select name="design_qrcode" id="design_qrcode" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="ingredient" class="form-label">Ingrédient</label>
                                        <select name="ingredient" id="ingredient" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="vip" class="form-label">VIP</label>
                                        <select name="vip" id="vip" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3">
                                        <label for="wifi" class="form-label">Wifi </label>
                                        <select name="wifi" id="wifi" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> Non </option>
                                            <option value="2"> Oui </option> 
                                        </select>  
                                    </div>
         
                                    <div class="col-md-3 wifi">
                                        <label for="wifi_ssid" class="form-label">Wifi SSID</label>
                                        <input  name="wifi_ssid" id="wifi_ssid" class="form-control form-control-sm   "   data-parsley-trigger="keyup"/>  
                                    </div>
                                    <div class="col-md-3 wifi">
                                        <label for="wifi_password" class="form-label">Wifi Password</label>
                                        <input  name="wifi_password" id="wifi_password" class="form-control form-control-sm   "   data-parsley-trigger="keyup"/>  
                                    </div> 
         
                                </div>
                            </div>
                            <div class="tab-pane fade  " id="info-theme" role="tabpanel" aria-labelledby="info-theme">
                                <div class="row">
    
                                    <h5 class="text-primary">Thème </h5> 
                                    
                                             
                                    <div class="col-md-3">
                                        <label for="niveau" class="form-label">Niveau de menu </label>
                                        <select name="niveau" id="niveau" class="form-control form-control-sm   "   data-parsley-trigger="keyup">
                                            <option value="1"> 1 niveau </option>
                                            <option value="2"> 2 niveau </option>
                                            <option value="3"> 3 niveau</option>
                                            <option value="4"> 4 niveau</option>
                                        </select>  
                                    </div>
         
                                    <div class="col-md-4">
                                        <label for="theme" class="form-label">Thème <span class="text-danger">*</span></label>
                                        <select name="theme" id="theme" class="form-control form-control-sm" data-size="9"  data-live-search="true" title="Sélectionnez un menu" required data-parsley-trigger="keyup">
                                             <?= $object->get_theme_liste(); ?>
                                        </select>  
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="background" class="form-label">Image </label>
                                        <input type="file" name="background" id="background"  class="form-control form-control-sm"  accept=".jpg, .jpeg, .png, .webp"/>
            						    <span id="market_uploaded_background"></span>   
                                    </div>
    
                                    <h5 class="text-primary varie">Background </h5> 
         
         
                                    <div class="col-md-2 point_vente varie">
                                        <label for="background_color0" class="form-label">BG Point de vente </label>
                                        <input type="color" name="background_color0" id="background_color0" value="#cda45e" class="form-control form-control-sm color"  /> 
                                    </div> 
         
                                    <div class="col-md-2 varie">
                                        <label for="background_color1" class="form-label">BG Catégories</label>
                                        <input type="color" name="background_color1" id="background_color1" value="#cda45e" class="form-control form-control-sm color"  /> 
                                    </div>
         
                                    <div class="col-md-2 niveau varie">
                                        <label for="background_color2" class="form-label">BG Sous Catégorie  </label>
                                        <input type="color" name="background_color2" id="background_color2" value="#cda45e" class="form-control form-control-sm color"  /> 
                                    </div>
         
                                    <div class="col-md-2 varie">
                                        <label for="background_color3" class="form-label">BG Article </label>
                                        <input type="color" name="background_color3" id="background_color3" value="#cda45e" class="form-control form-control-sm color"  /> 
                                    </div>
                                    <div class="col-md-2 varie">
                                        <label for="background_color4" class="form-label">BG Description </label>
                                        <input type="color" name="background_color4" id="background_color4" value="#cda45e" class="form-control form-control-sm color"  /> 
                                    </div>
    
                                    <h5 class="text-primary varie">Texte </h5>  
                                    
                                    <div class="col-md-2 point_vente varie">
                                        <label for="text_color0" class="form-label">Texte Point de vente  </label>
                                        <input type="color" name="text_color0" id="text_color0" value="#000000" class="form-control form-control-sm color"  /> 
                                    </div>
                                    
                                    <div class="col-md-2 varie">
                                        <label for="text_color1" class="form-label">Texte Catégorie  </label>
                                        <input type="color" name="text_color1" id="text_color1" value="#000000" class="form-control form-control-sm color"  /> 
                                    </div>
         
                                    <div class="col-md-2 niveau varie">
                                        <label for="text_color2" class="form-label">Texte Sous Catégorie  </label>
                                        <input type="color" name="text_color2" id="text_color2" value="#000000" class="form-control form-control-sm color"  /> 
                                    </div>
         
                                    <div class="col-md-2 varie">
                                        <label for="text_color3" class="form-label">Texte Article </label>
                                        <input type="color" name="text_color3" id="text_color3" value="#000000" class="form-control form-control-sm color"  /> 
                                    </div>
         
                                    <div class="col-md-2 varie">
                                        <label for="text_color4" class="form-label">Texte Description </label>
                                        <input type="color" name="text_color4" id="text_color4" value="#000000" class="form-control form-control-sm color"  /> 
                                    </div>
          
         
                                </div>
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
    <div class="modal fade" id="langueModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog   small">
            <form method="post" id="langue_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"  >Liste des langues</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>   
                    <div class="modal-body table-responsive-sm" id="langue_body" style="height: 500px;overflow-y: auto;">
                    </div>
                    <div class="modal-footer">
                      	<input type="hidden" name="marketid" id="marketid"   />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			 <button type="button" class="btn  btn-sm btn-primary save_langue">Sauvegarder</button>
              			
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
    
     
  
	var dataTable = $('#market_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"market-action",
			type:"POST",
			data:{action:'fetch'}
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
	var dataTable_archive = $('#market_archive_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"market-action",
			type:"POST",
			data:{action:'fetch_archive'}
		},
		"columnDefs":[
			{
				"targets":[],
				"orderable":false,
			},
		],   "drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
	});
	var dataTable_disabled = $('#market_disabled_table').DataTable({
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        },
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"market-action",
			type:"POST",
			data:{action:'fetch_disabled'}
		},
		"columnDefs":[
			{
				"targets":[ ],
				"orderable":false,
			},
		],   "drawCallback": function(settings) {
                var lightbox = GLightbox({
                  selector: '.glightbox'
                });
    		}
	});
 

	$('#add_market').click(function(){
		
		$('#market_form')[0].reset();

		$('#market_form').parsley().reset();

    	$('#modal_title').text('Ajout market');

    	$('#action').val('Add');

    	$('#submit_button').html('Ajouter');

    	$('#marketModal').modal('show');

    	$('#form_message').html('');
    	
    	$('#wifi').trigger("change"); 
    	
    	$('#pro').trigger("change"); 
    	
    	$('#varie').trigger("change"); 
    	
    	$('#niveau').trigger("change"); 
    	
    	description.setContents([{ insert: '\n' }]);
    	
		$('#market_uploaded_logo').html('');
		
		$('#market_uploaded_background').html('');

	});
 
      $('#logo').on('change', function() {
        var fileInput = $(this);
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
        var files = fileInput.get(0).files;
    
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          var fileName = file.name;
          if (!allowedExtensions.test(fileName)) {
              Swal.fire({
                  icon: 'error',
                  title: 'Extension de fichier invalide.',
                  text: 'Seuls les fichiers JPG, JPEG, PNG et WebP sont autorisés.',
                }); 
            fileInput.val('');
            return;
          }
        }
      });
 
      $('#background').on('change', function() {
        var fileInput = $(this);
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
        var files = fileInput.get(0).files;
    
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          var fileName = file.name;
          if (!allowedExtensions.test(fileName)) {
             Swal.fire({
                  icon: 'error',
                  title: 'Extension de fichier invalide.',
                  text: 'Seuls les fichiers JPG, JPEG, PNG et WebP sont autorisés.',
                }); 
            fileInput.val('');
            return;
          }
        }
      });
      
      var description = new Quill('.quill-editor-description', {
      theme: 'snow'
    });
 

 	$("#wifi").change(function(){
        
        if($(this).val() == '1' )
        { 
            $('.wifi').hide();  
        }else
        {
             $('.wifi').show(); 
        }
    });

 	$("#varie").change(function(){
        
        if($(this).val() == 'multiple' )
        { 
            $('.varie').hide();  
        }else
        {
             $('.varie').show(); 
        }
    });
 

 	$("#pro").change(function(){
        
        if($(this).val() == '1' )
        { 
             $('.apercu').show();  
        }else
        {
            $('.apercu').hide(); 
        }
    });

 	$("#niveau").change(function(){
 	    
 	    console.log('niveau triggered');
         
        if($("#niveau").val() == '4' )
        { 
            $('.point_vente').show(); 
            $('.niveau').show(); 
        }
        else if($("#niveau").val() == '3' )
        { 
            $('.point_vente').hide(); 
            $('.niveau').show(); 
        }else
        {
            $('.point_vente').hide(); 
            $('.niveau').hide(); 
        }
    });

	$('#market_form').parsley();

	$('#market_form').on('submit', function(event){
		event.preventDefault();
		if($('#market_form').parsley().isValid())
		{		
		    var editor_content = description.container.innerHTML
            
            $('#description').val($(editor_content).html());
            
			$.ajax({
				url:"market-action",
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
						$('#marketModal').modal('hide');
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
		
		$('#market_form')[0].reset();

		$('#market_form').parsley().reset();

		$('#form_message').html('');
		
        description.setContents([{ insert: '\n' }]);
        
		$.ajax({

	      	url:"market-action",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{
				$('#market_uploaded_logo').html('<img src="'+data.logo+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_market_logo" value="'+data.logo+'" />');
				
                $('#market_uploaded_background').html('<img src="'+data.background+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_market_background" value="'+data.background+'" />');
                
                $('#gestionnaire').val(data.gestionnaire);
                
                $('#varie').val(data.varie);
                
                $('#market').val(data.market);
                
                $('#apercu').val(data.apercu);
                
            	$('#email').val(data.email);
                
            	$('#siteweb').val(data.siteweb);
            	
            	$('#tel').val(data.tel);
            	
            	$('#multi_langue').val(data.multi_langue);
            	
            	$('#address').val(data.address);
            	
	        	$('#description').val(data.description);
	        	
	        	const value  = data.description;
                
                const delta  = description.clipboard.convert(value);
                    
                description.setContents(delta, 'silent');
            	
            	$('#facebook').val(data.facebook);
            	
            	$('#instagram').val(data.instagram);
            	
            	$('#tiktok').val(data.tiktok);
            	
            	$('#youtube').val(data.youtube);
            	
            	$('#youtube').val(data.youtube);
            	
            	$('#twitter').val(data.twitter);
            	
            	$('#whatsapp').val(data.whatsapp);
            	
            	$('#tripadvisor').val(data.tripadvisor);
            	
            	$('#google').val(data.google);
            	
            	$('#theme').val(data.theme);
            	
            	$('#niveau').val(data.niveau);
            	
            	$('#pro').val(data.pro);
            	
            	$('#tel').val(data.tel);
            	
            	$('#email').val(data.email);
            	
            	$('#siteweb').val(data.siteweb);
            	
            	$('#background_color0').val(data.background_color0);
            	
            	$('#background_color1').val(data.background_color1);
            	
            	$('#background_color2').val(data.background_color2);
            	
            	$('#background_color3').val(data.background_color3);
            	
            	$('#background_color4').val(data.background_color4);
            	
            	$('#text_color0').val(data.text_color0);
            	
            	$('#text_color1').val(data.text_color1);
            	
            	$('#text_color2').val(data.text_color2);
            	
            	$('#text_color3').val(data.text_color3);
            	
            	$('#text_color4').val(data.text_color4);
            	
            	$('#wifi').val(data.wifi);
            	
            	$('#wifi_ssid').val(data.wifi_ssid);
            	
            	$('#wifi_password').val(data.wifi_password);
            	
            	$('#feedback').val(data.feedback);
            	
            	$('#commande').val(data.commande);
            	
            	$('#utilisateur').val(data.utilisateur);
            	
            	$('#event').val(data.event); 
            	
            	$('#design_qrcode').val(data.design_qrcode); 
            	
            	$('#ingredient').val(data.ingredient); 
            	
            	$('#vip').val(data.vip); 
            	
            	$('#gestionnaire').selectpicker('refresh'); 

	        	$('#modal_title').text('Modifier market');

	        	$('#action').val('Edit');

                $('#wifi').trigger("change"); 

    	        $('#varie').trigger("change"); 
                 
                $('#niveau').trigger("change"); 

                $('#pro').trigger("change"); 

	        	$('#submit_button').html('Modifier'); 

	        	$('#marketModal').modal('show');

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
                    url:"market-action",
                    method:"POST",
                    data:{id:id, action:'statut', statut:statut, next_statut:next_statut},
                    success:function(data){
                        $('.DataTable').DataTable().ajax.reload();
                        notificationSwal.fire({
                            icon: 'success',
                            title: 'Market '+next_statut+'!',
                        });
                    }
                });
            }
        });   
        
  	});
  	
  	
  	     $(document).on('click', '.language_button', function()
        {

            var market = $(this).data('id');
            
            $('#marketid').val(market);

            $.ajax({

                url:"market-action",

                method:"POST",

                data:{ market: market , action:'langue'},

                dataType:'JSON',

                success:function(data)
                { 

                    var html = `<table class="table table-striped table-sm" > 
                                    <thead>
                                        <tr>
                                            <th scope="col">Langue</th>
                                            <th scope="col">Action  </th>       
                                        </tr>
                                    </thead>
                                    <tbody>`;
                    if(data.length == 0)
                    {
                        html = '<div class="alert alert-danger">Ajouter/Activer les langues</div>';
                    }else
                    { html+= `
                                <tr class="flower" data-id="tout">
                                <td><b>Tout</b></td>
                                    <td><input type="checkbox" onClick="toggleAll(this)" /></td>
                                </tr>
                                `; 
                        for(var count = 0; count < data.length; count++)
                        {
                           
                            if(data[count][1] == '2')
                            {
                                html += `
                                <tr class="flower" data-id="`+data[count][0]+`">
                                    <td>`+data[count][2]+`</td>
                                    <td><input type="checkbox"  name="check_list[]" value="`+data[count][0]+`"></td>
                                </tr>
                                `; 
                            }else if(data[count][1] == '1')
                            {
                                html += `
                                <tr  class="flower" data-id="`+data[count][0]+`" >
                                    <td>`+data[count][2]+`</td>
                                    <td><input type="checkbox" checked name="check_list[]" value="`+data[count][0]+`"></td>
                                </tr>
                                `;
                            }
                        }
                    }
                    html += `</tbody>
                        </table>
                    `;
                        
                
                    $('#langue_body').html(html);
                    
                    $('#langueModal').modal('show');
                }              

            })

        });
        
        $(document).on('click', '.save_langue', function()
        {
            var all_location_id = document.querySelectorAll('input[name="check_list[]"]:checked');

            var aIds = [];
            
            for(var x = 0, l = all_location_id.length; x < l;  x++)
            {
                aIds.push(all_location_id[x].value);
            }
            
            var check_list = aIds.join(', ');
            
           var market =  $('#marketid').val();
            
            $.ajax({

                url:"market-action",

                method:"POST",

                data:{ aIds: aIds ,market:market, action:'save_langue'},

                dataType:'JSON',

                success:function(data)
                {  
    				dataTable.ajax.reload();
                    
                    $('#langueModal').modal('hide');
                    
                     notificationSwal.fire({
                        icon: 'success',
                        title: data.success
                    });
                }              

            })
        });
        
  	$(document).on('click','.login',function(){
  	    var market = $(this).data('id');  
  	    var id = $(this).data('gestionnaire');  
        $.redirect("https://app.menuqrcode.tn/redirection-admin-market", {id:id,market:market,expire:$(this).data('expire'),signature:$(this).data('signature'),action:'login-market'}, "POST", "_blank");    
  	})
  	
  	$(document).on('click','.menu-link',function(){
    	    
	    var iframe = ' <iframe height="800" style=" border: 2px solid #0e4194;border-radius: 0.3rem; " src="'+$(this).data('link')+'"></iframe>';
	    
        $('#menuModalContent').html('');
        
        $('#menuModalContent').append(iframe);
        
        $('#menuModal').modal('show'); 
	});
 

});

    function toggleAll(source) {
        checkboxes = document.getElementsByName('check_list[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
 
</script>