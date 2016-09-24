<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Service_Icon_Box' ) ) {
	
    class UT_Service_Icon_Box {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_service_icon_box';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Service Icon Box', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( Base )',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/service-icon-box.png',
                        'content_element' => true,
                        'params'          => array(
                            array(
								'type'              => 'iconpicker',
                                'heading'           => esc_html__( 'Choose Icon', 'ut_shortcodes' ),
                                'param_name'        => 'icon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'attach_image',
                                'heading'           => esc_html__( 'or upload an own Icon', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'recommended size 48x48', 'ut_shortcodes' ),
                                'param_name'        => 'imageicon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Hover Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_hover_color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Background Color', 'ut_shortcodes' ),
								'param_name'        => 'color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Background Hover Color', 'ut_shortcodes' ),
								'param_name'        => 'hovercolor',
								'group'             => 'Colors'
						  	),
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design options', 'ut_shortcodes' ),
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Headline', 'ut_shortcodes' ),
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
                            array(
								'type'              => 'textfield',
								'heading'           => esc_html__( 'Link', 'ut_shortcodes' ),
								'param_name'        => 'link',
								'group'             => 'General'
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Link Target', 'ut_shortcodes' ),
								'param_name'        => 'target',
								'group'             => 'General',
                                'value'             => array(
                                    '_blank'  => esc_html__( '_blank', 'ut_shortcodes' ),
                                    '_self'   => esc_html__( '_self', 'ut_shortcodes' ),
                                ),
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
                                    'center'    => esc_html__( 'center', 'ut_shortcodes' ),
                                    'left'      => esc_html__( 'left', 'ut_shortcodes' ),
                                    'right'     => esc_html__( 'right', 'ut_shortcodes' ),
                                ),
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
								'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
								'param_name'        => 'class',
								'group'             => 'General'
						  	),
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'icon'              => '',
                'imageicon'         => '',
                'icon_color'        => '',
                'icon_hover_color'  => '',
                'color'             => '#CCC',
                'hovercolor'        => get_option('ut_accentcolor' , '#F1C40F'),
                'url'               => '',
                'link'              => '#',
                'headline'          => '',
                'headline_color'    => '',
                'text_color'        => '',
                'align'             => 'center',
                'effect'            => '',    
                'animate_once'      => 'no',
                'width'             => '',    /* deprecated */
                'last'              => '',    /* deprecated */
                'target'            => '_self',
                'css'               => '',
                'class'             => ''
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
                
            /* deprecated - will be removed one day - end block */
            
            /* animation effect */
            $dataeffect = NULL;
            
            if( !empty( $effect ) ) {
                
                $attributes['data-effect']      = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                
                $classes_2[]  = 'ut-animate-element';
                $classes_2[]  = 'animated';
                
            }  
            
            
            /* align */
            $classes[] = 'ut-service-icon-box-' . $align;
            
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
                $classes_2[] = str_replace('fa fa-', 'fa-', $icon );                
                
            }
            
            /* link alt */
            if( empty( $url ) ) {
                $url = $link;
            }
            
            $id       = uniqid("utbx_");
            $outer_id = uniqid("utbx_o_");
            
            $css_style = '<style type="text/css" scoped>';
                
                $css_style.= '#' . $id . ' { background:' . $color . '; }';
                $css_style.= '#' . $id . ':hover { background: ' . $hovercolor . '; } ';
                $css_style.= '#' . $id . ':after { box-shadow: 0 0 0 4px ' . $hovercolor . '; } ';
                
                if( $headline_color ) {
                    $css_style.= '#' . $outer_id . ' h3 { color:' . $headline_color . ' !important; }';
                }
                
                if( $text_color ) {
                    $css_style.= '#' . $outer_id . ' p { color:' . $text_color . ' !important; }';
                }
                
                if( $icon_color ) {
                    $css_style.= '#' . $id . ' { color:' . $icon_color . '; }';
                }
                
                if( $icon_hover_color ) {
                    $css_style.= '#' . $id . ':hover { color: ' . $icon_hover_color . '; } ';
                }
                
            $css_style.= '</style>';
            
            /* attributes string */
            $attributes = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
                $attributes,
                array_keys( $attributes )
            ) );
            
            /* start output */
            $output = '';  
            
            $output .= '<div id="' . $outer_id . '" class="ut-service-icon-box ' . implode(' ', $classes ) . '">';
                
                /* attach CSS */
                $output .= ut_minify_inline_css( $css_style );
                
                if( !empty( $icon ) ) {
                    
                    $output .= '<div class="ut-highlight-icon-wrap ut-highlight-icon-effect">';        
                        
                        if( $image_icon ) {
                               
                            $output .= '<a id="' . esc_attr( $id ) . '" data-id="' . esc_attr( $id ) . '" data-hovercolor="' . esc_attr( $hovercolor ) . '"  ' . $attributes . ' class="ut-highlight-icon" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '"><img alt="' . ( !empty($headline) ? $headline : 'icon' ) . '" src="' . esc_url( $icon ) . '"></a>';
                            
                        } else { 
                        
                            $output .= '<a id="' . esc_attr( $id ) . '" data-id="' . esc_attr( $id ) . '" data-hovercolor="' . esc_attr( $hovercolor ) . '"  ' . $attributes . ' class="ut-highlight-icon fa ' . implode(' ', $classes_2 ) . '" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '"></a>';
                            
                        }                            
                        
                    $output .= '</div>';
                
                }
                
                if( !empty( $headline ) || !empty( $headline ) ) {
                
                    $output .= '<div class="ut-service-icon-box-content">';
                        
                        if( !empty( $headline ) ) {
                            
                            $output .= '<h3>' . $headline . '</h3>';
                            
                        }
                        
                        $output .= '<p>' . do_shortcode( $content ) . '</p>';
                                    
                    $output .= '</div>';
                
                }
                                    
            $output .= '</div>';
            
            if( defined( 'WPB_VC_VERSION' ) ) { 
                                
                return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
            
            return $output;
        
        }
            
    }

}

new UT_Service_Icon_Box;

if ( class_exists( 'WPBakeryShortCode' ) ) {
    
    class WPBakeryShortCode_ut_service_icon_box extends WPBakeryShortCode {
        
        /*protected function outputTitle( $title ) {
            
            return $title;
            
        }*/
        
    }
    
}