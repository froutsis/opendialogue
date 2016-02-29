<?php 
	get_header();
	if (!empty($_GET['c'])){
		include(TEMPLATEPATH."/lib/single-comment.php");
	}
	else if (!empty($_GET['preview'])){
		include(TEMPLATEPATH."/lib/preview.php");
	}
	else {
	$options = get_option('consultation_options');
	
	
	$data = get_consultations_list_index();
?>
	<div class="row">
	     <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-primary">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                           <div class="h2 mt0"><?php echo $data['all']; ?>
                           </div>	
			</div>
            <div class="col-xs-8 pv-lg">
                           <div >
				<?php if(empty($_GET['type'])) echo ' <i class="fa fa-check-square"></i>'; ?>
				<a href="<?php echo URL; ?>">Όλες οι Διαβουλεύσεις</a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-purple">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                           <div class="h2 mt0"><?php echo $data['open']; ?></div>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div >
				<?php if(isset($_GET['type']) && $_GET['type']=='open') echo ' <i class="fa fa-check-square"></i>'; ?>
				<a href="<?php echo URL; ?>/?type=open">Ανοικτές σε Σχολιασμό</a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-warning">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                           <div class="h2 mt0"><?php echo $data['closed']; ?></div>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div>
				<?php if(isset($_GET['type']) && $_GET['type']=='closed') echo ' <i class="fa fa-check-square"></i>'; ?>
				<a href="<?php echo URL; ?>/?type=closed">Πρός Επεξεργασία</a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-green">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-green-dark pv-lg">
                           <div class="h2 mt0"><?php echo $data['done']; ?></div>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div>
				<?php if(isset($_GET['type']) && $_GET['type']=='done') echo ' <i class="fa fa-check-square"></i>'; ?>
				<a href="<?php echo URL; ?>/?type=done">Ολοκληρωμένες</a></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			<?php echo $data['all_data']; ?>
		</div>			
	</div>
<?php 
	}
	get_footer(); 
?>
