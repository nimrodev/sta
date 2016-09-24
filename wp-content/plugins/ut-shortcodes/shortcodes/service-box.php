<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Service_Box' ) ) {
	
    class UT_Service_Box {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_service_box';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Service Box', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( Base )',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/service-box.png',
                        'content_element' => true,
                        'params'          => array(
                            array(
								'type'              => 'iconpicker',
                                'heading'           => esc_html__( 'Choose Icon', 'ut_shortcodes' ),
                                'param_name'        => 'icon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Background Color', 'ut_shortcodes' ),
                                'param_name'        => 'background',
								'group'             => 'Colors'
						  	),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Headline', 'ut_shortcodes' ),
                                'description'       => esc_html__( '', 'ut_shortcodes' ),
                                'param_name'        => 'headline',
                                'admin_label'       => true,
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Headline Color', 'ut_shortcodes' ),
								'param_name'        => 'headline_color',
								'group'             => 'Colors'
						  	),
                            array(
                                'type'              => 'textarea',
                                'heading'           => esc_html__( 'Text', 'ut_shortcodes' ),
                                'admin_label'       => true,
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Text Color', 'ut_shortcodes' ),
								'param_name'        => 'text_color',
								'group'             => 'Colors'
						  	),
                            
                            /* animation */
                            array(
                                'type'              => 'dropdown',
								'heading'           => esc_html__( 'Icon Animation', 'ut_shortcodes' ),
								'param_name'        => 'effect',
								'group'             => 'Animation',
                                'value'             =>  ut_recognized_animation_effects_vc()                            
                            ),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Animate Once?', 'ut_shortcodes' ),
								'param_name'        => 'animate_once',
								'group'             => 'Animation',
                                'value'             => array(
                                    esc_html__( 'no' , 'ut_shortcodes' ) => 'no',
                                    esc_html__( 'yes', 'ut_shortcodes' ) => 'yes'                                    
                                ),
						  	),
                            
                            /* css */
                            array(
								'type'              => 'textfield',
								'heading'           => esc_html__( 'Class', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'ut_shortcodes' ),
								'param_name'        => 'class',
								'group'             => 'General'
						  	),
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design Options', 'ut_shortcodes' ),
                            ),
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'icon'           => '',
                'color'          => '#FFF',
                'headline'       => '',
                'headline_color' => '',
                'text_color'     => '',
                'background'     => get_option('ut_accentcolor' , '#F1C40F'),
                'effect'         => '',       
                'animate_once'   => 'no', 
                'opacity'        => '1',      /* deprecated */
                'width'          => '',       /* deprecated */
                'last'           => 'false',  /* deprecated */
                'css'            => '',
                'class'          => ''                
            ), $atts ) ); 
            
            $classes    = array();
            $classes_2  = array();
            $attributes = array();
            
            /* deprecated - will be removed one day - start block */
            
                $grid = array( 
                    'third'   => 'ut-one-third',
                    'fourth'  => 'ut-one-fourth',
                    'half'    => 'ut-one-half'
                );  
                
                $classes[] = ( $last == 'true' ) ? 'ut-column-last' : '';
                $classes[] = !empty( $grid[$width] ) ? $grid[$width] : 'clearfix';
                $classes[] = $class;
                
                /* check if if color is hex */
                if ( preg_match( '/^#[a-f0-9]{6}$/i', $background ) ) {
                    $background = 'rgba(' .  ut_hex_to_rgb( $background )  . ',' . $opacity . ');';
                }
                
                
            /* deprecated - will be removed one day - end block */

            /* animation effect */
            $dataeffect = NULL;
            
            if( !empty( $effect ) ) {
                
                $attributes['data-effect']      = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                
                $classes_2[]  = 'ut-animate-element';
                $classes_2[]  = 'ut-animate-element animated';
                
            }              
            
            /* fallback */
            $icon = str_replace('fa fa-', 'fa-', $icon );
            
            /* inline css */
            $id = uniqid("ut_sb_");
            
            $css_style = '<style type="text/css" scoped>';
                
                $css_style .= '#' . $id . ' .ut-icon-box .fa { color: ' . $color . '; }';
                
                if( !empty( $background ) ) {
                    
                    $css_style .= '#' . $id . ' .ut-arrow-right { border-left: 10px solid ' .  $background . '; }';
                    $css_style .= '#' . $id . ' .ut-icon-box { background: ' .  $background . '; }';    
                    
                }
                
                if( $headline_color ) {
                    $css_style .= '#' . $id . ' .ut-info h3 { color: ' . $headline_color . '; }';  
                }
                
                if( $text_color ) {
                    $css_style .= '#' . $id . ' .ut-info p { color: ' . $text_color . '; }';     
                }
                
            $css_style .= '</style>';              
            
            /* attributes string */
            $attributes = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
                $attributes,
                array_keys( $attributes )
            ) );            
            
            /* start output */
            $output = '';
            
            /* add css */ 
            $output .= ut_minify_inline_css( $css_style );
            
            $output .= '<div id="' . $id . '" class="' . implode( ' ', $classes ) . ' clearfix">';
            
                $output .= '<div ' . $attributes . ' class="ut-icon-box ' . implode( ' ', $classes_2 ) . '">';
                    $output .= '<div class="ut-arrow-right"></div>';
                    $output .= '<i class="fa ' . $icon . ' fa-4x ut-service-box-icon"></i>';
                $output .= '</div>';
                
                $output .= '<div class="ut-info">';
                    
                    if( !empty( $headline ) ) {
                        $output .= '<h3>' . $headline . '</h3>';
                    }
                    
                    if( !empty( $content ) ) {
                        $output .= '<p>' . do_shortcode($content) . '</p>';
                    }
                    
                $output .= '</div>';
                
            $output .= '</div>';
            
            if( defined( 'WPB_VC_VERSION' ) ) { 
                
                return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
            
            return $output;
        
        }
            
    }

}

new UT_Service_Box;