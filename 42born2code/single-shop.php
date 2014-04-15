<?php get_header() ?>
<div id="content">
	<?php the_post() ?>
	<div class="entry-single">
		<div class="entry-top">
		<?php 
if ( has_post_thumbnail() ) {
  the_post_thumbnail();} ?>
			<h2 class="entry-title"><?php the_title() ?></h2>
		</div>
		<div class="entry-content clearfix">
		<h2 style="font-size: 30px; font-weight: bold;"><?php echo get_post_meta($post->ID, 'price', true); ?> €</h2>
			<?php the_content() ?>
			<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" >
				<input type="hidden" name="cmd" value="_cart">
				<input type="hidden" name="business" value="sacha@blogdesacha.com">
				<input type="hidden" name="lc" value="FR">
				<input type="hidden" name="item_name" value="<?php the_title() ?>">
				<input type="hidden" name="amount" value="<?php echo get_post_meta($post->ID, 'price', true); ?>">
				<input type="hidden" name="currency_code" value="EUR">
				<input type="hidden" name="button_subtype" value="products">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="add" value="1">
				<input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_LG.gif:NonHostedGuest">
				<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
				<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
			</form>

		</div>
		<div class="entry-meta entry-bottom">
			<?php the_tags( __( '<span class="tag-links">Tags: ', 'wpbx' ), ", ", "</span>\n" ) ?>
		</div>
	</div><!-- .post -->

</div><!-- #content -->
<?php get_footer() ?>