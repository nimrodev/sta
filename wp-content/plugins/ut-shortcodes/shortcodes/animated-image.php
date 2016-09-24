<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Animated_Image' ) ) {
	
    class UT_Animated_Image {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_animated_image';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Animated Single Image', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( 4.0 )',
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            
                            array(
								'type'              => 'attach_image',
								'heading'           => esc_html__( 'Image', 'ut_shortcodes' ),
								'param_name'        => 'image',
                                'admin_label'       => true,
								'group'             => 'General'
						  	),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Image Size', 'ut_shortcodes' ),
                                'param_name'        => 'size',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'Thumbnail' , 'ut_shortcodes' ) => 'thumbnail',
                                    esc_html__( 'Medium' , 'ut_shortcodes' )    => 'medium',
                                    esc_html__( 'Large' , 'ut_shortcodes' )     => 'large',
                                    esc_html__( 'Original' , 'ut_shortcodes' )  => 'full'
                                )
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Image Alignment', 'ut_shortcodes' ),
                                'param_name'        => 'align',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'left'   , 'ut_shortcodes' ) => 'left',
                                    esc_html__( 'center' , 'ut_shortcodes' ) => 'center',
                                    esc_html__( 'right'  , 'ut_shortcodes' ) => 'right',
                                )
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Link Image?', 'ut_shortcodes' ),
                                'param_name'        => 'link_type',
                                'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'No Link' , 'ut_shortcodes' ) => 'none',
                                    esc_html__( 'Custom Link' , 'ut_shortcodes' ) => 'custom',
                                    esc_html__( 'Open in Lightbox' , 'ut_shortcodes' ) => 'image',
                                )
                            ),                            
                            
                            array(
								'type'              => 'vc_link',
								'heading'           => esc_html__( 'Link', 'ut_shortcodes' ),
								'param_name'        => 'link',
								'group'             => 'General',
                                'dependency'  => array(
                                    'element' => 'link_type',
                                    'value'   => 'custom',
                                )
						  	),
                            
                            array(
                                'type'              => 'animation_style',
                                'heading'           => __( 'Animation Effect', 'ut_shortcodes' ),
                                'description'       => __( 'Select image animation effect.', 'ut_shortcodes' ),
                                'group'             => 'General',
                                'param_name'        => 'effect',
                                'settings' => array(
                                    'type' => array(
                                        'in',
                                        'out',
                                        'other',
                                    ),
                                )
                                
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Once?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Animate Image only once? By default images are animating everytime when in viewport.', 'ut_shortcodes' ),
                                'param_name'        => 'animate_once',
                                'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'no',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'yes'                                    
                                )
                            ), 
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Image on Tablet?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_tablet',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Image on Mobile?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_mobile',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),                            
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Delay Animation?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Time in milliseconds until the image appears. e.g. 200', 'ut_shortcodes' ),
                                'param_name'        => 'delay',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'                                                                        
                                )
                            ),
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Delay Timer', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Time in milliseconds until the next image appears. e.g. 200', 'ut_shortcodes' ),
                                'param_name'        => 'delay_timer',
                                'group'             => 'General',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'dependency'        => array(
                                    'element' => 'delay',
                                    'value'   => 'true',
                                )
                            ),                            
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'ut_shortcodes' ),
                                'param_name'        => 'class',
                                'group'             => 'General'
                            ),
                            
                            /* css editor */
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
                'image'             => '',
                'size'              => 'thumbnail',
                'align'             => 'left',
                'effect'            => 'fadeIn',
                'animate_once'      => 'no',
                'animate_tablet'    => 'no',
                'animate_mobile'    => 'no',
                'delay'             => 'no',
                'delay_timer'       => '200',
                'link_type'         => '',
                'link'              => '',
                'class'             => '',
                'css'               => ''
            ), $atts ) ); 
                                    
            if( empty( $image ) ) {
                return esc_html__( 'No Image Selected' , 'ut_shortcodes' );
            }
            
            /* get image */
            $image_array = wp_get_attachment_image_src( $image, $size );
            
            /* image alt */
            $alt = get_post_meta( $image, '_wp_attachment_image_alt', true ) ? get_post_meta( $image, '_wp_attachment_image_alt', true ) : '';
            
            if( empty( $image_array ) ) {
                return esc_html__( 'Image could not be found.' , 'ut_shortcodes' );
            }
            
            /* class array */
            $classes = array();
            $animation_classes = array();            
            
            /* extra element class */
            $classes[] = $class;
            
            /* attributes array */
            $attributes = array();
            
            /* fill animation classes */
            if( $effect != 'none' ) {
                
                $animation_classes[] = 'ut-animate-image';
                $animation_classes[] = 'animated';             
                            
                if( $animate_tablet ) {
                    $animation_classes[]  = 'ut-no-animation-tablet';
                }
                
                if( $animate_mobile ) {
                    $animation_classes[]  = 'ut-no-animation-mobile';
                }
                
                $attributes['data-effect'] = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                $attributes['data-delay'] = esc_attr( $delay_timer );    
                
            }

            /* attributes string */
            $attributes = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
                $attributes,
                array_keys( $attributes )
            ) ); 
                        
            /* start output */
            $output = '';
            
            $output .= '<div class="' . implode( ' ', $classes ) . '" style="text-align:' . $align . ';">';
                
                if( $link_type == 'image' ) {
                    
                    /* get full size image */
                    $full = wp_get_attachment_url( $image );
                    
                    /* set link */
                    $output .= '<a href="' . esc_url( $full ) . '" class="ut-vc-images-lightbox">';
                
                }
                
                if( $link_type == 'custom' && !empty( $link ) ) {
                    
                    /* attract link settings */
                    $link = vc_build_link( $link );
                    
                    /* set link attributes */
                    $link['target'] = empty( $link['target'] ) ? '_self' : $link['target'];
                    $link['url']    = empty( $link['url'] )    ? '#'     : $link['url'];
                    $rel            = empty( $link['rel'] )    ? ''      : 'rel="' . $link['rel'] . '"';
                    
                    $output .= '<a target="' . esc_attr( $link['target'] ) . '" href="' . esc_url( $link['url'] ) . '" ' . $rel . '>';
                
                }
                
                $output .= '<img src="' . esc_url( $image_array[0] ) . '" width="' . esc_attr( $image_array[1] ) . '" height="' . esc_attr( $image_array[2] ) . '" alt="' . esc_attr( $alt ) . '"/>';
                
                if( $link_type == 'image' || $link_type == 'custom' && !empty( $link ) ) {
                    
                    $output .= '</a>';
                    
                }                
                
            $output .= '</div>';
                
            return '<div ' . $attributes . ' class="wpb_content_element ' . implode( ' ', $animation_classes ) . ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . ' clearfix">' . $output . '</div>'; 
        
        }
            
    }

}

new UT_Animated_Image;

if ( class_exists( 'WPBakeryShortCode' ) ) {
    
    class WPBakeryShortCode_ut_animated_image extends WPBakeryShortCode {
        
        function __construct( $settings ) {
            
            parent::__construct( $settings );
            $this->jsScripts();
            
        }
    
        public function jsScripts() {
            
            wp_register_script( 'zoom', vc_asset_url( 'lib/bower/zoom/jquery.zoom.min.js' ), array(), WPB_VC_VERSION );
            wp_register_script( 'vc_image_zoom', vc_asset_url( 'lib/vc_image_zoom/vc_image_zoom.min.js' ), array(
                'jquery',
                'zoom',
            ), WPB_VC_VERSION, true );
            
        }
    
        public function singleParamHtmlHolder( $param, $value ) {
            
            $output = '';
    
            $param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
            $type = isset( $param['type'] ) ? $param['type'] : '';
            $class = isset( $param['class'] ) ? $param['class'] : '';
    
            if ( 'attach_image' === $param['type'] && 'image' === $param_name ) {
                $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
                $element_icon = $this->settings( 'icon' );
                $img = wpb_getImageBySize( array(
                    'attach_id' => (int) preg_replace( '/[^\d]/', '', $value ),
                    'thumb_size' => 'thumbnail',
                ) );
                $this->setSettings( 'logo', ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_general vc_element-icon"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( ! empty( $element_icon ) ? ' ' . $element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . __( 'Add image', 'js_composer' ) . '</a>' );
                $output .= $this->outputTitleTrue( $this->settings['name'] );
            } elseif ( ! empty( $param['holder'] ) ) {
                if ( 'input' === $param['holder'] ) {
                    $output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
                } elseif ( in_array( $param['holder'], array( 'img', 'iframe' ) ) ) {
                    $output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
                } elseif ( 'hidden' !== $param['holder'] ) {
                    $output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
                }
            }
    
            if ( ! empty( $param['admin_label'] ) && true === $param['admin_label'] ) {
                $output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . $param['heading'] . '</label>: ' . $value . '</span>';
            }
    
            return $output;
        }
    
        public function getImageSquareSize( $img_id, $img_size ) {
            if ( preg_match_all( '/(\d+)x(\d+)/', $img_size, $sizes ) ) {
                $exact_size = array(
                    'width' => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
                    'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
                );
            } else {
                $image_downsize = image_downsize( $img_id, $img_size );
                $exact_size = array(
                    'width' => $image_downsize[1],
                    'height' => $image_downsize[2],
                );
            }
            $exact_size_int_w = (int) $exact_size['width'];
            $exact_size_int_h = (int) $exact_size['height'];
            if ( isset( $exact_size['width'] ) && $exact_size_int_w !== $exact_size_int_h ) {
                $img_size = $exact_size_int_w > $exact_size_int_h
                    ? $exact_size['height'] . 'x' . $exact_size['height']
                    : $exact_size['width'] . 'x' . $exact_size['width'];
            }
    
            return $img_size;
        }
    
        protected function outputTitle( $title ) {
            return '';
        }
    
        protected function outputTitleTrue( $title ) {
            return '<h4 class="wpb_element_title">' . $title . ' ' . $this->settings( 'logo' ) . '</h4>';
        }                
        
    }
    
}