<?php

if ( ! function_exists( 'travel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function travel_setup() {

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'custom-header', array(
        'header-text' => false,
    ) );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'travel' ),
    ) );

    // Enable support for Post Formats.
    add_theme_support( 'post-formats', array( 'standard', 'image', 'video', 'quote', 'link' ) );

    // Enable support for HTML5 markup.
    add_theme_support( 'html5', array(
        'comment-list',
        'search-form',
        'comment-form',
        'gallery',
        'caption',
    ) );
}
endif; // travel_setup
add_action( 'after_setup_theme', 'travel_setup' );

/**
 * Enqueue scripts and styles.
 */
function travel_scripts() {
    wp_enqueue_style( 'travel-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'travel_scripts' );


// -------------------------------
// custom header stuff 
//

// adding fields to the custom background
/* Adds banner_image_caption to the Custom Header options screen */
function travel_custom_image_options() { ?>
<table class="form-table">
    <tbody>
        <tr valign="top" class="hide-if-no-js">
            <th scope="row"><?php _e( 'Banner image caption' ); ?></th>
            <td>
                <p>
                    <input type="text" name="banner_image_caption" id="banner_image_caption" value="<?php echo esc_attr( get_theme_mod( 'banner_image_caption', '' ) ); ?>" />
                </p>
            </td>
        </tr>
    </tbody>
</table>
<?php
} // end my_custom_image_options
// add our custom header options hook
add_action('custom_header_options', 'travel_custom_image_options');

function save_travel_custom_options() {
    if ( isset( $_POST['banner_image_caption'] ) ) {
        // validate the request itself by verifying the _wpnonce-custom-header-options nonce
        // (note: this nonce was present in the normal Custom Header form already, so we didn't have to add our own)
        check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );

        // be sure the user has permission to save theme options (i.e., is an administrator)
        if ( current_user_can('manage_options') ) {
            set_theme_mod( 'banner_image_caption', $_POST['banner_image_caption'] );
        }
    }
    return;
}
add_action('admin_head', 'save_travel_custom_options'); 


// the callback for the custom background
function travel_custom_background_cb() {
    // $background is the saved custom image, or the default image.
    $background = set_url_scheme( get_background_image() );

    // $color is the saved custom color.
    // A default has to be specified in style.css. It will not be printed here.
    $color = get_background_color();

    if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
        $color = false;
    }

    if ( ! $background && ! $color )
        return;

    $style = $color ? "background-color: #$color;" : '';

    if ( $background ) {
        $image = " background-image: url('$background');";

        $repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
        if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
            $repeat = 'repeat';
        $repeat = " background-repeat: $repeat;";

        $position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
        if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
            $position = 'left';
        $position = " background-position: top $position;";

        $attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
        if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
            $attachment = 'scroll';
        $attachment = " background-attachment: $attachment;";

        $style .= $image . $repeat . $position . $attachment;
    }
?>
<style type="text/css" id="custom-background-css">
.site-header { <?php echo trim( $style ); ?> }
</style>
<?php
}


?>