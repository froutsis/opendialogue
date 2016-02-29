<?php  redirector(); ?>
<?php $options = get_option('consultation_options'); ?>
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>		<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>		<html class="no-js lt-ie9 ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>		<html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo IMG; ?>/favicon.ico" />
	<link rel="shortcut icon" href="<?php echo IMG; ?>/favicon.ico" />

	
	<script src="<?php echo JS; ?>/modernizr.js"></script>
	
	<title><?php headtitles(); ?></title>
	
	<?php
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!--[if lt IE 8]>
<p class="browsehappy">
	<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to be able to experience this site.', 'opengov'); ?>
</p><![endif]-->
<no-script>
 <p id="no-js-warning">
	<?php _e(' It seems you have <strong>disabled</strong> javascript. Please <strong><a href="http://www.enable-javascript.com/">enable javascript</a></strong> for this site to function properly.', 'opengov'); ?>
  </p>
</no-script>

	<header>
	
	<div id="top_bar" class="light">
        <div class="container">
            <div class="row">
            	<div class="col-lg-8 col-xs-12 col-sm-6 col-md-8  hidden-xs">
            	<!-- <nav class="navbar" role="navigation"> -->
            	 
            	<?php
			/*	wp_nav_menu( array(
					'menu'       		=> 'top-menu',
					'theme_location' 	=> 'top-menu',
					'container'  		=> false,
					'menu_class'        => 'nav navbar-nav pull-right',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker()
					)
				);*/
			?>
				<!--</nav>-->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  pull-right">
                <form class="navbar-form" method="get" action="<?php echo URL; ?>" role="search">
					<div class="form-group">
				  	<label for="s" style='padding-right:7px';><i class="fa fa-search text-white hidden-xs"></i></label>
				  	<input type="text" name="s" class="form-control" style="height: 27px!important; border-radius: 0px !important;" placeholder="Αναζήτηση.." value="" />
					</div>
				</form>
            </div>
        	</div><!-- end row -->
    	</div><!-- end container -->
    </div>
	<nav class="navbar navbar-blue navbar-static-top">
      <div class="container">
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
        	<div class="navbar-header logo">
         		<a href="<?php echo URL; ?>" title="<?php echo NAME; ?>">	
						<?php if($options['logo'] != '') { ?>
							<img src="<?php echo $options['logo']; ?>" alt="<?php echo NAME; ?>" title="<?php echo NAME; ?>" class="pull-left" />
						<?php } ?>
						<?php echo NAME; ?><br />
						<span><?php echo DESCRIPTION; ?></span>
				</a>
			</div>
		</div>
        
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
        	 <!--for mobile collapse-->
        	 <div class="navbar-header">
      			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      			</button>
      		</div>
      		<!--for mobile collapse-->
			<div class="navbar-collapse collapse" role="navigation" id="navbar-collapse">
						<?php
							// TODO: Make it collapsable
							wp_nav_menu( array(
								'menu'       		=> 'main-menu',
								'container'  		=> false,
								'menu_class'        => 'nav navbar-nav pull-right',
								'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
								'walker'            => new wp_bootstrap_navwalker()
								)
							);
						?>
					</nav>
				</div>
      </div>
    </nav>
  
   
	</header>
	
	<section>

	<?php global $cnt; echo $cnt;?>
	<div id="content">
		<div class="container">
		 <div class="col-md-12">
		<?php if((!is_home()) || (!empty($_GET['c'])) ){ my_breadcrumb(); } ?>
