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

// ------------------------------
// modify the main query
//
function travel_modify_main_query( $query ) {
    $query->query_vars['order'] = 'ASC';
    $query->query_vars['posts_per_page'] = -1; // show all posts
}
add_action( 'pre_get_posts', 'travel_modify_main_query' );



// ------------------------------
// hackin the editor
//

// Add Formats Dropdown Menu To MCE
if ( ! function_exists( 'wpex_style_select' ) ) {
    function wpex_style_select( $buttons ) {
        array_push( $buttons, 'styleselect' );
        return $buttons;
    }
}
add_filter( 'mce_buttons', 'wpex_style_select' );

// Add new styles to the TinyMCE "formats" menu dropdown
if ( ! function_exists( 'wpex_styles_dropdown' ) ) {
    function wpex_styles_dropdown( $settings ) {

        // Create array of new styles
        $new_styles = array(
            array(
                'title' => __( 'Sidebars', 'wpex' ),
                'items' => array(
                    array(
                        'title'     => __('Sidebar','wpex'),
                        'inline'  => 'span',
                        'classes'   => 'sidebar'
                    )
                ),
            ),
        );

        // DONT merge old & new styles
        $settings['style_formats_merge'] = false;

        // Add new styles
        $settings['style_formats'] = json_encode( $new_styles );

        // Return New Settings
        return $settings;

    }
}
add_filter( 'tiny_mce_before_init', 'wpex_styles_dropdown' );


// ---------------------------------
// ADVANCED CUSTOM FIELDS
//
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_photoset',
        'title' => 'Photoset',
        'fields' => array (
            array (
                'key' => 'field_536e90425964b',
                'label' => 'Content Row',
                'name' => 'travel_rows',
                'type' => 'repeater',
                'instructions' => 'Add a row of images. Be sure that the dimensions for each add up to 1.',
                'sub_fields' => array (
                    array (
                        'key' => 'field_536e98ec63c2c',
                        'label' => 'Row Type',
                        'name' => 'travel_row_type',
                        'type' => 'radio',
                        'column_width' => '',
                        'choices' => array (
                            'images' => 'Images',
                            'text' => 'Text',
                        ),
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                    array (
                        'key' => 'field_536e904a5964c',
                        'label' => 'Images',
                        'name' => 'travel_images',
                        'type' => 'repeater',
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_536e98ec63c2c',
                                    'operator' => '==',
                                    'value' => 'images',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'column_width' => '',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_536e969ab757e',
                                'label' => 'Image',
                                'name' => 'travel_image',
                                'type' => 'image',
                                'column_width' => '',
                                'save_format' => 'url',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                            ),
                            array (
                                'key' => 'field_5372df738a898',
                                'label' => 'Image Caption',
                                'name' => 'travel_image_caption',
                                'type' => 'wysiwyg',
                                'column_width' => '',
                                'default_value' => '',
                                'toolbar' => 'full',
                                'media_upload' => 'yes',
                            ),
                            array (
                                'key' => 'field_536e96b8b757f',
                                'label' => 'Image Size',
                                'name' => 'travel_image_size',
                                'type' => 'select',
                                'required' => 1,
                                'column_width' => '',
                                'choices' => array (
                                    'col-1-5' => '1/5',
                                    'col-2-5' => '2/5',
                                    'col-3-5' => '3/5',
                                    'col-4-5' => '4/5',
                                    'col-5-5' => 'Full row',
                                    'fullwidth' => 'Full screen width',
                                ),
                                'default_value' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                            ),
                        ),
                        'row_min' => '',
                        'row_limit' => '',
                        'layout' => 'table',
                        'button_label' => 'Add Image',
                    ),
                    array (
                        'key' => 'field_536e991763c2d',
                        'label' => 'Text',
                        'name' => 'travel_text',
                        'type' => 'wysiwyg',
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_536e98ec63c2c',
                                    'operator' => '==',
                                    'value' => 'text',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'column_width' => '',
                        'default_value' => '',
                        'toolbar' => 'full',
                        'media_upload' => 'yes',
                    ),
                ),
                'row_min' => '',
                'row_limit' => '',
                'layout' => 'row',
                'button_label' => 'Add Row',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}


?>