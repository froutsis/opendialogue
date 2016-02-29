<!-- footer.php-->
	<?php $options = get_option('consultation_options'); ?>
	</div>
	
	</section>
	
	<footer>
		<div class="container">
			<div class="col-md-5">
				<div class=" logo">
         		<a href="<?php echo URL; ?>" title="<?php echo NAME; ?>">	
						<?php if($options['logo'] != '') { ?>
							<img src="<?php echo $options['logo']; ?>" alt="<?php echo NAME; ?>" title="<?php echo NAME; ?>" class="pull-left" />
						<?php } ?>
						<?php echo NAME; ?><br />
						
				</a>
				<span><?php echo DESCRIPTION; ?></span>
				<?php dynamic_sidebar( 'footer-left' ); ?>

			</div>
				
								
			</div>
			<div class="col-md-4 clearfix">
				<?php dynamic_sidebar( 'footer-center' ); ?>

			</div>
			<div class="col-md-3 text-right">
				
				<?php dynamic_sidebar( 'footer-right' ); ?>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>