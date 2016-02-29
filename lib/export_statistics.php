<?php
	//This functions displays the timeline of a consultation 
	
	function createDateRangeArray($strDateFrom,$strDateTo){
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom)
		{
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}

	
	function get_statistics($cons){
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
		if($difference < 0) $difference=0;
		$percentage = 100 - abs(ceil((number_format(100*$difference/$all,0)/10))*10);
		
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
		
		$per_day = array();
		$days_traverse =  createDateRangeArray(mysql2date("Y-m-d", $expires[0]), mysql2date("Y-m-d", $expires[1]));
		foreach($days_traverse as $day){
			$per_day[$day] = array('comments' => 0, 'users' => array());
		}
		
		$all_users = array();
		foreach($all_comments as $comment){
			if(!in_array($comment['comment_author_email'], $all_users)){
				$all_users[] = $comment['comment_author_email'];
			}
			$day = mysql2date("Y-m-d", $comment['comment_date']);
			$per_day[$day]['comments'] = $per_day[$day]['comments'] + 1;
			if(!in_array($comment['comment_author_email'], $per_day[$day]['users'] )){
				$per_day[$day]['users'][]= $comment['comment_author_email'];
			}
		}
		$the_post = get_post( $cons ); 
		if ( empty($the_post->post_excerpt) )
			$excerpt = apply_filters('the_content', $the_post->post_content);
		else
			$excerpt = apply_filters('the_excerpt', $the_post->post_excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt = wp_html_excerpt($excerpt, 1000) . ' [...]';
		$excerpt = '<p>'.$excerpt.'</p><a class="more" href="'.URL.'/?p='.$the_post->ID.'">Περισσότερα &raquo;</a>';
		//$expires = explode('@', $cat_descr[$cat] );
	?>
	
	<!--main data -->
	<div class="panel widget">
			<div class="row row-table " style="border-bottom:1px solid #e4eaec;">
		  		<div class="col-md-12 col-sm-12 col-xs-12 pv text-center ">
                	<div class="text-info"><? the_title(); ?></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6 br">
            	<div class="row row-table row-flush">
                  <em class="fa fa-hourglass-start fa-fw"></em>
				  Μέρες που απομένουν 
				  <span class="text-success text-bold"><? echo $difference; ?></span><br/>		
                   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Ξεκίνησε στις</span><br/>
				   <span class="text-success"><? echo $startdate; ?></span><br/>
				   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Κλείνει στις</span><br/>
				   <span class="text-danger"><? echo $enddate; ?></span>
                </div>
            </div>
            <div class="col-lg-9 col-sm-6 col-xs-6 ">
            	<div>
                 <?php echo $excerpt; ?>
                </div>
            </div>
            
            
    </div>	
	
	 <!-- START STATISTICS -->

		 <div class="panel widget">
			<div class="row row-table " style="border-bottom:1px solid #e4eaec;">
		  		<div class="col-md-12 col-sm-12 col-xs-12 pv text-center ">
                	<div class="text-info">Βασικά Στοιχεία</div>
                </div>
            </div>
        	
            <div class="col-lg-3 col-sm-6 col-xs-6 bb br">
            	<div class="row row-table row-flush">
                	<div class="col-xs-4 text-center text-info">
                    	<em class="fa fa-file-text-o  fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                    	<div class="panel-body text-center">
				   			<h4 class="mt0"><?php echo $posts_count; ?></h4>
                            	<p class="mb0 text-muted">Άρθρα</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6 bb br">
            	<div class="row row-table row-flush">
                	<div class="col-xs-4 text-center text-info">
                    	<em class="fa fa-calendar-o  fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                    	<div class="panel-body text-center">
				   			<h4 class="mt0"><? echo $all; ?></h4>
                            	<p class="mb0 text-muted">Μέρες</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6 bb br">
            	<div class="row row-table row-flush">
                	<div class="col-xs-4 text-center text-info">
                    	<em class="fa fa-commenting-o  fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                    	<div class="panel-body text-center">
				   			<h4 class="mt0"><?php echo count($all_comments); ?></h4>
                            	<p class="mb0 text-muted">Σχόλια</p>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-sm-6 col-xs-6  bb br">
            	<div class="row row-table row-flush">
                	<div class="col-xs-4 text-center text-info">
                    	<em class="fa fa-users  fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                    	<div class="panel-body text-center">
				   			<h4 class="mt0"><?php echo count($all_users); ?></h4>
                            	<p class="mb0 text-muted">Χρήστες</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                         
		 <!-- END STATISTICS -->
               
		
		 <!-- START RSS -->
		 <div class="panel widget">
		 
		  <div class="row row-table " style="border-bottom:1px solid #e4eaec;">
		  <div class="col-lg-12 col-sm-12 col-xs-12 pv text-center ">
                	<div class="text-info">
                		Ανοικτά Δεδομένα (τρόποι διάθεσης)</div>
                </div>
            </div>
		        <div class="row row-table">
		        <div class="col-lg-3 col-sm-3 col-xs-3 pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?feed=comments-rss2&cat=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-rss fa-2x text-purple"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                       	<a href="<?php echo URL; ?>/?feed=comments-rss2&cat=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> rss</span></a>
                    </div>
                </div>
            	<div class="col-lg-3 col-sm-3 col-xs-3 pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?t=xml&ec=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-code fa-2x text-purple"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                       	<a href="<?php echo URL; ?>/?t=xml&ec=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> xml</span></a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3 pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?t=json&ec=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-hashtag fa-2x text-green"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?t=json&ec=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> json</span></a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3 pv text-center ">
                	<div class="text-info text-sm"><a href="<?php echo URL; ?>/?t=xls&ec=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-file-excel-o text-orange fa-2x"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?t=xls&ec=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted">xls</span></a>
                    </div>
                </div>
                          
            </div>
        </div>
		<?php
			$comments_per_day = array();
			$users_per_day = array();
			foreach($per_day as $day){;
				$comments_per_day[] = 	$day['comments'];
				$users_per_day[] = 	count($day['users']);
			}
		?>
		<script type="text/javascript">
		(function ($) {	
			$(document).ready(function($) {
				
				var comments = [<?php echo implode(',',$comments_per_day ); ?>];
				var users = [<?php echo implode(',',$users_per_day ); ?>];
				
				$('.inlinesparkline').sparkline(comments, {
					type: 'line',
					fillColor: '#ffffff',
					lineColor:'#7266ba',
					lineWidth: 2,
					width:"422",
					height:"80" 
				});
				
				/* The second argument gives options such as chart type */
				$('.dynamicbar').sparkline(users, {
					type: 'bar', 
					barColor: '#37bc9b', 
					width:"422",
					height:"80" , 
					barWidth:"5px", 
					barSpacing:"8" 
				});
				
			});
		})(jQuery);
		</script>
        
		 <!-- STOP RSS -->
		<div class="row">	
			<div class="col-lg-6">
                        <!-- START widget-->
                        <div class="panel widget">
                           <div class="panel-body">
                              <div class="clearfix">
                                 <h3 class="pull-left text-muted mt0"><?php echo count($all_comments); ?></h3>
                                 <em class="pull-right text-muted fa fa-commenting-o  fa-2x"></em>
                              </div>
                              <p style='padding:10px;'>
                              	<span class="inlinesparkline"  width="202" height="80" ></span>.
 							  </p>
                              <p>
                                 <small class="text-muted">Πορεία Διαβούλευσης</small>
                              </p>
                              <div class="progress progress-xs">
                                 <div role="progressbar" aria-valuenow="<?php echo $percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage;?>%" class="progress-bar progress-bar-info progress-bar-striped">
                                 </div>
                                 
                              </div>
                              <small><?php echo $percentage;?>% έχει ολοκληρωθεί</small>
                           </div>
                        </div>
                        <!-- END widget-->
                     </div>
                     
                     <div class="col-lg-6">
                        <!-- START widget-->
                        <div class="panel widget">
                           <div class="panel-body">
                              <div class="clearfix">
                                 <h3 class="pull-left text-muted mt0"><?php echo count($all_users); ?></h3>
                                 <em class="pull-right text-muted fa fa-users  fa-2x"></em>
                              </div>
                              <p style='padding:10px;'>
                              	<span class="dynamicbar"  width="202" height="80" ></span>.
 							  </p>
                              <p>
                                 <small class="text-muted">Πορεία Διαβούλευσης</small>
                              </p>
                              <div class="progress progress-xs">
                                 <div role="progressbar" aria-valuenow="<?php echo $percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage;?>%" class="progress-bar progress-bar-info progress-bar-striped">
                                 </div>
                                 
                              </div>
                              <small><?php echo $percentage;?>% έχει ολοκληρωθεί</small>
                           </div>
                        </div>
                        <!-- END widget-->
                     </div>
		</div>
                
	<?php
	}
	
?>