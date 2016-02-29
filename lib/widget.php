<?php
	
	function widgeter($num){
?>
	<style type="text/css">
		@import('<?php echo CSS; ?>/bootstrap.min.css');
		@import('<?php echo CSS; ?>/main.css');
		@import('<?php echo CSS; ?>/app.css');
		
		.timeline{
		    margin-bottom: 10px;
    		background-color: #fff;
    		border-radius: 5px;
    		border: 1px solid #e8e8e8;
   		 }
   		 .info_with_running,
   		 .info_with_loading,
   		 .info_with_results,
   		 h2#consultations ,
		strong ,
		a {font-family: 'Open Sans', sans-serif; font-size:14px;text-decoration:none;color:#656565;}
		h2#consultations {font-size:18px;color: #7266ba;}
		a:hover{text-decoration:underline;}
		.info_with_running{color:#7266ba;font-size:12px;}
		.info_with_loading{color:#f77600;font-size:12px;}
		.info_with_results{color:#37bc9b;font-size:12px;}
	
	</style>

	<div id="consultations-timeline" class="timeline">
	<h2 id="consultations"> Διαβουλεύσεις </h2>
	
	 <div id="consultations-list">
		 <div class="consultations-list-starts">
			<?php get_consultations_list("widget"); ?>
		 </div>
		 <div id="consultations-more"><strong>
		 <a href="<?php echo URL; ?>" class="btn btn-default btn-sm" target="blank">Δείτε τις όλες </a>
		 </strong>
		 </div>
	  </div>
	  
	</div>
<?php
		exit();
	}
	
?>