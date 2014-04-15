<?php

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Main Menu' ),
		));
}

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 150, true ); // Normal post thumbnails

add_custom_background();

// Custom comment listing
function wpbx_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
    $avatarURL = get_bloginfo('template_directory');
	$avatar = str_replace( "class='avatar", "class='avatar", get_avatar( $avatar_email, 40, $default = $avatarURL . '/images/gravatar-blank.jpg' ) );
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div id="div-comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo $avatar . ' <span class="fn n">' . $commenter . '</span>'; ?>
			</div>
			<div class="comment-meta">
				<?php printf(__('%1$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'wpbx'),
					get_comment_date('j M Y', '', '', false),
					get_comment_time(),
					'#comment-' . get_comment_ID() );
					edit_comment_link(__('Edit', 'wpbx'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>');
				?>
				<span class="reply-link">
					<span class="meta-sep">|</span> <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</span>
			</div>

			<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'wpbx') ?>

			<div class="comment-content"><?php comment_text() ?></div>
		</div>
<?php
}
// wpbx_comment()

// For category lists on category archives: Returns other categories except the current one (redundant)
function wpbx_cat_also_in($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;

	return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function wpbx_tag_also_in($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;

	return trim(join( $glue, $tags ));
}

// Generate custom excerpt length
function wpbx_excerpt_length($length) {
	return 75;
}
add_filter('excerpt_length', 'wpbx_excerpt_length');


// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function wpbx_widgets_init() {
	if ( !function_exists('register_sidebars') ) {
		return;
	}
	// Formats the theme widgets, adding readability-improving whitespace
	$p = array(
		'before_widget'  =>   '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "</li>\n",
		'before_title'   =>   '<h3 class="widget-title">',
		'after_title'    =>   "</h3>\n"
	);
	register_sidebars( 1, $p );
 	register_sidebar( array(
					'name' => 'Team42',
					'before_widget' => '<li id="%1$s" class="widget %2$s">',
					'after_widget' => '</li>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
						));
} // ici on ferme la fonction function wpbx_widgets_init()


// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'wpbx_widgets_init' );

// Adds filters for the description/meta content
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// Translate, if applicable
load_theme_textdomain('wpbx');


// Construct the WordPress header
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_action('wp_head', 'next_post_rel_link');
remove_action('wp_head', 'previous_post_rel_link');

add_action('add_meta_boxes', 'mb_init');
add_action('save_post','save_mb');

function mb_init() {
	add_meta_box('desc_img', 'desc_img', 'ft_desc_img', 'post');
	add_meta_box('desc_img', 'desc_img', 'ft_desc_img', 'page');
}

function save_mb($post_ID) {
	if (isset($_POST['desc_img']))
    	update_post_meta($post_ID,'desc_img', esc_html($_POST['desc_img']));
}
function ft_desc_img($post) {
	$desc = get_post_meta($post->ID, 'desc_img', true);
	echo '<label for="desc_img">Descirption de l\'image à la une : </label>';
	echo '<input id="desc_img" type="text" name="desc_img" value="'.$desc.'" />';
}


 function ft_custom_field($post_id)
 {
 	if (get_post_type($post_id) != 'post') {
 		add_post_meta($post_id, 'id_dailymotion', '', true);}
 	return true;
 }

add_action('wp_insert_post', 'ft_custom_field');
add_action( 'init', 'create_post_type' );


function create_post_type()
{
	    $labels = array( 
        'name' => 'Shop',
        'singular_name' => 'Shop',
        'add_new' => 'Ajouter',
        'add_new_item' => 'Ajouter un produit',
        'edit_item' => 'Editer un produit',
        'new_item' => 'Nouveau produit',
        'view_item' => 'Voir le produit',
        'search_items' => 'Rechercher un produit',
        'not_found' => 'Aucun produit trouvé',
        'not_found_in_trash' => 'Aucun produit dans la corbeille',
        'parent_item_colon' => 'Produit parent :',
        'menu_name' => 'Shop',
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Les produits de ma boutique.',
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,

        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
	register_post_type('shop', $args);
}

add_action('add_meta_boxes', 'mb_shop_init');
add_action('save_post','mb_shop_save');

function mb_shop_init() {
	add_meta_box('product_info', 'Informations sur le Produit', 'ft_product_info', 'Shop');
}

function mb_shop_save($post_ID) {
	if (isset($_POST['price']))
    	update_post_meta($post_ID,'price', esc_html($_POST['price']));
}

function ft_product_info($post) {
	$price = get_post_meta($post->ID, 'price', true);
	echo '<label for="price">Prix en euro (€) : </label>';
	echo '<input id="price" type="text" name="price" value="'.$price.'" />';
}