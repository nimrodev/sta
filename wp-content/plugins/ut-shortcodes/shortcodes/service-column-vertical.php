<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Service_Column_Vertical' ) ) {
	
    class UT_Service_Column_Vertical {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_service_column_vertical';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Service Column Vertical', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( Base )',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/service-column-vertical.png',
                        'class'           => '',
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
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'dropdown',
								'class'             => '',
								'heading'           => esc_html__( 'Icon Shape', 'ut_shortcodes' ),
								'param_name'        => 'shape',
								'value'             => '',
								'description'       => '',
								'group'             => 'General',
                                'value'             => array(
                                    'normal'    => esc_html__( 'normal', 'ut_shortcodes' ),
                                    'round'     => esc_html__( 'round', 'ut_shortcodes' ),
                                ),
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
								'class'             => '',
								'heading'           => esc_html__( 'Column Headline Color', 'ut_shortcodes' ),
								'param_name'        => 'headline_color',
								'value'             => '',
								'description'       => '',
								'group'             => 'Colors'
						  	),
                            array(
                                'type'              => 'textarea',
                                'heading'           => esc_html__( 'Column Text', 'ut_shortcodes' ),
                                'admin_label'       => true,
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'class'             => '',
								'heading'           => esc_html__( 'Column Text Color', 'ut_shortcodes' ),
								'param_name'        => 'text_color',
								'value'             => '',
								'description'       => '',
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
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design options', 'ut_shortcodes' ),
                            ),                            
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
                'icon'             => '',
                'imageicon'        => '',
                'shape'            => 'normal',
                'color'            => get_option('ut_accentcolor' , '#F1C40F'),
                'headline_color'   => '',
                'text_color'       => '',
                'background'       => '',
                'headline'         => '',
                'effect'           => '',      
                'animate_once'     => 'no',  
                'width'            => '',       /* deprecated */
                'margin_bottom'    => '',       /* deprecated */
                'last'             => 'false',  /* deprecated */
                'css'              => '',
                'class'            => ''
            ), $atts ) ); 
            
            $classes    = array();
            $attributes = array();
            $classes_2  = array();
            
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
                
                $classes_2[]  = 'ut-animate-element';
                $classes_2[]  = 'animated';
                
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
            $id = uniqid("ut_scv_");
            
            $css_style = '<style type="text/css" scoped>';
                
                /* fallback colors */
                if( $shape == 'round' && empty( $background ) && !$image_icon ) {
                    $color      = '#FFF';
                    $background = get_option('ut_accentcolor' , '#F1C40F');
                }
                    
                $css_style .= '#' . $id . ' .ut-service-icon .fa.fa-stack-1x { color: ' . $color . '; }';
                
                if( $background ) {
                    $css_style .= '#' . $id . ' .ut-service-icon .fa.fa-stack-2x { color: ' . $background . '; }';
                }                    
                
                if( $headline_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column.ut-vertical h3 { color: ' . $headline_color . '; }';  
                }
                
                if( $text_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column.ut-vertical p { color: ' . $text_color . '; }';     
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
            
            $output .= '<div id="' . $id . '" class="' . implode(' ', $classes ) . ' ut-vertical-style" ' . $margin_bottom . '>';
                
                if(!empty($icon) && $shape == 'round' && !$image_icon ) {
                
                    $output .= '<figure ' . $attributes . ' class="ut-service-icon fa-stack fa-lg ' . implode(' ', $classes_2 ) . '" style="line-height:60px;">';
                        
                        $output .= '<i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-stack-1x ' . $icon . '"></i>';
                        
                    $output .= '</figure>';
                
                } elseif( !empty($icon) ) {
                                        
                        if( $image_icon ) {
                            
                            $output .= '<figure ' . $attributes . ' class="ut-service-icon ut-custom-icon ' . implode(' ', $classes_2 ) . '" style="text-align:center;">';                        
                            $output .= '<img alt="' . ( !empty($headline) ? $headline : 'icon' ) . '" src="' . esc_url( $icon ) . '">';                        
                            
                        } else { 
                            
                            $output .= '<figure ' . $attributes . ' class="ut-service-icon ' . implode(' ', $classes_2 ) . '" style="text-align:center;">';
                            $output .= '<i style="color: ' . $color . '" class="fa ' . $icon . '"></i>';
                            
                        } 
                        
                    $output .= '</figure>';
                    
                }
                    
                $output .= '<div class="ut-service-column ut-vertical">';
                    
                    if( !empty($headline) ) {
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

new UT_Service_Column_Vertical;