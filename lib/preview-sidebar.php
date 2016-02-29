<div id="sidebar">

	<?php 
		$category = $_GET[preview];
		$options = get_option('consultation_options');	
		$cons_cat = get_category($category);  
		
	?>

	<div class="sidespot red_spot">
		
		<?php 
			$expires = explode('@', $cons_cat -> category_description );
			$countdate =  '"'.mysql2date("m/d/Y H:i", $expires[1]).'"'; 
		?>
		<h4>
			Αναρτήθηκε<br />
			<span><?php echo mysql2date("j F Y, H:i", $expires[0]); ?></span><br />
			Ανοικτή σε Σχόλια έως<br />
			<span><?php echo mysql2date("j F Y, H:i", $expires[1]); ?></span>
		</h4>
		<script language="JavaScript">
			TargetDate = <?php echo $countdate; ?>;
			BackColor = "#FFFFCC";
			ForeColor = "navy";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true;
			DisplayFormat = "Απομένουν %%D%% Ημέρες";
			FinishMessage = "Ολοκληρώθηκε.";
		</script>
		<script language="JavaScript" src="<?php echo JS; ?>/countdown.js"></script>
	</div>
	
	<?php
	if ( function_exists( 'get_downloads' ) ){
		$dl = get_downloads('category='.$cons_cat->cat_ID.'');
		if (!empty($dl)) { ?>
		<div class="sidespot orange_spot">
			<h4>Σχετικά Αρχεία</h4>
			<?php	foreach($dl as $d) {
					$date = date("j F Y, H:s", strtotime($d->date));
					echo '<span class="file"><a href="'.$d->url.'" title="(Έκδοση '.$d->version.') Μεταφορτώθηκε '.$d->hits.' φορές" >'.$d->title.'</a></span>';
			 } ?>
		</div>
	<?php } } ?>

	<div class="sidespot">
		
		<h4>Παρακολουθήστε</h4>
		<span class="rss_gray">
			<a href="<?php echo URL; ?>/?feed=comments-rss2&cat=<?php echo $cons_cat->cat_ID; ?>">Σχόλια επι της Διαβούλευσης</a>
		</span>		
		<span class="rss_all">
			<a href="<?php echo URL; ?>/?feed=comments-rss2">Όλα τα Σχόλια</a>
		</span>	
	
		<span class="seperator"></span>
		
		<h4>Εργαλεία</h4>
		<span class="print">
			<a href="<?php echo URL; ?>/?p=<?php echo $post->ID; ?>&print=1">Εκτύπωση</a>
		</span>
		
		<span class="seperator"></span>

		<h4>Στατιστικά</h4>
		<span class="comments_cons">
		<?php
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
				AND t1.term_id = ".$cons_cat->cat_ID."";
				$cons_comments = $wpdb->get_var($sql);
		?>
			<?php echo $cons_comments ; ?> Σχόλια επι της <a href="<?php echo URL.'/?cat='.$cons_cat->cat_ID; ?>">Διαβούλευσης</a>
		</span>
		<span class="comments_all">
		<?php
			global $wpdb;
			$sql =
			"SELECT count(*)
			FROM $wpdb->comments
			WHERE comment_approved = '1'
				AND comment_type = ''";
				$all_comments = $wpdb->get_var($sql);
		?>
			<?php echo $all_comments ; ?> - Όλα τα Σχόλια
		</span>

		<span class="seperator"></span>
	
		<h4>Όλες οι Διαβουλεύσεις</h4>
		<ul>
			<?php get_consultations_list();	?>
		</ul>
	</div>

</div>