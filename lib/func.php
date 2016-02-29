<?php

function headtitles() {
	if ( is_home() ) { 
		echo NAME ;
		echo (' | '.DESCRIPTION.'');}
	else{
		wp_title(''); 
		echo (' | ');
		echo NAME; }
}

function the_category_filter($thelist,$separator=' ') {  
	if(!defined('WP_ADMIN')) {  
        //Category IDs to exclude 
		$options = get_option('consultation_options');			
        $exclude = array($options['cat_close'],$options['cat_open'],$options['cat_results']);  
     
        $exclude2 = array();  
        foreach($exclude as $c) {  $exclude2[] = get_cat_name($c); }  
     
           $cats = explode($separator,$thelist);  
           $newlist = array();  
           foreach($cats as $cat) {  
              $catname = trim(strip_tags($cat));  
             if(!in_array($catname,$exclude2))  
                  $newlist[] = $cat;  
           }  
          return implode($separator,$newlist);  
       } else {  
           return $thelist;  
		}  
} 

//@link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
function post_is_in_descendant_category( $cats, $_post = null ){

	foreach ( (array) $cats as $cat ) {
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

 // @link http://wordpress.org/support/topic/272978
function is_descendant_category($cat_id){

	if ( is_category() ) {
		$cat = get_query_var('cat');
		$args = array(
			'include' => $cat,
			'hide_empty' => 0
		  );
		$categories = get_categories($args);
		if ( ($cat == $cat_id) || ($categories[0]->category_parent == $cat_id) ) {
		return true;
	  }
	  return false;
	}
}

/* If We Really Are Home ************************/
function is_really_home(){

	$curent_url=$_SERVER['REQUEST_URI'];
	if (strlen($curent_url)==1 ){  
			return true;
		}
	return false;
}


/* Checks If a Url Exists ************************/
 function url_exists($url){
	if(preg_match('#http\:\/\/[aA-zZ0-9\.]+\.[aA-zZ\.]+#',$url)) return true;
    else return false;
} 

function my_breadcrumb() {
        echo'<div class="row">';
        echo'<div class="col-md-12">';
      
        echo'<ol class="breadcrumb">';
		echo '<li><a href="'.URL.'">Αρχική</a> </li>';
	
		if ( is_category() ) {
			single_cat_title( ); 
		}
	
		if(is_single()) { 
			$category = get_the_category();
			$options = get_option('consultation_options');			
			foreach ($category as $cat) {
			$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])){
					echo '<li><a href="'.URL.'/?cat='.$ID.'">'.$cat -> cat_name.'</a></li>';
					break;
				}
			}
			if(!empty($_GET['t'])){
				$t = trim($_GET['t']);
				if($t == 'statistics')  echo '<li class="active">Στατιστικά</li>';
				if($t == 'timeline') echo '<li class="active">Timeline</li>';
			} else {
				echo '<li class="active">'; 
				the_title();
				echo '</li>'; 
			}
		}
		
		if(is_page()) {  echo '<li class="active">'; the_title(); echo '</li>';}
		if(is_tag()){ echo "<li class='active'> Ετικέτα: ".single_tag_title('',FALSE); echo '</li>'; }
		if(is_search()){ echo "<li class='active'>Αναζήτηση</li>"; }
		if(is_year()){echo '<li class="active">'; echo get_the_time('Y');  echo '</li>';}
		if (!empty($_GET['c'])){
			$the_comment = get_comment($_GET['c']); 
			if ($the_comment->comment_approved == '1') {
				$category = get_the_category($the_comment->comment_post_ID);
				$options = get_option('consultation_options');			
				foreach ($category as $cat) {
				$ID = $cat->cat_ID;
					if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])){
						echo '<li><a href="'.URL.'/?cat='.$ID.'">'.$cat -> cat_name.'</a></li>';
						break;
					}
				}	
				echo '<li class="active">'; 
				echo '<a href="'.get_permalink($the_comment->comment_post_ID).'">'.get_the_title($the_comment->comment_post_ID).'</a>';	
				echo '</li>'; 			
				echo '<li class="active">'; 
				echo 'Σχόλιο του χρήστη ';
				echo $the_comment->comment_author ; 
				echo ' | ';
				echo mysql2date("j F Y, H:s", $the_comment->comment_date);
				echo '</li>'; 
			} else {
				echo '<li class="active">'; 
				echo 'Σφάλμα! Το σχόλιο δεν εντοπίστηκε! ';
				echo '</li>'; 
			}
		}
		echo "</ol>";
		echo "</div>";
		echo "</div>";
		
}

function getCurrentCatID(){
	global $wp_query;
	$cat_ID = get_query_var('cat');
	return $cat_ID;
}

function get_consultations_list($from=''){
	
	$closed_cats = array();
	$open_cats = array();
	$result_cats = array();
	$cat_namez = array();
	$cat_posts = array();
	$options = get_option('consultation_options');		
	
	// get closed ones
	query_posts('cat='.$options['cat_close']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open']) && ($ID != $options['cat_results'])){
					$closed_cats[] =  $ID ;
					//$cat_namez[$ID] = $cat->cat_name;
					break;
				}
			}		
		}
	}
	
	// get closed ones
	query_posts('cat='.$options['cat_results']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open']) && ($ID != $options['cat_results'])){
					$result_cats[] =  $ID ;
					//$cat_namez[$ID] = $cat->cat_name;
					break;
				}
			}		
		}
	}

	// get open ones
	query_posts('cat='.$options['cat_open']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			global $post;
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open']) && ($ID != $options['cat_results'])){
					$expires = explode('@', $cat -> category_description );
					$open_cats[] =  $ID ;
					$cat_namez[$ID] = $cat->cat_name;
					$cat_posts[$ID] = $post;
					$cat_dates[$ID] = mysql2date("d/m/Y", $expires[1]);
					break;
				}
			}		
		}
	}
	wp_reset_query() ;
	$open_cats = array_diff($open_cats, $closed_cats);
	$open_cats = array_values($open_cats);
	
	$closed_cats = array_diff($closed_cats, $result_cats);
	$closed_cats = array_values($closed_cats);
	$date = '31/12/2016';
	$the_post = new stdClass();
	foreach ($open_cats as $cat) {
		$the_post = $cat_posts[$cat];		
		
		if($from=='widget'){
			echo'[<strong>'.$cat_dates[$cat] .'</strong>] <a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item" target="blank">';
			echo''.$cat_namez[$cat].'</a> <span class="info_with_running">(ανοικτή σε σχολιασμό)</span><br/><br/>';
		}else{
			echo '<a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item">';
			echo '<span class="label label-purple pull-right">'.$cat_dates[$cat] .'</span>';
			echo'<span class="text-purple"><em class="fa fa-fw fa-unlock mr"></em></span>'.$cat_namez[$cat].'</a>';
		}
	}
	
	foreach ($closed_cats as $cat) {
		$the_post = $cat_posts[$cat];
		if($from=='widget'){
			echo'[<strong>'.$cat_dates[$cat] .'</strong>] <a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item" target="blank">';
			echo''.$cat_namez[$cat].'</a> <span class="info_with_loading"> (σε επεξεργασία)</span><br/><br/>';
		}else{
			echo '<a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item">';
			echo '<span class="label label-warning pull-right">'.$cat_dates[$cat] .'</span>';
			echo'<span class="text-orange"><em class="fa fa-fw fa-lock mr"></em></span>'.$cat_namez[$cat].'</a>';	
		}
	}
	
	foreach ($result_cats as $cat) {
		$the_post = $cat_posts[$cat];
		if($from=='widget'){
			echo'[<strong>'.$cat_dates[$cat] .'</strong>] <a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item" target="blank">';
			echo''.$cat_namez[$cat].'</a> <span class="info_with_results"> (έχει ολοκληρωθεί με αποτελέσματα)</span><br/><br/>';
		}else{
			echo '<a href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'" class="list-group-item">';
			echo '<span class="label label-green pull-right">'.$cat_dates[$cat] .'</span>';
			echo'<span class="text-green"><em class="fa fa-fw fa-lock mr"></em></span>'.$cat_namez[$cat].'</a>';	
		}	
	}
}

function get_consultations_one($cons_type,$the_post,$cat_namez,$cat,$expires,$excerpt,$number_of_articles,$cons_comments){
	$html = '';
	//Consultation title
	$html .= '<div class="row">';
	$html .= '<div class="col-lg-12 col-md-6 col-sm-12">';
	 	$html .= '<a class="short_title" href="'.URL.'/?p='.$the_post->ID.'" title="'.$cat_namez[$cat].'">';
		$html .= '<h4 class="media-box-heading">';
		if($cons_type=='open')
			$html .= '<span class="text-purple"><i class="fa fa-unlock"></i></span>';
		if($cons_type=='closed')
			$html .= '<span class="text-orange"><i class="fa fa-lock"></i></span>';
		if($cons_type=='done')
			$html .= '<span class="text-green"><i class="fa fa-lock"></i></span>';
		$html .= ' '.$cat_namez[$cat].'</h4></a>';
	$html .= '</div>';//end col-lg-12 col-md-6 col-sm-12
	$html .= '</div>';//end row

	//actual content
	$html .= '<div class="row">';
		$html .= '<div class="col-lg-12 col-md-6 col-sm-12">';
			$html .= '<div class="list-group">';
			//date
				$dayFull = mysql2date("l", $expires[1]);
				$day = mysql2date("j", $expires[1]);
				$month = mysql2date("F", $expires[1]);
				$hour = mysql2date("H:i", $expires[1]);
				$year = mysql2date("Y", $expires[1]);
				$html .= '<div class="col-lg-2 mt0 bg-gray-light text-right">';
				if($cons_type=='open')
                              	$html .= '<div class="ph text-purple">';
				if($cons_type=='closed')
                              	$html .= '<div class="ph text-orange">';
				if($cons_type=='done')
                              	$html .= '<div class="ph text-green">';
                                   $html .= '<div data-now="" data-format="dddd" class="text-uppercase ">'.$dayFull .'</div> ';
                                   $html .= '<div data-now="" data-format="D" class="mt0 text-bold"> '.$day.'</div>';
                                   $html .= ' <br>';
                                   $html .= '<div data-now="" data-format="MMMM" class="text-sm ">'. $month.'</div> ';
                                   $html .= '<div data-now="" data-format="YYYY" class="text-sm "> '. $year.'</div>';
                                   $html .= '<br>';
                                   $html .= '<div data-now="" data-format="h:mm" class="h2 mt0 ">'. $hour .'</div>';
                                   $html .= '<div data-now="" data-format="a" class="text-sm">am</div>';
                              $html .= '</div>';
                        $html .= '</div>';
			//date end

			//description 
			$html .= '<div class="col-lg-4 col-sm-12">';
                              $html .= '<p class="mb-sm">';
                                 $html .= '<small class="text-muted">'.$excerpt.'</small>';
                              $html .= '</p>';
                        $html .= '</div>';
			//description end
			
			//commenting in articles
			$html .= '<div class="col-lg-2 col-sm-6 col-xs-3">';
                              $html .= '<div class="ph text-purple text-center">';
                                $html .= '<span class="h2"><i class="fa fa-commenting-o h2"></i> '.$number_of_articles.' </span><br/>';
				if($cons_type=='done')
					$html .= '<a href="'.URL.'/?p='.$the_post->ID.'#consnav"><small>Άρθρα</small></a>';
				else
					$html .= '<a href="'.URL.'/?p='.$the_post->ID.'#consnav"><small>Σχολιάσιμα Άρθρα</small></a>';
                             $html .= '</div>';
                        $html .= '</div>';
			//commenting in articles end

			//comments num
			$html .= '<div class="col-lg-2 col-sm-6 col-xs-3">';
                              $html .= '<div class="ph text-dark text-center">';
                                $html .= '<span class="h2"><i class="fa fa-comments h2"></i> '.$cons_comments.' </span><br/>';
                                $html .= '<small>Σχόλια</small>';
                             $html .= '</div>';
                        $html .= '</div>';
			//comments num end
			//rss
			if($cons_type=='done' || $cons_type=='closed'){
                        $html .= '<div class="col-lg-1 col-sm-6 col-xs-3">';
                              $html .= '<div class="ph text-warning">'; 
                                $html .= '<a href="'.URL.'/?t=xls&ec='.$cat.'"><span class="h2"><i class="fa fa-file-excel-o h2"></i></span><br/>';
                                $html .= '<small> σε xls</small></a>';
                             $html .= '</div>';
			$html .= '</div>';
			}else{ 

			//rss
                        $html .= '<div class="col-lg-1 col-sm-6 col-xs-3">';
                              $html .= '<div class="ph text-warning">';
                                $html .= '<a href="'.URL.'/?feed=comments-rss2&cat='.$cat.'"><span class="h2"><i class="fa fa-rss-square h2"></i></span></a>';
                             $html .= '</div>';
			$html .= '</div>';
			//rss end
			}
			if($cons_type=='done'){
				$html .= '<div class="col-lg-1 col-sm-6 col-xs-3">';
				      $html .= '<div class="ph text-warning text-center">';
					$html .= '<a href="'.URL.'/?p='.$the_post->ID.'"><span class="h2"><i class="fa fa-file-text h2 text-green"></i></span><br/>';
					$html .= '<small class="text-left">Αποτελέσματα</small></a>';
				$html .= '</div>';
				$html .= '</div>';
			}
			
			if($cons_type!='done' && $the_post->comment_status =='open'){
				$html .= '<div class="col-lg-1 col-sm-6 col-xs-3">';
				      $html .= '<div class="ph text-warning text-center">';
					$html .= '<a href="'.URL.'/?p='.$the_post->ID.'#consnav"><span class="h2"><i class="fa fa-pencil-square-o text-orange h2"></i></span><br/>';
					$html .= '<small class="text-left">Συμμετέχω</small></a>';
				$html .= '</div>';
				$html .= '</div>';
			}
	
			$html .= '</div>';//class="list-group"
		$html .= '</div>';//class="col-lg-12 col-md-6 col-sm-12"
	$html .= '</div>';//end row
		


	//consultation line
	$html .= '<div class="row">';
	$html .= '<div class="col-lg-12 col-md-6 col-sm-12">';
		$html .= '<div class="panel panel-default"></div>';
	$html .= '</div>';
	$html .= '</div>';
	
	return $html;
}

function get_consultations_list_index(){
	
	$data = array(
		'all' => 0,
		'open' => 0,
		'closed' => 0,
		'done' => 0,
		'all_data' => ''
	);
	
	$closed_cats = array();
	$open_cats = array();
	$result_cats = array();
	$cat_namez = array();
	$cat_descr = array();
	$cat_posts = array();
	$options = get_option('consultation_options');		
	
	// get finished ones
	query_posts('cat='.$options['cat_results']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])  && ($ID != $options['cat_results'])){
					$result_cats[] =  $ID ;
					//$cat_namez[$ID] = $cat->cat_name;
					break;
				}
			}		
		}
	}
	
	// get closed ones
	query_posts('cat='.$options['cat_close']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])  && ($ID != $options['cat_results'])){
					$closed_cats[] =  $ID ;
					//$cat_namez[$ID] = $cat->cat_name;
					break;
				}
			}		
		}
	}

	// get open ones
	query_posts('cat='.$options['cat_open']);  
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			global $post;
			$category = get_the_category();
			foreach ($category as $cat) {
				$ID = $cat->cat_ID;
				if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])  && ($ID != $options['cat_results'])){
					$open_cats[] =  $ID ;
					$cat_descr[$ID] = $cat->category_description ;
					$cat_namez[$ID] = $cat->cat_name;
					$cat_posts[$ID] = $post;
					break;
				}
			}		
		}
	}
	wp_reset_query() ;
	// Keep only Open
	$open_cats = array_diff($open_cats, $closed_cats);
	$open_cats = array_values($open_cats);
	
	// Keep only Closed
	$closed_cats = array_diff($closed_cats, $result_cats);
	$closed_cats = array_values($closed_cats);
	
	
	$data['open'] 	= count($open_cats);
	$data['closed'] = count($closed_cats);
	$data['done'] 	= count($result_cats);
	
	$data['all'] 	= $data['open'] + $data['closed'] + $data['done'];
	
	$the_post = new stdClass();
	
	$type = '';
	if(isset($_GET['type']))
		$type = trim($_GET['type']);
	
	if(($type!='closed') && ($type!='done')){
		foreach ($open_cats as $cat) {
			$cons_type='open';
			$the_post = $cat_posts[$cat];
			
			if ( empty($the_post->post_excerpt) )
				$excerpt = apply_filters('the_content', $the_post->post_content);
			else
				$excerpt = apply_filters('the_excerpt', $the_post->post_excerpt);
			$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
			$excerpt = wp_html_excerpt($excerpt, 1200) . ' [...]';
			$excerpt = '<p>'.$excerpt.'</p><a class="more" href="'.URL.'/?p='.$the_post->ID.'">Περισσότερα &raquo;</a>';
			$expires = explode('@', $cat_descr[$cat] );
			
			global $wpdb;
			$sql =
			"SELECT count(*)
			FROM $wpdb->posts
				INNER JOIN $wpdb->term_relationships as r1 ON ($wpdb->posts.ID = r1.object_id)
				INNER JOIN $wpdb->term_taxonomy as t1 ON (r1.term_taxonomy_id = t1.term_taxonomy_id)
			WHERE 
				post_password = ''
				AND post_status =  'publish'
				AND t1.taxonomy = 'category'
				AND t1.term_id = ".$cat."";
				$posts = $wpdb->get_var($sql);
				$posts = $posts - 1;
			$number_of_articles = $posts;
			
			global $wpdb;
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
				AND t1.term_id = ".$cat."";
				$cons_comments = $wpdb->get_var($sql);

			$data['all_data'] = $data['all_data']. get_consultations_one($cons_type,$the_post,$cat_namez,$cat,$expires,$excerpt,$number_of_articles,$cons_comments);
		}
	}

	if(($type!='open') && ($type!='done')){
		foreach ($closed_cats as $cat) {
			$the_post = $cat_posts[$cat];
			
			if ( empty($the_post->post_excerpt) )
				$excerpt = apply_filters('the_content', $the_post->post_content);
			else
				$excerpt = apply_filters('the_excerpt', $the_post->post_excerpt);
			$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
			$excerpt = wp_html_excerpt($excerpt, 1200) . ' [...]';
			$excerpt = '<p>'.$excerpt.'</p><a class="more" href="'.URL.'/?p='.$the_post->ID.'">Περισσότερα &raquo;</a>';
			$expires = explode('@', $cat_descr[$cat] );
			
			global $wpdb;
			$sql =
			"SELECT count(*)
			FROM $wpdb->posts
				INNER JOIN $wpdb->term_relationships as r1 ON ($wpdb->posts.ID = r1.object_id)
				INNER JOIN $wpdb->term_taxonomy as t1 ON (r1.term_taxonomy_id = t1.term_taxonomy_id)
			WHERE 
				post_password = ''
				AND post_status =  'publish'
				AND t1.taxonomy = 'category'
				AND t1.term_id = ".$cat."";
				$posts = $wpdb->get_var($sql);
				$posts = $posts - 2;
				$number_of_articles=$posts;
					
			global $wpdb;
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
				AND t1.term_id = ".$cat."";
				$cons_comments = $wpdb->get_var($sql);

			$cons_type='closed';
			$data['all_data'] = $data['all_data']. get_consultations_one($cons_type,$the_post,$cat_namez,$cat,$expires,$excerpt,$number_of_articles,$cons_comments);
		}
	}

	if(($type!='open') && ($type!='closed')){
		foreach ($result_cats as $cat) {
			$the_post = $cat_posts[$cat];
			
			if ( empty($the_post->post_excerpt) )
				$excerpt = apply_filters('the_content', $the_post->post_content);
			else
				$excerpt = apply_filters('the_excerpt', $the_post->post_excerpt);
			$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
			$excerpt = wp_html_excerpt($excerpt, 1200) . ' [...]';
			$excerpt = '<p>'.$excerpt.'</p><a class="more" href="'.URL.'/?p='.$the_post->ID.'">Περισσότερα &raquo;</a>';
			
			$expires = explode('@', $cat_descr[$cat] );
			
			global $wpdb;
			$sql =
			"SELECT count(*)
			FROM $wpdb->posts
				INNER JOIN $wpdb->term_relationships as r1 ON ($wpdb->posts.ID = r1.object_id)
				INNER JOIN $wpdb->term_taxonomy as t1 ON (r1.term_taxonomy_id = t1.term_taxonomy_id)
			WHERE 
				post_password = ''
				AND post_status =  'publish'
				AND t1.taxonomy = 'category'
				AND t1.term_id = ".$cat."";
				$posts = $wpdb->get_var($sql);
				$posts = $posts - 3;
				$number_of_articles = $posts;
			
			global $wpdb;
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
				AND t1.term_id = ".$cat."";
				$cons_comments = $wpdb->get_var($sql);

			$cons_type='done';
			$data['all_data'] = $data['all_data']. get_consultations_one($cons_type,$the_post,$cat_namez,$cat,$expires,$excerpt,$number_of_articles,$cons_comments);
		}
	}
	
	return $data;
}


function get_cons_posts_list($p_id,$nav_title){
	$options = get_option('consultation_options');	
	$p_category = get_the_category($p_id);
	$c_ID;
	foreach ($p_category as $p_cat) {
		$ID = $p_cat->cat_ID;
		if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])){
			$c_ID = $ID;
			
			break;
		}
	}
	query_posts('posts_per_page=-1&cat='.$c_ID); 


	echo'<div style="clear:both;"></div>';
	echo'<div class="row">';
		echo'<div class="panel panel-default">';
        	echo'<div class="panel-heading">';
            	echo'<div class="panel-title">'.$nav_title.'</div>';
            echo'</div>';//class="panel-heading"
       
            //<!-- START list group-->
            echo'<div class="slimscrollFiles" id="slimscrollFiles">';
            
	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			if (count($category)>1) { continue; }
			else{
				global $post;
				
				if ($post->ID == $p_id){
					
					 echo'<a href="#" class="list-group-item bg-gray"	>';
                    	echo'<div class="media-box">';
                             echo'<div class="media-box-body clearfix">';
                            	echo'<span class="pull-left">';
                            	if($post->comment_status=='open'){
                            	echo'<div class="pull-left label label-success">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια </div>';
                            	}else{
                            	echo'<div class="pull-left label label-danger">';
                            		
                            	echo' κλειστό </div>';
                            	}
                            		
                            		//comments_popup_link('0 Σχόλια','1 Σχόλιο','% Σχόλια'); 
                            	echo'</span>';
                                echo'<small> &nbsp;&nbsp; - ';
                                the_title(); 
                                echo'</small>';
                        	echo'</div>';
                        echo'</div>';
                    echo'</a>';
				}else{
					//<!-- START list group item-->
                    echo'<a class="list-group-item" href="'.get_permalink().'" >';
                    	echo'<div class="media-box">';
                             echo'<div class="media-box-body clearfix">';
                             	if($post->comment_status=='open'){
                            	echo'<div class="pull-left label label-success">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια </div>';
                            	}else{
                            	echo'<div class="pull-left label label-danger">';
                            		
                            	echo' κλειστό </div>';
                            	}
                            
                                echo'<small> &nbsp;&nbsp; - ';
                                the_title(); 
                                echo'</small>';   
                        	echo'</div>';
                        echo'</div>';
                    echo'</a>';
				}
			}
		}
	}
	?>
	
	     <!-- END list group item-->
            
            </div>
                           <!-- END list group-->
                           <!-- START panel footer-->
                          
                           <!-- END panel-footer-->
                        </div>
                     </div>
                     
                  
        <?php
	wp_reset_query() ;
}

function get_cons_posts_list_timeline($p_id,$nav_title){
	$options = get_option('consultation_options');	
	$p_category = get_the_category($p_id);
	$c_ID;
	foreach ($p_category as $p_cat) {
		$ID = $p_cat->cat_ID;
		if (($ID !=$options['cat_close'] ) && ($ID != $options['cat_open'])){
			$c_ID = $ID;
			
			break;
		}
	}
	query_posts('posts_per_page=-1&cat='.$c_ID); 

	if (have_posts()) {
		while (have_posts()) { 
			the_post(); 
			$category = get_the_category();
			if (count($category)>1) { continue; }
			else{
				global $post;
				
				if ($post->ID == $p_id){
								echo'<p>';
					        	echo'<span class="pull-left">';
                            	if($post->comment_status=='open'){
                            	echo'<span class="pull-left label label-success">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια </span>';
                            	}else{
                            	echo'<span class="pull-left label label-danger">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια </span>';
                            	}
                          
                            	echo'</span>';
                                echo'<small> &nbsp;&nbsp; - ';
                                the_title(); 
                                echo'</small>';
                                echo'</p>';
                    
				}else{
					//<!-- START list group item-->
								echo'<p>';
                             	if($post->comment_status=='open'){
                            	echo'<span class="pull-left label label-success">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια </span>';
                            	}else{
                            	echo'<span class="pull-left label label-danger">';
                            	comments_number( '0', '1', '%' );
                            	echo' σχόλια  </span>';
                            	}
                            	echo'</span>';
                                echo'<small> &nbsp;&nbsp; - ';
                                the_title(); 
                                echo'</small>';
                                echo'</p>';   
                      
				}
			}
		}
	}
	?>
	
	  
                  
        <?php
	wp_reset_query() ;
}


function redirector(){
	// Redirect 404 Errors
	if (is_404() || is_archive()){
		header("Location: ".URL."");
	}
	$options = get_option('consultation_options');	
	
	// Redirect Intro & Outro Categories
	if (is_category($options['cat_close']) || is_category($options['cat_open'])|| is_category($options['cat_results'])) {
		header("Location: ".URL."");
	}
	
	// Redirect Categories to Intro Posts
	if (is_category()){
		$cur_cat_id = getCurrentCatID(); 
		//global $cnt;
		query_posts('cat='.$options['cat_open']);  
		if (have_posts()) {
			while (have_posts()) { 
				the_post(); 
				global $post;
				if (in_category($cur_cat_id)) {
					header("Location: ".URL."/?p=".$post->ID);
				}	
			}
		}
		wp_reset_query() ;
	}
	if (!empty($_GET['ec'])){
		exporter();
	}
	if (!empty($_GET['wdg'])){
		widgeter($_GET['num']);
	}
}

function is_open($cons_id){
	global $wpdb;
    $poststable = $wpdb->posts;
	$tp = $wpdb->prefix;
	
	$sql= "SELECT COUNT(*) FROM $poststable  
			INNER JOIN {$tp}term_relationships as r1 
				ON ($poststable.ID = r1.object_id) 
			INNER JOIN {$tp}term_taxonomy as t1 
				ON (r1.term_taxonomy_id = t1.term_taxonomy_id) 
			WHERE  post_password = '' 
				AND comment_status = 'open' 
				AND t1.taxonomy = 'category' 
				AND t1.term_id = ".$cons_id."";
	
	$open_posts = $wpdb->get_var($sql);
	if ($open_posts > 0){ return true;	}
	return false;
}

function print_document($type='', $start='', $end='',$difference=''){ ?>
	<div class="panel panel-default">
			<div class="panel-heading" 
				<?php if ($type=='results') echo "style='background-color: #37bc9b; color:white;'";?>
			> 
				<div class="panel-title">
						<h4><?php the_title(); ?></h4>
				</div>
			</div>
			<div class="panel-body ">
				<?php if ( $start!=''){ ?>
				   <div class="hidden-lg hidden-sm">
				   <em class="fa fa-hourglass-start fa-fw"></em>
				   <span>Απομένουν</span>
				   <span class="text-success"><? echo $difference; ?></span><span> μέρες</span><br/>
				   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Ξεκίνησε στις</span>
				   <span class="text-success"><? echo $start; ?></span><br/>
				   <em class="fa fa-clock-o fa-fw"></em>
				   <span>Κλείνει στις</span>
				   <span class="text-danger"><? echo $end; ?></span>
				   </div>
				<?php } ?>
				   
				<?php the_content(''); ?>
			</div><!--panel-body-->
			<div class="panel-footer ">
				</div><!--class="panel-footer "-->
	</div> <!--class="panel panel-default"-->	
<?php } 


?>
