<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Image_Gallery' ) ) {
	
    class UT_Image_Gallery {
        
        private $shortcode;
        
        private $image_count;
        private $image_total_count;
        
        private $mobile_image_count;
        private $mobile_total_count;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_image_gallery';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Image Gallery', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( 4.0 )',
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            
                            array(
                                'type'              => 'attach_images',
                                'heading'           => esc_html__( 'Gallery', 'ut_shortcodes' ),
                                'group'             => 'Gallery',
                                'param_name'        => 'gallery',
                                'admin_label'       => true
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Thumbnail Size', 'ut_shortcodes' ),
                                'param_name'        => 'thumbnail_size',
                                'group'             => 'Gallery',
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
                                'heading'           => esc_html__( 'Activate Lightbox?', 'ut_shortcodes' ),
                                'param_name'        => 'lightbox',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'yes', 'ut_shortcodes' ) => 'yes',
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'no',
                                )
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Gallery Items per row.', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Select your desired amount of images per row.', 'ut_shortcodes' ),
                                'param_name'        => 'grid',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( '1' , 'ut_shortcodes' ) => '1',
                                    esc_html__( '2' , 'ut_shortcodes' ) => '2',
                                    esc_html__( '3' , 'ut_shortcodes' ) => '3',
                                    esc_html__( '4' , 'ut_shortcodes' ) => '4',
                                    esc_html__( '5' , 'ut_shortcodes' ) => '5',
                                )
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Adjust last row?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'This Option will adjust the remaining items inside the last row to a higher grid if necessary.', 'ut_shortcodes' ),
                                'param_name'        => 'adjust_row',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'no',
                                    esc_html__( 'yes', 'ut_shortcodes' ) => 'yes'
                                ),
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Gallery Items Gap.', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Select gap between gallery images.', 'ut_shortcodes' ),
                                'param_name'        => 'gap',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( '0px'  , 'ut_shortcodes' ) => '0',
                                    esc_html__( '5px'  , 'ut_shortcodes' ) => '5',
                                    esc_html__( '10px' , 'ut_shortcodes' ) => '10',
                                    esc_html__( '15px' , 'ut_shortcodes' ) => '15',
                                    esc_html__( '20px' , 'ut_shortcodes' ) => '20',
                                    esc_html__( '25px' , 'ut_shortcodes' ) => '25',
                                    esc_html__( '30px' , 'ut_shortcodes' ) => '30',
                                    esc_html__( '35px' , 'ut_shortcodes' ) => '35',
                                    esc_html__( '40px' , 'ut_shortcodes' ) => '40',
                                )
                            ),
                            
                            
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Images?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Animate each element inside your gallery with an awesome animation effect.', 'ut_shortcodes' ),
                                'param_name'        => 'animate',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-12',
                                'value'             => array(
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true',
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false'
                                ),
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Images on Tablet?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_tablet',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Images on Mobile?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_mobile',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),                            
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Once?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Animate Images only once? By default images are animating everytime when in viewport.', 'ut_shortcodes' ),
                                'param_name'        => 'animate_once',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'no',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'yes'                                    
                                ),
                                'dependency'        => array(
                                    'element' => 'animate',
                                    'value'   => 'true',
                                )
                            ),    
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Delay Animation?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Animate Images inside the Gallery one by one.', 'ut_shortcodes' ),
                                'param_name'        => 'delay_animation',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'                                                                        
                                ),
                                'dependency'        => array(
                                    'element' => 'animate',
                                    'value'   => 'true'
                                )
                            ),
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Delay Timer', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Time in milliseconds until the next image appears. e.g. 200', 'ut_shortcodes' ),
                                'param_name'        => 'delay_timer',
                                'group'             => 'Gallery',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'dependency'        => array(
                                    'element' => 'delay_animation',
                                    'value'   => 'true',
                                )
                            ),                            
                            
                            array(
                                'type'              => 'animation_style',
                                'heading'           => __( 'Animation Effect', 'ut_shortcodes' ),
                                'description'       => __( 'Select initial loading animation for images.', 'ut_shortcodes' ),
                                'group'             => 'Gallery',
                                'param_name'        => 'effect',
                                'settings' => array(
                                    'type' => array(
                                        'in',
                                        'other',
                                    ),
                                ),
                                'dependency'        => array(
                                    'element' => 'animate',
                                    'value'   => 'true',
                                )
                                
                            ),
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'ut_shortcodes' ),
                                'param_name'        => 'class',
                                'group'             => 'Gallery'
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
        
        function ut_create_inline_css( $id, $atts ) {
            
            extract( shortcode_atts( array (
                'animate'   => 'true',
                'effect'    => '',
            ), $atts ) );    
            
           $css = '<style type="text/css" scoped>';
        
                if( $animate == 'true' && $effect ) {
                    
                    $css .= '#' . esc_attr( $id ) . ' .ut-animate-gallery-element { visibility: hidden; }';
                    
                }
            
           $css .= '</style>';
            
           return $css;
        
        }
        
        function ut_create_inline_script( $id, $atts ) {
            
            extract( shortcode_atts( array (
                'animate'         => 'true',
                'effect'          => '',
                'delay_animation' => 'false',
                'delay_timer'     => 200,
            ), $atts ) );
            
            ob_start();
            
            ?>
            
            <script type="text/javascript">
                
                (function($){
                                            
                    $(document).ready(function(){
                        
                        <?php if( $animate == 'true' && $effect ) : ?>
                        
                            $("#<?php echo esc_attr( $id ); ?> .ut-animate-gallery-element").appear();
                            
                            $(document.body).on('appear', '#<?php echo esc_attr( $id ); ?> .ut-animate-gallery-element', function( event, $all_appeared_elements ) {
    
                                var effect = $(this).data('effect');
                                
                                <?php if( $delay_animation == 'true' ) : ?>
                                    
                                    if( $(this).hasClass('appeared') ) {
                                        return;
                                    }
                                    
                                    $(this).delay(<?php echo $delay_timer; ?>* $all_appeared_elements.index(this) ).queue( function() {
                                                    
                                        $(this).css('visibility','visible').addClass( effect ).addClass('appeared').dequeue();
                                        
                                    });
                                            
                                
                                <?php else: ?>
                                    
                                    $(this).delay(200).queue( function() {
                                                        
                                        $(this).css('visibility','visible').addClass( effect ).dequeue();
                                        
                                    });
                                
                                <?php endif; ?>
                                
                                
                            });
                            
                            $(document.body).on('disappear', '#<?php echo esc_attr( $id ); ?> .ut-animate-gallery-element', function() {
                                
                                var effect = $(this).data('effect');
                                            
                                if( $(this).data('animateonce') === 'no' ) {
                                    
                                    $(this).stop(true,true).removeClass( effect ).css( 'visibility', 'hidden' ).removeClass('appeared');
                                
                                }
                                          
                            }); 
                        
                        <?php endif; ?>
  
                    });
                        
                })(jQuery);
            
            </script>
            
            <?php
            
            return ob_get_clean();
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'gallery'        => '',
                'thumbnail_size' => 'thumbnail',
                'lightbox'       => 'yes',
                'animate'        => 'true',
                'effect'         => '',
                'animate_once'   => 'no',
                'animate_mobile' => false,
                'animate_tablet' => false,
                'gap'            => '',
                'grid'           => '',
                'adjust_row'     => '',
                'class'          => '',
                'css'            => ''
            ), $atts ) ); 
            
            /* fallback */
            $grid = !$grid ? '1' : $grid;
            
            /* available grid sizes */
            $theme_grid = array(  
                1 => '100',
                2 => '50',
                3 => '33',
                4 => '25',
                5 => '20' 
            );
            
            $tablet_grid = array(  
                1 => '100',
                2 => '50',
                3 => '33',
                4 => '50',
                5 => '33' 
            );
                        
            /* class array */
            $classes = array();
            $animation_classes = array();
            
            $attributes = array();
            
            /* extra element class */
            $classes[] = $class;
            
            /* gap */
            if( $gap ) {
                $classes[] = 'ut-image-gallery-' .  $gap;
            }
            
            if( $animate == 'true' && $effect ) {
                
                $attributes['data-effect']      = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                
                $animation_classes[]  = 'ut-animate-gallery-element';
                $animation_classes[]  = 'animated';
                
                if( !$animate_tablet ) {
                    $animation_classes[]  = 'ut-no-animation-tablet';
                }
                
                if( !$animate_mobile ) {
                    $animation_classes[]  = 'ut-no-animation-mobile';
                }
                
                
            }           
            
            /* attributes string */
            $attributes = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
                $attributes,
                array_keys( $attributes )
            ) ); 
            
            
            /* unique ID */
            $id = uniqid("ut_ig_");
            
            /* start output */
            $output = '';
            
            /* attach js */
            $output .= $this->ut_create_inline_script( $id, $atts );
            
            /* attach css */
            $output .= ut_minify_inline_css( $this->ut_create_inline_css( $id, $atts ) );
                
            $gallery = explode( ',' , $gallery );
                    
            if( !empty( $gallery ) && is_array( $gallery ) ) {
                
                $this->mobile_total_count = count( $gallery );
                $this->image_total_count  = count( $gallery );
                
                $output .= '<div id="' . esc_attr( $id ) . '" class="ut-image-gallery ' . implode( ' ', $classes ) . ' clearfix">';
                    
                    foreach( $gallery as $image ) {
                        
                        $image_classes = array();
                        
                        $this->image_count++;
                        $this->mobile_image_count++;                        
                        
                        /* grid settings */
                        if( $adjust_row == 'yes' ) {
                            
                            $grid_items        = ( $this->image_total_count >= $grid ) ? $grid : $this->image_total_count;
                            $grid_items_tablet = ( $this->image_total_count >= $grid ) ? $grid : $this->image_total_count;
                            
                            /* force grid 33 for tablets */
                            if( $grid == '5' ) { $grid_items_tablet = ( $this->mobile_total_count >= '3' ) ? '3' : $this->mobile_total_count; }
                            
                            /* element classes */
                            $desktop = $theme_grid[$grid_items];
                            $tablet  = $tablet_grid[$grid_items_tablet];
                            
                        } else {
                            
                            $desktop = $theme_grid[$grid];
                            $tablet  = $tablet_grid[$grid];
                                                        
                        }
                        
                        /* if counter has reached the maximum of items per row, decrease the total counter */
                        if( $this->mobile_image_count == '3' && $this->mobile_total_count > '3') {
                            $this->mobile_total_count = $this->mobile_total_count - $this->mobile_image_count;
                            $this->mobile_image_count = 0;
                            $image_classes[] = 'ut-tablet-last';
                        }
                        
                        /* if counter has reached the maximum of items per row, decrease the total counter */
                        if( $this->image_count ==  $grid && $this->image_total_count > $grid) {
                            $this->image_total_count = $this->image_total_count - $this->image_count;
                            $this->image_count = 0;
                            $image_classes[] = 'ut-desktop-last';
                        }
                        
                        /* get image sizes */
                        $thumbnail  = wp_get_attachment_image_src( $image, $thumbnail_size );
                        $full       = wp_get_attachment_image_src( $image, 'full' );
                        
                        $output .= '<div data-count="' . $this->image_total_count . '" class="ut-image-gallery-item grid-' . esc_attr( $desktop ) . ' tablet-grid-' . esc_attr( $tablet ) . ' mobile-grid-100 ' . implode( ' ', $image_classes ) . '">';
                            
                            if( $lightbox != 'no' ) {
                                
                                $output .= '<a class="ut-vc-images-lightbox" href="' . esc_url( $full[0] ) . '"><img class="' . implode( ' ', $animation_classes ) . '" ' . $attributes . ' src="' . esc_url( $thumbnail[0] ) . '" width="' . esc_attr( $thumbnail[1] ) . '" height="' . esc_attr( $thumbnail[2] ) . '"></a>';
                                
                            } else {
                                
                                $output .= '<img class="' . implode( ' ', $animation_classes ) . '" ' . $attributes . ' src="' . esc_url( $thumbnail[0] ) . '" width="' . esc_attr( $thumbnail[1] ) . '" height="' . esc_attr( $thumbnail[2] ) . '">';
                                
                            }                            
                            
                        $output .= '</div>';
                            
                    }
                    
                    $output .= '<div class="clear"></div>';
                        
                $output .= '</div>';
            
            }
            
            $wpb = $gap ? array( 'ut-gallery-' .  $gap ) : array();
            return '<div class="wpb_content_element ' . implode( ' ', $wpb ) . ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . ' clearfix">' . $output . '</div>'; 
        
        }
            
    }

}

new UT_Image_Gallery;


if ( class_exists( 'WPBakeryShortCode' ) ) {
    
    class WPBakeryShortCode_ut_image_gallery extends WPBakeryShortCode {
        
        /* add images to visual composer */
        public function singleParamHtmlHolder( $param, $value ) {
            
            $output = '';
            
            $param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
            
            if ( 'gallery' === $param_name ) {
                
                $images_ids = empty( $value ) ? array() : explode( ',', trim( $value ) );
                $output .= '<ul class="attachment-thumbnails' . ( empty( $images_ids ) ? ' image-exists' : '' ) . '" data-name="' . $param_name . '">';
                foreach ( $images_ids as $image ) {
                    $img = wpb_getImageBySize( array( 'attach_id' => (int) $image, 'thumb_size' => 'thumbnail' ) );
                    $output .= ( $img ? '<li>' . $img['thumbnail'] . '</li>' : '<li><img width="150" height="150" test="' . $image . '" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail" alt="" title="" /></li>' );
                }
                $output .= '</ul>';
                $output .= '<a href="#" class="column_edit_trigger' . ( ! empty( $images_ids ) ? ' image-exists' : '' ) . '">' . __( 'Add images', 'js_composer' ) . '</a>';
    
            }
            
            return $output;
            
        }        
        
    }
    
}