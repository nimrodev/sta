<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Fancy_Image' ) ) {
	
    class UT_Fancy_Image {
        
        function __construct() {
			
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( 'ut_fancy_image', array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Fancy Image', 'ut_shortcodes' ),
                        'base'            => 'ut_fancy_image',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/fancy-image.png',
                        'category'        => 'Brooklyn ( 4.0 )',
                        'class'           => '',
                        'content_element' => true,
                        'params' => array(
                            array(
								'type'        => 'attach_image',
								'heading'     => esc_html__( 'Image', 'ut_shortcodes' ),
								'param_name'  => 'image',
								'group'       => 'General'
						  	),
                            array(
								'type'        => 'colorpicker',
								'heading'     => esc_html__( 'Image Overlay Color', 'ut_shortcodes' ),
								'param_name'  => 'overlay',
								'group'       => 'Colors'
						  	),
                            array(
								'type'        => 'colorpicker',
								'heading'     => esc_html__( 'Border Color', 'ut_shortcodes' ),
								'param_name'  => 'border',
								'group'       => 'Colors'
						  	),
                            array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Title', 'ut_shortcodes' ),
								'param_name'  => 'title',
								'group'       => 'General'
						  	),
                            array(
								'type'        => 'colorpicker',
								'heading'     => esc_html__( 'Title Color', 'ut_shortcodes' ),
								'param_name'  => 'title_color',
								'group'       => 'Colors'
						  	),
                            array(
								'type'        => 'colorpicker',
								'heading'     => esc_html__( 'Title Hover Color', 'ut_shortcodes' ),
								'param_name'  => 'title_hover_color',
								'group'       => 'Colors'
						  	),
                            array(
								'type'        => 'textarea',
								'heading'     => esc_html__( 'Description', 'ut_shortcodes' ),
								'param_name'  => 'content',
								'group'       => 'General'
						  	),
                            array(
								'type'        => 'colorpicker',
								'heading'     => esc_html__( 'Description Color', 'ut_shortcodes' ),
								'param_name'  => 'desc_color',
								'group'       => 'Colors'
						  	),
                            array(
								'type'        => 'vc_link',
								'heading'     => esc_html__( 'Link', 'ut_shortcodes' ),
								'param_name'  => 'link',
								'group'       => 'General'
						  	),
                            array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Margin Bottom', 'ut_shortcodes' ),
                                'description' => esc_html__( 'value in px , eg "20px" (optional)' , 'ut_shortcodes' ),
								'param_name'  => 'margin_bottom',
								'group'       => 'Spacing'
						  	),
                            
                        ),
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'image'             => '',
                'title'             => '',
                'title_color'       => '',
                'title_hover_color' => '',
                'desc_color'        => '',
                'link'              => '#',
                'target'            => '_blank',
                'rel'               => '',
                'overlay'           => '',
                'border'            => '',
                'margin_bottom'     => '',      
                'class'             => ''
            ), $atts ) ); 
            
            if( empty( $image ) ) {
                return;
            }            
            
            $image = ut_resize( wp_get_attachment_url( $image ) , '800', '600', true, true, true );
            
            /* unique id */
            $id = uniqid( 'ut_fancy_image_' );
            
            /* css */
            $css = '<style type="text/css" scoped>';
                
                if( !empty( $title_color ) ) {
                    $css .= '#' . $id . ' .ut-fancy-image figcaption h3 { color: ' . $title_color . '; }';
                }
                
                if( !empty( $title_hover_color ) ) {
                    $css .= '#' . $id . ' .ut-fancy-image:hover figcaption h3 { color: ' . $title_hover_color . '; }';
                }                
                
                if( !empty( $desc_color ) ) {
                    $css .= '#' . $id . ' .ut-fancy-image p { color: ' . $desc_color . '; }';
                }
                
                if( !empty( $overlay ) ) {
                    $css .= '#' . $id . ' .ut-fancy-image { background: ' . $overlay . '; }';
                }
                
                if( !empty( $border ) ) {
                    $css .= '#' . $id . ' .ut-fancy-image figcaption::before { border-color: ' . $border . '; }';
                    $css .= '#' . $id . ' .ut-fancy-image figcaption::after { border-color: ' . $border . '; }';
                }               
                
                if( !empty( $margin_bottom ) ) {
                    $css .= '#' . $id . '.ut-fancy-image-wrap { margin-bottom: ' . $margin_bottom  . '; }';
                }
                
            $css .= '</style>';
            
            /* start output */
            $output = '';
             
            /* add css */ 
            $output .= ut_minify_inline_css( $css );
                      
            /* html */
            $output .= '<div id="' . $id . '" class="ut-fancy-image-wrap">';
                
                /* get link config */
                if( function_exists('vc_build_link') && !empty( $link ) && strpos( $link, 'url:') !== false ) {

                    $link = vc_build_link( $link );
                    
                    $link['target'] = empty( $link['target'] ) ? '_self' : $link['target'];
                    $link['url']    = empty( $link['url'] )    ? '#'     : $link['url'];
                    $rel            = empty( $link['rel'] )    ? ''      : 'rel="' . $link['rel'] . '"';
                
                } else {
                    
                    $url = array();
                                        
                    $url['url']     = $link;
                    $url['target']  = $target;
                    $rel            = empty( $rel ) ? '' : 'rel="' . $rel . '"';
                    
                    $link = $url;                 
                
                }
                
                $output .= '<a target="' . esc_attr( $link['target'] ) . '" href="' . esc_url( $link['url'] ) . '" ' . $rel . '>';
                
                    $output .= '<figure class="ut-fancy-image">';
                        
                            $output .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '"/>';        
                            
                            $output .= '<figcaption>';
                                
                                if( !empty( $title ) ) {
                                
                                    $output .= '<h3>' . $title . '</h3>';
                                
                                }
                                
                                if( !empty( $content ) ) {
                                    
                                    $output .= '<p class="hide-on-mobile">' . $content . '</p>';    
                                    
                                }
                                
                            $output .= '</figcaption>';                        
                                    
                    $output .= '</figure>';
                
                $output .= '</a>';
                
            $output .= '</div>';
                
            return $output;
        
        }
            
    }

}

new UT_Fancy_Image;