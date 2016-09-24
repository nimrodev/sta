<?php 

/*
 * Portfolio Management by United Themes
 * http://www.unitedthemes.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ut_portfolio_shortcode {
	
	static $add_showcase_script;
	static $add_masonry_script;
    static $add_gallery_script;
    static $add_lightbox_script;
    
	static $token;
    static $lightbox;
    static $portfolio_settings;
    static $detailstyle;
	static $cache;
	
	/* init */
	static function init() {
		
		add_shortcode( 'ut_showcase' , array(__CLASS__, 'handle_shortcode') );		
		
	}
	
	/* start shortcode */
	static function handle_shortcode( $atts ) {
		
		extract( shortcode_atts( array( 
            'id' => '' 
        ) , $atts ) );
		
		/* no id has been set , nothing more to do here */
		if( empty( $id ) ) return;
		
		/* set token */
		self::$token = $id;
		
		/* set cache */
		self::$cache = ( get_option('portfolio_cache_mode') == 'on' ) ? '&amp;c=1' : '';
        
        /* set lightbox */
        self::$lightbox = ( get_option('portfolio_lightbox_script') == 'lightgallery' ) ? 'ut-lightgallery' : 'ut-prettyphoto';
		
        /* portfolio settings */
        self::$portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings', true );
                
        /* detail style */
        self::$detailstyle = self::$portfolio_settings['detail_style'];
        
        /* get portfolio type */
		$ut_portfolio_type = get_post_meta( self::$token , 'ut_portfolio_type' , true );
                
        /*
        |--------------------------------------------------------------------------
        | Showcase Gallery
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_showcase' ) {
			
			self::$add_showcase_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_showcase_scripts') );
			
			/* create showcase gallery */
			return self::create_showcase_gallery();
            
		}
        
        /*
        |--------------------------------------------------------------------------
        | Portfolio Carousel
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_carousel' ) {
			
			self::$add_showcase_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_showcase_scripts') );
			
			/* create showcase gallery */
			return self::create_portfolio_carousel();
            
		}
		
        /*
        |--------------------------------------------------------------------------
        | Grid / Masonry Gallery
        |--------------------------------------------------------------------------
        */
		if( $ut_portfolio_type == 'ut_masonry' ) {
			
			self::$add_masonry_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_masonry_scripts') );
			
			/* create masonry gallery */
			return self::create_masonry_gallery();
            
		}
        
        /*
        |--------------------------------------------------------------------------
        | Portfolio Filterable Gallery
        |--------------------------------------------------------------------------
        */
        if( $ut_portfolio_type == 'ut_gallery' ) {
			
			self::$add_gallery_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_gallery_scripts') );
			
			/* create masonry gallery */
			return self::create_portfolio_gallery();
            
		}
        
        /*
        |--------------------------------------------------------------------------
        | Portfolio Filterable Gallery Packery
        |--------------------------------------------------------------------------
        */
        if( $ut_portfolio_type == 'ut_packery' ) {
			
			self::$add_gallery_script = true;
			add_action( 'wp_footer' , array(__CLASS__, 'enqueue_packery_scripts') );
			
			/* create masonry gallery */
			return self::create_portfolio_packery_gallery();
            
		}
        		

	}
    
    /*
    |--------------------------------------------------------------------------
    | Custom CSS
    |--------------------------------------------------------------------------
    */
    static function create_custom_css( $custom_settings = array() ) {
        
        $css  = '<style type="text/css" scoped>';
            
            if( function_exists('ut_create_typography_css') && function_exists('ot_get_option') && function_exists('ut_recognized_google_fonts') && function_exists('ut_recognized_font_styles') ) {
                
                $google_fonts = ut_recognized_google_fonts();
                
                /* portfolio title */
                if( ot_get_option('ut_global_portfolio_title_font_type' , 'ut-font' ) == 'ut-google' ) {
                    
                    $font_style = ot_get_option('ut_google_portfolio_title_font_style');
                    
                    if( !empty($google_fonts[$font_style['font-id']]['family']) ) {
                    
                        $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c h3, .ut-portfolio-' . self::$token . ' .portfolio-title {';

                            $css .= 'font-family:"' . $google_fonts[$font_style['font-id']]['family'] . '";';                    
                            
                            if( !empty($font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($font_style['font-size']) ) {
                                $css .= ' font-size: ' . $font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($font_style['font-style']) && isset($font_styles[$font_style['font-style']]) ) {
                                $css .= ' font-style: ' . $font_styles[$font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($font_style['line-height']) ) {
                                $css .= ' line-height: ' . $font_style['line-height'] . ';';    
                            }
                            
                            if( !empty($font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } 
                
                } 
                
                if( ot_get_option('ut_global_portfolio_title_font_type' , 'ut-font') == 'ut-websafe' ) {
                
                    $css .= ut_create_typography_css( '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c h3, .ut-portfolio-' . self::$token . ' .portfolio-title', ot_get_option('ut_websafe_portfolio_title_font_style') );
                    
                }
                
                /* title color */
                $text_color = !empty( self::$portfolio_settings['text_color'] ) ? self::$portfolio_settings['text_color'] : ot_get_option( 'ut_global_portfolio_title_color', '#222222' );
                $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c h3, .ut-portfolio-' . self::$token . ' .portfolio-title { color: ' . $text_color . ' ; }';
                
                
                if( isset( $custom_settings['style'] ) && $custom_settings['style'] == 'style_two' ) {
                
                    /* title background */
                    $title_background_color = !empty( self::$portfolio_settings['title_background_color'] ) ? self::$portfolio_settings['title_background_color'] : ot_get_option( 'ut_global_portfolio_title_background_color', '#FFF' );
                    $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-title-wrap, .ut-portfolio-' . self::$token . ' .portfolio-title { background: ' . $title_background_color . ' ; }';
                
                }
                
                /* portfolio category */
                if( ot_get_option('ut_global_portfolio_category_font_type' , 'ut-font' ) == 'ut-google' ) {
                    
                    $font_style = ot_get_option('ut_google_portfolio_category_font_style');
                    
                    if( !empty($google_fonts[$font_style['font-id']]['family']) ) {
                    
                        $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c span {';

                            $css .= 'font-family:"' . $google_fonts[$font_style['font-id']]['family'] . '";';                    
                            
                            if( !empty($font_style['font-weight']) ) {
                                $css .= ' font-weight: ' . $font_style['font-weight'] . ';';    
                            }
                            
                            if( !empty($font_style['font-size']) ) {
                                $css .= ' font-size: ' . $font_style['font-size'] . ';';    
                            }
                            
                            if( !empty($font_style['font-style']) && isset($font_styles[$font_style['font-style']]) ) {
                                $css .= ' font-style: ' . $font_styles[$font_style['font-style']] . ';';    
                            }
                            
                            if( !empty($font_style['line-height']) ) {
                                $css .= ' line-height: ' . $font_style['line-height'] . ';';    
                            }
                            
                            if( !empty($font_style['text-transform']) ) {
                                $css .= ' text-transform: ' . $font_style['text-transform'] . ';';    
                            }
                            
                        $css .= '}';
                    
                    } 
                
                } 
                
                if( ot_get_option('ut_global_portfolio_category_font_type' , 'ut-font') == 'ut-websafe' ) {
                
                    $css .= ut_create_typography_css( '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c span', ot_get_option('ut_websafe_portfolio_category_font_style') );
                    
                }
                
                $category_color = !empty( self::$portfolio_settings['category_color'] ) ? self::$portfolio_settings['category_color'] : ot_get_option( 'ut_global_portfolio_category_color', '#FFF' );
                $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c, .ut-portfolio-' . self::$token . ' .ut-portfolio-info-c span { color: ' . $category_color . ' ; }';
                               
                
            }
            
            if( !empty( self::$portfolio_settings['caption_position'] ) ) {
                
                $positions = explode( '-', self::$portfolio_settings['caption_position'] );
                $css .= '.ut-portfolio-' . self::$token . ' .ut-portfolio-info-c { vertical-align: ' . $positions[0] . ' ; text-align: ' . $positions[1] . ' ;}';
                $css .= '.ut-portfolio-' . self::$token . ' .portfolio-style-two .ut-portfolio-info i { text-align: ' . $positions[1] . ' ;}';
            
            }
            
        $css .= '</style>';
        
        return $css;       
            
    }
    
    /*
    |--------------------------------------------------------------------------
    | Responsive CSS
    |--------------------------------------------------------------------------
    */
    static function create_responsive_css( $gallery_options ) {
        
        /* desktop base height */
        $desktop_base_height = !empty( $gallery_options['desktop_base_height'] ) ? $gallery_options['desktop_base_height'] : '200';
        $tablet_base_height  = !empty( $gallery_options['tablet_base_height'] )  ? $gallery_options['tablet_base_height']  : '400';
        $mobile_base_height  = !empty( $gallery_options['mobile_base_height'] )  ? $gallery_options['mobile_base_height']  : '300';
        
        ob_start();
        
        ?>
        
        <style type="text/css" scoped>
            
            <?php if ( isset( $gallery_options['style'] ) && $gallery_options['style'] == 'style_one' ) : ?>
                  
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default {
                     height:<?php echo $desktop_base_height; ?>px; 
                }
                 
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait {
                    height:<?php echo $desktop_base_height * 2; ?>px;    
                }
                
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl {
                    height:<?php echo $desktop_base_height * 2; ?>px;    
                }
                
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama {
                    height:<?php echo $desktop_base_height; ?>px;    
                }
                
                @media screen and (max-width: 767px) {
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default {
                         height:<?php echo $mobile_base_height; ?>px; 
                    }
                     
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }                
                
                }
                
                @media screen and (min-width: 768px) and (max-width: 1024px) {
                
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default {
                         height:<?php echo $tablet_base_height; ?>px; 
                    }
                     
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                
                }
            
            <?php else :?>
            
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default .ut-portfolio-item {
                     height:<?php echo $desktop_base_height; ?>px; 
                }
                 
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait .ut-portfolio-item {
                    height:<?php echo ( $desktop_base_height * 2 ) + 80; ?>px;    
                }
                
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl .ut-portfolio-item {
                    height:<?php echo ( $desktop_base_height * 2 ) + 80; ?>px;    
                }
                
                .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama .ut-portfolio-item {
                    height:<?php echo $desktop_base_height; ?>px;    
                }
                
                @media screen and (max-width: 767px) {
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default .ut-portfolio-item {
                         height:<?php echo $mobile_base_height; ?>px; 
                    }
                     
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait .ut-portfolio-item {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl .ut-portfolio-item {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama .ut-portfolio-item {
                        height:<?php echo $mobile_base_height; ?>px;    
                    }                
                
                }
                
                @media screen and (min-width: 768px) and (max-width: 1024px) {
                
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-default .ut-portfolio-item {
                         height:<?php echo $tablet_base_height; ?>px; 
                    }
                     
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-portrait .ut-portfolio-item {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-xxl .ut-portfolio-item {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                    
                    .ut-portfolio-<?php echo self::$token; ?> .ut-masonry-panorama .ut-portfolio-item {
                        height:<?php echo $tablet_base_height; ?>px;    
                    }
                
                }            
            
            <?php endif; ?>
            
        </style>
        
        <?php
        
        return ob_get_clean();
    
    }
    
	/*
    |--------------------------------------------------------------------------
    | Create hidden slide / popup gallery for all gallery types
    |--------------------------------------------------------------------------
    */
	static function create_hidden_popup_portfolio( $portfolio_args = array() , $image_style = "" ) {
		
		/* no query args - we leave here */
		if( empty( $portfolio_args ) ) {
			return;
		}
		
		/* create hidden portfolio */		
		$hidden_portfolio  = '<div id="ut-loader-' . self::$token . '" class="ut-portfolio-detail-loader"><i class="fa fa-refresh fa-spin"></i></div>';
		$hidden_portfolio .= '<div id="ut-portfolio-details-wrap-' . self::$token . '" class="ut-portfolio-details-wrap clearfix">';
			
			$hidden_portfolio .= '<div id="ut-portfolio-details-' . self::$token . '" class="inner ut-portfolio-details">';
			
			/*
			|--------------------------------------------------------------------------
			| Portfolio Navigation
			|--------------------------------------------------------------------------
			*/
			$hidden_portfolio .= '<div class="ut-portfolio-details-navigation">';
				$hidden_portfolio .= '<a class="prev-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
				$hidden_portfolio .= '<a class="close-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
				$hidden_portfolio .= '<a class="next-portfolio-details" data-wrap="' . self::$token . '" href="#"></a>';
			$hidden_portfolio .= '</div>';
			
			
			/* start query */
			$portfolio_query = new WP_Query( $portfolio_args );	
			
			/* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
				
				global $more; 
				
				/* needed variables */
				$more = $portfolio_details = $optionkey = NULL;
				$post_format = get_post_format();
                
                /* hero type setting - new with 2.6 */
                $ut_page_hero_type = get_post_meta($portfolio_query->post->ID , 'ut_page_hero_type' , true);
				
                if( !empty($ut_page_hero_type) ) {
                    
                    if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                        $post_format = '';
                    }
                    
                    if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                        $post_format = 'gallery';
                    }
                    
                    if($ut_page_hero_type == 'video') {
                        $post_format = 'video';
                        $ut_page_video_source = get_post_meta($portfolio_query->post->ID, 'ut_page_video_source' , true);
                    }
                    
                    /* switch option key */
                    switch ($ut_page_hero_type) {
                    
                        case 'animatedimage':
                        $optionkey = 'ut_page_hero_animated_image';
                        break;
                        
                        default:  
                        $optionkey = 'ut_page_hero_image';  
                    
                    }                  
                
                }                
                                
				/* meta data*/
				$ut_portfolio_details = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_details', true );
				
				/* grab up the featured image url */
				$fullsize = $thumbnail = $portfolio_detail_image = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );				
				
                /* check if there is a detail image available */
                $portfolio_detail_image_data = get_post_meta( $portfolio_query->post->ID , $optionkey , true );                
                
                if( is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data['background-image']) ) {
                        
                    $portfolio_detail_image = $portfolio_detail_image_data['background-image'];
                    
                } elseif( !is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data) ) {
                    
                    $portfolio_detail_image = $portfolio_detail_image_data;
                    
                }
                
                /* check if portfolio leads to internal page - so we don't need to show the details anymore */
                if( self::$detailstyle == 'internal' && ( get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'global' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'internal' ) ) {
                    continue;
                }
               
                /* check if portfolio leads to internal page or external page - so we don't need to show the details anymore */
                if( get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'external' ) {
                    continue;
                }
                                
				/* create hidden content div first */
				$hidden_portfolio .= '<div id="ut-portfolio-detail-' . $portfolio_query->post->ID . '" class="animated ut-portfolio-detail clearfix" data-post="' . $portfolio_query->post->ID . '" data-format="' . $post_format . '">';
										
					/* portfolio details */
					if( is_array( $ut_portfolio_details ) && !empty( $ut_portfolio_details ) && ( count($ut_portfolio_details) > 1 ) ) {
						
						$portfolio_details .= '<ul class="ut-portfolio-list clearfix">';
						
							foreach( $ut_portfolio_details as $key => $detail ) {
								
                                if( !empty($detail['title']) && !empty($detail['value']) ) {   
								    $portfolio_details .= '<li><strong>' . $detail['title'] . ': </strong>' . $detail['value'] . '</li>';
                                }
                                
							}
						
						$portfolio_details .= '</ul>';
						
					}
					
					/* start markup */
					$hidden_portfolio .= '<div class="grid-80 prefix-10 mobile-grid-100 tablet-grid-80 tablet-prefix-10 ut-portfolio-media">';
                        
						if( ! post_password_required() ) {
							                                                        
                            /* fallback to old system prioer to 2.6 */
                            if( empty( $ut_page_hero_type ) ) {
                                
                                /*
                                |--------------------------------------------------------------------------
                                | Standard Post Format
                                |--------------------------------------------------------------------------
                                */
                                if( empty( $post_format ) ) {
    
                                    /* featured image */
                                    $hidden_portfolio .= '<img class="ut-portfolio-image ut-load-me ' . $image_style . '" alt="' . get_the_title() . '" data-original="' . $portfolio_detail_image . '">';								
    
                                }							
                                
                                /*
                                |--------------------------------------------------------------------------
                                | Video Post Format 
                                |--------------------------------------------------------------------------
                                */
                                if( $post_format == 'video' ) {
                                                                    
                                    /* add video to hidden portfolio detail*/
                                    $hidden_portfolio .= '<div id="ut-video-call-'.$portfolio_query->post->ID.'" class="ut-video-call"></div>';								
                                                                    
                                }							
                                
                                /*
                                |--------------------------------------------------------------------------
                                | Gallery Post Format 
                                |--------------------------------------------------------------------------
                                */
                                if( $post_format == 'gallery' ) {
                                
                                    $hidden_portfolio .= ut_portfolio_flex_slider( $portfolio_query->post->ID , false , $image_style );								
                                    
                                }
                            
                            
                            /* new markup for 2.6 */
                            } else {
                                
                                if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                                    
                                    /* featured image */
                                    $hidden_portfolio .= '<img class="ut-portfolio-image ut-load-me ' . $image_style . '" alt="' . get_the_title() . '" data-original="' . $portfolio_detail_image . '">';                                    
                                
                                }
                                
                                if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                                    
                                    /* create flex slider list */
                                    $hidden_portfolio .= ut_portfolio_flex_slider( $portfolio_query->post->ID , false , $image_style, $ut_page_hero_type );
                                
                                }
                                
                                if($ut_page_hero_type == 'video') {
                                    
                                    /* create video placeholder div - ut-ajax call media will fill it with content on request */
                                    $hidden_portfolio .= '<div id="ut-video-call-'.$portfolio_query->post->ID.'" class="ut-video-call"></div>';	
                                
                                }
                                                            
                            }
							
						} else {
						
							$hidden_portfolio .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							$the_content = get_the_password_form();
							
						}
					
					$hidden_portfolio .= '</div>';
					
					$hidden_portfolio .= '<div class="grid-70 prefix-15 mobile-grid-100 tablet-grid-70 tablet-prefix-15 entry-content clearfix">';
						
					$hidden_portfolio .= '</div>';					
					
				$hidden_portfolio .= '</div>';
				
			/* end loop */
			endwhile; endif;
			
			/* reset query */
			wp_reset_postdata();
			
			$hidden_portfolio .= '</div>';
			
		$hidden_portfolio .= '</div>';
		
		$hidden_portfolio .= '<div class="clear"></div>';
		
		return $hidden_portfolio;
		
	}
	
    /*
    |--------------------------------------------------------------------------
    | Showcase Gallery
    |--------------------------------------------------------------------------
    */
	static function create_showcase_gallery() {
		
		global $paged;
				
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
        
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
		
        /* showcase options */
        $showcase_options = get_post_meta( self::$token , 'ut_showcase_options' );
        $showcase_options = $showcase_options[0];
        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
						
        /* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        ); 
        
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );
		        
        /* needed javascript */
		$showcase = self::generate_showcase_script( $showcase_options );		
		
        /* needed css */
        $showcase .= self::create_custom_css();
        
        /* text color */
        if( function_exists('ot_get_option') ) {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : ot_get_option('ut_global_portfolio_title_color','#FFF');
            
        } else {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : '#FFF';
            
        }
        
        /* start showcase */
		$showcase .= '<div class="ut-portfolio-wrap ut-portfolio-' . self::$token . ' ' . $portfolio_settings["optional_class"] . '" data-textcolor="' . esc_attr( $textcolor ) . '" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
		
		$showcase .= '<div id="slider_' . self::$token . '" class="flexslider ut-showcase">';
		$showcase .= '<ul class="slides">';				
		
        /* create thumbnail navigation */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            $showcase_navigation  = '<div id="carousel_' . self::$token . '" class="flexslider ut-showcase-navigation">';
            $showcase_navigation .= '<ul class="slides">';
        }
        				
					/* loop trough portfolio items */
					if ($portfolio_query->have_posts() ) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
												
						if ( has_post_thumbnail() && ! post_password_required() ) {		
            
							$fullsize   = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
						
							$showcase .= '<li>';
								$showcase .= '<img alt="' . get_the_title() . '" src="' . $fullsize . '" />';
							$showcase .= '</li>';
							
							/* create showcase navigation items */
							if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
								
								$thumbnail = ut_resize( $fullsize , 210 , 140 , true , true , true );
								
									$showcase_navigation .= '<li class="ut-hover">';
										
										$showcase_navigation .= '<a href="#">';
										
										$showcase_navigation .= '<figure>';
											$showcase_navigation .= '<img src="' . $thumbnail . '" />';
										$showcase_navigation .= '</figure>';
										
										$showcase_navigation .= '<div class="ut-hover-layer">';
											
											$showcase_navigation .= '<div class="ut-portfolio-info">';
                                                
                                                $showcase_navigation .= '<div class="ut-portfolio-info-c">';
											
                                                    $showcase_navigation .= '<h3>' . get_the_title() . '</h3>';											
                                                    $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                                                    $showcase_navigation .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
										    
                                            $showcase_navigation .= '</div>';
                                            	
										$showcase_navigation .= '</div>';
										
									$showcase_navigation .= '</div>';
									
									$showcase_navigation .= '</a>';
									
								$showcase_navigation .= '</li>';                           
								
							}
						
						} else {
							
							
										
						}                       
						
					endwhile; endif;
				
				/* reset query */
				 wp_reset_postdata();
	    
        /* end showcase navigation */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            $showcase_navigation .= '</ul>';
            $showcase_navigation .= '</div>';
        }
        
        /* end showcase */		
		$showcase .= '</ul>';
		$showcase .= '</div>';
		        
        /* return final showcase */
        if( isset($showcase_options['display_thumbnail_navigation'] ) ) {
            return $showcase . $showcase_navigation . '</div>';
        } else {
            return $showcase . '</div>';
        }
        
	}
	
	static function generate_showcase_script( $showcase_options ) {
		
		/* settings */
		$container = self::$token;
		$thumbnail_navigation = '';
		$sync = '';
		
		/* showcase navigation script */
		if( isset( $showcase_options['display_thumbnail_navigation'] ) ) :
			
			$thumbnail_navigation = "
			$('#carousel_$container').flexslider({
            	animation: 'slide',
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 210,
                itemMargin: 5,
                asNavFor: '#slider_$container'
            });";
			
			// sync for slider function
			$sync = "sync: '#carousel_$container'";

		endif;
		/* end showcase navigation */ 
        
                
        /* showcase options */
        $animation      = !empty($showcase_options['animation']) ? $showcase_options['animation'] : 'slide';
        $slideshowSpeed = !empty($showcase_options['slideshowSpeed']) ? $showcase_options['slideshowSpeed'] : '7000'; 
        $animationSpeed = !empty($showcase_options['animationSpeed']) ? $showcase_options['animationSpeed'] : '600'; 
        $directionNav   = !empty($showcase_options['directionNav']) ? 'true' : 'false';
        $smoothHeight   = !empty($showcase_options['smoothHeight']) ? 'true' : 'false';
        
        /* main showcase script */
        $script = "
		<script type='text/javascript'>
		/* <![CDATA[ */ 
        
			(function($){
			
				$(window).load(function(){
				
					$thumbnail_navigation
				
					$('#slider_$container').flexslider({
						
						animation: '$animation',
                    	controlNav: false,
                    	animationLoop: false,
                    	slideshow: true,
                        slideshowSpeed: $slideshowSpeed,
						animationSpeed: $animationSpeed,
                        directionNav: $directionNav,
                        smoothHeight: $smoothHeight,
                        
                        $sync
						
					});
					
				});
			
			})(jQuery);
		
		/* ]]> */ 
		</script>";
		/* end main showcase script */       
               
		
        /* output javascript */
		return ut_compress_java($script);
		
	}
	
    /*
    |--------------------------------------------------------------------------
    | Portfolio Carousel
    |--------------------------------------------------------------------------
    */
    static function create_portfolio_carousel() { 
        				
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
        
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings', true );
		
		/* showcase options */
        $carousel_options = get_post_meta( self::$token , 'ut_carousel_options', true );
        		        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;		
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
						
        /* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		        
		/* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        );
                
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );
		        
        /* needed javascript */
		$carousel = self::generate_carousel_script( $carousel_options );        	
		
        /* needed css */
        $carousel .= self::create_custom_css();
        
		/* gallery style */
		$gallery_style      = !empty($carousel_options['style']) ? $carousel_options['style'] : 'style_one';
        $carousel_columns   = !empty($carousel_options['columns']) ? $carousel_options['columns'] : 4;
        
		$gallery_style_class = NULL;
		
		switch ( $gallery_style ) {
			
			case 'style_one':
				$gallery_style_class = 'portfolio-style-one';
			break;
				
			case 'style_two':
				$gallery_style_class = 'portfolio-style-two';
			break;

		}
		
		/* create hidden gallery */
		$carousel .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
        
        if( function_exists('ot_get_option') ) {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : ot_get_option('ut_global_portfolio_title_color','#FFF');
            
        } else {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : '#FFF';
            
        }
        
        /* create carousel */
        $carousel .= '<div id="carousel_' . self::$token . '" class="ut-portfolio-wrap ut-portfolio-' . self::$token . ' flexslider ut-carousel ' . $gallery_style_class . ' ut-carousel-' . $carousel_columns . '-col" data-textcolor="' . esc_attr( $textcolor ) . '" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
        $carousel .= '<ul class="slides">';
        				
            /* loop trough portfolio items */
            if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                                
                if ( has_post_thumbnail() && ! post_password_required() ) {		
    
                    $fullsize = $thumbnail = $portfolio_detail_image = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
                    $caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;					
                    
                    /* hero type setting - new with 2.6 */
                    $ut_page_hero_type = get_post_meta($portfolio_query->post->ID , 'ut_page_hero_type' , true);
                    
                    if( !empty($ut_page_hero_type) ) {
                        
                        if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                            $post_format = '';
                        }
                        
                        if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                            $post_format = 'gallery';
                        }
                        
                        if($ut_page_hero_type == 'video') {
                            $post_format = 'video';
                            $ut_page_video_source = get_post_meta($portfolio_query->post->ID, 'ut_page_video_source' , true);
                        }
                        
                        /* switch option key */
                        switch ($ut_page_hero_type) {
                        
                            case 'animatedimage':
                            $optionkey = 'ut_page_hero_animated_image';
                            break;
                            
                            default:  
                            $optionkey = 'ut_page_hero_image';  
                        
                        }                  
                    
                    } /* end ut_page_hero_type */
                    
                    /* check if there is a detail image available */
                    $portfolio_detail_image_data = get_post_meta( $portfolio_query->post->ID , $optionkey , true );                
                    
                    if( is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data['background-image']) ) {
                            
                        $portfolio_detail_image = $portfolio_detail_image_data['background-image'];
                        
                    } elseif( !is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data) ) {
                        
                        $portfolio_detail_image = $portfolio_detail_image_data;
                        
                    }                  
                                            
					/* cropping dimensions */
					$width  = !empty($carousel_options['crop_size_x']) ? $carousel_options['crop_size_x'] : '600';
					$height = !empty($carousel_options['crop_size_y']) ? $carousel_options['crop_size_y'] : '400';
					
					$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
                    
					/* link settings */
					$ut_portfolio_link_type = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true);
                    $external = FALSE;
                    $target = '_blank';
                    
                    /* theme meta boxes are storing strings */
                    if( !is_array($ut_portfolio_link_type) ) {
                        $temp_array = array();                    
                        $temp_array['target'] = $ut_portfolio_link_type;
                        $ut_portfolio_link_type = $temp_array;
                        $temp_array = null;
                    } 
                    
                    if( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'external' ) {
                       
                       /* get link user haas to set */ 
                       $external = get_post_meta( $portfolio_query->post->ID , 'ut_external_link' , true);
                        
                    } elseif( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'internal' || $ut_portfolio_link_type['target'] == 'global' && self::$detailstyle == 'internal' ) {
                       
                       /* get permalink to single portfolio */
                       $external = get_permalink( $portfolio_query->post->ID );
                       $target = '_self';
                       
                    }

                    $a_tag = false;                    
                    
					if( $gallery_style == 'style_one' ) {    
						                        
						$carousel  .= '<li class="ut-carousel-item ut-hover">';
							
							$title= str_ireplace('"', '', trim(get_the_title()));
							
								/* link markup for detail slideup */
								if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {
									
									/* has external link */
									if($external) {
									
										$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
									
										$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
									
									}

                                    $a_tag = true;
									
								}
								
								/* link markup for image popup */
								if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
									
									$popuplink = NULL;
                                    
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										
										/* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {
										    
                                            if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                                $carousel .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                            
                                            }
                                            
											$carousel  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
										
										}
										
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
                                        /* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {                                           
                                            
                                           /* get the content */
                                           if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                                
                                                /* youtube video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                                }
                                                
                                                /* selfhosted video - not supported by prettyphoto */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                    $popuplink = $fullsize;                                            
                                                }
                                                
                                                /* custom video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                                }                                            
                                                
                                                /* content is still empty - let's assign the regular content */
                                                if(empty($content)) {
                                                    $content = get_the_content();
                                                }
                                                
                                            } else {                                            
                                                $content = get_the_content();                                            
                                            }
                                            
                                            /* try to catch video url */
                                            $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                            
                                            if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                                $carousel .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                                
                                            }
                                            
                                            $carousel .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
                                            
                                        }
                                        
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
                                        /* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {
                                        
										    if( self::$lightbox == 'ut-lightgallery' ) {
                                                
                                                $carousel .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                                
                                            } else {
                                                
                                                $carousel .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                                    
                                            }
                                            
                                            $carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="' . $portfolio_detail_image . '">';									
									    
                                        }
                                        
									}								
									
								}
								
								$carousel .= '<figure>';
									$carousel .= '<img alt="' . get_the_title() . '" src="' . $thumbnail . '" />';
								$carousel .= '</figure>';
								
								$carousel .= '<div class="ut-hover-layer">';
									$carousel .= '<div class="ut-portfolio-info">';
									    $carousel .= '<div class="ut-portfolio-info-c">';                                        
                                        	
                                            /* Portfolio Slogan */										
                                            $carousel .= '<h3 class="portfolio-title">' . get_the_title() . '</h3>';
                                            
                                            $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                                            $carousel .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
                                            
										$carousel .= '</div>';
									$carousel .= '</div>';
								$carousel  .= '</div>';
								
							$carousel  .= '</a>';						
							
						$carousel  .= '</li>';
					
					}
					
					if( $gallery_style == 'style_two' ) {    
						
						$carousel  .= '<li class="ut-carousel-item ut-hover">';
							
							$title= str_ireplace('"', '', trim(get_the_title()));
							
								/* link markup for detail slideup */
								if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {
									
									/* has external link */
									if($external) {
									
										$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
									
										$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
									
									}

                                    $a_tag = true;
									
								}
								
								/* link markup for image popup */
								if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
									
									$popuplink = NULL;
									
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										
										/* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {										
										    
                                            if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                                $carousel .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                                
                                            }
                                            
											$carousel  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
											
										}
										
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
                                        /* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {
                                                                                        
                                            /* get the content */
                                           if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                                
                                                /* youtube video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                                }
                                                
                                                /* selfhosted video - not supported by prettyphoto */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                    $popuplink = $fullsize;                                            
                                                }
                                                
                                                /* custom video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                                }                                            
                                                
                                                /* content is still empty - let's assign the regular content */
                                                if(empty($content)) {
                                                    $content = get_the_content();
                                                }
                                                
                                            } else {                                            
                                                $content = get_the_content();                                            
                                            }
                                            
                                            /* try to catch video url */
                                            $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                            
                                            if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                                $carousel .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                                
                                            }
                                            
                                            $carousel  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'  .$popuplink . '">';
										
                                        }
                                        
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
                                        /* has external link */
										if($external) {
										
											$carousel .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
										} else {
                                            
                                            if( self::$lightbox == 'ut-lightgallery' ) { 
                                                
                                                $carousel .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                                
                                            } else {
                                            
                                                $carousel .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                            
                                            }
                                            
										    $carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="' . $portfolio_detail_image . '">';									
									    
                                        }
                                        
									}								
									
								}
								
								$carousel .= '<figure>';
									$carousel .= '<img alt="' . get_the_title() . '" src="' . $thumbnail . '" />';
								$carousel .= '</figure>';
								
								$carousel .= '<div class="ut-hover-layer">';
									$carousel .= '<div class="ut-portfolio-info">';
                                        $carousel .= '<div class="ut-portfolio-info-c">';
										
                                            if( $post_format == 'video' ) {
                                                $carousel .= '<i class="fa fa-film fa-lg"></i>';
                                            }
                                            
                                            if( $post_format == 'audio' ) {
                                                $carousel .= '<i class="fa fa-headphones fa-lg"></i>';
                                            }
        
                                            if(  $post_format == 'gallery' ) {
                                                $carousel .= '<i class="fa fa-camera-retro fa-lg"></i>';
                                            }
                                            
                                            if( empty($post_format) ) {
                                                $carousel .= '<i class="fa fa-picture-o fa-lg"></i>';
                                            }
                                            
                                            /* Portfolio Slogan */
                                            $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                                            $carousel .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
                                            
									    $carousel .= '</div>';	
									$carousel .= '</div>';
								$carousel  .= '</div>';
								
							$carousel  .= '</a>';
							
							$carousel .= '<div>';
                                    
                                    $a_tag = false;								    

									/* link markup for detail slideup */
									if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {

										$carousel  .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
                                        $a_tag = true;                                        

									}
									
									/* link markup for image popup */
									if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
										
										$popuplink = NULL;
										
										/* image post or audio post */
										if( empty( $post_format ) || $post_format == 'audio' ) {
											                                                                                        
                                            $carousel  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
                                            
										}
										
										/* video post */
										if( $post_format == 'video' ) {
											
                                            /* get the content */
                                            if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                                
                                                /* youtube video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                                }
                                                
                                                /* selfhosted video - not supported by prettyphoto */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                    $popuplink = $fullsize;                                            
                                                }
                                                
                                                /* custom video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                                }                                            
                                                
                                                /* content is still empty - let's assign the regular content */
                                                if(empty($content)) {
                                                    $content = get_the_content();
                                                }
                                                
                                            } else {
                                                $content = get_the_content();                                            
                                            }
                                            
                                            /* try to catch video url */
                                            $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                            $carousel  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
											
										}
										
										/* gallery post */
										if( $post_format == 'gallery' ) {
											
                                            if( self::$lightbox == 'ut-lightgallery' ) {
                                                
                                               $carousel .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                                
                                            } else {
                                               
                                               $carousel .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type ); 
                                               
                                            }
                                            
											$carousel .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="' . $portfolio_detail_image . '">';									
										
										}								
										
									}
								
									$carousel .= '<h3 class="portfolio-title">' . $title . '</h3>';
								
								$carousel  .= '</a>';
								
							$carousel .= '</div>';
							
						$carousel  .= '</li>';
					
					}
					
                }                     
                
            endwhile; endif;
				
        /* reset query */
        wp_reset_postdata();
	    
        /* end showcase navigation */
        $carousel .= '</ul>';
        $carousel .= '</div>';
                
        /* return final carousel */
        return $carousel;

    
    }
    
    static function generate_carousel_script( $carousel_options ) {
		
		/* settings */
		$container = self::$token;
        $columns   = !empty($carousel_options['columns']) ? $carousel_options['columns'] : 4;
        
        /* script */
        $script = "
		<script type='text/javascript'>
		/* <![CDATA[ */ 
        
			(function($){
			    
                function getGridSize() {
                    
                    var \$container = $('#carousel_$container');
                    
                    if( $(window).width() <= 767) {
						
                        columns = 1;
                        
					} else {
                        
						columns = $columns;
                        
					}
                    
                    return \$container.width() / columns;
                    
                }
                
				$(window).load(function(){
										                                                                
					$('#carousel_$container').flexslider({
                        animation: 'slide',
                        controlNav: false,
                        animationLoop: false,
                        slideshow: false,
                        itemWidth: getGridSize(),
                        itemMargin: 0,
						touch: true
                    });
					
				});
				
				$(window).utresize(function(){
				    	
					$('#carousel_$container').removeData('flexslider').flexslider({
                        animation: 'slide',
                        controlNav: false,
                        animationLoop: false,
                        slideshow: false,
                        itemWidth: getGridSize(),
                        itemMargin: 0,
						touch: true
                    });
											
				});
				
			})(jQuery);
		
		/* ]]> */ 
		</script>";
		/* end carousel script */ 
		
        /* return javascript */
		return ut_compress_java($script);
		
	}
    
    
    /*
    |--------------------------------------------------------------------------
    | Grid / Masonry Gallery
    |--------------------------------------------------------------------------
    */
	static function create_masonry_gallery() {
		
		global $paged;
		
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
		
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings' );
        $portfolio_settings = $portfolio_settings[0];
				
        /* masonry options */
        $masonry_options = get_post_meta( self::$token , 'ut_masonry_options' );
        $masonry_options = $masonry_options[0];
        
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
				
		/* portfolio query terms */
		$portfolio_terms = array();
		if( is_array($portfolio_categories[0])  && !empty($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
		}
		
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = new WP_Query( $portfolio_args );		
		
		/* needed javascript */
		$masonry  = self::generate_masonry_script( $masonry_options );
        
        /* needed css */
        $masonry .= self::create_custom_css();
        
		/* create hidden gallery */
		$masonry .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		
        if( function_exists('ot_get_option') ) {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : ot_get_option('ut_global_portfolio_title_color','#FFF');
            
        } else {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : '#FFF';
            
        }
        
        /* portfolio wrapper */		
		$masonry .= '<div id="ut_masonry_' . self::$token . '" class="ut-portfolio-wrap ut-portfolio-' . self::$token . '" data-textcolor="' . esc_attr( $textcolor ) .'" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
			
			/* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
				
				$fullsize = $thumbnail = $portfolio_detail_image = wp_get_attachment_url( get_post_thumbnail_id( $portfolio_query->post->ID ) );
				$caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
				
				/* image dimensions */
				$imageinfo = wp_get_attachment_image_src( get_post_thumbnail_id( $portfolio_query->post->ID ) , 'full' );
				$width  = $imageinfo[1];
				$height = $imageinfo[2];
				
                /* hero type setting - new with 2.6 */
                $ut_page_hero_type = get_post_meta($portfolio_query->post->ID , 'ut_page_hero_type' , true);
                
                $post_format = '';
                $optionkey   = 'ut_page_hero_image';
                
                if( !empty($ut_page_hero_type) ) {
                    
                    if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                        $post_format = '';
                    }
                    
                    if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                        $post_format = 'gallery';
                    }
                    
                    if($ut_page_hero_type == 'video') {
                        $post_format = 'video';
                        $ut_page_video_source = get_post_meta($portfolio_query->post->ID, 'ut_page_video_source' , true);  
                    }
                    
                    /* switch option key */
                    switch ( $ut_page_hero_type ) {
                    
                        case 'animatedimage':
                        $optionkey = 'ut_page_hero_animated_image';
                        break;
                        
                        default:  
                        $optionkey = 'ut_page_hero_image';  
                    
                    }                  
                
                } /* end ut_page_hero_type */
                
                                    			
                /* check if there is a detail image available */
                $portfolio_detail_image_data = get_post_meta( $portfolio_query->post->ID , $optionkey , true );                
                
                if( is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data['background-image']) ) {
                        
                    $portfolio_detail_image = $portfolio_detail_image_data['background-image'];
                    
                } elseif( !is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data) ) {
                    
                    $portfolio_detail_image = $portfolio_detail_image_data;
                    
                }               
                	
				/* cropping dimensions */
				$width  = !empty($masonry_options['crop_size_x']) ? $masonry_options['crop_size_x'] : '600';
				$height = !empty($masonry_options['crop_size_y']) ? $masonry_options['crop_size_y'] : '400';
				
				$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
				
				/* link settings */
                $ut_portfolio_link_type = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true);
                $external = FALSE;
                $target = '_blank';
                
                /* theme meta boxes are storing strings */
                if( !is_array($ut_portfolio_link_type) ) {
                    $temp_array = array();                    
                    $temp_array['target'] = $ut_portfolio_link_type;
                    $ut_portfolio_link_type = $temp_array;
                    $temp_array = null;
                } 
                
                if( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'external' ) {
                   
                   /* get link user haas to set */ 
                   $external = get_post_meta( $portfolio_query->post->ID , 'ut_external_link' , true);
                    
                } elseif( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'internal' || $ut_portfolio_link_type['target'] == 'global' && self::$detailstyle == 'internal' ) {
                   
                   /* get permalink to single portfolio */
                   $external = get_permalink( $portfolio_query->post->ID );
                   $target = '_self';
                   
                }
                
                $a_tag = false;
	
				/* create single content item */				
				$masonry .= '<div class="ut-masonry ut-hover">';
					
						$title= str_ireplace('"', '', trim(get_the_title()));
						
						/* link markup for detail slideup */
						if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {
							
							/* has external link */
							if($external) {
							
								$masonry .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
							
							} else {
								
								$masonry .= '<a class="ut-portfolio-link ' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#">';
							
							}
                            
                            $a_tag = true;							

							
						}
						
						/* link markup for image popup */
						if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
							
							$popuplink = NULL;
							
							/* image post or audio post */
							if( empty( $post_format ) || $post_format == 'audio' ) {
								
								/* has external link */
								if($external) {
								
									$masonry .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
								
								} else {
								    
                                    if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                        $masonry .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                    
                                    }
                                    
									$masonry  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
								
								}
																
							}
							
							/* video post */
							if( $post_format == 'video' ) {
								
                                /* has external link */
								if($external) {
								
									$masonry .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
								
								} else {
                                
                                    /* get the content */
                                    if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                        
                                        /* youtube video */
                                        if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                            $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                        }
                                        
                                        /* selfhosted video - not supported by prettyphoto */
                                        if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                            $popuplink = $fullsize;                                            
                                        }
                                        
                                        /* custom video */
                                        if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                            $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                        }                                            
                                        
                                        /* content is still empty - let's assign the regular content */
                                        if(empty($content)) {
                                            $content = get_the_content();
                                        }
                                        
                                    } else {                                            
                                        $content = get_the_content();                                            
                                    }
                                    
                                    /* try to catch video url */
                                    $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);                                    
                                    
                                    if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                        $masonry .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                    
                                    }
                                    
                                    $masonry  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
                                
                                }
								
							}
							
							/* gallery post */
							if( $post_format == 'gallery' ) {
								
                                /* has external link */
								if($external) {
								
									$masonry .= '<a class="' . $portfolio_settings['image_style'] . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
								
								} else {
                                    
                                    if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                        $masonry .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                        
                                    } else {
                                    
								        $masonry .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                    
                                    }
                                    
								    $masonry .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' '. $portfolio_settings['image_style'] . '" title="' . $title . '" href="' . $portfolio_detail_image . '">';									
                                
                                }
							
							}								
							
						}
					
						if ( has_post_thumbnail() && ! post_password_required() ) :		
							
							$masonry .= '<figure>';
								$masonry .= '<img alt="' . get_the_title() . '" width="'.$width.'" height="'.$height.'" src="' . UT_PORTFOLIO_URL . 'i/?w='.$width.'&amp;h='.$height.self::$cache.'" class="portfolio-lazy"  data-original="' . $thumbnail  . '" />';
							$masonry .= '</figure>';
							
						else :
							
							$masonry .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
										
						endif;
						
						$masonry .= '<div class="ut-hover-layer">';
							$masonry .= '<div class="ut-portfolio-info">';
                                $masonry .= '<div class="ut-portfolio-info-c">';
								
                                    /* Portfolio Title and Categories */
                                    $masonry .= '<h3 class="portfolio-title">' . get_the_title() . '</h3>';								
                                    
                                    /* get all portfolio-categories for this item */
                                    $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                                    $masonry .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
								
							    $masonry .= '</div>';	
							$masonry .= '</div>';
						$masonry .= '</div>';
				
					$masonry .= '</a>';				
				$masonry .= '</div>';
				
			endwhile; endif;
		
		$masonry .= '</div><!-- end ut_masonry_' . self::$token . '-->';
				
		/* reset query */
		wp_reset_postdata();
		
		return  $masonry;
		
	}
	
	static function generate_masonry_script( $masonry_options ) {
		
        /* settings */
		$container = self::$token;
		$columns = !empty($masonry_options['columns']) ? $masonry_options['columns'] : 5;
		$tcolumns = !empty($masonry_options['tcolumns']) ? $masonry_options['tcolumns'] : 3;
		$mcolumns = !empty($masonry_options['mcolumns']) ? $masonry_options['mcolumns'] : 2;
        $height = !empty($masonry_options['crop_size_y']) ? $masonry_options['crop_size_y'] : '400';
		
		$script = "
		
		<script type='text/javascript'>
		
		/* <![CDATA[ */ 
        
        	(function($){ 
				
				$(document).ready(function() {
				
                	$('#ut_masonry_$container').utmasonry({ columns : $columns , tcolumns: $tcolumns , mcolumns : $mcolumns , itemClass : 'ut-grid-item' , unitHeight : $height });
                    
				}); 
			
			})(jQuery);    
        
        /* ]]> */ 
		
		</script>";
		
		return ut_compress_java($script);
		
	}
    
    
    /*
    |--------------------------------------------------------------------------
    | Portfolio Filterable Gallery
    |--------------------------------------------------------------------------
    */
    static function create_portfolio_gallery() {
		
		global $paged , $wp_query;

        /* pagination */		
        if  ( empty($paged) ) {
                
                if ( !empty( $_GET['paged'] ) ) {
                        $paged = $_GET['paged'];
                } elseif ( !empty($wp->matched_query) && $args = wp_parse_args($wp->matched_query) ) {
                        if ( !empty( $args['paged'] ) ) {
                                $paged = $args['paged'];
                        }
                }
                if ( !empty($paged) ) {
                    $wp_query->set('paged', $paged);
                }
                
        }           
                
		$temp = $wp_query;
        $wp_query = $term = null;
		
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
		$term = '';
		
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings', true );
				
        /* gallery options */
        $gallery_options = get_post_meta( self::$token , 'ut_gallery_options', true );
        		
		/* columnset */
		$columnset = !empty($gallery_options['columns']) ? $gallery_options['columns'] : 4;
		$gutter = !empty( $gallery_options['gutter'] ) ? 'gutter' : '';
        $gutter_shadow = !empty( $gallery_options['gutter_shadow'] ) ? 'gutter-shadow' : '';
        
        $gutter_size = !empty( $gallery_options['gutter_size'] ) & $gutter == 'gutter' ? 'gutter-' . $gallery_options['gutter_size'] : '1';
		
		/* image style */
		$image_style_class = $portfolio_settings['image_style'];
		
		/* variables for last row item */
		switch ($columnset) {
			case 2:
				$z = 0;
				$counter = 1;
				break;
			case 3:
				$z = 4;
				$counter = 2;
				break;
			case 4:
				$z = 5;
				$counter = 3;
				break;
		}
		
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
		
		/* portfolio query terms */
		$portfolio_terms = array();
        $portfolio_terms_query = '';
        
		if( !empty( $portfolio_categories[0] ) && is_array($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
			$portfolio_terms_query = $portfolio_terms;
			
		}
		
		
		/* only change term if browser is browsing this portfolio */
		if( ( !empty( $_GET['portfolioID'] ) && $_GET['portfolioID'] == self::$token ) ) :
		
			if( $gallery_options['filter_type'] == 'static' && !empty($_GET['termID']) ) {
				
				/* sanitize term */
				$term = absint( $_GET['termID'] );
				
				/* reset terms */
				$portfolio_terms_query = array();
				array_push($portfolio_terms_query , $term);
			
			}
			
		endif;
		
		
		/* user is not browsing this portfolio , so we reset the pagination */
		if( ( !empty( $_GET['portfolioID'] ) && $_GET['portfolioID'] != self::$token ) ) :
			
			$paged = 0;
		
		endif;
		
				
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms_query,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = $wp_query = new WP_Query( $portfolio_args );
        
        /* portfolio filter */                
        if( !empty($gallery_options['filter']) ) :
        		
        $filter  = '<div class="ut-portfolio-menu-wrap" ' . ( !empty( $gallery_options['filter_align'] ) ? 'style="text-align:' . $gallery_options['filter_align'] .';"' : '' ) . '><ul id="ut-portfolio-menu-' . self::$token . '" class="ut-portfolio-menu ' . ( !empty( $gallery_options['filter_style'] ) ? $gallery_options['filter_style'] : 'style_one' ) . '">';
            
            /* reset button */
			$reset = !empty($gallery_options['reset_text']) ? $gallery_options['reset_text'] : __('All' , 'ut_portfolio_lang');
			
            if( $gallery_options['filter_type'] == 'static' ) {
				
				$selected = (empty($term)) ? 'class="selected"' : '';
				$filter .= '<li><a href="?portfolioID='.self::$token.'#ut-portfolio-items-' . self::$token . '-anchor" data-filter="*" ' . $selected . '>' . $reset . '</a></li>';
			
			} else {
			
				$filter .= '<li><a href="#" data-filter="*" class="selected">' . $reset . '</a></li>';
				
			}
            
            /* get taxonomies */
            $taxonomies = get_terms('portfolio-category');
			$taxonomiesarray =  json_decode(json_encode($taxonomies), true);
					    
            if( is_array($portfolio_terms) && is_array($taxonomies) ) {
                
                foreach ($portfolio_terms as $single_term ) {
										
                    $key = self::search_tax_key( $single_term , $taxonomiesarray );
										                    
					if( $gallery_options['filter_type'] == 'static' && isset($key) ) {
						
						$selected = ( $taxonomies[$key]->term_id == $term ) ? 'class="selected"' : '';
						
						$filter .= '<li><a ' . $selected . ' href="?termID=' . $taxonomies[$key]->term_id . '&amp;portfolioID='.self::$token.'#ut-portfolio-items-' . self::$token . '-anchor" data-filter=".'.$taxonomies[$key]->slug.'-filt">'.$taxonomies[$key]->name.'</a></li>';
						
					} else {
						
                        if( isset($taxonomies[$key]->slug) ) {
						    $filter .= '<li><a href="#" data-filter=".'.$taxonomies[$key]->slug.'-filt">'.$taxonomies[$key]->name.'</a></li>';
                        }
                        
					}
					
					
                }
            
			}      
        
        $filter .= '</ul></div>';
        
        endif;
        
        /* needed javascript */
		$gallery = self::generate_gallery_script( $gallery_options , $counter );
        
        /* needed css */
        $gallery .= self::create_custom_css( $gallery_options );
        
		/* create hidden gallery */
		$gallery .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		
        if( function_exists('ot_get_option') ) {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : ot_get_option('ut_global_portfolio_title_color','#FFF');
            
        } else {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : '#FFF';
            
        }
        
        /* output portfolio wrap */
        $gallery .= '<div id="ut-portfolio-wrap" class="ut-portfolio-wrap ut-portfolio-' . self::$token . '" data-textcolor="' . esc_attr( $textcolor ) .'" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
		$gallery .= '<a class="ut-portfolio-offset-anchor" style="top:-120px;" id="ut-portfolio-items-' . self::$token . '-anchor"></a>';
		
        /* add filter */
        if( isset($gallery_options['filter']) ) {
            $gallery .= $filter;
        }
        
        /* output portfolio container */
        $gallery .= '<div id="ut-portfolio-items-' . self::$token . '" class="ut-portfolio-item-container">';
        	
            /* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                				
                /* needed variables */
                $projecttype = '';
                $title = str_ireplace('"', '', trim(get_the_title()));
                $post_format = get_post_format();
				
                /* link settings */
                $ut_portfolio_link_type = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true);
                $external = false;
                $target = '_blank';
                
                /* theme meta boxes are storing strings */
                if( !is_array($ut_portfolio_link_type) ) {
                    $temp_array = array();                    
                    $temp_array['target'] = $ut_portfolio_link_type;
                    $ut_portfolio_link_type = $temp_array;
                    $temp_array = null;
                }     
                
                if( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'external' ) {
                   
                   /* get link user haas to set */ 
                   $external = get_post_meta( $portfolio_query->post->ID , 'ut_external_link' , true);
                    
                } elseif( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'internal' || $ut_portfolio_link_type['target'] == 'global' && self::$detailstyle == 'internal' ) {
                   
                   /* get permalink to single portfolio */
                   $external = get_permalink( $portfolio_query->post->ID );
                   $target = '_self';
                   
                }
                
				/* itemposition */
				$itemposition = '';
				if($columnset !=3) { 
					if($columnset == 2) { (($z%2)==0) ? $itemposition = '' : $itemposition = 'last'; }
					if($columnset == 4) { (($z%4)==0) ? $itemposition = 'last' : $itemposition = ''; }
				} else { 
					if(($z%3) == 0) { $itemposition = 'last'; $z = 3; } 
				} 
				
                /* get all portfolio-categories for this item ( needed for filter ) */
                $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                
                /* set filter attributes */               
                if( is_array($portfolio_cats) ) {
                    foreach($portfolio_cats as $single_cat) {
                        $projecttype .=  $single_cat->slug."-filt ";
                    }
                }
                
				/* gallery style */
				$gallery_style = !empty($gallery_options['style']) ? $gallery_options['style'] : 'style_one';
				
				/* portfolio featured image */
				$fullsize = $thumbnail = $portfolio_detail_image = wp_get_attachment_url( get_post_thumbnail_id($portfolio_query->post->ID) );
				$caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
				
                /* hero type setting - new with 2.6 */
                $ut_page_hero_type = get_post_meta($portfolio_query->post->ID , 'ut_page_hero_type' , true);
                $optionkey = 'ut_page_hero_image';
                
                if( !empty($ut_page_hero_type) ) {
                    
                    if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                        $post_format = '';
                    }
                    
                    if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                        $post_format = 'gallery';
                    }
                    
                    if($ut_page_hero_type == 'video') {
                        $post_format = 'video';
                        $ut_page_video_source = get_post_meta($portfolio_query->post->ID, 'ut_page_video_source' , true);
                    }
                    
                    /* switch option key */
                    switch ($ut_page_hero_type) {
                    
                        case 'animatedimage':
                        $optionkey = 'ut_page_hero_animated_image';
                        break;
                        
                        default:  
                        $optionkey = 'ut_page_hero_image';  
                    
                    }                  
                
                } /* end ut_page_hero_type */
                
                                
                /* check if there is a detail image available */
                $portfolio_detail_image_data = get_post_meta( $portfolio_query->post->ID , $optionkey , true );                
                
                if( is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data['background-image']) ) {
                        
                    $portfolio_detail_image = $portfolio_detail_image_data['background-image'];
                    
                } elseif( !is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data) ) {
                    
                    $portfolio_detail_image = $portfolio_detail_image_data;
                    
                }
                					
				/* cropping dimensions */
				$width  = !empty($gallery_options['crop_size_x']) ? $gallery_options['crop_size_x'] : '600';
				$height = !empty($gallery_options['crop_size_y']) ? $gallery_options['crop_size_y'] : '400';
				
				$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
				$a_tag = false;
                
				/* style one images with title */
				if( $gallery_style == 'style_one') {
				    
					/* create single portfolio item */
					$gallery .= '<article class="' . $projecttype . ' ' . $itemposition . ' ut-masonry ' . $gutter . ' ' . $gutter_size . ' portfolio-style-one">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover">';
												
							/* link markup for slideup details */
							if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {							
								
								/* has external link */
								if( !empty( $external ) ) {
								    
									$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="'.$target.'">';
								
								} else {
								
									$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
								
								}
                                
                                $a_tag = true;
                                
								
							}
							
							/* link markup for image popup */
							if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
								
								$popuplink = NULL;
																
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {

									/* has external link */ 
									if( !empty( $external ) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="' . $target . '">';
										
									} else {
										
                                        if( self::$lightbox == 'ut-lightgallery' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                                                                
										$gallery .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
										
									}
									
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="' . $target . '">';
										
									} else {                                    
                                    
                                       /* get the content */
                                       if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                            
                                            /* youtube video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                            }
                                            
                                            /* selfhosted video - not supported by prettyphoto */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                $popuplink = $fullsize;                                            
                                            }
                                            
                                            /* custom video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                            }                                            
                                            
                                            /* content is still empty - let's assign the regular content */
                                            if(empty($content)) {
                                                $content = get_the_content();
                                            }
                                            
                                        } else {                                            
                                            $content = get_the_content();                                            
                                        }
                                        
                                        /* try to catch video url */
                                        $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
                                        $gallery .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
                                        
                                    }
                                    
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
									} else {
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
									        $gallery .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                        
                                        } else {
                                            
                                            $gallery .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                            
                                        }
                                        
									    $gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' ' . $image_style_class . ' ' . $gutter_shadow . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';									
								    
                                    }
                                    
								}								
								
							}							
							
							if ( has_post_thumbnail() && ! post_password_required() ) :		
						
								$gallery .= '<figure><img alt="' . get_the_title() . '" width="'.$width.'" height="'.$height.'" src="' . UT_PORTFOLIO_URL . 'i/?w='.$width.'&amp;h='.$height.self::$cache.'" class="portfolio-lazy"  data-original="' . $thumbnail . '" /></figure>';
																
							elseif( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
								
								$gallery .= '<div class="ut-hover-layer">';
									$gallery .= '<div class="ut-portfolio-info">';
                                        $gallery .= '<div class="ut-portfolio-info-c">';
							
                                            /* item title */
                                            $gallery .= '<h3 class="portfolio-title">' . $title . '</h3>';								
                                            $gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
									    
                                        $gallery .= '</div>';
									$gallery .= '</div>';
								$gallery .= '</div>';								
							
							$gallery .= '</a>';
															
						$gallery .= '</div>';
					
					$gallery .= '</article>';		

				}
				
				
				/* style two only images and title beneath */
				if( $gallery_style == 'style_two') {					
					
					/* create single portfolio item */
					$gallery .= '<article class="' . $projecttype . ' ' . $itemposition . ' ut-masonry ' . $gutter . ' ' . $gutter_size . ' ' . $gutter_shadow . ' portfolio-style-two">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover">';
							
							/* link markup for slideup details */
							if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {							
								
								/* has external link */
								if($external) {
								
									$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
								
								} else {
								
									$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
								
								}
								
							}
							
							/* link markup for image popup */
							if( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) {
								
								$popuplink = NULL;
								
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {

									/* has external link */
									if($external) {
									
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
									    
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
										$gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
									
									}
									
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
									} else {
                                    
                                       /* get the content */
                                       if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                            
                                            /* youtube video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                            }
                                            
                                            /* selfhosted video - not supported by prettyphoto */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                $popuplink = $fullsize;                                            
                                            }
                                            
                                            /* custom video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                            }                                            
                                            
                                            /* content is still empty - let's assign the regular content */
                                            if(empty($content)) {
                                                $content = get_the_content();
                                            }
                                            
                                        } else {                                            
                                            $content = get_the_content();                                            
                                        }
                                        
                                        /* try to catch video url */
                                        $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
                                        $gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
									
                                    }
                                    
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
                                    /* has external link */
									if($external) {
									
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                            
                                            $gallery .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                            
                                        } else {
                                            
                                            $gallery .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                        
                                        }
									    
									    $gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' ' . $image_style_class . ' ' . $gutter_shadow . '" title="' . $title . '" href="#">';									
								    
                                    }
                                    
								}								
								
							}
							
							if ( has_post_thumbnail() && ! post_password_required() ) :		
						
								$gallery .= '<figure><img alt="' . get_the_title() . '" width="'.$width.'" height="'.$height.'" src="' . UT_PORTFOLIO_URL . 'i/?w='.$width.'&amp;h='.$height.self::$cache.'" class="portfolio-lazy"  data-original="' . $thumbnail . '" /></figure>';
																
							elseif( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
							
								$gallery .= '<div class="ut-hover-layer">';
									$gallery .= '<div class="ut-portfolio-info">';
                                        $gallery .= '<div class="ut-portfolio-info-c">';
							
                                            if( $post_format == 'video' ) {
                                                $gallery .= '<i class="fa fa-film fa-lg"></i>';
                                            }
                                            
                                            if( $post_format == 'audio' ) {
                                                $gallery .= '<i class="fa fa-headphones fa-lg"></i>';
                                            }
        
                                            if(  $post_format == 'gallery' ) {
                                                $gallery .= '<i class="fa fa-camera-retro fa-lg"></i>';
                                            }
                                            
                                            if( empty($post_format) ) {
                                                $gallery .= '<i class="fa fa-picture-o fa-lg"></i>';
                                            }									
                                        
                                            $gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
									
                                        $gallery .= '</div>';
									$gallery .= '</div>';
								$gallery .= '</div>';
							
							$gallery .= '</a>';
								
							$gallery .= '<div>';
								
                                $a_tag = false;
                    								
								/* link markup for slideup details */
								if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {							
									
                                    $gallery .= '<a class="ut-portfolio-link ' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
                                    $a_tag = true;                                    

								}
								
								/* link markup for image popup */
								if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
									
									$popuplink = NULL;
									
									/* image post or audio post */
									if( empty( $post_format ) || $post_format == 'audio' ) {
										
                                        /* has external link */
                                        if( $external ) {
                                        
                                            $gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $caption . '" href="'.$external.'" target="'.$target.'">';
                                        
                                        } else {
                                            
                                            $gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
                                        
                                        }
                                        
									}
									
									/* video post */
									if( $post_format == 'video' ) {
										
                                        /* has external link */
                                        if($external) {
                                            
                                            $gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $caption . '" href="'.$external.'" target="'.$target.'">';
                                            
                                        } else {
                                        
                                            /* get the content */
                                            if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                                
                                                /* youtube video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                                }
                                                
                                                /* selfhosted video - not supported by prettyphoto */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                    $popuplink = $fullsize;                                            
                                                }
                                                
                                                /* custom video */
                                                if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                    $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                                }                                            
                                                
                                                /* content is still empty - let's assign the regular content */
                                                if(empty($content)) {
                                                    $content = get_the_content();
                                                }
                                                
                                            } else {                                            
                                                $content = get_the_content();                                            
                                            }
                                            
                                            /* try to catch video url */
                                            $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                            $gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $portfolio_settings['image_style'] . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" href="'.$popuplink.'">';
									    
                                        }
                                        	
									}
									
									/* gallery post */
									if( $post_format == 'gallery' ) {
										
                                        /* has external link */
                                        if($external) {
                                            
                                            $gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $caption . '" href="'.$external.'" target="'.$target.'">';
                                        
                                        } else {
                                        
										    $gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' ' . $portfolio_settings['image_style'] . '" title="' . $title . '" href="#">';
                                            
                                        }
									
									}								
									
								}	
								
								/* item title */
								$gallery .= '<h3 class="portfolio-title">' . $title . '</h3>';
								$gallery .= '</a>';
								
								
							$gallery .= '</div>';
											
						$gallery .= '</div>';
					
					$gallery .= '</article>';  
				
				}
            
            $z++; endwhile; endif;
            
        /* end portfolio container */
        $gallery .= '</div>';
		
		/* portfolio pagination */
		if( $portfolio_query->max_num_pages > 1 ){
									
			$gallery .= '<nav class="ut-portfolio-pagination clearfix '.(!empty($gallery_options['filter_style']) ? $gallery_options['filter_style'] : 'style_one').'">';
			
			if ( $paged > 1 ) { 
        		$gallery .= '<a href="?paged=' . ($paged -1) .'&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-left"></i></a>';
			}
			
			for( $i=1 ;$i<=$portfolio_query->max_num_pages; $i++ ){
				
				$selected = ($paged == $i || ( empty($paged) && $i == 1 ) ) ? 'selected' : '';
				$gallery .= '<a href="?paged=' . $i . '&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor" class="' . $selected . '">' . $i . '</a>';

            }
			
			if($paged < $portfolio_query->max_num_pages){
                $paged_next = $paged == 0 ? $paged + 1 : $paged;
                $gallery .= '<a href="?paged=' . ($paged_next + 1) . '&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-right"></i></a>';
            } 
			
			$gallery .= '</nav>';
		
		}

				
        /* end portfolio wrap */
        $gallery .= '</div>';
        
		/* restore wp_query */
		$wp_query = null; $wp_query = $temp;
		
        /* reset query */
		wp_reset_postdata();
        
        /* return final gallery */
        return $gallery;

    
    }
        
    static function generate_gallery_script( $gallery_options , $counter = 3 ) {
        
		$gutter      = !empty( $gallery_options['gutter'] )      ? 'on' : '';
        $gutter_size = !empty( $gallery_options['gutter_size'] ) ? $gallery_options['gutter_size'] : '1';
				        
        $script = '
        <script type="text/javascript">
        /* <![CDATA[ */
        (function($) {
			    
            $(document).ready(function($){
 
                "use strict";
                
                var $win = $(window),
                    $container = $("#ut-portfolio-items-' . self::$token . '"),
					columns = ' . $gallery_options['columns'] . ',
					gutter = "' . $gutter . '",
					gutterwidth = "",
                    guttersize = "' . $gutter_size . '",
					$sortedItems = "";                
				
				function ut_call_isotope( update ) {
					
					if( $(window).width() > 1024) {
						columns = ' . $gallery_options['columns'] . ';
                        guttersize = "' . $gutter_size . '";
					} 
					
					if( $(window).width() <= 1024) {
						columns = 3;
                        guttersize = "' . $gutter_size . '";
					} 
					
					if( $(window).width() <= 767) {
						columns = 1;
                        guttersize = 1.5;
					} 				
					
                    if( $(window).width() <= 400 ) {
                        guttersize = 1;
                    }
                    					
					if( gutter === "on" ) {
						
                        $container.children().width( Math.floor($container.width() / columns - ( ( 20 * guttersize )  * ( columns - 1 ) / columns ))).addClass("show");
						gutterwidth = 20 * guttersize;
                        
					} else {
						
                        $container.children().width( Math.floor($container.width() / columns )).addClass("show");
						gutterwidth = 0;
                        
					}
															
					/* IsoTope
					================================================== */                                    
					$container.isotope({
					  
					  	itemSelector : ".ut-masonry",
					  	animationEngine : "best-available",
					  	resizable: false,
					  	layoutMode: "fitRows",
					  	masonry: { columnWidth: $container.width() / columns - gutterwidth },
						itemPositionDataEnabled: true,
						onLayout: function (elems, instance) {
														
                            // trigger scroll for lazy load
                            $win.trigger("scroll");
                            
							$container.addClass("animated");
							elems.addClass("animated");
							
						}
						
					}).isotope("layout"); 				
				
				}
				
				
				function ut_update_isotope_grid() {
					
					if( $sortedItems ) {
					
						$container.find(".last").removeClass("last");
						var i = columns - 1;		  
						
						$.each($sortedItems, function(key, value) {
							if($(this).hasClass("isotope-hidden")) {
								i++;
							}
							if(((key-i)/ columns)==0) {
								$(this).addClass("last");
								i = columns+i;
							}
						});
						
                        $container.on( "arrangeComplete",function(){
                           $.waypoints("refresh");
                        });
                        
					}
					
				}
				
				$(window).utresize(function(){
												
					/* update isotope */
					ut_call_isotope();
					
					/* update isotope grid */
					ut_update_isotope_grid();
							
				}); 
				
                $(window).load(function() {
            		
					/* create isotope */
					ut_call_isotope();
					
					/* store sorted items */
					$sortedItems = $container.data("isotope").$filteredAtoms;
					
					/* update isotope grid */
					ut_update_isotope_grid();';
									
					
				/* additonal call for ajax filter */
				if( $gallery_options['filter_type'] == 'ajax' ) :
				
				$script .= '
				
                    /* IsoTope Filtering
                    ================================================== */               
                    $("#ut-portfolio-menu-' . self::$token . ' a").each(function( index ) {
                            
                            var searchforclass = $(this).attr("data-filter");
                            if( !$(searchforclass).length  ) {
                                // hide filter if we do not have any children to filter
                                $(this).hide();
                            }
                            
                    });				
                    
                    $("#ut-portfolio-menu-' . self::$token . ' a").click(function(){
                      
                        var selector = $(this).attr("data-filter");
                        $container.isotope({ filter: selector });
                        
						/* update isotope grid */
                        ut_update_isotope_grid();
                      
                        if ( !$(this).hasClass("selected") ) {
                            $(this).parents("#ut-portfolio-menu-' . self::$token . '").find(".selected").removeClass("selected");
                            $(this).addClass("selected");
                        }          
                      	                        
                        return false;
                      
                    }); ';
				
				endif;
				       
            $script .= ' });  
        
            });
			
        }(jQuery));
		    
        /* ]]> */
        </script>        
        ';
        
        return ut_compress_java($script);
    
    }
    
    /*
    |--------------------------------------------------------------------------
    | Portfolio Filterable Packery Gallery
    |--------------------------------------------------------------------------
    */
    static function create_portfolio_packery_gallery() {
		
		global $paged , $wp_query;

        /* pagination */		
        if  ( empty($paged) ) {
                
                if ( !empty( $_GET['paged'] ) ) {
                        $paged = $_GET['paged'];
                } elseif ( !empty($wp->matched_query) && $args = wp_parse_args($wp->matched_query) ) {
                        if ( !empty( $args['paged'] ) ) {
                                $paged = $args['paged'];
                        }
                }
                if ( !empty($paged) ) {
                    $wp_query->set('paged', $paged);
                }
                
        }           
                
		$temp = $wp_query;
        $wp_query = $term = null;
		
		/* settings */
		$portfolio_categories = get_post_meta( self::$token , 'ut_portfolio_categories' );
		$term = '';
		
		/* global portfolio settings */
        $portfolio_settings = get_post_meta( self::$token , 'ut_portfolio_settings', true );
				
        /* gallery options */
        $gallery_options = get_post_meta( self::$token , 'ut_packery_options', true );
        
		/* columnset */
		$columnset = !empty($gallery_options['columns']) ? $gallery_options['columns'] : 4;
		$gutter = !empty( $gallery_options['gutter'] ) ? 'gutter' : '';
        $gutter_size = !empty( $gallery_options['gutter_size'] ) & $gutter == 'gutter' ? 'gutter-' . $gallery_options['gutter_size'] : '1';
        $gutter_shadow = !empty( $gallery_options['gutter_shadow'] ) ? 'gutter-shadow' : '';
        $gutter_class = !empty( $gutter ) ? 'has-gutter guttersize-' . $gutter_size : '' ;

		/* image style */
		$image_style_class = $portfolio_settings['image_style'];
		
		/* variables for last row item */
		switch ($columnset) {
			case 2:
				$z = 0;
				$counter = 1;
				break;
			case 3:
				$z = 4;
				$counter = 2;
				break;
			case 4:
				$z = 5;
				$counter = 3;
				break;
		}
		
		/* fallback if no meta has been set */
		$portfolio_per_page   = !empty($portfolio_settings['posts_per_page']) ? $portfolio_settings['posts_per_page'] : 4 ;
		$portfolio_categories = !empty($portfolio_categories) ? $portfolio_categories : array();
		
		/* portfolio query terms */
		$portfolio_terms = array();
		$portfolio_terms_query = '';
        
        if( !empty($portfolio_categories[0]) && is_array($portfolio_categories[0]) ) {

			foreach( $portfolio_categories[0] as $key => $value) {                
                array_push($portfolio_terms , $key);
			}
			
			$portfolio_terms_query = $portfolio_terms;
			
		}
				
        /* query args */
        $portfolio_args = array(
            
            'post_type'      => 'portfolio',
            'posts_per_page' => $portfolio_per_page,
            'paged'          => $paged,
            'tax_query'      => array( array(
                    'taxonomy' => 'portfolio-category',
                    'terms'    => $portfolio_terms_query,
                    'field'    => 'term_id'  
            ) )
            
        
        );
        
        /* start query */
        $portfolio_query = $wp_query = new WP_Query( $portfolio_args );
        
        /* portfolio filter */                
        if( !empty($gallery_options['filter']) ) :
        		
        $filter  = '<div class="ut-portfolio-menu-wrap" ' . ( !empty( $gallery_options['filter_align'] ) ? 'style="text-align:' . $gallery_options['filter_align'] .';"' : '' ) . '><ul id="ut-portfolio-menu-' . self::$token . '" class="ut-portfolio-menu ' . ( !empty( $gallery_options['filter_style'] ) ? $gallery_options['filter_style'] : 'style_one' ) . '">';
            
            /* reset button */
			$reset = !empty($gallery_options['reset_text']) ? $gallery_options['reset_text'] : __('All' , 'ut_portfolio_lang');
			
            $filter .= '<li><a href="#" data-filter="*" class="selected">' . $reset . '</a></li>';				
            
            /* get taxonomies */
            $taxonomies = get_terms('portfolio-category');
			$taxonomiesarray =  json_decode(json_encode($taxonomies), true);
					    
            if( is_array($portfolio_terms) && is_array($taxonomies) ) {
                
                foreach ($portfolio_terms as $single_term ) {
										
                    $key = self::search_tax_key( $single_term , $taxonomiesarray );
										                    
                    if( isset($taxonomies[$key]->slug) ) {
                        $filter .= '<li><a href="#" data-filter=".'.$taxonomies[$key]->slug.'-filt">'.$taxonomies[$key]->name.'</a></li>';
                    }
                        
					
					
                }
            
			}      
        
        $filter .= '</ul></div>';
        
        endif;
        
        /* needed javascript */
		$gallery = self::generate_gallery_packery_script( $gallery_options , $counter );
        
        /* needed css */
        $gallery .= self::create_custom_css( $gallery_options );
        
        /* need responsive css */
        $gallery .= self::create_responsive_css( $gallery_options );
        
		/* create hidden gallery */
		$gallery .= self::create_hidden_popup_portfolio( $portfolio_args , $portfolio_settings['image_style'] );
		
        if( function_exists('ot_get_option') ) {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : ot_get_option('ut_global_portfolio_title_color','#FFF');
            
        } else {
            
            $textcolor = !empty( $portfolio_settings["text_color"] ) ? $portfolio_settings["text_color"] : '#FFF';
            
        }
        
        /* output portfolio wrap */
        $gallery .= '<div id="ut-portfolio-wrap" class="ut-portfolio-wrap ut-portfolio-packery-wrap ut-portfolio-' . self::$token . '" data-textcolor="' . esc_attr( $textcolor ) .'" data-opacity="' . $portfolio_settings["hover_opacity"] . '" data-hovercolor="' . ut_hex_to_rgb($portfolio_settings["hover_color"]) . '">';
		$gallery .= '<a class="ut-portfolio-offset-anchor" style="top:-120px;" id="ut-portfolio-items-' . self::$token . '-anchor"></a>';
		
        /* add filter */
        if( isset($gallery_options['filter']) ) {
            $gallery .= $filter;
        }
        
        /* output portfolio container */
        $gallery .= '<div id="ut-portfolio-items-' . self::$token . '" class="ut-portfolio-item-packery-container ' . $gutter_class . ' ut-portfolio-item-container-'. $columnset .'-columns">';
        	
            /* loop trough portfolio items */
			if ($portfolio_query->have_posts()) : while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                				
                /* needed variables */
                $projecttype = '';
                $title = str_ireplace('"', '', trim(get_the_title()));
                $post_format = get_post_format();
				
                /* link settings */
                $ut_portfolio_link_type = get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true);
                $external = false;
                $target = '_blank';
                
                /* theme meta boxes are storing strings */
                if( !is_array($ut_portfolio_link_type) ) {
                    $temp_array = array();                    
                    $temp_array['target'] = $ut_portfolio_link_type;
                    $ut_portfolio_link_type = $temp_array;
                    $temp_array = null;
                }     
                
                if( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'external' ) {
                   
                   /* get link user haas to set */ 
                   $external = get_post_meta( $portfolio_query->post->ID , 'ut_external_link' , true);
                    
                } elseif( !empty($ut_portfolio_link_type['target']) && $ut_portfolio_link_type['target'] == 'internal' || $ut_portfolio_link_type['target'] == 'global' && self::$detailstyle == 'internal' ) {
                   
                   /* get permalink to single portfolio */
                   $external = get_permalink( $portfolio_query->post->ID );
                   $target = '_self';
                   
                }
                
				/* itemposition */
				$itemposition = '';
				if($columnset !=3) { 
					if($columnset == 2) { (($z%2)==0) ? $itemposition = '' : $itemposition = 'last'; }
					if($columnset == 4) { (($z%4)==0) ? $itemposition = 'last' : $itemposition = ''; }
				} else { 
					if(($z%3) == 0) { $itemposition = 'last'; $z = 3; } 
				} 
				
                /* get all portfolio-categories for this item ( needed for filter ) */
                $portfolio_cats = wp_get_object_terms( $portfolio_query->post->ID , 'portfolio-category' );
                
                /* set filter attributes */               
                if( is_array($portfolio_cats) ) {
                    foreach($portfolio_cats as $single_cat) {
                        $projecttype .=  $single_cat->slug."-filt ";
                    }
                }
                
				/* gallery style */
				$gallery_style = !empty($gallery_options['style']) ? $gallery_options['style'] : 'style_one';
				
				/* portfolio featured image */
				$fullsize = $thumbnail = $portfolio_detail_image = wp_get_attachment_url( get_post_thumbnail_id($portfolio_query->post->ID) );
				$caption = get_post( get_post_thumbnail_id( $portfolio_query->post->ID ) )->post_excerpt;
				
                /* hero type setting - new with 2.6 */
                $ut_page_hero_type = get_post_meta($portfolio_query->post->ID , 'ut_page_hero_type' , true);
                $optionkey = 'ut_page_hero_image';
                
                if( !empty($ut_page_hero_type) ) {
                    
                    if($ut_page_hero_type == 'image' || $ut_page_hero_type == 'animatedimage' || $ut_page_hero_type == 'splithero' || $ut_page_hero_type == 'custom' || $ut_page_hero_type == 'dynamic') {
                        $post_format = '';
                    }
                    
                    if($ut_page_hero_type == 'slider' || $ut_page_hero_type == 'transition' || $ut_page_hero_type == 'tabs') {
                        $post_format = 'gallery';
                    }
                    
                    if($ut_page_hero_type == 'video') {
                        $post_format = 'video';
                        $ut_page_video_source = get_post_meta($portfolio_query->post->ID, 'ut_page_video_source' , true);
                    }
                    
                    /* switch option key */
                    switch ($ut_page_hero_type) {
                    
                        case 'animatedimage':
                        $optionkey = 'ut_page_hero_animated_image';
                        break;
                        
                        default:  
                        $optionkey = 'ut_page_hero_image';  
                    
                    }                  
                
                } /* end ut_page_hero_type */
                
                                
                /* check if there is a detail image available */
                $portfolio_detail_image_data = get_post_meta( $portfolio_query->post->ID , $optionkey , true );                
                
                if( is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data['background-image']) ) {
                        
                    $portfolio_detail_image = $portfolio_detail_image_data['background-image'];
                    
                } elseif( !is_array($portfolio_detail_image_data) && !empty($portfolio_detail_image_data) ) {
                    
                    $portfolio_detail_image = $portfolio_detail_image_data;
                    
                }
                					
				/* cropping dimensions */
				$width  = !empty($gallery_options['crop_size_x']) ? $gallery_options['crop_size_x'] : '800';
				$height = !empty($gallery_options['crop_size_y']) ? $gallery_options['crop_size_y'] : '800';
				
                /* mobile image */
                $mobile_image = array();
                $mobile_image['src']    = ut_resize( $fullsize , $width , $height , true , true , true );
                $mobile_image['height'] = $height;
                $mobile_image['width']  = $width;
                
                /* default size */                
                $size = 'default';
                
                /* portrait size */
                if( get_post_meta( $portfolio_query->post->ID , 'ut_showcase_image_size' , true ) == 'portrait' ) {
                    
                    $height = $height * 2;
                    $size = 'portrait';
                    
                }
                
                /* panorama size */
                if( get_post_meta( $portfolio_query->post->ID , 'ut_showcase_image_size' , true ) == 'panorama' ) {
                    
                    $width = $width * 2;
                    $size = 'panorama';    
                
                }
                
                /* xxl size */
                if( get_post_meta( $portfolio_query->post->ID , 'ut_showcase_image_size' , true ) == 'xxl' ) {
                    
                    $height = $height * 2;
                    $width = $width * 2;
                    $size = 'xxl';
                
                }
                
                /* create thumbnail */
				$thumbnail  =  ut_resize( $fullsize , $width , $height , true , true , true );
				
                /* flag */
                $a_tag = false;
                
				/* style one images with title */
				if( $gallery_style == 'style_one') {
				    
					/* create single portfolio item */
					$gallery .= '<article style="background:url(' .  esc_url( $thumbnail ) . '); background-size:cover; background-position: center center;" data-size="' . $size . '" class="' . $projecttype . ' ' . $itemposition . ' ut-masonry show ' . $gutter . ' ' . $gutter_size . ' ut-masonry-' . $size . ' portfolio-style-one">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover">';
												
							/* link markup for slideup details */
							if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {							
								
								/* has external link */
								if( !empty( $external ) ) {
								    
									$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="'.$target.'">';
								
								} else {
								
									$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
								
								}
                                
                                $a_tag = true;
                                
								
							}
							
							/* link markup for image popup */
							if( ( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) && !$a_tag ) {
								
								$popuplink = NULL;
																
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {

									/* has external link */ 
									if( !empty( $external ) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="' . $target . '">';
										
									} else {
										
                                        if( self::$lightbox == 'ut-lightgallery' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                                                                
										$gallery .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" data-exthumbimage="' .  esc_url( $thumbnail ) . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';
										
									}
									
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="' . $external . '" target="' . $target . '">';
										
									} else {                                    
                                    
                                       /* get the content */
                                       if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                            
                                            /* youtube video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                            }
                                            
                                            /* selfhosted video - not supported by prettyphoto */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                $popuplink = $fullsize;                                            
                                            }
                                            
                                            /* custom video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                            }                                            
                                            
                                            /* content is still empty - let's assign the regular content */
                                            if(empty($content)) {
                                                $content = get_the_content();
                                            }
                                            
                                        } else {                                            
                                            $content = get_the_content();                                            
                                        }
                                        
                                        /* try to catch video url */
                                        $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
                                        $gallery .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . ' ' . $gutter_shadow . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" data-exthumbimage="' .  esc_url( $thumbnail ) . '" title="' . $caption . '" href="'.$popuplink.'">';
                                        
                                    }
                                    
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . ' ' . $gutter_shadow . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
									} else {
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
									        $gallery .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                        
                                        } else {
                                            
                                            $gallery .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                            
                                        }
                                        
									    $gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' ' . $image_style_class . ' ' . $gutter_shadow . '" title="' . $caption . '" href="'. $portfolio_detail_image .'">';									
								    
                                    }
                                    
								}								
								
							}							
							
							if( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
								
								$gallery .= '<div class="ut-hover-layer">';
                                
									$gallery .= '<div class="ut-portfolio-info">';
                                    
                                        $gallery .= '<div class="ut-portfolio-info-c">';
							                
                                            $gallery .= '<h3 class="portfolio-title">' . $title . '</h3>';
                                            
                                            if( get_post_meta($portfolio_query->post->ID , 'ut_showcase_custom_title', true ) ) {
                                            
                                                $gallery .= '<span>' . get_post_meta($portfolio_query->post->ID , 'ut_showcase_custom_title', true ) . '</span>';
									        
                                            } else {
                                                
                                                $gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
                                                
                                            }							
									    
                                        $gallery .= '</div>';
                                        
									$gallery .= '</div>';
                                    
								$gallery .= '</div>';								
							    
                                if( ut_generate_packery_caption( $portfolio_query->post->ID ) ) {
                                            
                                    $gallery .= ut_generate_packery_caption( $portfolio_query->post->ID );								
                                
                                }
                                
							$gallery .= '</a>';
															
						$gallery .= '</div>';
					
					$gallery .= '</article>';		

				}
				
				
				/* style two only images and title beneath */
				if( $gallery_style == 'style_two') {					
					
                    $lightbox = self::$lightbox == 'ut-lightgallery' ? 'ut-lightgallery-alternative' : self::$lightbox;
                    
					/* create single portfolio item */
					$gallery .= '<article data-size="' . $size . '" class="' . $projecttype . ' ' . $itemposition . ' ut-masonry show ' . $gutter . ' ' . $gutter_size . ' ut-masonry-' . $size . ' ' . $gutter_shadow . ' portfolio-style-two">';
						
						$gallery .= '<div class="ut-portfolio-item ut-hover" style="background:url(' .  esc_url( $thumbnail ) . '); background-size:cover; background-position: center center;">';
							
							/* link markup for slideup details */
							if( self::$detailstyle == 'slideup' || self::$detailstyle == 'internal' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'onepage' ) {							
								
								/* has external link */
								if( $external ) {
								
									$gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
								
								} else {
								
									$gallery .= '<a class="ut-portfolio-link ' . $image_style_class . '" rel="bookmark" title="' . $title . '" data-wrap="' . self::$token . '" data-post="' . $portfolio_query->post->ID . '" href="#ut-portfolio-details-wrap-' . self::$token . '">';
								
								}
								
							}
							
							/* link markup for image popup */
							if( self::$detailstyle == 'popup' || get_post_meta( $portfolio_query->post->ID , 'ut_portfolio_link_type' , true ) == 'popup' ) {
								
								$popuplink = NULL;
								
								/* image post or audio post */
								if( empty( $post_format ) || $post_format == 'audio' ) {

									/* has external link */
									if($external) {
									
										$gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
									    
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
										$gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" data-exthumbimage="' .  esc_url( $thumbnail ) . '" href="'. $portfolio_detail_image .'">';
									
									}
									
								}
								
								/* video post */
								if( $post_format == 'video' ) {
									
                                    /* has external link */ 
									if( !empty($external) ) {
										 
										$gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
										
									} else {
                                    
                                       /* get the content */
                                       if(!empty($ut_page_hero_type) && $ut_page_hero_type == 'video') { 
                                            
                                            /* youtube video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'youtube') {
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video', true);                                            
                                            }
                                            
                                            /* selfhosted video - not supported by prettyphoto */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'selfhosted') {
                                                $popuplink = $fullsize;                                            
                                            }
                                            
                                            /* custom video */
                                            if(isset($ut_page_video_source) && $ut_page_video_source == 'custom') {                                                
                                                $content = get_post_meta($portfolio_query->post->ID , 'ut_page_video_custom', true);
                                            }                                            
                                            
                                            /* content is still empty - let's assign the regular content */
                                            if(empty($content)) {
                                                $content = get_the_content();
                                            }
                                            
                                        } else {                                            
                                            $content = get_the_content();                                            
                                        }
                                        
                                        /* try to catch video url */
                                        $popuplink = !empty($popuplink) ? $popuplink : ut_get_portfolio_format_video_content($content);
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                        
                                            $gallery .= '<div class="ut-new-hide" id="ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '"><h4>' . $title . '</h4><p>' . $caption . '</p></div>';
                                        
                                        }
                                        
                                        $gallery  .= '<a data-rel="' . self::$lightbox . '" class="' . $image_style_class . '" data-sub-html="#ut-lightgallery-sub-html-' . $portfolio_query->post->ID . '" title="' . $caption . '" data-exthumbimage="' .  esc_url( $thumbnail ) . '" href="'.$popuplink.'">';
									
                                    }
                                    
								}
								
								/* gallery post */
								if( $post_format == 'gallery' ) {
									
                                    /* has external link */
									if($external) {
									
										$gallery .= '<a class="' . $image_style_class . '" rel="bookmark" title="' . $title . '" href="'.$external.'" target="'.$target.'">';
									
									} else {
                                        
                                        if( self::$lightbox == 'ut-lightgallery' ) {
                                            
                                            $gallery .= ut_portfolio_lightgallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                            
                                        } else {
                                            
                                            $gallery .= ut_portfolio_prettyphoto_gallery( $portfolio_query->post->ID , self::$token , $ut_page_hero_type );
                                        
                                        }
									    
									    $gallery .= '<a class="ut-portfolio-popup-'.$portfolio_query->post->ID.' ' . $image_style_class . '" title="' . $title . '" href="#">';									
								    
                                    }
                                    
								}								
								
							}
							
							if( post_password_required() ) :
								
								$gallery .= '<div class="ut-password-protected">' . __('Password Protected Portfolio' , 'ut_portfolio_lang') . '</div>';
							
							endif;
							
								$gallery .= '<div class="ut-hover-layer">';
									
                                    $gallery .= '<div class="ut-portfolio-info">';
                                        
                                        $gallery .= '<div class="ut-portfolio-info-c">';
							                
                                            if( get_post_meta($portfolio_query->post->ID , 'ut_showcase_custom_title', true ) ) {
                                            
                                                $gallery .= '<span>' . get_post_meta($portfolio_query->post->ID , 'ut_showcase_custom_title', true ) . '</span>';
									        
                                            } else {
                                                
                                                $gallery .= '<span>' . ut_generate_cat_list( $portfolio_cats ) . '</span>';
                                                
                                            }
                                            
                                        $gallery .= '</div>';
                                        
									$gallery .= '</div>';
                                    
								$gallery .= '</div>';
							    
                                if( ut_generate_packery_caption( $portfolio_query->post->ID ) ) {
                                            
                                    $gallery .= ut_generate_packery_caption( $portfolio_query->post->ID );								
                                
                                }
                                
							$gallery .= '</a>';
											
						$gallery .= '</div>';
					    
                        $gallery .= '<div class="ut-portfolio-title-wrap">';
								
						    $gallery .= '<div class="ut-portfolio-title-inner-wrap"><h3 class="portfolio-title">' . $title . '</h3></div>';
								
                        $gallery .= '</div>';
                        
					$gallery .= '</article>';  
				
				}
            
            $z++; endwhile; endif;
            
        /* end portfolio container */
        $gallery .= '</div>';
		
		/* portfolio pagination */
		if( $portfolio_query->max_num_pages > 1 ){
									
			$gallery .= '<nav class="ut-portfolio-pagination clearfix '.(!empty($gallery_options['filter_style']) ? $gallery_options['filter_style'] : 'style_one').'">';
			
			if ( $paged > 1 ) { 
        		$gallery .= '<a href="?paged=' . ($paged -1) .'&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-left"></i></a>';
			}
			
			for( $i=1 ;$i<=$portfolio_query->max_num_pages; $i++ ){
				
				$selected = ($paged == $i || ( empty($paged) && $i == 1 ) ) ? 'selected' : '';
				$gallery .= '<a href="?paged=' . $i . '&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor" class="' . $selected . '">' . $i . '</a>';

            }
			
			if($paged < $portfolio_query->max_num_pages){
                $paged_next = $paged == 0 ? $paged + 1 : $paged;
                $gallery .= '<a href="?paged=' . ($paged_next + 1) . '&amp;portfolioID='.self::$token.'&amp;termID='.$term.'#ut-portfolio-items-' . self::$token . '-anchor"><i class="fa fa-angle-double-right"></i></a>';
            } 
			
			$gallery .= '</nav>';
		
		}

				
        /* end portfolio wrap */
        $gallery .= '</div>';
        
		/* restore wp_query */
		$wp_query = null; $wp_query = $temp;
		
        /* reset query */
		wp_reset_postdata();
        
        /* return final gallery */
        return $gallery;

    
    }
        
    static function generate_gallery_packery_script( $gallery_options , $counter = 3 ) {
                
        ob_start();
            
        ?>
        				        
        <script type="text/javascript">
        /* <![CDATA[ */
        (function($) {
			    
            $(document).ready(function($){
                
                "use strict";
                
                var $win         = $(window),
                    $container   = $("#ut-portfolio-items-<?php echo self::$token; ?>"),
					$sortedItems = "";
				
				/* IsoTope
                ================================================== */                                    
                $container.isotope({
                  
                    itemSelector : '.ut-masonry',
                    animationEngine : 'best-available',
                    layoutMode: 'packery',
                    percentPosition: true,
                    itemPositionDataEnabled: true,
                    onLayout: function (elems, instance) {
                        
                        $win.trigger("scroll");
                        
                        $container.addClass("animated");
                        elems.addClass("animated");
                        
                    }
                    
                }); 				
                
				$(window).load(function() {
            		
					/* store sorted items */
					$sortedItems = $container.data("isotope").$filteredAtoms;
					
                    $container.isotope('layout');
				    
                    /* IsoTope Filtering
                    ================================================== */               
                    $("#ut-portfolio-menu-<?php echo self::$token; ?> a").each(function( index ) {
                            
                        var searchforclass = $(this).attr("data-filter");

                        if( !$(searchforclass).length  ) {
                            
                            $(this).hide(); // hide filter if we do not have any children to filter
                            
                        }
                            
                    });				
                
                    $("#ut-portfolio-menu-<?php echo self::$token; ?> a").click(function(){
                      
                        var selector = $(this).attr("data-filter");
                        $container.isotope({ filter: selector });
                        
                        /* update isotope grid */
                        $container.isotope('layout');	
                      
                        if ( !$(this).hasClass("selected") ) {
                            $(this).parents("#ut-portfolio-menu-<?php echo self::$token; ?>").find(".selected").removeClass("selected");
                            $(this).addClass("selected");
                        }          
                                                
                        return false;
                      
                    });
				
				       
                });  
        
            });
			
        }(jQuery));
		    
        /* ]]> */
        </script>        

        <?php
        return ob_get_clean();
        
        return ut_compress_java( ob_get_clean() );
    
    }
    
    static function search_tax_key( $id, $array ) {
		        
        foreach ($array as $key => $val) {

           if($val['term_id'] == $id) {
               return $key;
           }
           
        }
        
        return null;
            
    }
    	  
	static function enqueue_showcase_scripts() {
		
		if ( ! self::$add_showcase_script )  {
            return;
        }
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		/* needed js */
		wp_enqueue_script(
            'ut-flexslider-js', 
            UT_PORTFOLIO_URL . 'assets/js/plugins/flexslider/jquery.flexslider' . $min . '.js',
            array(),
            '2.2.2'
        );
        
		wp_enqueue_script(
            'ut-effect', 
            UT_PORTFOLIO_URL . 'assets/js/ut.effects' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_localize_script('ut-effect', 'utPortfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		
		/* needed css */
		wp_enqueue_style(
            'ut-flexslider',
            UT_PORTFOLIO_URL . 'assets/css/plugins/flexslider/flexslider' . $min . '.css',
            array(),
            '2.2.2'
        );
		
	}
	
	static function enqueue_masonry_scripts() {
		
		if ( ! self::$add_masonry_script )  {
            return;
        }
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		wp_enqueue_script(
            'ut-masonry-js',
            UT_PORTFOLIO_URL . 'assets/js/jquery.utmasonry' . $min . '.js',
            array(),
            '1.8'
        );
        
		wp_enqueue_script(
            'ut-effect',
            UT_PORTFOLIO_URL . 'assets/js/ut.effects' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_localize_script( 'ut-effect', 'utPortfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
	
	}
    
    static function enqueue_gallery_scripts() {
		
		if ( ! self::$add_gallery_script )  {
            return;
        }
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		wp_enqueue_script(
            'ut-masonry-js',
            UT_PORTFOLIO_URL . 'assets/js/jquery.utmasonry' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_enqueue_script(
            'ut-effect', 
            UT_PORTFOLIO_URL . 'assets/js/ut.effects' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_localize_script( 'ut-effect', 'utPortfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );		
			
	}
    
    static function enqueue_packery_scripts() {
		
		if ( ! self::$add_gallery_script )  {
            return;
        }
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		wp_enqueue_script(
            'ut-masonry-js',
            UT_PORTFOLIO_URL . 'assets/js/jquery.utmasonry' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_enqueue_script(
            'ut-effect', 
            UT_PORTFOLIO_URL . 'assets/js/ut.effects' . $min . '.js',
            array(),
            UT_PORTFOLIO_VERSION
        );
        
		wp_localize_script( 'ut-effect', 'utPortfolio' , array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );		
			
	}     
    
}

ut_portfolio_shortcode::init();