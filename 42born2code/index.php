<?php get_header() ?>

<div id="content_index">
	<?php if (!is_user_logged_in() ) { ?>
	<div style="float: right">
		<form method="post" action="<?php echo site_url(); ?>/wp-login.php" id="loginform" name="loginform">

 <p>

  <label for="user_login">Identifiant</label>

  <input type="text" tabindex="10" size="20" value="" id="user_login" name="log">

  </p>

  <p>

  <label for="user_pass">Mot de passe</label>

  <input type="password" tabindex="20" size="20" value="" id="user_pass" name="pwd">

  </p>

 <p><label><input type="checkbox" tabindex="90" value="forever" id="rememberme" name="rememberme">

  Rester connecter</label>

  | <a href="<?php echo site_url(); ?>/wp-login.php?action=lostpassword">Mot de passe oublié</a></p>

  <p>

  <input type="submit" tabindex="100" value="Se connecter" id="wp-submit" name="wp-submit">

  <input type="hidden" value="<?php echo site_url(); ?>" name="redirect_to">

  </p>

 </form>
	</div>
<?php } ?>
</div>
<?php get_footer() ?>