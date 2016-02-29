<div class="wrap">
	<div class="icon32" id="icon-edit-comments"><br></div>
	<h2>Επεξεργασία Διαβουλεύσεων</h2>
	
	<?php if(isset($_POST['consultation_edit'])) { ?>
		<div class="updated fade below-h2" id="message"><p>
			<?php update_consultation(); ?>
			H Διαβούλευση <em><?php echo get_cat_name($_GET['cons']); ?></em> Αναβαθμίστηκε.	
		</p></div>
	<?php	} ?>
	
	<?php if(isset($_GET['open']) || isset($_GET['close'])) { ?>
		<div class="updated fade below-h2" id="message"><p>
			<?php
				if (isset($_GET['open'])) {
					if (open_consultation($_GET['cons'])){
						echo 'Η Διαβούλευση <em>'.get_cat_name($_GET['cons']).'</em> Άνοιξε!';
					}
				}
				if (isset($_GET['close'])) {
					if (close_consultation($_GET['cons'])){
						echo 'Η Διαβούλευση <em>'.get_cat_name($_GET['cons']).'</em> Έκλεισε!';
					}
				}?>	
		</p></div>
	<?php	} ?>
	
	<?php if(isset($_GET['cons']) && (!isset($_GET['open']))&& (!isset($_GET['close']))){ 
		$consultation = get_category($_GET['cons']); 
		$datez = explode('@', $consultation->description);
		
		$date_hour = explode(' ', $datez[0]);
		$date_split = explode('-', $date_hour[0]);
		$hour_split = explode(':', $date_hour[1]);
		$defaultyear = $date_split[0];
		$defaultmonth = $date_split[1];
		$defaultday = $date_split[2];
		$defaulthour =  $hour_split[0];
		$defaultminute =  $hour_split[1];
		
		$date_hour = explode(' ', $datez[1]);
		$date_split = explode('-', $date_hour[0]);
		$hour_split = explode(':', $date_hour[1]);
		$defaultyear_end = $date_split[0];
		$defaultmonth_end = $date_split[1];
		$defaultday_end = $date_split[2];
		$defaulthour_end =  $hour_split[0];
		$defaultminute_end =  $hour_split[1];
	
	?>
		<form action="#" method="post" enctype="multipart/form-data" name="consultation_form" id="blocks_form">
		
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Τίτλος: </th>
						<td><input type="text" size="100" value="<?php echo get_cat_name($_GET['cons']); ?>" name="cons_title" id="cons_title" ></tr>				
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Ενέργεια: </th>
						<td>
							<?php if(!is_open($_GET['cons'])) { ?>
							[<a href="<?php echo URL; ?>/wp-admin/admin.php?page=edit-consultation-handle&cons=<?php echo $_GET['cons']; ?>&open=1">Άνοιγμα</a>] 
							<?php } else { ?> [<a href="<?php echo URL; ?>/wp-admin/admin.php?page=edit-consultation-handle&cons=<?php echo $_GET['cons']; ?>&close=1">Κλείσιμο</a>]
							<?php } ?>
						</td>
					</tr>				
				</tbody>
			</table>

			
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Ημερομηνία Έναρξης</th>
						<td>
							<input type="text" size="2" value="<?php echo $defaultday; ?>" name="startdate_day" id="startdate_day" >,

							<select id="startdate_month" name="startdate_month">
								<option value="01" <?php if($defaultmonth==01) echo 'selected="selected"'; ?>>Ιανουαρίου</option>
								<option value="02" <?php if($defaultmonth==02) echo 'selected="selected"'; ?>>Φεβρουαρίου</option>
								<option value="03" <?php if($defaultmonth==03) echo 'selected="selected"'; ?>>Μαρτίου</option>
								<option value="04" <?php if($defaultmonth==04) echo 'selected="selected"'; ?>>Απριλίου</option>
								<option value="05" <?php if($defaultmonth==05) echo 'selected="selected"'; ?>>Μαΐου</option>
								<option value="06" <?php if($defaultmonth==06) echo 'selected="selected"'; ?>>Ιουνίου</option>
								<option value="07" <?php if($defaultmonth==07) echo 'selected="selected"'; ?>>Ιουλίου</option>
								<option value="08" <?php if($defaultmonth==08) echo 'selected="selected"'; ?>>Αυγούστου</option>
								<option value="09" <?php if($defaultmonth==09) echo 'selected="selected"'; ?>>Σεπτεμβρίου</option>
								<option value="10" <?php if($defaultmonth==10) echo 'selected="selected"'; ?>>Οκτωβρίου</option>
								<option value="11" <?php if($defaultmonth==11) echo 'selected="selected"'; ?>>Νοεμβρίου</option>
								<option value="12" <?php if($defaultmonth==12) echo 'selected="selected"'; ?>>Δεκεμβρίου</option>
							</select>
							
							<select id="startdate_year" name="startdate_year" >
								<option <?php if($defaultyear==2010) echo 'selected="selected"'; ?>>2010</option>
								<option <?php if($defaultyear==2011) echo 'selected="selected"'; ?>>2011</option>
								<option <?php if($defaultyear==2012) echo 'selected="selected"'; ?>>2012</option>
								<option <?php if($defaultyear==2013) echo 'selected="selected"'; ?>>2013</option>
								<option <?php if($defaultyear==2014) echo 'selected="selected"'; ?>>2014</option>
								<option <?php if($defaultyear==2015) echo 'selected="selected"'; ?>>2015</option>
								<option <?php if($defaultyear==2016) echo 'selected="selected"'; ?>>2016</option>
								<option <?php if($defaultyear==2017) echo 'selected="selected"'; ?>>2017</option>
							</select>
							@ (24Η)<input type="text" size="2" value="<?php echo $defaulthour; ?>" name="startdate_hour" id="startdate_hour" >
							:<input type="text" size="2" value="<?php echo $defaultminute; ?>" name="startdate_minute" id="startdate_minute" >
						</td>
					</tr>				
				</tbody>
			</table>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Ημερομηνία Λήξης</th>
						<td>
							<input type="text" size="2" value="<?php echo $defaultday_end; ?>" name="expirationdate_day" id="expirationdate_day" >,

							<select id="expirationdate_month" name="expirationdate_month">
								<option value="01" <?php if($defaultmonth_end==01) echo 'selected="selected"'; ?>>Ιανουαρίου</option>
								<option value="02" <?php if($defaultmonth_end==02) echo 'selected="selected"'; ?>>Φεβρουαρίου</option>
								<option value="03" <?php if($defaultmonth_end==03) echo 'selected="selected"'; ?>>Μαρτίου</option>
								<option value="04" <?php if($defaultmonth_end==04) echo 'selected="selected"'; ?>>Απριλίου</option>
								<option value="05" <?php if($defaultmonth_end==05) echo 'selected="selected"'; ?>>Μαΐου</option>
								<option value="06" <?php if($defaultmonth_end==06) echo 'selected="selected"'; ?>>Ιουνίου</option>
								<option value="07" <?php if($defaultmonth_end==07) echo 'selected="selected"'; ?>>Ιουλίου</option>
								<option value="08" <?php if($defaultmonth_end==08) echo 'selected="selected"'; ?>>Αυγούστου</option>
								<option value="09" <?php if($defaultmonth_end==09) echo 'selected="selected"'; ?>>Σεπτεμβρίου</option>
								<option value="10" <?php if($defaultmonth_end==10) echo 'selected="selected"'; ?>>Οκτωβρίου</option>
								<option value="11" <?php if($defaultmonth_end==11) echo 'selected="selected"'; ?>>Νοεμβρίου</option>
								<option value="12" <?php if($defaultmonth_end==12) echo 'selected="selected"'; ?>>Δεκεμβρίου</option>
							</select>
							
							<select id="expirationdate_year" name="expirationdate_year" >
								<option <?php if($defaultyear_end==2010) echo 'selected="selected"'; ?>>2010</option>
								<option <?php if($defaultyear_end==2011) echo 'selected="selected"'; ?>>2011</option>
								<option <?php if($defaultyear_end==2012) echo 'selected="selected"'; ?>>2012</option>
								<option <?php if($defaultyear_end==2013) echo 'selected="selected"'; ?>>2013</option>
								<option <?php if($defaultyear_end==2014) echo 'selected="selected"'; ?>>2014</option>
								<option <?php if($defaultyear_end==2015) echo 'selected="selected"'; ?>>2015</option>
								<option <?php if($defaultyear_end==2016) echo 'selected="selected"'; ?>>2016</option>
								<option <?php if($defaultyear_end==2017) echo 'selected="selected"'; ?>>2017</option>
							</select>
							@ (24Η)<input type="text" size="2" value="<?php echo $defaulthour_end; ?>" name="expirationdate_hour" id="expirationdate_hour" >
							:<input type="text" size="2" value="<?php echo $defaultminute_end; ?>" name="expirationdate_minute" id="expirationdate_minute" >
						</td>
					</tr>				
				</tbody>
			</table>
		
			<p class="submit">
				<input class="button-primary" type="submit" name="consultation_edit" value="Αποθήκευση" />
			</p>
		</form>
	<?php } ?>
</div>

<?php $consultations = get_categories(); 
	$options = get_option('consultation_options');
	?> 
<table cellspacing="0" class="widefat fixed">
	<thead>
	<tr>
	<th style="" class="manage-column column-name" id="name" scope="col">Τίτλος</th>
	<th style="" class="manage-column column-posts" id="slug" scope="col">Ανοιχτή / Κλειστή</th>
	<th style="" class="manage-column column-posts" id="date" scope="col">Ημ. Ολοκλήρωσης</th>
	<th style="" class="manage-column column-posts num" id="posts" scope="col">Επεξεργασία</th>
	<th style="" class="manage-column column-posts num2" id="posts" scope="col">Προβολή</th>
	</tr>
	</thead>

	<tfoot>
	<tr>
	<th style="" class="manage-column column-name" id="name" scope="col">Τίτλος</th>
	<th style="" class="manage-column column-posts" id="slug" scope="col">Ενέργεια</th>
	<th style="" class="manage-column column-posts" id="date" scope="col">Ημ. Ολοκλήρωσης</th>
	<th style="" class="manage-column column-posts num" id="posts" scope="col">Επεξεργασία</th>
	<th style="" class="manage-column column-posts num2" id="posts" scope="col">Προβολή</th>
	</tr>
	</tfoot>
	
	<?php  foreach ($consultations as $consultation) { 
		if (($consultation->term_id == $options['cat_close']) ||
			($consultation->term_id == $options['cat_open']) ||
			($consultation->term_id == $options['cat_results'] )) { continue; }
		?>
		
		<tbody class="list:cat" id="the-list">
			<tr class="iedit alternate" id="cat-1">
				<td class="name column-name">
					<a href="<?php echo URL; ?>/wp-admin/edit.php?s&post_status=all&mode=list&action=-1&m=0&cat=<?php echo $consultation->term_id ; ?>&action2=-1"><?php echo $consultation->name; ?></a>
				</td>
				<td class="slug column-posts">
					<?php if(!is_open($consultation->term_id)) {?>
					[<a href="<?php echo URL; ?>/wp-admin/admin.php?page=edit-consultation-handle&cons=<?php echo $consultation->term_id ; ?>&open=1" style="color:green;"> Άνοιγμα </a>]
					<?php } else {?>
					[<a href="<?php echo URL; ?>/wp-admin/admin.php?page=edit-consultation-handle&cons=<?php echo $consultation->term_id; ?>&close=1" style="color:red;"> Κλείσιμο </a>] 
					<?php }	?>
				</td>
				<td class="slug column-posts">
				<?php 
					$dateNow =  ''.date('Y').'-'.date('m').'-'.date('d').' '.date('H').':'.date('i') ;	
					$dates = explode('@',$consultation->description); 
					if(strtotime($dates[1]) < strtotime($dateNow)){ 
						echo '<font color="red"><em>'.mysql2date("j M Y, H:i", $dates[1]).'</em></font>';	
					} else {
						echo '<font color="green"><em>'.mysql2date("j M Y, H:i", $dates[1]).'</em></font>';
					}
				?>
				</td>
				<td class="posts column-posts num">
					<a href="<?php echo URL; ?>/wp-admin/admin.php?page=edit-consultation-handle&cons=<?php echo $consultation->term_id; ?>">Επεξεργασία</a>
				</td>
				<td class="posts column-posts num2">
					<?php if(!is_open($consultation->term_id)) {
							if(strtotime($dates[1]) < strtotime($dateNow)){ ?>
								<a href="<?php echo URL; ?>/?cat=<?php echo $consultation->term_id; ?>" style="color:red;">Προβολή</a> 
					<?php 	} else { ?>
						<a href="<?php echo URL; ?>/?preview=<?php echo $consultation->term_id; ?>" style="color:green;">Προεπισκόπηση</a>
					<?php 	} 
						} else {
					?>
						<a href="<?php echo URL; ?>/?cat=<?php echo $consultation->term_id; ?>" style="color:red;">Προβολή</a> 
					<?php }	?>
				</td>
			</tr>	
		</tbody>
	<?php  } ?>
</table>

<?php
function open_consultation($cons_id){
	global $wpdb;
    $poststable = $wpdb->posts;
	$tp = $wpdb->prefix;
	
	$sql= "SELECT ID FROM $poststable  
			INNER JOIN {$tp}term_relationships as r1 
				ON ($poststable.ID = r1.object_id) 
			INNER JOIN {$tp}term_taxonomy as t1 
				ON (r1.term_taxonomy_id = t1.term_taxonomy_id) 
			WHERE  post_password = '' 
				AND post_status = 'publish' 
				AND t1.taxonomy = 'category' 
				AND t1.term_id = ".$cons_id."";		
	$post_list = $wpdb->get_col($sql);
	
	$sql = "UPDATE $poststable SET comment_status = 'open'
		WHERE post_status = 'publish'
		AND ID in (";
	$first = true;	
	foreach ($post_list as $post){
		if ($first){
			$sql .=" ".$post;
			$first = false;
		}else{
			$sql .=", ".$post;
		}
	}
	$sql .=	")";
	$wpdb->query($sql);
	return true;
}

function close_consultation($cons_id){
global $wpdb;
    $poststable = $wpdb->posts;
	$tp = $wpdb->prefix;
	
	$sql= "SELECT ID FROM $poststable  
			INNER JOIN {$tp}term_relationships as r1 
				ON ($poststable.ID = r1.object_id) 
			INNER JOIN {$tp}term_taxonomy as t1 
				ON (r1.term_taxonomy_id = t1.term_taxonomy_id) 
			WHERE  post_password = '' 
				AND post_status = 'publish' 
				AND t1.taxonomy = 'category' 
				AND t1.term_id = ".$cons_id."";		
	$post_list = $wpdb->get_col($sql);
	
	$sql = "UPDATE $poststable SET comment_status = 'closed', ping_status = 'closed'
		WHERE post_status = 'publish'
		AND ID in (";
	$first = true;	
	foreach ($post_list as $post){
		if ($first){
			$sql .=" ".$post;
			$first = false;
		}else{
			$sql .=", ".$post;
		}
	}
	$sql .=	")";
	$wpdb->query($sql);
	return true;
}

function update_consultation(){
	global $wpdb;

	$dateExpSet = ''.$_POST['expirationdate_year'].'-'.$_POST['expirationdate_month'].'-'.$_POST['expirationdate_day'].' ';
	$dateExpSet .= ''.$_POST['expirationdate_hour'].':'.$_POST['expirationdate_minute'];
	$dateStrSet = ''.$_POST['startdate_year'].'-'.$_POST['startdate_month'].'-'.$_POST['startdate_day'].' ';
	$dateStrSet .= ''.$_POST['startdate_hour'].':'.$_POST['startdate_minute'];
	$dateNow =  ''.date('Y').'-'.date('m').'-'.date('d').' '.date('H').':'.date('i') ;			

	if(strtotime($dateExpSet) < strtotime($dateNow)){ 
		$month = date('m');
		$day = '01';
		if ($month ==12 ) { $month = '01'; 
			$year = date('Y') + 1; 
			$dateDef =  ''.$year.'-'.$month.'-'.$day.' '.date('H').':'.date('i') ;	
		} else {
			$dateDef =  ''.date('Y').'-'.$month.'-'.$day.' '.date('H').':'.date('i') ;	
		}
		$dateExpSet = $dateDef; 
	} 
	
	if(strtotime($dateStrSet) < strtotime($dateNow)){ 
		$month = date('m');
		$day = '01';
		if ($month ==12 ) { $month = '01'; 
			$year = date('Y') + 1; 
			$dateDef =  ''.$year.'-'.$month.'-'.$day.' '.date('H').':'.date('i') ;	
		} else {
			$dateDef =  ''.date('Y').'-'.$month.'-'.$day.' '.date('H').':'.date('i') ;	
		}
		$dateStrSet = $dateDef ;
	} 
	
	wp_update_term($_GET['cons'], 'category', array('name' => trim($_POST['cons_title']),'description' => ''.$dateStrSet.'@'.$dateExpSet.''));

}
?>