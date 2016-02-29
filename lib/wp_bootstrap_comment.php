<?php

function bootstrapBasicComment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;

	if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) { 
		echo '<li class="media" id="comment-';
			comment_ID();
			echo '" ';
			comment_class('comment-type-pt');
		echo '>';
		echo '<div class="comment-body media-left"></div>';
		
			echo '<div class="media-body">';
				_e('Pingback:', 'bootstrap-basic');
				comment_author_link(); 
				edit_comment_link(__('Edit', 'bootstrap-basic'), '<span class="edit-link">', '</span>');
			echo '</div>';
		echo '</div>';
	} else {
		echo '<li  class="media" id="comment-';
			comment_ID();
			echo '" ';
			comment_class(empty($args['has_children']) ? '' : 'parent media');
		echo '>';
		
		echo '<div id="auth-div-comment-';
			comment_ID();
		echo '" class="comment-body media-left" style="border-top: 2px solid #ddd;border-left: 2px solid #ddd;background-color:white;">';
			//avatar
			if (0 != $args['avatar_size']) {
			//echo'<a href="#">';
			echo get_avatar($comment, $args['avatar_size']);
			//echo'</a>';
			// footer
			}
		
			echo '</div><!-- .comment-meta -->';
			// end avatar
			
			// comment content
			echo '<div class="comment-content media-body" style="border-top: 2px solid #ddd; background-color:white;" id="div-comment-';
			comment_ID();
			echo '" >';
				echo'<div class="row">';
					echo'<div class="col-lg-9 col-xs-12">';
					// comment author says
					printf(__('%s <span class="says">αναφέρει:</span>', 'bootstrap-basic'), sprintf('<cite class="fn "><span class="text-purple text-bold">%s</span></cite>', get_comment_author_link()));
					//which time
					echo'<br/>';
					echo '<small><time datetime="';
						comment_time('c');
					echo '">';
					printf(_x('%1$s | %2$s', '1: date, 2: time', 'bootstrap-basic'), get_comment_date(), get_comment_time());
					echo '</time></small>';
					// end date-time
					// reply link
					
					// if comment was not approved
					if ('0' == $comment->comment_approved) {
						echo '<div class="comment-awaiting-moderation text-warning alert alert-danger"> ';
							_e('Το σχόλιο σας περιμένει έγκριση από το διαχειριστή.', 'bootstrap-basic');
						echo '</div>';
					} //endif;
				
				echo'<p>';
				// comment content body
				comment_text();
				// end comment content body
				if ('0' != $comment->comment_approved) {
				?>
				  <div role="group" class="">
                    <?
                    $comment_reply_link = get_comment_reply_link(array_merge($args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'reply_text' => '<span class="fa fa-reply"></span> ' . __('Απάντηση', 'bootstrap-basic'),
					'login_text' => '<span class="fa fa-reply"></span> ' . __('Σύνδεση για απάντηση', 'bootstrap-basic')
				)));
					echo str_replace('comment-reply-link','comment-reply-link btn btn-default',   $comment_reply_link);
				?>
                    </div>
                     <br/>
                     <?
					 }
				echo'</p>';
				
				if ('0' != $comment->comment_approved) {
					$comment_link = URL.'/?c='.$comment->comment_ID;
				?>
				</div>
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
                    
			        	echo '<a href="'.$comment_link.'" title="" class="permalink btn btn-default">';
						echo '<span class="text-info"><em class="fa fa-link"></em></span> &nbsp;'; 
						echo 'Μόνιμος Σύνδεσμος</a>';
			        	//echo'</button>';
			        echo'</div>';
					?>
             
                     <br/>
                      <div> 
                     	<?
                    	 global $post;
						if ('open' == $post->comment_status) { 
								echo '<div class="rate text-center">'.do_shortcode( '[rating-system-comments]').'</div>';
					 	} else { 
						// TODO: if closed make this only with code.
							echo '<div class="rate">'.do_shortcode( '[rating-system-comments]').'</div>';
						}
					?>
					</div>
					<br/>
                    
                </div>
                </div>
					<?php
					}
					echo ' ';
					
				echo'</div>';	
					

					//edit_comment_link('<span class="fa fa-pencil-square-o "></span>' . __('Edit', 'bootstrap-basic'), '<span class="edit-link">', '</span>');
					
				//	echo '</div><!-- .comment-metadata -->';
					
			//	echo '</div><!-- .comment-author -->';
				
				
				// end reply link
			echo '</div><!-- .comment-content -->';
			// end comment content
			
		
		
		echo '</li><!-- .comment-body -->';
	} //endif;
}// bootstrapBasicComment

?>
