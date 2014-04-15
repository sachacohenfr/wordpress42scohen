<?php get_header() ?>
<div id="content">
<?php the_post() //cf. codex the_post() ?>
	<div class="entry">
	
		<h2 class="page-title"><?php if ($arg['id_dailymotion'][0]) {echo "VIDEO :";} else if (has_post_thumbnail() ) {echo "PHOTO :";} ?><?php the_title() ?></h2>
		<div class="entry-content">

		<?php 
			$arg = get_post_custom();
			if ($arg['id_dailymotion'][0]) {?>
				<iframe frameborder='0' width="530" src='http://www.dailymotion.com/embed/video/<?php echo $arg["id_dailymotion"][0]; ?>' allowfullscreen></iframe>
			<?php }
			else if ( has_post_thumbnail() ) {the_post_thumbnail();}
			else {
				?>
					<img src="<?php bloginfo('template_url') ?>/images/notfound_imgvd.jpg" />
					<?php } ?>
  <div><?php echo get_post_meta($post->ID, 'desc_img', true); ?></div>
		<?php the_content() //cf. codex the_content() ?>
		<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
		</div>
	</div><!-- entry -->
<?php if ( get_post_custom_values('comments') ) comments_template() ?>
</div><!-- #content -->
<?php
if (get_the_ID() == 7)
	get_sidebar();
else if (get_the_ID() == 9)
	include(TEMPLATEPATH."/my_sidebar.php");
?>
<?php get_footer() ?>