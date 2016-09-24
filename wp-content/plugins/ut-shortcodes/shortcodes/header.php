<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Header' ) ) {
	
    class UT_Header {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_header';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Header', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/header.png',
                        'category'        => 'Brooklyn ( 4.0 )',                        
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            array(
								'type'              => 'dropdown',
								'class'             => 'ut-select-header-style',
								'heading'           => esc_html__( 'Style', 'ut_shortcodes' ),
								'param_name'        => 'style',
								'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'Select Style', 'ut_shortcodes' ) => '',
                                    esc_html__( 'Default (Theme Options)', 'ut_shortcodes' ) => 'global',
                                    esc_html__( 'Style One'   , 'ut_shortcodes' ) => 'pt-style-1',
                                    esc_html__( 'Style Two'   , 'ut_shortcodes' ) => 'pt-style-2',
                                    esc_html__( 'Style Three' , 'ut_shortcodes' ) => 'pt-style-3',
                                    esc_html__( 'Style Four'  , 'ut_shortcodes' ) => 'pt-style-4',
                                    esc_html__( 'Style Five'  , 'ut_shortcodes' ) => 'pt-style-5',
                                    esc_html__( 'Style Six'   , 'ut_shortcodes' ) => 'pt-style-6',
                                    esc_html__( 'Style Seven' , 'ut_shortcodes' ) => 'pt-style-7',

                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'class'             => '',
								'heading'           => esc_html__( 'Alignment', 'ut_shortcodes' ),
								'param_name'        => 'align',
							    'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'Select Alignment', 'ut_shortcodes' ) => '',
                                    esc_html__( 'Default (Theme Options)', 'ut_shortcodes' ) => 'global',
                                    esc_html__( 'center', 'ut_shortcodes' ) => 'center',
                                    esc_html__( 'left'  , 'ut_shortcodes' ) => 'left',
                                ),						  	),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Title', 'ut_shortcodes' ),
                                'param_name'        => 'title',
                                'admin_label'       => true,
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Title Font Size', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) value in px or em, eg "20px" or "6em"' , 'ut_shortcodes' ),
                                'param_name'        => 'font_size',
                                'group'             => 'General'
                            ),
                            // Extra Settings Style 1
                            
                            array(
								'type'              => 'dropdown',
								'class'             => '',
								'heading'           => esc_html__( 'Title Style', 'ut_shortcodes' ),
								'param_name'        => 'title_style',
								'value'             => '',
								'description'       => '',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'pt-style-1' ),
                                ),
								'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'Decoration Line as Linetrough' , 'ut_shortcodes' ) => 'section',
                                    esc_html__( 'Decoration Line above Title'   , 'ut_shortcodes' ) => 'parallax',
                                ),
						  	),
                            
                            array(
                                'type'              => 'textarea',
                                'heading'           => esc_html__( 'Lead Text', 'ut_shortcodes' ),
                                'admin_label'       => true,
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Lead Text Margin Left', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) - value in px , default: 0px', 'ut_shortcodes' ),
                                'param_name'        => 'lead_margin_left',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Lead Text Margin Right', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) - value in px , default: 0px', 'ut_shortcodes' ),
                                'param_name'        => 'lead_margin_right',
                                'group'             => 'General'
                            ),
                            
                            // Extra Settings Style 2
                           
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Decoration Line Height', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) - value in px , default: 1px', 'ut_shortcodes' ),
                                'param_name'        => 'style_2_height',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'pt-style-2' ),
                                ),
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Decoration Line Width', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) - value in % , default: 15%', 'ut_shortcodes' ),
                                'param_name'        => 'style_2_width',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'pt-style-2' ),
                                ),
                                'group'             => 'General'
                            ),
                            
                            // Colors
                            
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Accent Color', 'ut_shortcodes' ),
								'param_name'        => 'accent',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'pt-style-1', 'pt-style-2', 'pt-style-3', 'pt-style-4', 'pt-style-5', 'pt-style-6' ),
                                ),
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Title Color', 'ut_shortcodes' ),
								'param_name'        => 'title_color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( ' Lead Color', 'ut_shortcodes' ),
								'param_name'        => 'lead_color',
								'group'             => 'Colors'
						  	),
                            
                            // CSS
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design Options', 'ut_shortcodes' ),
                            )
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'title'                 => '',
                'font_size'             => '',
                'style'                 => 'global',
                'align'                 => 'global',
                'accent'                => '',
                'color'                 => '',
                'title_color'           => '',
                'lead_color'            => '',
                'lead_margin_left'      => '',
                'lead_margin_right'     => '',
                'title_style'           => 'section',
                'style_2_height'        => '',
                'style_2_width'         => '',
                'css'                   => ''                               
            ), $atts ) ); 
            
            $classes   = array();
            
            /* align */
            if( $align == 'global' && function_exists('ot_get_option') ) {
                $align = ot_get_option( 'ut_global_headline_align', 'center' );                
            }
            
            /* style */
            if( $style == 'global' && function_exists('ot_get_option') ) {
                $style = ot_get_option('ut_global_headline_style', 'pt-style-1' );                
            }
            
                        
            /* add class */
            $classes[] = $style;
            $classes[] = 'header-' . $align;
            
            /* style extra */
            $height = !empty( $style_2_height ) && $style == 'pt-style-2' ? $style_2_height : '';
            $width  = !empty( $style_2_width )  && $style == 'pt-style-2' ? $style_2_width  : '';
                        
            /* unique header ID */
            $id = uniqid("ut_header_");
            
            $css_style = '<style type="text/css" scoped>';
                
                if( $title_color ) {
                    $css_style.= '#' . $id . ' h2 span { color:' . $title_color . '; }';
                }
                
                if( $font_size ) {
                    $css_style.= '#' . $id . ' h2 { font-size: ' . $font_size . ' !important; }';
                } 
                
                if( $lead_color ) {
                    $css_style.= '#' . $id . ' .lead { color:' . $lead_color . '; }';
                    $css_style.= '#' . $id . ' .lead p { color:' . $lead_color . '; }';
                }                
                
                if( $lead_margin_left ) {
                    $css_style.= '#' . $id . ' .lead { margin-left:' . $lead_margin_left . '; }';    
                }
                
                if( $lead_margin_right ) {
                    $css_style.= '#' . $id . ' .lead { margin-right:' . $lead_margin_right . '; }';    
                }
                
                if( $style == 'pt-style-1' && $title_style == 'section' && !empty( $accent ) ) {
                    $css_style.= '#' . $id . ' h2 span { background:' . $accent . '; }';
                } elseif( $style == 'pt-style-1' && $title_style == 'section' && empty( $accent ) ) {
                    $css_style.= '#' . $id . ' h2 span { background:#FFF; }';
                }
                                
                $css_style .= $this->create_section_headline_style( '#' . $id, $style, $accent, $height, $width );
                    
            $css_style.= '</style>';            
            
            /* start output */
            $output = '';
            
            /* attach CSS */
            $output .= ut_minify_inline_css( $css_style );            
                        
            $output .= '<header id="' . $id . '" class="section-header ' . implode( ' ', $classes ) . '">';
                
                if( !empty( $title ) ) {
                
                    $output .= '<h2 class="' . $title_style . '-title"><span>' . $title . '</span></h2>';
                
                }
                
                if( !empty( $content ) ) {
                
                    $output .= '<div class="lead">' . do_shortcode( wpautop( $content ) ) . '</div>';
                
                }
                
            $output .= '</header>';            
            
            if( defined( 'WPB_VC_VERSION' ) ) { 
                
                return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
                            
            return $output;
        
        }
        
        function create_section_headline_style( $div = '',  $style = 'pt-style-1' , $color = '' , $height = '' , $width = '' ) {
        
            if( empty( $color ) ) {
                
                // nothing to do here, let's leave
                return;
                
            }
            
            switch ( $style ) {
                
                case 'pt-style-1':
                    return;
                break;
                
                case 'pt-style-2':
                    
                    return '
                        ' . $div . '.pt-style-2 .page-title:after, 
                        ' . $div . '.pt-style-2 .parallax-title:after, 
                        ' . $div . '.pt-style-2 .section-title:after {
                            background-color: ' . $color . ';
                            height: ' . $height .';
                            width: ' . $width . ';
                        }
                    ';
                    
                break;
                
                case 'pt-style-3':
                    
                    return '
                        ' . $div . '.pt-style-3 .page-title span, 
                        ' . $div . '.pt-style-3 .parallax-title span, 
                        ' . $div . '.pt-style-3 .section-title span { 
                            background:' . $color . ';            
                            -webkit-box-shadow:0 0 0 3px' . $color . '; 
                            -moz-box-shadow:0 0 0 3px' . $color . '; 
                            box-shadow:0 0 0 3px' . $color . '; 
                        }
                    ';                
                    
                break;
                
                case 'pt-style-4':
                    
                    return '
                        ' . $div . '.pt-style-4 .page-title span, 
                        ' . $div . '.pt-style-4 .parallax-title span, 
                        ' . $div . '.pt-style-4 .section-title span {
                            border:3px solid ' . $color . ';
                        }
                    ';
                    
                break;
                
                case 'pt-style-5':
                    
                    return '
                        ' . $div . '.pt-style-5 .page-title span, 
                        ' . $div . '.pt-style-5 .parallax-title span, 
                        ' . $div . '.pt-style-5 .section-title span {
                            background:' . $color . ';            
                            -webkit-box-shadow:0 0 0 3px' . $color . '; 
                            -moz-box-shadow:0 0 0 3px' . $color . '; 
                            box-shadow:0 0 0 3px' . $color . '; 
                        }
                    ';
                    
                break;
                
                
                case 'pt-style-6':
                    
                    return '
                        ' . $div .'.pt-style-6 .page-title:after, 
                        ' . $div .'.pt-style-6 .parallax-title:after, 
                        ' . $div .'.pt-style-6 .section-title:after {
                            border-bottom: 1px dotted ' . $color . ';
                        }
                    ';
                
                break;
                
                
            }
            
        }
            
    }

}

new UT_Header;