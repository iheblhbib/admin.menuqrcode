 
           
           
           <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background-color:#ffffffd4;color: black;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                
                        </div>
                        <div class="modal-body">Sélectionnez «Déconnexion» ci-dessous si vous êtes prêt à mettre fin à votre session en cours.</div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <a class="btn  btn-sm btn-primary" href="logout">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
            
                       
    <div class="modal fade" id="profilModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  small">
            <form method="post" id="profil_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" > Profil </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row"> 

                            <div class="col-md-12 ">
                                <label for="name_profil" class="form-label">Nom et prénom <span class="text-danger">*</span></label>
                                <input type="text" name="name_profil" id="name_profil" class="form-control form-control-sm" required value="<?= $user->name ?>" data-parsley-maxlength="150" data-parsley-trigger="keyup">
                            </div> 
                            
                             <div class="col-md-12">
                                <br>
                            </div>

                            <div class="col-md-6 ">
                                <label for="num_profil" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" name="num_profil" id="num_profil" class="form-control form-control-sm" required value="<?= $user->num ?>" data-parsley-minlength="8" data-parsley-maxlength="13" data-parsley-trigger="keyup">
                            </div> 

                            <div class="col-md-6">
                                <label for="email_profil" class="form-label">E-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email_profil" id="email_profil" class="form-control form-control-sm" required value="<?= $user->email ?>" d  data-parsley-trigger="keyup">
                            </div>   
                            
                            
                        </div>                        
                    </div>
                    <div class="modal-footer">   
              			<input type="hidden" name="action_profil" id="action_profil" value="update" />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			<button type="submit" name="submit" id="submit_button_profil" class="btn btn-sm  btn-primary" >Modifier</button>
              			
                    </div>
                  </div>
            </form>
        </div>
    </div>  
           
    <div class="modal fade" id="passwordModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  small">
            <form method="post" id="password_form" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" > Mot de passe </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>

                        <div class="row">  
                            
                             <div class="col-md-6 ">
                                <label for="password_profil" class="form-label">Nouveau mot de passe  <span class="text-danger">*</span></label>
                                <input type="password" name="password_profil" id="password_profil" class="form-control form-control-sm"  required  data-parsley-trigger="keyup">
                            </div> 

                            <div class="col-md-6">
                                <label for="renewpassword_profil" class="form-label">Ré-entrez le nouveau mot de passe  <span class="text-danger">*</span></label>
                                <input type="password" name="renewpassword_profil" id="renewpassword_profil" class="form-control form-control-sm" required    data-parsley-trigger="keyup"  data-parsley-equalto="#password_profil">
                            </div> 
                            
                            
                        </div>                        
                    </div>
                    <div class="modal-footer">   
              			<input type="hidden" name="action_password" id="action_password" value="update" />
              			<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
              			<button type="submit" name="submit" id="submit_button_password" class="btn btn-sm  btn-primary" >Modifier</button>
              			
                    </div>
                  </div>
            </form>
        </div>
    </div>  
        
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <script src="assets/vendor/quill/quill.min.js"></script>
        <script src="assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="assets/vendor/chart.js/chart.min.js"></script>
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="assets/vendor/echarts/echarts.min.js"></script>
 
        <script src='vendor/fullcalendar/packages/core/main.js'></script>
        <script src='vendor/fullcalendar/packages/daygrid/main.js'></script>
        <script src='vendor/fullcalendar/packages/timegrid/main.js'></script>
        <script src='vendor/fullcalendar/packages/list/main.js'></script>
        <script src='vendor/fullcalendar/packages/interaction/main.js'></script>
        <script src='vendor/fullcalendar/packages/core/locales-all.js'></script>
 
        <script type="text/javascript" src="vendor/datatables/datatables/1.13.2/jquery.dataTables.js"></script>
        <script type="text/javascript" src="vendor/datatables/datatables/1.13.2/dataTables.bootstrap5.js"></script>
        <script type="text/javascript" src="vendor/datatables/buttons/2.2.2/dataTables.buttons.js"></script>
        <script type="text/javascript" src="vendor/datatables/buttons/2.2.2/buttons.html5.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="vendor/datatables/fixedheader/3.2.1/dataTables.fixedHeader.js"></script>
        <script type="text/javascript" src="vendor/datatables/rowgroup/1.2.0/dataTables.rowGroup.js"></script>
        <script type="text/javascript" src="vendor/datatables/rowreorder/1.2.7/dataTables.rowReorder.js"></script>
        <script type="text/javascript" src="vendor/datatables/responsive/2.2.9/js/dataTables.responsive.js"></script>
        <script type="text/javascript" src="vendor/datatables/select/1.6.0/js/dataTables.select.js"></script>
        <script type="text/javascript" src="vendor/datatables/plug-ins/1.13.2/pagination/scrolling.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        
        <script type="text/javascript" src="vendor/parsley/dist/parsley.min.js"></script>
 
        <script type="text/javascript" src="vendor/parsley/dist/i18n/fr.js"></script>
 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
        
    	<script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
    	<script src="vendor/jquery/jquery.redirect/jquery.redirect.js"></script>        
        <script src="assets/js/number_format.js"></script>  
        <script src="vendor/jquery/jquery-sortable.js"></script>  
 
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
        <script src="assets/js/main2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.1/fabric.min.js"></script>
 
        <script>
            $(document).ready(function(){ 
                
                $(document).on('click','#go-profil',function(){ 
                    
            		$('#profil_form')[0].reset();
            
            		$('#profil_form').parsley().reset();   
            
                	$('#profilModal').modal('show');
                });
                
                $(document).on('click','#go-password',function(){ 
                    
            		$('#password_form')[0].reset();
            
            		$('#password_form').parsley().reset();   
            
                	$('#passwordModal').modal('show');
                });
                
            	$('#profil_form').parsley();
    
            	$('#profil_form').on('submit', function(event){
            		event.preventDefault();
            		if($('#profil_form').parsley().isValid())
            		{		
            			$.ajax({
            				url:"profil-action",
            				method:"POST",
            				data:new FormData(this),
            				dataType:'json',
                            contentType:false,
                            processData:false, 
            				beforeSend:function()
            				{
            					$('#submit_button_profil').attr('disabled', 'disabled');
            					$('#submit_button_profil').html('<i class="fa-duotone fa-spinner fa-spin"></i>');
            				},
            				success:function(data)
            				{
            				    $('#submit_button_profil').html('Modifier');
            					$('#submit_button_profil').attr('disabled', false);
            					if(data.error != '')
            					{
            						notificationSwal.fire({
                                        icon: 'error',
                                        title: data.error,
                                    });
            						
            					}
            					else
            					{
            						$('#profilModal').modal('hide'); 
                                    notificationSwal.fire({
                                        icon: 'success',
                                        title: data.success,
                                    });
            					}
            				}
            			})
            		}
            	});
                
            	$('#password_form').parsley();
    
            	$('#password_form').on('submit', function(event){
            		event.preventDefault();
            		if($('#password_form').parsley().isValid())
            		{		
            			$.ajax({
            				url:"profil-action",
            				method:"POST",
            				data:new FormData(this),
            				dataType:'json',
                            contentType:false,
                            processData:false, 
            				beforeSend:function()
            				{
            					$('#submit_button_password').attr('disabled', 'disabled');
            					$('#submit_button_password').html('<i class="fa-duotone fa-spinner fa-spin"></i>');
            				},
            				success:function(data)
            				{
            				    $('#submit_button_password').html('Modifier');
            					$('#submit_button_password').attr('disabled', false);
            					if(data.error != '')
            					{
        						    notificationSwal.fire({
                                        icon: 'error',
                                        title: data.error,
                                    });  
            					}
            					else
            					{
            						$('#passwordModal').modal('hide'); 
                                    notificationSwal.fire({
                                        icon: 'success',
                                        title: data.success,
                                    });
            					}
            				}
            			})
            		}
            	});
            	
            	

        	});
        </script>
    </body>

</html>