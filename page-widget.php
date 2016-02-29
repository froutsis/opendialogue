<?php 
  /*
  Template Name: Widget
  */

	get_header();
	$options = get_option('consultation_options');
?>
<div id="main_content">
	<div class="col-md-9">
			<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="panel panel-default">
				<div class="panel-heading" > 
					<div class="panel-title">
                			<h4><span class="text-purple"><em class="fa fa-fw fa-unlock mr"></em></span><?php the_title(); ?></h4>
					</div>
				</div>
				
				<div class="panel-body ">
          			<div class="row bb">
          				<div class="col-lg-12 col-sm-12 col-xs-12 ">
          				Τα <span class="text-purple text-bold"><em class="fa fa-fw fa-cogs"></em></span> widgets είναι μικρά κομμάτια έτοιμου κώδικα που μπορούν να ενσωματωθούν σε οποιοδήποτε σημείο του δικού σας δικτυακού τόπου και μπορούν να προσθέσουν λειτουργικότητα σε αυτό, χωρίς να απαιτούνται από εσάς ιδιαίτερες τεχνικές γνώσεις.
          				<br/><br/>
          				Με το συγκεκριμένο  <span class="text-purple text-bold"><em class="fa fa-fw fa-unlock "></em> widget διαβουλεύσεων </span>μπορείτε να παρουσιάζεται τον αριθμό διαβουλεύσεων που θέλετε στο δικό σας δικτυακό τόπο.
          				<br/><br/>
          				</div>
          			</div>
          			<div class="row">
          				<div class="col-lg-6 col-sm-6 col-xs-6 br">
          					<h4 class="text-purple">Παραμετροποίηση <span class="text-purple text-bold"><em class="fa fa-fw fa-unlock "></em> widget </span></h4>
          					<br/>
          					<!-- start num -->
          					 <div class="form-group">
   								<label for="num">Αριθμός διαβουλεύσεων:</label>
    							<div class="row">
    							<div class="col-sm-6">
    							<select class="form-control" id="num" onblur="generate_widget_code()">
  									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
								</select>
								</div><!--col-sm-6-->								
								</div><!--row-->
								<span id="helpBlock" class="help-block">Δηλώστε των αριθμό των διαβουλεύσεων που θέλετε να έχει το widget σας.</span>
  							</div><!-- class="form-group"-->
          					<!-- end num -->
          					<!-- start platos  -->
          					<div class="form-group">
   								<label for="num">Πλάτος:</label>
    							<div class="row">
    							<div class="col-sm-6">
    							<input onblur="generate_widget_code()" class="form-control" type="text" size="40" value="300" id="width">
								</div><!--col-sm-6-->
								</div><!--row-->
								<span id="helpBlock" class="help-block">Δηλώστε το πλάτος που θέλετε να έχει το widget σας.</span>
  							</div><!-- class="form-group"-->
          				<!-- end platos  -->
          				<!-- start platos  -->
          					<div class="form-group">
   								<label for="num">Ύψος:</label>
    							<div class="row">
    							<div class="col-sm-6">
    							<input onblur="generate_widget_code()" class="form-control" type="text" size="40" value="450" id="height">
								
								</div><!--col-sm-6-->
								</div><!--row-->
								<span id="helpBlock" class="help-block">Δηλώστε το ύψος που θέλετε να έχει το widget σας.</span>
								
  							</div><!-- class="form-group"-->
          				<!-- end platos  -->
          				<!-- start Κωδικός  -->
          					<div class="form-group">
   								<label for="num">Κώδικaς widget:</label>
    							<div class="row">
    							<div class="col-sm-12">
    							<textarea id="widget_script" class="form-control" rows="7" cols="100" readonly></textarea>
    							<span id="helpBlock" class="help-block">Αντιγράψτε τον κώδικα που βλέπετε στο πεδίο αυτό για να το χρησιμοποιήσετε στο δικό σας δικτυακό τόπο.</span>
									<script type="text/javascript">
									var head=('<div id="conswd"></div><script type="text/javascript" src="<?php echo JS; ?>/widget.js"><\/script><script type="text/javascript">init_widget(');
									var body='3, 300, 450';
									var footer=(')<\/script>');
									function generate_widget_code(){
										body= ''+document.getElementById("num").value+','+document.getElementById("width").value+','+document.getElementById("height").value;
										document.getElementById("widget_script").innerHTML=head+body+footer;
									}
									document.getElementById("widget_script").innerHTML=head+body+footer;
									</script>
									</div><!--col-sm-6-->
								</div><!--row-->
  							</div><!-- class="form-group"-->
          				<!-- end Κωδικός  -->
          			
          				</div>
          				<div class="col-lg-6 col-sm-6 col-xs-6 ">
          					<h4 class="text-purple">Προεπισκόπιση <span class="text-purple text-bold"><em class="fa fa-fw fa-unlock "></em> widget </span></h4>
          					<br/>
          					<span id="helpBlock" class="help-block">Δείτε πως θα παρουσιάζεται στο δικό σας δικτυακό τόπο.</span>
								
          					<div id="conswd"></div><script type="text/javascript" src="http://localhost/Grnet/Prace/wp-content/themes/advanced-consultations/js/widget.js"></script><script type="text/javascript">init_widget(3, 300, 450)</script>

          				</div>
          			</div>
          			
					
				</div>
				<div class="panel-footer ">
         		</div><!--class="panel-footer "-->
			</div> <!--class="panel panel-default"-->	
	
		<?php endwhile; // end of the loop. ?>
			
			</div><!--row-->
			
		</div>	<!--col-md-9-->	
		
		<?php get_sidebar('page'); ?>
	</div>	

</div>
<?php get_footer();