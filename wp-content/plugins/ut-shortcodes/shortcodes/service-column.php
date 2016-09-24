<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Service_Column' ) ) {
	
    class UT_Service_Column {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_service_column';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Service Column', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( Base )',
                        'class'           => '',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/service-column.png',
                        'content_element' => true,
                        'custom_markup'   => '',
                        'params' => array(
                            array(
								'type'              => 'iconpicker',
                                'heading'           => esc_html__( 'Choose Icon', 'ut_shortcodes' ),
                                'param_name'        => 'icon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'attach_image',
                                'heading'           => esc_html__( 'or upload an own Icon', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'recommended size 32x32', 'ut_shortcodes' ),
                                'param_name'        => 'imageicon',
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
								'group'             => 'Colors',
                                 'dependency' => array(
                                    'element' => 'shape',
                                    'value'   => array( 'round' ),
                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Icon Shape', 'ut_shortcodes' ),
								'param_name'        => 'shape',
								'group'             => 'General',
                                'value'             => array(
                                    'normal'    => esc_html__( 'normal', 'ut_shortcodes' ),
                                    'round'     => esc_html__( 'round', 'ut_shortcodes' ),
                                ),
						  	),  
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Headline', 'ut_shortcodes' ),
                                'admin_label'       => true,
                                'param_name'        => 'headline',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Headline Margin Bottom', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'value in px , eg "20px" (optional)' , 'ut_shortcodes' ),
                                'param_name'        => 'headline_margin_bottom',
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Column Headline Color', 'ut_shortcodes' ),
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
								'heading'           => esc_html__( 'Column Text Color', 'ut_shortcodes' ),
								'param_name'        => 'text_color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'dropdown',
								'class'             => '',
								'heading'           => esc_html__( 'Alignment', 'ut_shortcodes' ),
								'param_name'        => 'align',
								'value'             => '',
								'description'       => '',
								'group'             => 'General',
                                'value'             => array(
                                    'left'      => esc_html__( 'left', 'ut_shortcodes' ),
                                    'right'     => esc_html__( 'right', 'ut_shortcodes' ),
                                ),
						  	),
                            
                            /* animation */
                            array(
                                'type'              => 'dropdown',
								'heading'           => esc_html__( 'Column Animation', 'ut_shortcodes' ),
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
                            
                            /* custom css */
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design Options', 'ut_shortcodes' ),
                            ),                            
                            array(
								'type'              => 'textfield',
								'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'ut_shortcodes' ),
								'param_name'        => 'class',
								'group'             => 'General'
						  	), 
                        ),
                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'icon'             => '',
                'imageicon'        => '',
                'align'            => '',
                'shape'            => 'normal',
                'color'            => get_option('ut_accentcolor' , '#F1C40F'),
                'headline_color'   => '',
                'headline_margin_bottom' => '',
                'text_color'       => '',
                'background'       => '',
                'headline'         => '',
                'effect'           => '',     
                'animate_once'     => 'no',
                'width'            => '',      /* deprecated */
                'margin_bottom'    => '',      /* deprecated */
                'last'             => 'false', /* deprecated */
                'css'              => '',
                'class'            => ''
            ), $atts ) ); 
            
            $classes    = array();
            $attributes = array();            
            
            /* deprecated - will be removed one day - start block */
            
                $grid = array( 
                    'third'   => 'ut-one-third',
                    'fourth'  => 'ut-one-fourth',
                    'half'    => 'ut-one-half',
                    'full'    => ''
                );  
                
                $classes[] = ( $last == 'true' ) ? 'ut-column-last' : '';
                $classes[] = !empty( $grid[$width] ) ? $grid[$width] : 'clearfix';
                $classes[] = $class;
                    
                /* margin bottom*/
                $margin_bottom = !empty($margin_bottom) ? 'style="margin-bottom:' . $margin_bottom . 'px"' : '';                
                
            /* deprecated - will be removed one day - end block */
            
            /* animation effect */
            $dataeffect = NULL;
            
            if( !empty( $effect ) ) {
                
                $attributes['data-effect']      = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                
                $classes[]  = 'ut-animate-element';
                $classes[]  = 'animated';
                
            }
                        
            /* icon setting */
            if( !empty( $imageicon ) && is_numeric( $imageicon ) ) {
                $imageicon = wp_get_attachment_url( $imageicon );        
            }            
            
            /* overwrite default icon */
            $icon = empty( $imageicon ) ? $icon : $imageicon;
            
            /* check if icon is an image */
            $image_icon = strpos( $icon, '.png' ) !== false || strpos( $icon, '.jpg' ) !== false || strpos( $icon, '.gif' ) !== false || strpos( $icon, '.ico' ) !== false ? true : false;
            
            /* font awesome icon */
            if( !$image_icon ) {
                
                /* fallback */
                $icon = str_replace('fa fa-', 'fa-', $icon );                
                
            }            
            
            /* inline css */
            $id = uniqid("ut_sc_");
            
            $css_style = '<style type="text/css" scoped>';
                
                /* fallback colors */
                if( $shape == 'round' && empty( $background ) && !$image_icon ) {
                    $color      = '#FFF';
                    $background = get_option('ut_accentcolor' , '#F1C40F');
                }

                if( $headline_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column h3 { color: ' . $headline_color . '; }';  
                }
                
                if( $text_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column p { color: ' . $text_color . '; }';     
                }                
                
                if( $headline_margin_bottom ) {
                    $css_style .= '#' . $id . ' .ut-service-column p { margin-top: ' . $headline_margin_bottom  . '; }';
                }
                
            $css_style .= '</style>';
            
            
            /* align */
            $talign = ( $align == 'right' ) ? 'style="text-align:right;"' : '';
            $align  = ( $align == 'right' ) ? 'ut-si-right' : '';            
            
            
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
            
            $output .= '<div id="' . $id . '" ' . $attributes . ' class="' . implode(' ', $classes ) . '" ' . $margin_bottom . '>';
            
                if( !empty( $icon ) && $shape == 'round' && !$image_icon ) {
                    
                    $output .= '<figure class="ut-service-icon fa-stack fa-lg ' . $align . '" style="line-height:60px;">';
                        
                        $output .= '<i class="fa fa-circle fa-stack-2x" style="color: ' . $background . '"></i><i style="color: ' . $color . '" class="fa ' . $icon . ' fa-stack-1x"></i>';                    
                        
                    $output .= '</figure>';
                    
                } elseif( !empty( $icon ) ) {
                    
                    if( $image_icon ) {
                           
                        $output .= '<figure class="ut-service-icon ut-custom-icon ' . $align . '">';
                            
                            $output .= '<img alt="' . ( !empty($headline) ? $headline : 'icon' ) . '" src="' . esc_url( $icon ) . '">';                        
                            
                        $output .= '</figure>';
                        
                    } else { 
                    
                        $output .= '<figure class="ut-service-icon ' . $align . '">';
                            
                            $output .= '<i style="color: ' . $color . '" class="fa ' . $icon . '"></i>';
                            
                        $output .= '</figure>';
                        
                    }               
                    
                }            
                
                $output .= '<div class="ut-service-column" ' . $talign . '>';
                    
                    if( !empty( $headline ) ) {
                        $output .= '<h3>' . $headline . '</h3>';
                    }
                    
                    $output .= '<p>' . do_shortcode( $content ) . '</p>';
                    
                $output .= '</div>';
            
            $output .= '</div>';
            
            if( defined( 'WPB_VC_VERSION' ) ) { 
                
                return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
                
            return $output;
        
        }
            
    }

}

new UT_Service_Column;

if( class_exists('WPBakeryShortCode') ) {

    class WPBakeryShortCode_UT_Service_Column extends WPBakeryShortCode {
        
        /*protected function outputTitle( $title ) {
            
            $icon = $this->settings( 'icon' );
            return '<h4 class="wpb_element_title">' . ( ! empty( $headline ) ? ' ' . $headline : '' ) . '"></h4>';	
            
        }*/
        
    }

}