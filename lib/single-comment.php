<?php 
	get_header();
	$c = mysqli_real_escape_string($_GET['c']);
	//$c=$_GET['c'];
	$the_comment = get_comment($_GET['c']); 
	
?>
	<div id="comments">
		<ul>
			<li  class="media" style="border-left:2px solid #ddd;">
			<?php if ($the_comment->comment_approved == '1') { ?>
				<div class="comment-body media-left" style="border-top: 2px solid #ddd;background-color:white;">
				<?php 
					echo get_avatar($the_comment, '80');		
				?>
				</div><!--media-left-->
				<?php
				echo '<div class="comment-content media-body" style="border-top: 2px solid #ddd; background-color:white;" >';
				echo'<div class="row">';
					echo'<div class="col-lg-9 col-xs-12">';
						$auth_link = $the_comment->comment_author_url ;  
						if (url_exists($auth_link)){ ?>
							Σχόλιο του χρήστη <span class="text-purple text-bold"><a href="<?php echo $auth_link; ?>" target="_blank" rel="nofollow"><?php echo $the_comment->comment_author; ?></a></span>
						<?php } else { ?>
							Σχόλιο του χρήστη <span class="text-purple text-bold"><?php echo $the_comment->comment_author; ?></span>
						<?php }	 
					//which time
					echo'<br/>';
					echo '<small><time datetime="';
						comment_time('c');
					echo '">';
					echo mysql2date("j F Y, H:s", $the_comment->comment_date);
					echo '</time></small>';
					
					echo'<p>';
				// comment content body
				echo  apply_filters('the_content', $the_comment->comment_content);
				// end comment content body
				echo'</p>';
				echo'</div>';
				
				$comment_link = URL.'/?c='.$comment->comment_ID;
			?>
			
			
				<div class="col-lg-3 col-xs-12 ">
				<div class="pull-right">
					<div role="group" class="btn-group  pull-right">
					   <a class="btn btn-default socials fb" href="<?php echo $comment_link; ?>">
						  <em class="fa fa-facebook text-muted"></em>
					   </a>
						<a class="btn btn-default socials tw" href="<?php echo $comment_link; ?>">
						 <em class="fa fa-twitter text-muted"></em>
					   </a>
					   <a class="btn btn-default socials mail" href="<?php echo $comment_link; ?>">
						 <em class="fa fa-envelope text-muted"></em>
					   </a>
                    </div>
                    <br/>
                    <br/>
                    	
                   <?
                    echo'<div>';
                	    //echo' <button type="button" class="btn btn-default">';
                    	// The default Wordpress Comment link -> echo esc_url(get_comment_link($comment->comment_ID));
                    
			        	echo '<a href="'.$comment_link .'" title="" class="permalink btn btn-default">';
						echo '<span class="text-info"><em class="fa fa-link"></em></span> &nbsp;'; 
						echo 'Μόνιμος Σύνδεσμος</a>';
			        	//echo'</button>';
			        echo'</div>';
					?>
             
                     <br/>
                     
                    
                </div><!--pull-right-->
                </div><!--col-lg-3 col-xs-12 -->
            </div><!--row-->
			
				
			<?php } else { ?>
				<div class="col-lg-12 col-xs-12 ">
					Το Σχόλιο δεν εντοπίστηκε.
				</div>
			<?php
			} ?>
		</li></ul>			
	</div>	

<?php 
	get_footer(); 
?>