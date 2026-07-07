<?php if(have_rows('accordion')):?>
	<div class="accordion">

		<?php while(have_rows('accordion')):the_row();?>
			<?php $accordion_title = get_sub_field('title');
				  $accordion_content = get_sub_field('content');
				  $accordion_link 	= get_sub_field('link');
				  $accordion_team = get_sub_field('team_members');?>
			<div class="accordion-toggle">

				<div class="accordion-toggle__inner">
					<span class="accordion-toggle__title"><?= $accordion_title;?></span>
					<svg class="plus" width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
						<line x1="23.8348" x2="23.8348" y2="46.669" stroke="black"/>
						<line x1="46.6692" y1="23.835" x2="0.000193274" y2="23.835" stroke="black"/>
					</svg>
				</div>
			

			</div>
			<div class="accordion-content">
				<div class="accordion-content__inner">
					<div class="row">
						<div class="col-xs-12">
							<?= $accordion_content;?>
						</div>
	
					</div>
				</div>
			</div>
		<?php endwhile;?>

	</div>
<?php endif;?>