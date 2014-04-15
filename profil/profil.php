<?php

/*

 Plugin Name: Profile

 Author : Sacha Cohen 

 Version: 1.0 

*/

function add_social_data($user) {
?> 
 <h3>Infos supplémentaires</h3> 
 <table class="form-table"> 
 	<tr>
 		<th><label for="twitter">Twitter</label></th> 
 		<td><input type="url" name="twitter" id="twitter" value="<?php echo get_the_author_meta( 'twitter', $user->ID ); ?>" class="regular-text" /><br /></td> 
 	</tr>
 	<tr>
 		<th><label for="facebook">Facebook</label></th> 
 		<td><input type="url" name="facebook" id="facebook" value="<?php echo get_the_author_meta( 'facebook', $user->ID ); ?>" class="regular-text" /><br /></td> 
 	</tr>
 	<tr>
 		<th><label for="dailymotion">Dailymotion</label></th> 
 		<td><input type="url" name="dailymotion" id="dailymotion" value="<?php echo get_the_author_meta( 'dailymotion', $user->ID ); ?>" class="regular-text" /><br /></td> 
 	</tr>
 	<tr>
		<th><label for="dailymotion">Video</label></th>
 		<td><?php if (get_the_author_meta( 'dailymotion', $user->ID )) {echo "<iframe frameborder='0' width='480' height='270' src='http://www.dailymotion.com/embed/video/".get_dailymotion_id(get_the_author_meta( 'dailymotion', $user->ID ))."' allowfullscreen></iframe>";} ?></td>
 	</tr>
 	 <tr>
 		<th><label for="indicator">Indicateur d'humeur</label></th> 
 		<td>
 			<select name="indicator" id="indicator">
  				<option value="happy" <?php if (get_the_author_meta( 'indicator', $user->ID ) == 'happy') {echo 'selected="selected"';}?>>Heureux</option>
  				<option value="sad" <?php if (get_the_author_meta( 'indicator', $user->ID ) == 'sad') {echo 'selected="selected"';}?>>Malheureux</option>
  				<option value="angry" <?php if (get_the_author_meta( 'indicator', $user->ID ) == 'angry') {echo 'selected="selected"';}?>>Enervé</option>
			</select>
 		<br /></td> 
 	</tr> 
 </table> 
<?php }

function get_dailymotion_id($url) {
	preg_match("/^.+dailymotion.com\/((video|hub)\/([^_]+))?[^#]*(#video=([^_&]+))?/", $url, $id);
	return $id[3];
}

function save_social_data($user_id) {

if ( !current_user_can( 'edit_user', $user_id)) 
	return FALSE; 
update_usermeta( $user_id, 'twitter', $_POST['twitter']);
update_usermeta( $user_id, 'facebook', $_POST['facebook']);
update_usermeta( $user_id, 'dailymotion', $_POST['dailymotion']);
update_usermeta( $user_id, 'indicator', $_POST['indicator']);

} 

add_action( 'show_user_profile', 'add_social_data'); 
add_action( 'edit_user_profile', 'add_social_data'); 

add_action( 'personal_options_update', 'save_social_data'); 
add_action( 'edit_user_profile_update', 'save_social_data'); 

	

function social_widget_display($args) {
   extract($args);
   if (is_author(1))
   {
   		$before_title = '<h3 class="widget-title">';
   		$after_title = '</h3>';
   		extract($args);
		echo $before_title . 'Social Widget' . $after_title;
		echo $after_widget;
		// print some HTML for the widget to display here
		?>
			<?php if (get_the_author_meta( 'twitter', $user->ID )) {
				?>
					<a target="_blank" href="<?php echo get_the_author_meta( 'twitter', $user->ID ); ?>"><span class="gototwitter"></span></a>
				<?php
				}
			if (get_the_author_meta( 'facebook', $user->ID )) {
				?>
					<a target="_blank" href="<?php echo get_the_author_meta( 'facebook', $user->ID ); ?>"><span class="gotofacebook"></span></a>
				<?php 
			}
			if (get_the_author_meta( 'dailymotion', $user->ID )) {
				?>
					<iframe frameborder='0' width='280'  src='http://www.dailymotion.com/embed/video/<?php echo get_dailymotion_id(get_the_author_meta( 'dailymotion', $user->ID ))?>' allowfullscreen></iframe>
				<?php
				}
			if (get_the_author_meta( 'indicator', $user->ID )) {
					echo "Vous ètes ";
					if (get_the_author_meta( 'indicator', $user->ID ) == 'angry')
						echo "énervé !";
					if (get_the_author_meta( 'indicator', $user->ID ) == 'happy')
						echo "heureux ! :-)";
					if (get_the_author_meta( 'indicator', $user->ID ) == 'sad')
						echo "malheureux. :-(";
				}

   }
}

wp_register_sidebar_widget(
    'social_widget',        // your unique widget id
    'Social Widget',          // widget name
    'social_widget_display',  // callback function
    array(                  // options
        'description' => 'The Social Widget'
    )
);

?>