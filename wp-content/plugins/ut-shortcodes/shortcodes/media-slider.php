<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Media_Slider' ) ) {
	
    class UT_Media_Slider {
        
        private $shortcode;
        private $add_script;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_media_slider';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
            /* scripts */
            add_action( 'init', array( $this, 'register_scripts' ) );
            add_action( 'wp_footer', array( $this, 'enqueue_scripts' ) );
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Media Slider', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( 4.0 )',
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            
                            
                            array(
                                'type'          => 'param_group',
                                'heading'       => esc_html__( 'Slides', 'ut_shortcodes' ),
                                'group'         => 'Slides',
                                'param_name'    => 'slides',
                                'params' => array(
                                    
                                    array(
                                        'type'          => 'textfield',
                                        'heading'       => esc_html__( 'Title', 'ut_shortcodes' ),
                                        'param_name'    => 'title',                                        
                                        'admin_label'   => true,
                                    ),
                                    
                                    array(
                                        'type'          => 'dropdown',
                                        'heading'       => esc_html__( 'Slide Type', 'ut_shortcodes' ),
                                        'param_name'    => 'type',
                                        'value'         => array(
                                            esc_html__( 'image'  , 'ut_shortcodes' ) => 'image',
                                            esc_html__( 'video', 'ut_shortcodes' )   => 'video'
                                        ),
                                    ),
                                                                          
                                    array(
                                        'type'        => 'attach_image',
                                        'heading'     => esc_html__( 'Image', 'ut_shortcodes' ),
                                        'param_name'  => 'image',
                                        'dependency'    => array(
                                            'element' => 'type',
                                            'value'   => array( 'image' ),
                                        )
                                    ),
                                      
                                    array(
                                        'type'              => 'dropdown',
                                        'heading'           => esc_html__( 'Link Image?', 'ut_shortcodes' ),
                                        'param_name'        => 'link_type',
                                        'value'             => array(
                                            esc_html__( 'No Link' , 'ut_shortcodes' ) => 'none',
                                            esc_html__( 'Custom Link' , 'ut_shortcodes' ) => 'custom',
                                            esc_html__( 'Open in Lightbox' , 'ut_shortcodes' ) => 'image',
                                        ),
                                        'dependency'    => array(
                                            'element' => 'type',
                                            'value'   => array( 'image' ),
                                        )
                                    ),                            
                                    
                                    array(
                                        'type'              => 'vc_link',
                                        'heading'           => esc_html__( 'Link', 'ut_shortcodes' ),
                                        'param_name'        => 'link',
                                        'dependency'  => array(
                                            'element' => 'link_type',
                                            'value'   => 'custom',
                                        )                                        
                                    ),  
                                      
                                    array(
                                        'type'          => 'textfield',
                                        'heading'       => esc_html__( 'Video URL', 'ut_shortcodes' ),
                                        'description'   => esc_html__( 'Needs to be Vimeo or Youtube!' , 'ut_shortcodes' ),
                                        'param_name'    => 'video',
                                        'dependency'    => array(
                                            'element' => 'type',
                                            'value'   => array( 'video' ),
                                        )

                                    ),
                                    
                                    array(
                                        'type'          => 'attach_image',
                                        'heading'       => esc_html__( 'Poster Image', 'ut_shortcodes' ),
                                        'description'   => esc_html__( 'This images gets displayed until the video player loads.' , 'ut_shortcodes' ),
                                        'param_name'    => 'poster',
                                        'dependency'    => array(
                                            'element' => 'type',
                                            'value'   => array( 'video' ),
                                        )
                                    ),
                                    
                                ),
                                
                            ),
                            
                            array(
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Slider Type', 'ut_shortcodes' ),
                                'param_name'    => 'slider_type',
                                'group'         => 'Slider Settings',
                                'value'         => array(
                                    esc_html__( 'Single Slide'  , 'ut_shortcodes' ) => 'single',
                                    esc_html__( 'Carousel', 'ut_shortcodes' ) => 'carousel'
                                ),
                            ),  
                            
                            array(
                                'type'          => 'range_slider',
                                'heading'       => esc_html__( 'Slides on Desktop', 'ut_shortcodes' ),
                                'description'   => esc_html__( 'The number of items you want to see on the screen.' , 'ut_shortcodes' ),
                                'param_name'    => 'number',
                                'group'         => 'Slider Settings',
                                'value'             => array(
                                    'min'   => '1',
                                    'max'   => '5',
                                    'step'  => '1',
                                    'unit'  => 'x'
                                ),
                                'dependency'    => array(
                                    'element' => 'slider_type',
                                    'value'   => array( 'carousel' ),
                                )
                            ),
                            
                            array(
                                'type'          => 'range_slider',
                                'heading'       => esc_html__( 'Slides on Tablet', 'ut_shortcodes' ),
                                'description'   => esc_html__( 'The number of items you want to see on the screen.' , 'ut_shortcodes' ),
                                'param_name'    => 'number_tablet',
                                'group'         => 'Slider Settings',
                                'value'             => array(
                                    'min'   => '1',
                                    'max'   => '5',
                                    'step'  => '1',
                                    'unit'  => 'x'
                                ),
                                'dependency'    => array(
                                    'element' => 'slider_type',
                                    'value'   => array( 'carousel' ),
                                )                                
                            ),
                            
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
                                'type'          => 'dropdown',
                                'heading'       => esc_html__( 'Show Dot Navigation?', 'ut_shortcodes' ),
                                'param_name'    => 'dots',
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
                                'group'             => 'Slides'
                            ),
                            
                            /* colors */
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
                            
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Dot Color', 'ut_shortcodes' ),
								'param_name'        => 'dot_color',
								'group'             => 'Navigation Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Dot Color', 'ut_shortcodes' ),
								'param_name'        => 'dot_color_hover',
								'group'             => 'Navigation Colors'
						  	),
                            
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Video Play Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'video_icon_color',
								'group'             => 'Navigation Colors'
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
                'arrow_color'                  => '',
                'arrow_color_hover'            => '',
                'arrow_background_color'       => '',
                'arrow_background_color_hover' => '',
                'dot_color'                    => '',
                'dot_color_hover'              => '',
                'video_icon_color'             => ''
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
                
                <?php if( $dot_color ) : ?>     
                    
                    #<?php echo $id; ?> .owl-theme .owl-dots .owl-dot span { background: <?php echo $dot_color ?>;}
                    
                <?php endif; ?>
                
                <?php if( $dot_color_hover ) : ?>     
                    
                    #<?php echo $id; ?> .owl-theme .owl-dots .owl-dot.active span, 
                    #<?php echo $id; ?> .owl-theme .owl-dots .owl-dot:hover span {
                        background:<?php echo $dot_color_hover ?>;
                    }
                    
                <?php endif; ?>
                
                <?php if( $video_icon_color ) : ?>     
                    
                    #<?php echo $id; ?> .ut-owl-video-play-icon { 
                        border-color:<?php echo $video_icon_color ?>;
                    }
                    
                    #<?php echo $id; ?> .ut-owl-video-play-icon { 
                        color:<?php echo $video_icon_color ?>;
                    }
                    
                <?php endif; ?>
                                
            
            </style>
            
            <?php
            
            return ob_get_clean();
        
        }
        
        function ut_create_inline_script( $id, $atts ) {
            
            extract( shortcode_atts( array (
                'slider_type'       => 'single',
                'effect_in'         => 'fadeIn',
                'effect_out'        => 'fadeOut',
                'autoplay'          => 'false',
                'autoplay_timeout'  => 5000,
                'loop'              => 'true',
                'dots'              => 'true',
                'number'            => 1,
                'number_tablet'     => 1
            ), $atts ) );
            
            ob_start();
            
            ?>
                        
            <script type="text/javascript">
                
                (function($){
                                            
                    $(document).ready(function(){
                        
                        <?php if( $slider_type == 'single' ) : ?>
                        
                            $("#<?php echo esc_attr( $id ); ?>").owlCarousel({
                                items:1,
                                lazyLoad: true,
                                smartSpeed: 600,
                                animateIn: "<?php echo $effect_in; ?>",
                                animateOut: "<?php echo $effect_out; ?>",
                                autoplay: <?php echo $autoplay; ?>,
                                autoplayTimeout: <?php echo $autoplay_timeout; ?>,
                                loop:<?php echo $loop; ?>,
                                nav: false,
                                dots: <?php echo $dots; ?>,
                            });
                        
                        <?php else : ?>
                            
                            $("#<?php echo esc_attr( $id ); ?>").owlCarousel({
                                items:<?php echo $number; ?>,
                                lazyLoad: true,
                                smartSpeed: 600,
                                animateIn: "<?php echo $effect_in; ?>",
                                animateOut: "<?php echo $effect_out; ?>",
                                autoplay: <?php echo $autoplay; ?>,
                                autoplayTimeout: <?php echo $autoplay_timeout; ?>,
                                loop: true,
                                nav: false,
                                dots: <?php echo $dots; ?>,
                                responsiveClass:true,
                                responsive:{
                                    0:{
                                        items:1
                                    },
                                    768:{
                                        items:<?php echo $number_tablet; ?>
                                    },
                                    1025:{
                                        items:<?php echo $number; ?>
                                    }
                                }
                            });                        
                        
                        <?php endif; ?>
                        
                        if ( $().lightGallery ) {
                            
                            /* run lightgallery */
                            $("#<?php echo esc_attr( $id ); ?>").lightGallery({
                                selector: ".for-lightbox",
                                hash: false,
                                thumbnail: false,
                                exThumbImage: "data-src"
                            });            
                        
                        }                        
                        
                    });
                        
                })(jQuery);
            
            </script>
            
            <?php
            
            return ob_get_clean();
        
        }
        
        function create_retina_url( $image ) {
            
            $extension  = pathinfo( $image, PATHINFO_EXTENSION );     
            return str_replace('.' . $extension, '@2x.' . $extension, $image );
                
        }        
        
        function create_image_slide( $image ) {

            if( empty( $image['image'] ) ) {
                return;
            }
                        
            /* get necessary images */
            $full_image  = wp_get_attachment_url( $image['image'] );
            $slide_image = ut_resize( $full_image, '1280' , '720', true, true, true );
            
            
            /* lightbox slide */
            if( isset( $image['link_type'] ) && $image['link_type'] == 'image' ) {
                
                /* link to full size image */
                return '<a href="' . esc_url( $full_image ) . '" class="for-lightbox" data-src="' . esc_url( $slide_image ) .'"><img class="item owl-lazy" data-src="' . esc_url( $slide_image ) .'" data-src-retina="' . esc_url( $this->create_retina_url( $slide_image ) ) .'" /></a>';
                
            }
            
            /* custom link slide */            
            if( isset( $image['link_type'] ) && $image['link_type'] == 'custom' && !empty( $image['link'] ) ) {
                    
                /* attract link settings */
                $link = vc_build_link( $image['link'] );
                
                /* set link attributes */
                $link['target'] = empty( $link['target'] ) ? '_self' : $link['target'];
                $link['url']    = empty( $link['url'] )    ? '#'     : $link['url'];
                $rel            = empty( $link['rel'] )    ? ''      : 'rel="' . $link['rel'] . '"';
                                
                return '<a target="' . esc_attr( $link['target'] ) . '" href="' . esc_url( $link['url'] ) . '" ' . $rel . '><img class="item owl-lazy" data-src="' . esc_url( $slide_image ) .'" data-src-retina="' . esc_url( $this->create_retina_url( $slide_image ) ) .'" /></a>';
            
            }
            
            /* default slide */
            return '<div><img class="item owl-lazy" data-src="' . esc_url( $slide_image ) .'" data-src-retina="' . esc_url( $this->create_retina_url( $slide_image ) ) .'" /></div>';
        
        }
        
        function create_video_slide( $video ) {
            
            if( empty( $video['video'] ) ) {
                return;
            }
            
            $poster = $class = '';
            
            if( !empty( $video['poster'] ) ) {
                
                $poster = ut_resize( wp_get_attachment_url( $video['poster'] ) , '1280' , '720', true, true, true );
                
                return '<a href="' . esc_url( $video['video'] ) . '" class="for-lightbox ut-owl-video-link"><div class="ut-owl-video-play-icon"><i class="fa fa-play" aria-hidden="true"></i></div><img class="item owl-lazy" data-src="' . esc_url( $poster ) .'" data-src-retina="' . esc_url( $this->create_retina_url( $poster ) ) .'" /></a>';
                    
            }
            
        
        }        
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            /* enqueue scripts */
            $this->add_script = true;
            
            extract( shortcode_atts( array (
                'slides'        => '',
                'effect_in'     => 'fadeIn',
                'effect_out'    => 'fadeOut',
                'nav'           => 'true',
                'class'         => '',
                'css'           => ''
            ), $atts ) ); 
            
            /* class array */
            $classes = array();
            
            /* extra element class */
            $classes[] = $class;
            
            /* unique ID */
            $id = uniqid("ut_ms_");
            
            /* slides */
            $slides = vc_param_group_parse_atts( $slides ); 
            
            /* start output */
            $output = '';
            
            /* attach js */
            $output .= $this->ut_create_inline_script( $id, $atts );
            
            /* attach css */
            $output .= ut_minify_inline_css( $this->ut_create_inline_css( $id, $atts ) );
                        
            if( !empty( $slides ) && is_array( $slides ) ) {
                
                $output .= '<div class="ut-owl-gallery-slider-wrap">';
                
                    $output .= '<div id="' . esc_attr( $id ) . '" class="ut-owl-gallery-slider owl-carousel ' . implode( ' ', $classes ) . '">';
                        
                        foreach( $slides as $slide ) {
                            
                            if( $slide['type'] == 'image' ) {
                                $output .= $this->create_image_slide( $slide );
                            }
                            
                            if( $slide['type'] == 'video' ) {
                                $output .= $this->create_video_slide( $slide );
                            }
                                   
                        }
                            
                    $output .= '</div>';
                    
                    
                    if( $nav == 'true' ) {
                        $output .= '<a href="#" data-for="' . esc_attr( $id ) . '" class="ut-prev-gallery-slide"><i class="fa fa-angle-left"></i></a>';
                        $output .= '<a href="#" data-for="' . esc_attr( $id ) . '" class="ut-next-gallery-slide"><i class="fa fa-angle-right"></i></a>';                
                    }
                
                $output .= '</div>';
            
            }
               
            return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
        
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

new UT_Media_Slider;