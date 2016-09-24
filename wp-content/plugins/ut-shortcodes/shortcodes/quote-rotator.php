<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Quote_Rotator' ) ) {
	
    class UT_Quote_Rotator {
        
        private $shortcode;
        private $inner_shortcode;
        private $add_script;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode       = 'ut_qtrotator';
            $this->inner_shortcode = 'ut_qt';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );
            add_shortcode( $this->inner_shortcode, array( $this, 'ut_create_inner_shortcode' ) );
            
            /* scripts */
            add_action( 'init', array( $this, 'register_scripts' ) );
            add_action( 'wp_footer', array( $this, 'enqueue_scripts' ) );            	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'                    => esc_html__( 'Quote Rotator', 'ut_shortcodes' ),
                        'base'                    => $this->shortcode,
                        'category'                => 'Brooklyn ( 4.0 )',
                        'icon'                    => UT_SHORTCODES_URL . '/admin/img/vc_icons/quote-rotator.png',
                        'as_parent'               => array( 'only' => $this->inner_shortcode ),
                        'content_element'         => true,
                        'is_container'            => true,
                        'params'                  => array(
                            
                            array(
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Autoplay Slider?', 'ut_shortcodes' ),
                                'param_name'    => 'autoplay',
                                'group'         => 'Slider Settings',
                                'value'         => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__( 'Autoplay Timeout', 'ut_shortcodes' ),
                                'description'   => esc_html__( 'Autoplay interval timeout in milliseconds. Default: 5000' , 'ut_shortcodes' ),
                                'param_name'    => 'autoplay_timeout',
                                'group'         => 'Slider Settings',
                                'dependency'    => array(
                                    'element' => 'autoplay',
                                    'value'   => array( 'true' ),
                                )

                            ),
                            array(
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Loop Slider?', 'ut_shortcodes' ),
                                'param_name'    => 'loop',
                                'group'         => 'Slider Settings',
                                'value'         => array(
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true',
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false'
                                ),
                                'dependency'    => array(
                                    'element' => 'type',
                                    'value'   => array( 'single' ),
                                ) 
                            ),
                            array(
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Show Next / Prev Navigation?', 'ut_shortcodes' ),
                                'param_name'    => 'nav',
                                'group'         => 'Slider Settings',
                                'value'         => array(
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true',
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false'
                                ),
                            ),
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animation Effect In', 'ut_shortcodes' ),
                                'param_name'        => 'effect_in',
                                'group'             => 'Slide Effects',
                                'value'             => ut_recognized_in_animation_effects()
                            ),
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animation Effect Out', 'ut_shortcodes' ),
                                'param_name'        => 'effect_out',
                                'group'             => 'Slide Effects',
                                'value'             => ut_recognized_out_animation_effects()
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'ut_shortcodes' ),
                                'param_name'        => 'class',
                                'group'             => 'Slider Settings'
                            ),                            
                            
                            /* navigation colors */
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Arrow Color', 'ut_shortcodes' ),
								'param_name'        => 'arrow_color',
								'group'             => 'Navigation Colors'
						  	), 
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Arrow Color Hover', 'ut_shortcodes' ),
								'param_name'        => 'arrow_color_hover',
								'group'             => 'Navigation Colors'
						  	),
                            
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Arrow Background Color', 'ut_shortcodes' ),
								'param_name'        => 'arrow_background_color',
								'group'             => 'Navigation Colors'
						  	), 
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Arrow Background Color Hover', 'ut_shortcodes' ),
								'param_name'        => 'arrow_background_color_hover',
								'group'             => 'Navigation Colors'
						  	),
                            
                            /* testimonial colors */
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Author Name Color', 'ut_shortcodes' ),
								'param_name'        => 'name_color',
								'group'             => 'Testimonial Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Quote Color', 'ut_shortcodes' ),
								'param_name'        => 'quote_color',
								'group'             => 'Testimonial Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Origin Color', 'ut_shortcodes' ),
								'param_name'        => 'origin_color',
								'group'             => 'Testimonial Colors'
						  	),  
                            
                            /* css editor */
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design Options', 'ut_shortcodes' ),
                            )                            
                                  
                        ),
                        'js_view'         => 'VcColumnView'                        
                        
                    )
                
                ); /* end mapping */
                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Quote', 'ut_shortcodes' ),
                        'base'            => $this->inner_shortcode,
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/quote.png',
                        'as_child'        => array( 'only' => $this->shortcode ),
                        'content_element' => true,
                        'params'          => array(
                            array(
                                'type'              => 'attach_image',
                                'heading'           => esc_html__( 'Avatar', 'ut_shortcodes' ),
                                'param_name'        => 'avatar',
                                'group'             => 'General'
                            ),    
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Author', 'ut_shortcodes' ),
                                'param_name'        => 'author',
                                'admin_label'       => true,
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textarea',
                                'heading'           => esc_html__( 'Quote', 'ut_shortcodes' ),
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Origin', 'ut_shortcodes' ),
                                'param_name'        => 'origin',
                                'admin_label'       => true,
                                'group'             => 'General'
                            ),
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
 
            } 
        
        }
        
        function ut_create_inline_css( $id, $atts ) {
            
            extract( shortcode_atts( array (
                'arrow_color'                  => '',
                'arrow_color_hover'            => '',
                'arrow_background_color'       => '',
                'arrow_background_color_hover' => '',
                'name_color'                   => '',
                'quote_color'                  => '',
                'origin_color'                 => ''
            ), $atts ) );
            
            ob_start();
            
            ?>   
            
            <style type="text/css" scoped>
                
                <?php if( $arrow_color ) : ?>     
                    
                    #<?php echo $id; ?> .ut-next-gallery-slide { color: <?php echo $arrow_color ?>;}
                    #<?php echo $id; ?> .ut-prev-gallery-slide { color: <?php echo $arrow_color ?>;}
                    
                <?php endif; ?>
                
                <?php if( $arrow_color_hover ) : ?>     
                    
                    #<?php echo $id; ?> .ut-next-gallery-slide:hover { color: <?php echo $arrow_color_hover ?>;}
                    #<?php echo $id; ?> .ut-prev-gallery-slide:hover { color: <?php echo $arrow_color_hover ?>;}                        
                    
                <?php endif; ?>
                
                <?php if( $arrow_background_color ) : ?>     
                    
                    #<?php echo $id; ?> .ut-next-gallery-slide { background: <?php echo $arrow_background_color ?>;}
                    #<?php echo $id; ?> .ut-prev-gallery-slide { background: <?php echo $arrow_background_color ?>;}
                    
                <?php endif; ?>
                
                <?php if( $arrow_background_color_hover ) : ?>     
                    
                    #<?php echo $id; ?> .ut-next-gallery-slide:hover { background: <?php echo $arrow_background_color_hover ?>;}
                    #<?php echo $id; ?> .ut-prev-gallery-slide:hover { background: <?php echo $arrow_background_color_hover ?>;}
                    
                <?php endif; ?>
                
                <?php if( $name_color ) : ?>     
                    
                    #<?php echo $id; ?> .bklyn-testimonials-author { color: <?php echo $name_color ?>;}
                    
                <?php endif; ?>
                
                <?php if( $quote_color ) : ?>     
                    
                    #<?php echo $id; ?> .bklyn-testimonials-quote { color: <?php echo $quote_color ?>;}
                    
                <?php endif; ?>
                
                <?php if( $origin_color ) : ?>     
                    
                    #<?php echo $id; ?> .bklyn-testimonials-origin { color: <?php echo $origin_color ?>;}
                    
                <?php endif; ?>
            
            </style>
            
            <?php
            
            return ob_get_clean();
        
        }
        
        function ut_create_inline_script( $id, $atts ) {
            
            extract( shortcode_atts( array (
                'effect_in'         => 'fadeIn',
                'effect_out'        => 'fadeOut',
                'autoplay'          => 'false',
                'autoplay_timeout'  => 5000,
                'loop'              => 'true',
            ), $atts ) );
            
            ob_start();
            
            ?>
            
            <script type="text/javascript">
                
                (function($){
                                            
                    $(document).ready(function(){
                        
                        var $<?php echo esc_attr( $id ); ?> =  $("#<?php echo esc_attr( $id ); ?>");
                        
                        $<?php echo esc_attr( $id ); ?>.owlCarousel({
                            items:1,
                            smartSpeed: 600,
                            lazyLoad: true,
                            animateIn: "<?php echo $effect_in; ?>",
                            animateOut: "<?php echo $effect_out; ?>",
                            autoplay: <?php echo $autoplay; ?>,
                            autoplayTimeout: <?php echo $autoplay_timeout; ?>,
                            loop:<?php echo $loop; ?>,
                            nav: false,
                            dots: false,
                        });
                          
                
                    });
                        
                })(jQuery);
                    
            </script>
            
            <?php
            
            return ob_get_clean();
        
        }
        
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            /* enqueue scripts */
            $this->add_script = true;
            
            extract( shortcode_atts( array (
                'nav'       => 'true',
                'css'       => '',                
                'class'     => ''
            ), $atts ) ); 
            
            /* class array */
            $classes = array();
            
            /* extra element class */
            $classes[] = $class;
            
            /* set unique ID for this rotator */
            $id = uniqid("qtSlider_");
            $outer_id = uniqid("qtSliderOuter");
            
            /* start output */
            $output = '';            
            
            /* attach script */
            $output .= $this->ut_create_inline_script( $id, $atts );
            
            /* attach css */
            $output .= ut_minify_inline_css( $this->ut_create_inline_css( $outer_id, $atts ) );
            
            $output .= '<div class="ut-bkly-qt-rotator ' . implode( ' ', $classes ) . '">';
            
                $output .= '<div id="' . esc_attr( $id ) . '" class="owl-carousel">';
                    
                    $output .= do_shortcode( $content );
                         
                $output .= '</div>';
                
                if( $nav == 'true' ) {
                        
                    $output .= '<a href="#" data-for="' . esc_attr( $id ) . '" class="ut-prev-gallery-slide"><i class="fa fa-angle-left"></i></a>';
                    $output .= '<a href="#" data-for="' . esc_attr( $id ) . '" class="ut-next-gallery-slide"><i class="fa fa-angle-right"></i></a>';                
                
                }
            
            $output .= '</div>';
            
            if( defined( 'WPB_VC_VERSION' ) ) { 
                
                return '<div id="'. esc_attr( $outer_id ).'" class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
                
            return $output;
        
        }
        
        function ut_create_inner_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'author'    => '',
                'avatar'    => '',
                'origin'    => '',
            ), $atts ) ); 
            
            $output = '';
            
            if( !empty( $avatar ) ) {        
                $avatar = ut_resize( wp_get_attachment_url( $avatar ) , '200' , '200', true , true , true );
            }
            
            $output .= '<div class="ut-bkly-qt-slide bkly-testimonials-style1">';
                
                if( !empty( $avatar ) ) {  
                
                    $output .= '<div class="bklyn-testimonials-avatar">';
                    
                        $output .= '<img src="' .  esc_url( $avatar ) . '" alt="' . esc_attr( $author ) . '">';
                        
                    $output .= '</div>';
                
                }
                
                $output .= '<div class="bklyn-testimonials-quote">';
                    
                    if( !empty( $content ) ) {
                
                        $output .= do_shortcode( wpautop( $content ) );
                        
                    }
                    
                $output .= '</div>';
                
                $output .= '<div class="bklyn-about-testimonials-author">';
                    
                    if( !empty( $author ) ) {
                    
                        $output .= '<div class="bklyn-testimonials-author">';
                        
                            $output .= $author;
                    
                        $output .= '</div>';
                    
                    }
                        
                    if( !empty( $origin ) ) {
                    
                        $output .= '<div class="bklyn-testimonials-origin">';
                    
                            $output .= $origin;
                    
                        $output .= '</div>';
                    
                    }
                
                $output .= '</div>';
            
            $output .= '</div>';
            
            return $output;                     
        
        }
        
        function register_scripts() {
            
            $min = NULL;
        
            if( !WP_DEBUG ){
                $min = '.min';
            } 
            
            wp_register_script( 
                'ut-owl-carousel', 
                plugins_url('../js/plugins/owlsider/js/owl.carousel' . $min . '.js', __FILE__), 
                array('jquery'), 
                '2.0.0', 
                true
            );
            
            wp_register_style(
                'ut-owl-carousel', 
                plugins_url('../js/plugins/owlsider/css/owl.carousel' . $min . '.css', __FILE__), 
                array(), 
                '2.0.0' 
            );
            
            wp_register_style(
                'ut-owl-carousel-theme', 
                plugins_url('../js/plugins/owlsider/css/owl.theme.default' . $min . '.css', __FILE__), 
                array(), 
                '2.0.0' 
            );
            
            
        
        }        
        
        function enqueue_scripts() {
            
            if( !$this->add_script ) {
                return;
            }
            
            wp_print_scripts('ut-owl-carousel');
            wp_print_styles('ut-owl-carousel');
            wp_print_styles('ut-owl-carousel-theme');
        
        }       
            
    }

}

new UT_Quote_Rotator;


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    
    class WPBakeryShortCode_ut_qtrotator extends WPBakeryShortCodesContainer {
    
    }
    
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    
    class WPBakeryShortCode_ut_qt extends WPBakeryShortCode {
    
    }
    
}