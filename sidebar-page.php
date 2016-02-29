<aside class="col-lg-3">
		 
		<div role="tabpanel" class="panel">
               <!-- Nav tabs-->
               <ul role="tablist" class="nav nav-tabs nav-justified">
                  <li role="presentation" class="active">
                     <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                        <em class="fa fa-clock-o fa-fw"></em>Τελευταίες διαβουλεύσεις</a>
                  </li>
               </ul>
               <!-- Tab panes-->
               <div class="tab-content p0">
                  <div id="home" role="tabpanel" class="tab-pane active">
                     <!-- START list group-->
                     <div class="list-group mb0">
						<?php get_consultations_list(); ?>
                     </div>
                     <!-- END list group-->
                     <div class="panel-footer text-right"><a href="<?php echo URL; ?>" class="btn btn-default btn-sm">Δείτε τiς όλες </a>
                     </div>
                  </div>
               </div>
            </div>
            
       

	
</aside>
