<?php 
	get_header();
	$options = get_option('consultation_options');
?>
<div id="main_content">
	<div class="col-md-9">
			<div class="row">
			
			<div class="panel panel-default">
				<div class="panel-heading" > 
					<div class="panel-title">
                		<h4><?php echo "Αποτελέσματα Αναζήτησης για '".get_search_query()."'"; ?></h4>
					</div>
				</div>
				<div class="panel-body ">
					<?php if(have_posts()){ while ( have_posts() ) { the_post(); 
							// Ιgnore Thank you & Completion posts
							$category = get_the_category();
							$skip =false;
							foreach ($category as $cat) {
								if($cat->cat_ID ==$options['cat_close'] or $cat->cat_ID ==$options['cat_results']) $skip = true;
							}
							if($skip)  continue;
					?>
						<div class="panel-body ">
							<strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
							<?php the_excerpt(); ?>
							
						</div><!--panel-body-->
					<?php } } else { ?>
						<p>Δεν εντοπίστηκε άρθρο με τον όρο της αναζήτησής σας.</p>
					<?php } ?>
				</div><!--panel-body-->
				<div class="panel-footer ">
         		</div><!--class="panel-footer "-->
			</div> <!--class="panel panel-default"-->	
	
		
			
			</div><!--row-->
			
		</div>	<!--col-md-9-->	
		
		<?php get_sidebar('page'); ?>
	</div>	

</div>
<?php get_footer();