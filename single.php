<?php 
	get_header();
	$options = get_option('consultation_options');
?>
	<div id="main_content">
	<?php
			if(isset($_GET['t']) && $_GET['t']=='timeline'){
				$cons=$post->ID;
			
				get_timeline($cons);
			}else if(isset($_GET['t']) && $_GET['t']=='statistics'){
				$cons=$post->ID;
				get_statistics($cons);
			}else{ 
			?>
		<div class="col-md-9">
			<div class="row">
				<div class="btn-group pull-right " style="margin-top:3px;margin-right:2px;">
        			<a href="<?php echo get_permalink();?>/?t=timeline" class="btn btn-default btn-sm"><span class="text-purple"><em class="fa fa-line-chart"></em> Timeline</span></a>
        			<a href="<?php echo get_permalink();?>/?t=statistics" class="btn btn-default btn-sm"><span class="text-orange"><em class="fa fa-bar-chart"></em> Στατιστικά</span></a>
      			</div>
			<?
			
			
			if (in_category($options['cat_open'])){
			// Είναι εισαγωγικό: 
			$category_in = get_the_category();
			$cat_id_in ;
			foreach ($category_in as $cat_in) {
				$cat_id_in = $cat_in->cat_ID;
				if (($cat_id_in !=$options['cat_close'] ) && ($cat_id_in != $options['cat_open']) && ($cat_id_in != $options['cat_results'])){	break; }
			}
			
			//Φέρε άν υπάρχει Τελικό Σχέδιο. Είναι διαβούλεησ με αποτελέμσατα
			query_posts('cat='.$options['cat_results']);  
			if (have_posts()) {
				while (have_posts()) { 
					the_post(); 
					$category = get_the_category();
					foreach ($category as $cat) {
						if ($cat_id_in == $cat->cat_ID){ 
							print_document($type='results');
						?>	
						<?php
							break;
						}
					}		
				}
			}
			wp_reset_query() ;
			
			//Φέρε άν υπάρχει της ολοκλήρωσης			
				query_posts('cat='.$options['cat_close']);  
				if (have_posts()) {
					while (have_posts()) { 
						the_post(); 
						$category = get_the_category();
						foreach ($category as $cat) {
							if ($cat_id_in == $cat->cat_ID){ 
										
							print_document();
							
								break;
							}
						}		
					}
				}
				wp_reset_query() ;
			}			
			?>
			
			<?php
			if (in_category($options['cat_close'])){
				$category_in = get_the_category();
				$cat_id_in ;
				foreach ($category_in as $cat_in) {
					$cat_id_in = $cat_in->cat_ID;
					if (($cat_id_in !=$options['cat_close'] ) && ($cat_id_in != $options['cat_open']) && ($cat_id_in != $options['cat_results'])){	break; }
				}
				
				//Φέρε άν υπάρχει Τελικό Σχέδιο
				query_posts('cat='.$options['cat_results']);  
				if (have_posts()) {
					while (have_posts()) { 
						the_post(); 
						$category = get_the_category();
						foreach ($category as $cat) {
							if ($cat_id_in == $cat->cat_ID){ 
								print_document();
								break;
							}
						}		
					}
				}
				wp_reset_query() ;
			}
			?>
			
			<?php while (have_posts()) : the_post(); ?>
			
				<?php if (in_category($options['cat_close'])){ ?>				
					
				<?php } else { 
					print_document();
					
				 }  ?>
			<?php endwhile; ?> 
			<?php
			if (in_category($options['cat_close'])){
			// Είναι ολοκλήρωσης: Φέρε άν υπάρχει της εισαγωγής
				$category_in = get_the_category();
				$cat_id_in ;
				foreach ($category_in as $cat_in) {
					$cat_id_in = $cat_in->cat_ID;
					if (($cat_id_in !=$options['cat_close'] ) && ($cat_id_in != $options['cat_open'])){	break; }
				}
				
				query_posts('cat='.$options['cat_open']);  
				if (have_posts()) {
					while (have_posts()) { 
						the_post(); 
						$category = get_the_category();
						foreach ($category as $cat) {
							if ($cat_id_in == $cat->cat_ID){ 
							?>				
								<h3><?php the_title(); ?></h3>
								<div class="list-group"><?php the_content(''); ?></div>
							<?php
								break;
							}
						}		
					}
				}
				wp_reset_query() ;
			}			
			?>
			</div>
			<?php get_cons_posts_list($post->ID,'Πλοήγηση στη Διαβούλευση'); ?>
		<?php 
	$has_comments = get_post_meta($post->ID, 'has_comments', true); 
	if (((!in_category($options['cat_open'])) && (!in_category($options['cat_close'])) && (!in_category($options['cat_results']))) || ($has_comments==true) ){ 
		
		comments_template(); } 
	?>
		</div>	
		<?php get_sidebar('single'); ?>
		<?php } ?>	
	</div>	

</div>
<?php get_footer(); ?>		