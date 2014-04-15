<?php
/*
Template Name: Login Page
*/
?>

<?php get_header() ?>
<div id="content">
<?php the_post() //cf. codex the_post() ?>
	<div class="entry">
		<h2 class="page-title"><?php the_title() ?></h2>
		<div class="entry-content">
		<?php wp_login_form(array('redirect' =>  home_url() )); ?>
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