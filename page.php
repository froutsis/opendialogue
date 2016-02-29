<?php 
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
                			<h4><?php the_title(); ?></h4>
					</div>
				</div>
				<div class="panel-body ">
          			<?php the_content(''); ?>
				</div><!--panel-body-->
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