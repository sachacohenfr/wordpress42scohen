<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" value="<?php _e("Faites ici votre recherche"); ?>" name="s" id="searchbox" onfocus="if (this.value == '<?php _e("Faites ici votre recherche"); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e("Faites ici votre recherche"); ?>';}" />
	<input type="submit" id="searchsubmit" value="<?php _e("0k"); ?>" />
</form>