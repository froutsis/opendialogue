<?php
	//This functions displays the timeline of a consultation 
	
	function get_timeline($cons){
		$category = get_the_category();
		$options = get_option('consultation_options');	
		
		$cons_cat;
		foreach ($category as $cat) {
			if($cat->cat_ID == $options['cat_open'] or $cat->cat_ID ==$options['cat_close'] or $cat->cat_ID ==$options['cat_results']) continue;
			$cons_cat = $cat;  
		}			
		$expires = explode('@', $cons_cat -> category_description );
		$countdate =  '"'.mysql2date("m/d/Y H:i", $expires[1]).'"'; 
		$startdate =  mysql2date("j F Y, H:i", $expires[0]);
		$enddate =  mysql2date("j F Y, H:i", $expires[1]);
		$current_date = date("U");
		$start_date_stamp = mysql2date( 'U', $expires[0]);
		$end_date_stamp = mysql2date( 'U', $expires[1]);
		$selected_date = date("U",$end_date_stamp);
		$all = round (($end_date_stamp - $start_date_stamp)/(3600*24));
		$difference = round (($selected_date - $current_date)/(3600*24));
		
		
		global $wpdb;
		
		$sql =
		"SELECT `comment_author_email`, `comment_date`
		FROM $wpdb->comments
			LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
			INNER JOIN $wpdb->term_relationships as r1 ON ($wpdb->posts.ID = r1.object_id)
			INNER JOIN $wpdb->term_taxonomy as t1 ON (r1.term_taxonomy_id = t1.term_taxonomy_id)
		WHERE comment_approved = '1'
			AND comment_type = ''
			AND post_password = ''
			AND t1.taxonomy = 'category'
			AND t1.term_id = ".$cons_cat->cat_ID."";
		
		$all_comments = $wpdb->get_results($sql, ARRAY_A);
		
		$posts_count = 0;
		query_posts('posts_per_page=-1&cat='.$cons_cat->cat_ID); 
		
		if (have_posts()) { while (have_posts()) {  the_post(); 
			$category = get_the_category();
			if (count($category)>1) { continue; }
			$posts_count++;
		} } wp_reset_query() ;
		
	?>
	
	<ul class="timeline">
               <li data-datetime="Τώρα" class="timeline-separator">
               <!-- START timeline item-->
               
               <?php if($difference <=0){ ?>
               <li class="timeline-inverted">
                  <div class="timeline-badge info">
                     <em class="fa fa-lock " style="margin-top:10px;"></em>
                  </div>
                  <div class="timeline-panel">
                     <div class="popover right">
                        <h4 class="popover-title">Ολοκλήρωση</h4>
                        <div class="arrow"></div>
                        <div class="popover-content">
                           <p>Η Διαβούλευση ολοκληρώθηκε στις <span class="text-danger"><?php echo $enddate;?></span></a>
                              <br>
                              <small>Η διαβούλευση ολοκληρώθηκε με επιτυχία.</small>
                           </p>
                        </div>
                     </div>
                  </div>
               </li>
               <?}?>
               <li>
                  <div class="timeline-badge primary">
                     <em class="fa fa-bar-chart" style="margin-top:10px;"></em>
                  </div>
                  <div class="timeline-panel">
                     <div class="popover">
                        <h4 class="popover-title">Σχόλια</h4>
                        <div class="arrow"></div>
                        <div class="popover-content">
                          <?php get_cons_posts_list_timeline($cons,''); ?>
                        </div>
                     </div>
                  </div>
               </li>
                <?php if($difference <=0){ ?>
           	   <li data-datetime="<?php echo $enddate;?>" class="timeline-separator"></li>
           	    <?}?>
                <li class="timeline-inverted">
                  <div class="timeline-badge info">
                     <em class="fa fa-unlock" style="margin-top:10px;"></em>
                  </div>
                  <div class="timeline-panel">
                     <div class="popover right">
                        <h4 class="popover-title">Έναρξη</h4>
                        <div class="arrow"></div>
                        <div class="popover-content">
                           <p>Η Διαβούλευση ξεκίνησε στις <span class="text-green"><?php echo $startdate;?></span></a>
                              <br>
                              <small>Η διαβούλευση ξεκίνησε με <strong><?php echo $posts_count;?></strong> άρθρα.</small>
                           </p>
                        </div>
                     </div>
                  </div>
               </li>
                <li data-datetime="<?php echo $startdate;?>" class="timeline-separator"></li>
               
<!-- END timeline item-->
               
            </ul>
	<?php
	}
	
?>