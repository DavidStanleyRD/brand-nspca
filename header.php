<?php
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php $favicon = get_field('favicon', 'options');?>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon['url'];?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicon['url'];?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon['url'];?>">
	<link rel="shortcut icon" href="<?php echo $favicon['url'];?>">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	
	<title>
		<?php bloginfo('name'); // show the blog name, from settings ?> | 
		<?php is_front_page() ? bloginfo('description') : wp_title(''); // if we're on the home page, show the description, from the site's settings - otherwise, show the title of the post or page ?>
	</title>

	<?php $fonts = get_field('fonts', 'options');
		  $fontchoice = $fonts['font_choice'];
		  $google_font_link = $fonts['google_font_link'];
		  $google_font_name = $fonts['google_font_name'];
		  $boldwoff = $fonts['bold_woff'];
		  $boldwoff2 = $fonts['bold_woff2'];
		  $regularwoff = $fonts['regular_woff'];
		  $regularwoff2 = $fonts['regular_woff2'];

		  $custom_css = get_field('custom_css', 'options');

		  $buttons = get_field('buttons', 'options');
		//   $button_colour = $buttons['button_colour'];
		//   $button_text_colour = $buttons['button_text_colour'];
		//   $button_hover_colour = $buttons['button_hover_colour'];
		//   $button_hover_text_colour = $buttons['button_hover_text_colour'];
		  $button_icon = $buttons['button_icon'];
		  $button_hover_icon = $buttons['button_hover_icon'];
		  $button_border_radius = $buttons['button_border_radius'];

		  $lower_footer = get_field('lower_footer', 'options');
		  $lower_footer_background_colour = $lower_footer['lower_footer_background_colour'];
		  $lower_footer_text_colour = $lower_footer['lower_footer_text_colour'];

		  $floating_notice = get_field('floating_notice', 'options');
		  $floating_notice_enabled = $floating_notice['floating_notice_enabled'];
		  $floating_notice_position = $floating_notice['floating_notice_position'];
		  $floating_notice_content = $floating_notice['floating_notice_content'];
		  $floating_notice_background_colour = $floating_notice['floating_notice_background_colour'];
		  $floating_notice_text_colour = $floating_notice['floating_notice_text_colour'];

	?>

	<?php if($fontchoice == 'google'):?>
	<?php echo $google_font_link;?>
	<style>
		
		body {
			<?php echo $google_font_name; ?>
			font-weight: 300;
		}
		h1,h2,h3,h4,h5 {
			font-weight: 300;
		}
		b, strong {
			font-weight: 600;
		}
		.btn {
			font-weight: 300;
		}
	</style>		  
	<?php else: ?>

	<style>
		<?php if($boldwoff || $boldwoff2):?>
		@font-face {
			font-family: <?php echo ($boldwoff ? $boldwoff['title'] : $boldwoff2['title']);?>;
			src: <?php if($boldwoff):?>url('<?php echo $boldwoff['url'];?>') format('WOFF')<?php endif;?>
			<?php if($boldwoff && $boldwoff2):?>, <?php endif;?>
			<?php if($boldwoff2):?>url('<?php echo $boldwoff2['url'];?>') format('WOFF2')<?php endif;?>;
		}
		<?php endif;?>
		<?php if($regularwoff || $regularwoff2):?>
		@font-face {
			font-family: <?php echo ($regularwoff ? $regularwoff['title'] : $regularwoff2['title']);?>;
			src: <?php if($regularwoff):?>url('<?php echo $regularwoff['url'];?>') format('WOFF')<?php endif;?>
			<?php if($regularwoff && $regularwoff2):?>, <?php endif;?>
			<?php if($regularwoff2):?>url('<?php echo $regularwoff2['url'];?>') format('WOFF2')<?php endif;?>;
		}
		<?php endif;?>
		<?php if($regularwoff || $regularwoff2):?>
		body {
			font-family: <?php echo ($regularwoff ? $regularwoff['title'] : $regularwoff2['title']);?>;
			font-weight: normal;
		}
		h1,h2,h3,h4,h5 {
			font-family: <?php echo ($regularwoff ? $regularwoff['title'] : $regularwoff2['title']);?>;
			font-weight: normal;
		}
		.btn {
			font-family: <?php echo ($regularwoff ? $regularwoff['title'] : $regularwoff2['title']);?>;
			font-weight: normal;
		}
		<?php endif;?>
		<?php if($boldwoff || $boldwoff2):?>
		/* b,strong {
			font-family: <?php echo ($boldwoff ? $boldwoff['title'] : $boldwoff2['title']);?>;
			font-weight: normal;
		} */
		<?php endif;?>
	</style>	

	<?php endif;?>
	
	<?php $header_border_radius = get_field('header_border_radius', 'options');?>
	<?php if($header_border_radius):?>
		<style>
			header > .wrapper {
				border-radius: <?php echo $header_border_radius;?>px;
			}
		</style>
	<?php endif;?>

	<?php $header_bg = get_field('header_background_colour', 'option'); 
	  $header_text_colour = get_field('header_text_colour', 'options');
	  $header_style = get_field('header_style', 'options');
	  $nav_active_colour = get_field('nav_active_colour', 'options');
	  $nav_hover_colour = get_field('nav_hover_colour', 'options');
	  $search_icon = get_field('search_icon', 'options');
	  $header_border_radius = get_field('header_border_radius', 'options');
?>

<style>
	
	<?php if($header_style == 'full-width'):?>
		header {
			background: <?php echo $header_bg; ?>;
		}
	<?php else:?>
		header > .wrapper {
			background: <?php echo $header_bg; ?>;
		}
	<?php endif;?>

	header > .wrapper {
		color: <?php echo $header_text_colour; ?>;
		border-radius: <?php echo $header_border_radius;?>px;
	}
	/*header ul li ul {
		border-radius: <?php echo $header_border_radius;?>px;
	}*/
	.line {
		background: <?php echo $header_text_colour;?>;
	}
	.mobile-navigation {
		background: <?php echo $header_bg; ?>;
		color: <?php echo $header_text_colour; ?>;
	}
	.mobile-navigation a {
		color: <?php echo $header_text_colour; ?>;
	}
	header ul li a {
		color: <?php echo $header_text_colour; ?>;
	}
	header ul li.current_page_item a {
		color: <?php echo $nav_active_colour; ?>;
	}
	header ul li a:hover {
		color: <?php echo $nav_hover_colour;?>;
	}
	header ul li a:focus {
		color: <?php echo $nav_hover_colour;?>;
	}
	header ul {
/*		background-color: <?php echo $header_bg; ?>;*/
	}
	header ul.sub-menu {
		background-color: <?php echo $header_bg; ?>;
	}

	.btn {
		border-radius: <?php echo $button_border_radius;?>;
	}
	.btn.download.normal::after {
		background-image: url(' <?php echo $button_icon['url'];?> ');
	}
	.btn.download.reversed::after {
		background-image: url(' <?php echo $button_hover_icon['url'];?> ');
	}
	.btn.download:hover {
		/* background-color: <?php echo $button_hover_colour;?>; */
		/* color: <?php echo $button_hover_text_colour; ?>; */
	}
	.btn.download::after {
		/* background-image: url(' <?php echo $button_icon['url'];?> '); */
	}
	.btn.download:hover:after {
		/* background-image: url(' <?php echo $button_hover_icon['url'];?> '); */
	}
	.lower-footer {
		background-color: <?php echo $lower_footer_background_colour;?>;
		color: <?php echo $lower_footer_text_colour;?>;
	}
	.lower-footer a {
		color: <?php echo $lower_footer_text_colour;?>;
	}

	<?php if($custom_css):?>
		<?php echo $custom_css;?>
	<?php endif;?>
</style>


	<?php wp_head(); ?>	
	
</head>


<body <?php body_class(); ?>>

<?php if($floating_notice_enabled == 'enabled'):?>
	<style>
		.floating-notice {
			background-color: <?php echo $floating_notice_background_colour;?>;
			color: <?php echo $floating_notice_text_colour;?>;
			<?php if($floating_notice_position == 'left'):?>
				left: 2rem;
			<?php endif;?>
			<?php if($floating_notice_position == 'right'):?>
				right: 2rem;
			<?php endif;?>
		}
	</style>
	<div class="floating-notice">
		<?php echo $floating_notice_content;?>
	</div>
<?php endif;?>

<header class="fixed header-inner">

	<div class="wrapper">
		
		<div class="logo-container">
			<a href="<?php echo home_url(); ?>">
				<?php $logo = get_field('logo', 'option'); ?>
				<img src="<?php echo $logo['url']; ?>" class="logo">
			</a>
		</div>
		
		<div class="navigation-container desktop-navigation">
			<nav class="main-menu main-nav desktop-nav">
				<?php 
					$defaults = array(
						'menu' => 'Main Menu', 
						'container' => '', 
						'items_wrap' => '<ul>%3$s</ul>',
						'walker' => new Custom_Nav_Walker()
					);
					echo wp_nav_menu( $defaults ); 
				?>
			</nav>
			<div class="search-icon">
				<?php if($search_icon):?>
					<img src="<?php echo $search_icon['url'];?>" alt="<?php echo $search_icon['title'];?>" />
				<?php else:?>
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12 9.76142 9.76142 12 7 12C4.23858 12 2 9.76142 2 7C2 4.23858 4.23858 2 7 2C9.76142 2 12 4.23858 12 7ZM11.1922 12.6064C10.0236 13.4816 8.57234 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7C14 8.57234 13.4816 10.0236 12.6064 11.1922L17.2071 15.7929L15.7929 17.2071L11.1922 12.6064Z" fill="white"/>
					</svg>
				<?php endif;?>
			</div>
		</div>
		<div class="hamburger">
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
		</div>

		<div class="mobile-navigation">
			<div class="wrapper">
				<div class="row">
					<div class="col-xs-12">
						<nav class="mobile-nav">
						<?php 
							$defaults = array(
								'menu' => 'Main Menu', 
								'container' => '', 
								'items_wrap' => '<ul>%3$s</ul>',
								'walker' => new Custom_Nav_Walker()
							);
							echo wp_nav_menu( $defaults ); 
						?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</header>

<div class="search-modal">
	<div class="search-modal__inner">
		<div class="search-form">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="search-input-wrapper">
					<input type="search" id="live-search-input" name="s"
					       placeholder="Search..."
					       value="<?php echo esc_attr( get_search_query() ); ?>"
					       autocomplete="off">
					<button type="submit" class="search-submit" aria-label="Search">
						<svg width="20" height="20" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12 9.76142 9.76142 12 7 12C4.23858 12 2 9.76142 2 7C2 4.23858 4.23858 2 7 2C9.76142 2 12 4.23858 12 7ZM11.1922 12.6064C10.0236 13.4816 8.57234 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7C14 8.57234 13.4816 10.0236 12.6064 11.1922L17.2071 15.7929L15.7929 17.2071L11.1922 12.6064Z" fill="currentColor"/>
						</svg>
					</button>
				</div>
			</form>
		</div>
		<div class="search-results" id="live-search-results"></div>
	</div>
	<div class="search-modal__background"></div>
</div>
