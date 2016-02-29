	<?php 
		$category = get_the_category();
		$options = get_option('consultation_options');	
		$cons_cat;
		foreach ($category as $cat) {
			if($cat->cat_ID == $options['cat_open'] or $cat->cat_ID ==$options['cat_close'] or $cat->cat_ID ==$options['cat_results']) continue;
			$cons_cat = $cat;  
		}			
	?>
	<?php 
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
		$percentage =  ceil((number_format(100*$difference/$all,0)/10))*10;
		if($difference<0) $difference=0;
		global $wpdb;
		$sql =
		"SELECT count(*)
		FROM $wpdb->comments
		WHERE comment_approved = '1'
			AND comment_type = ''";
			$all_comments = $wpdb->get_var($sql);

		$sql =
		"SELECT count(*)
		FROM $wpdb->comments
			LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
			INNER JOIN $wpdb->term_relationships as r1 ON ($wpdb->posts.ID = r1.object_id)
			INNER JOIN $wpdb->term_taxonomy as t1 ON (r1.term_taxonomy_id = t1.term_taxonomy_id)
		WHERE comment_approved = '1'
			AND comment_type = ''
			AND post_password = ''
			AND t1.taxonomy = 'category'
			AND t1.term_id = ".$cons_cat->cat_ID."";
			$cons_comments = $wpdb->get_var($sql);
			
			
	?>

		<aside class="col-lg-3 col-xs-hidden hidden-xs clearfix">
                  <!-- START loader widget-->
                  <div class="panel panel-default">
                     <div class="panel-body text-center">
                        <div class="text-info">
                           <em class="fa fa-hourglass-start fa-fw"></em>
							Μέρες που απομένουν 
							
						</div>
						
				<div data-label="<?php echo round($difference);?>" class="radial-bar radial-bar-<?php echo $percentage;?> radial-bar-lg"></div>
                     	</div><!--text-info-->
                     	<div class="panel-footer">
                        	<p class="text-muted">
				   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Ξεκίνησε στις</span><br/>
				   <span class="text-success"><? echo $startdate; ?></span><br/>
				   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Κλείνει στις</span><br/>
				   <span class="text-danger"><? echo $enddate; ?></span>
				   
				</p>
                    	</div><!--panel-footer"-->
                  </div><!--lass="panel-body text-center"-->
                  <!-- END loader widget-->
		 <!-- START COMMENTING -->
		<?php if (comments_open()) { ?>
                  <div class="panel panel-default">
                     <div class="panel-body text-center">
                        <div class="text-info">
                        <div class="panel-title">Ανοικτή σε σχολιασμό</div>
                         </div>
                     </div>
			<?php if ((!in_category($options['cat_open'])) && (!in_category($options['cat_close'])) && (!in_category($options['cat_results']))){	?>
                       	<div class="panel-footer">
							<em class="fa fa-pencil fa-fw"></em><a href="#respond" >Σχολιάστε!</a>
                     	</div><!--text-info-->
                
			<?php }  ?>
		  </div> <!-- panel panel-default-->
		  
		  <?php }  ?>
		 <!-- END COMMENTING -->
		 <!-- START RSS -->
		 <div class="panel widget">
		  <div class="row row-table " style='border-bottom:1px solid #e4eaec;'>
		  <div class="col-md-12 col-sm-12 hidden-xs pv text-center ">
                	<div class="text-info">
                		Δεδομένα</div>
                </div>
            </div>
		<?php if (comments_open()) { ?>
		
		<?php if(!(in_category($options['cat_open']) || in_category($options['cat_close']))){ ?>
		
            <div class="row row-table " style='border-bottom:1px solid #e4eaec;'>
            	<div class="col-md-4 col-sm-3 hidden-xs pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?feed=rss2&p=<?php echo $post->ID; ?>"><em class="fa fa-rss fa-2x text-purple"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                       	<a href="<?php echo URL; ?>/?feed=rss2&p=<?php echo $post->ID; ?>"><span class="text-muted"> άρθρου</span></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-3 hidden-xs pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?feed=comments-rss2&cat=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-rss fa-2x text-green"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?feed=comments-rss2&cat=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> διαβού<br/>λευσης</span></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-3 hidden-xs pv text-center " >
                	<div class="text-info text-sm"><a href="<?php echo URL; ?>/?feed=comments-rss2"><em class="fa fa-rss text-orange fa-2x"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?feed=comments-rss2"><span class="text-muted">όλα</span></a>
                    </div>
                </div>
                          
            </div>
            
        <?php } ?>
        <?php } ?>
        <div class="row row-table">
            	<div class="col-md-4 col-sm-3 hidden-xs pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?t=xml&ec=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-code fa-2x text-purple"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                       	<a href="<?php echo URL; ?>/?t=xml&sec=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> xml</span></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-3 hidden-xs pv text-center br">
                	<div class="text-info text-sm">
                		<a href="<?php echo URL; ?>/?t=json&ec=<?php echo $cons_cat->cat_ID; ?>"><em class="fa fa-hashtag fa-2x text-green"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?t=json&ec=<?php echo $cons_cat->cat_ID; ?>"><span class="text-muted"> json</span></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-3 hidden-xs pv text-center ">
                	<div class="text-info text-sm"><a href="<?php echo URL; ?>/?t=xls&ec=<?php echo $cons_cat->cat_ID;?> "><em class="fa fa-file-excel-o text-orange fa-2x"></em></a></div>
                    <div class="text-info">
                        <em class="wi wi-sprinkles"></em>
                        <a href="<?php echo URL; ?>/?t=xls&ec=<?php echo $cons_cat->cat_ID;?> "><span class="text-muted">xls</span></a>
                    </div>
                </div>
                          
            </div>
        </div>
        
		 <!-- STOP RSS -->
		 <!-- START STATISTICS -->

		 <div class="panel widget">
                     <div class="row row-table row-flush">
                        <div class="col-xs-6 bb br">
                           <div class="row row-table row-flush">
                              <div class="col-xs-4 text-center text-info">
                                 <em class="fa fa-commenting-o  fa-2x"></em>
                              </div>
                              <div class="col-xs-8">
                                 <div class="panel-body text-center">
				    <h4 class="mt0"><?php echo $cons_comments;?> </h4>
                                    <p class="mb0 text-muted">Σχόλια εδώ</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xs-6 bb">
                           <div class="row row-table row-flush">
                              <div class="col-xs-4 text-center text-danger">
                                 <em class="fa fa-comments fa-2x"></em>
                              </div>
                              <div class="col-xs-8">
                                 <div class="panel-body text-center">
                                    <h4 class="mt0"><?php echo $all_comments;?></h4>
                                    <p class="mb0 text-muted">Σχόλια σύνολο</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
		 <!-- END STATISTICS -->
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
                  </div>
                  <!-- END messages and activity-->
</aside>
