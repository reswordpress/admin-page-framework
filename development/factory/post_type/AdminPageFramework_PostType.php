<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides methods for registering custom post types.
 * 
 * @abstract
 * @since           2.0.0
 * @package         AdminPageFramework
 * @subpackage      PostType
 */
abstract class AdminPageFramework_PostType extends AdminPageFramework_PostType_Controller {    
        
    /**
    * The constructor of the class object.
    * 
    * Registers necessary hooks and sets up internal properties.
    * 
    * <h4>Example</h4>
    * <code>new APF_PostType( 
    *     'apf_posts',     // post type slug
    *       array( 
    *           'labels' => array(
    *               'name'               => 'Demo',
    *               'all_items'          => __( 'Sample Posts', 'admin-page-framework-demo' ),
    *               'singular_name'      => 'Demo',
    *               'add_new'            => __( 'Add New', 'admin-page-framework-demo' ),
    *               'add_new_item'       => __( 'Add New APF Post', 'admin-page-framework-demo' ),
    *               'edit'               => __( 'Edit', 'admin-page-framework-demo' ),
    *               'edit_item'          => __( 'Edit APF Post', 'admin-page-framework-demo' ),
    *               'new_item'           => __( 'New APF Post', 'admin-page-framework-demo' ),
    *               'view'               => __( 'View', 'admin-page-framework-demo' ),
    *               'view_item'          => __( 'View APF Post', 'admin-page-framework-demo' ),
    *               'search_items'       => __( 'Search APF Post', 'admin-page-framework-demo' ),
    *               'not_found'          => __( 'No APF Post found', 'admin-page-framework-demo' ),
    *               'not_found_in_trash' => __( 'No APF Post found in Trash', 'admin-page-framework-demo' ),
    *               'parent'             => __( 'Parent APF Post', 'admin-page-framework-demo' ),
    *               
    *               // (framework specific)
    *               'plugin_listing_table_title_cell_link' => __( 'APF Posts', 'admin-page-framework-demo' ), // framework specific key. [3.0.6+]
    *           ),
    *           'public'            => true,
    *           'menu_position'     => 110,
    *           'supports'          => array( 'title' ), // e.g. array( 'title', 'editor', 'comments', 'thumbnail', 'excerpt' ),    
    *           'taxonomies'        => array( '' ),
    *           'has_archive'       => true,
    *           'show_admin_column' => true, // [3.5+ core] this is for custom taxonomies to automatically add the column in the listing table.
    *           'menu_icon'         => $this->oProp->bIsAdmin 
    *               ? ( 
    *                   version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) 
    *                       ? 'dashicons-wordpress' 
    *                       : plugins_url( 'asset/image/wp-logo_16x16.png', APFDEMO_FILE ) 
    *               )
    *               : null, // do not call the function in the front-end.
    *               
    *           // (framework specific) this sets the screen icon for the post type for WordPress v3.7.1 or below.
    *           // a file path can be passed instead of a url, plugins_url( 'asset/image/wp-logo_32x32.png', APFDEMO_FILE )
    *           'screen_icon' => dirname( APFDEMO_FILE  ) . '/asset/image/wp-logo_32x32.png', 
    *           
    *           // [3.5.10+] (framework specific) default: true
    *           'show_submenu_add_new'  => true, 
    *           
    *       )     
    * );</code>
    * 
    * <h4>Framework Specific Post Type Arguments</h4>
    * In addition to the post type argument structure defined by the WordPress core, there are arguments defined by the framework.
    * 
    * - screen_icon - For WordPress 3.7.x or below, set an icon url or path for the 32x32 screen icon displayed in the post listing page.
    * - show_submenu_add_new [3.5.10+]

    * <h4>Framework Specific Post Type Label Arguments</h4>
    * - plugin_listing_table_title_cell_link' - If the caller script is a plugin, this determines the label of the action link embedded in the plugin listing page (plugins.php).
    * To disable the action link, set an empty string `''`. 

    * 
    * @since        2.0.0
    * @since        2.1.6       Added the $sTextDomain parameter.
    * @see          http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
    * @param        string      The post type slug.
    * @param        array       The <a href="http://codex.wordpress.org/Function_Reference/register_post_type#Arguments">argument array</a> passed to register_post_type().
    * @param        string      The path of the caller script. This is used to retrieve the script information to insert it into the footer. If not set, the framework tries to detect it.
    * @param        string      The text domain of the caller script.
    * @return       void
    */
    public function __construct( $sPostType, $aArguments=array(), $sCallerPath=null, $sTextDomain='admin-page-framework' ) {
        
        if ( empty( $sPostType ) ) { 
            return; 
        }

        // Properties
        $this->oProp = new AdminPageFramework_Property_PostType( 
            $this, 
            $sCallerPath 
                ? trim( $sCallerPath ) 
                : ( 
                    ( is_admin() && isset( $GLOBALS['pagenow'] ) && in_array( $GLOBALS['pagenow'], array( 'edit.php', 'post.php', 'post-new.php', 'plugins.php', 'tags.php', 'edit-tags.php', ) ) )
                        ? AdminPageFramework_Utility::getCallerScriptPath( __FILE__ )
                        : null 
                ),     // this is important to attempt to find the caller script path here when separating the library into multiple files.    
            get_class( $this ), // class name
            'publish_posts',    // capability
            $sTextDomain,       // text domain
            'post_type'         // fields type
        );
        $this->oProp->sPostType     = AdminPageFramework_WPUtility::sanitizeSlug( $sPostType );
        $this->oProp->aPostTypeArgs = $aArguments; // for the argument array structure, refer to http://codex.wordpress.org/Function_Reference/register_post_type#Arguments

        // Make sure to call the parent construct first as the factory router need to set up sub-class objects.
        parent::__construct( $this->oProp );
                
        $this->oUtil->addAndDoAction( 
            $this, 
            "start_{$this->oProp->sClassName}", 
            $this 
        );
                           
    }
                
}