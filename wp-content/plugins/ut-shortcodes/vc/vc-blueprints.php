<?php


/**
 * Remove VC Default Templates
 *
 * @return    array
 *
 * @access    private
 * @since     4.0
 *
 */
 
function _ut_remove_default_vc_templates( $data ) {
    
    $data = array();
            
    return $data;
    
}

add_filter( 'vc_load_default_templates', '_ut_remove_default_vc_templates', 10 ); 


/**
 * Theme Default Templates
 *
 * @return    array
 *
 * @access    private
 * @since     4.0
 *
 */
 
function ut_vc_templates() {

    $templates = array(
        
        /* Demo 20 - Contruction */
        array(
            'name'      => esc_html__( 'Demo 20 - Abouts Us', 'ut_shortcodes' ),
            'weight'    => 201,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_about_us.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 20 - Contact Page', 'ut_shortcodes' ),
            'weight'    => 202,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_contact_page.txt' ) ),
        ),
        array(
            'name'       => esc_html__( 'Demo 20 - Front Page', 'ut_shortcodes' ),
            'weight'     => 203,
            'content'    => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_front_page.txt' ) ),
        ),
        array(
            'name'      => esc_html__( 'Demo 20 - Service Page', 'ut_shortcodes' ),
            'weight'    => 204,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_service_page.txt' ) ),
        ),
        array(
            'name'      => esc_html__( 'Demo 20 - Team Member', 'ut_shortcodes' ),
            'weight'    => 205,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_team_member.txt' ) ),
        ),
        array(
            'name'      => esc_html__( 'Demo 20 - Project Details Page', 'ut_shortcodes' ),
            'weight'    => 206,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo20_project_details_page.txt' ) ),
        ),
        
        /* Demo 21 - Creative Agency */
        array(
            'name'      => esc_html__( 'Demo 21 - Home Page', 'ut_shortcodes' ),
            'weight'    => 210,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_home.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - About Page', 'ut_shortcodes' ),
            'weight'    => 211,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_about.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Contact Page', 'ut_shortcodes' ),
            'weight'    => 212,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_contact.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Main Portfolio Page', 'ut_shortcodes' ),
            'weight'    => 213,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_main_portfolio.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Service Page', 'ut_shortcodes' ),
            'weight'    => 214,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_service_page.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 1', 'ut_shortcodes' ),
            'weight'    => 215,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_1.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 2', 'ut_shortcodes' ),
            'weight'    => 216,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_2.txt' ) ),

        ),
        array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 3', 'ut_shortcodes' ),
            'weight'    => 217,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_3.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 4', 'ut_shortcodes' ),
            'weight'    => 218,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_4.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 5', 'ut_shortcodes' ),
            'weight'    => 219,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_5.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 6', 'ut_shortcodes' ),
            'weight'    => 220,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_6.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 7', 'ut_shortcodes' ),
            'weight'    => 221,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_7.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 8', 'ut_shortcodes' ),
            'weight'    => 222,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_8.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 9', 'ut_shortcodes' ),
            'weight'    => 223,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_9.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 10', 'ut_shortcodes' ),
            'weight'    => 224,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_10.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 11', 'ut_shortcodes' ),
            'weight'    => 225,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_11.txt' ) ),

        ),
         array(
            'name'      => esc_html__( 'Demo 21 - Single Portfolio Style 12', 'ut_shortcodes' ),
            'weight'    => 226,
            'content'   => wp_remote_retrieve_body( wp_remote_get( UT_SHORTCODES_URL . '/vc/blueprints/demo21_single_portfolio_style_12.txt' ) ),

        ),
        
        
        
        
        
    );
    
    return $templates;

}


/**
 * Add Theme Default Templates
 *
 * @return    array
 *
 * @access    private
 * @since     4.0
 *
 */
 
if( !function_exists( 'ut_add_vc_template' ) ) {
    
    function ut_add_vc_template() {
    
        foreach( ut_vc_templates() as $template ) {
 
            vc_add_default_templates( $template );
            
        }
    
    }    
    
    add_action( 'vc_load_default_templates_action', 'ut_add_vc_template', 11 ); 
    
}


