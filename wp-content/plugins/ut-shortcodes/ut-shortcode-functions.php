<?php

/*
 * CSS Minifier
 */

if ( !function_exists( 'ut_minify_inline_css' ) ) {
    
    function ut_minify_inline_css($buffer) { 
        
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        return $buffer;
        
    }
        
}

/*
 * Built Button
 */

if( !function_exists('array_filter_recursive') ) {

    function array_filter_recursive( $input ) { 
   
        foreach ($input as &$value) { 
            
            if( is_array( $value ) ) { 
                
                $value = array_filter_recursive( $value );
                 
            }
            
        }
            
        return array_filter( $input ); 
   
    } 

}

/*
 * Web Safe Font Markup
 */
if( !function_exists('get_websafe_font_css_family') ) {

    function get_websafe_font_css_family( $key ) {
        
        $websafe_fonts = array(
            'arial'         => 'Arial, Helvetica, sans-serif',
            'courier'       => '"Courier New", Courier, monospace',
            'comic'         => '"Comic Sans MS", cursive, sans-serif',
            'georgia'       => 'Georgia, serif',
            'helvetica'     => 'Helvetica, sans-serif',
            'impact'        => 'Impact, Charcoal, sans-serif',
            'lucida_sans'   => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
            'lucida_console'=> '"Lucida Console", Monaco, monospace',
            'palatino'      => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
            'tahoma'        => 'Tahoma, Geneva, sans-serif',
            'times'         => '"Times New Roman", Times, serif',
            'trebuchet'     => '"Trebuchet MS", Helvetica, sans-serif',
            'verdana'       => 'Verdana, Geneva, sans-serif'
        );
        
        return isset( $websafe_fonts[$key] ) ? $websafe_fonts[$key] : $websafe_fonts['arial'];
        
    }

}




/*
 * Built Button
 */
 
if ( !function_exists( 'ut_create_button' ) ) {
    
    function ut_create_button( $id, $button_settings = array() ) { 
        
        $button_settings = array_filter_recursive( $button_settings );
        
        if( empty( $button_settings ) ) {
            return;
        }
        
        $css = NULL;
                
        if( !empty( $button_settings['default'] ) && is_array( $button_settings['default'] ) ) {
            
            $default = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s:%s;", $k, $v); },
                $button_settings['default'],
                array_keys( $button_settings['default'] )
            ) );
            
            $css .= '#' . $id . ' .bklyn-btn { ' . $default . ' }';
            
        }
        
        if( !empty( $button_settings['hover'] ) && is_array( $button_settings['hover'] ) ) {
            
            $hover = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s:%s;", $k, $v); },
                $button_settings['hover'],
                array_keys( $button_settings['hover'] )
            ) );
            
            $css .= '#' . $id . ' .bklyn-btn:hover { ' . $hover . ' }';
            $css .= '#' . $id . ' .bklyn-btn:focus { ' . $hover . ' }';
            $css .= '#' . $id . ' .bklyn-btn:active{ ' . $hover . ' }';   
            
        }
        
        return $css;
        
    }
        
}



/*
 * CSS3 Animation Effects
 */

if( !function_exists('ut_recognized_animation_effects') ) :

    function ut_recognized_animation_effects() {
     
      return apply_filters( 'ut_recognized_animation_effects', array(
        'flash'             => 'Flash',
        'bounce'            => 'Bounce',
        'shake'             => 'Shake',
        'tada'              => 'Tada',
        'swing'             => 'Swing',
        'wobble'            => 'Wobble',
        'wiggle'            => 'Wiggle',
        'pulse'             => 'Pulse',
        'slideInUp'         => 'Slide In Up',
        'slideInLeft'       => 'Slide In Left',
        'slideInRight'      => 'Slide In Right',
        'slideInDown'       => 'Slide In Down',
        'flip'              => 'Flip',
        'flipInX'           => 'Flip In X',
        'flipInY'           => 'Flip In Y',
        'fadeIn'            => 'Fade In',
        'fadeInUp'          => 'Fade In Up',
        'fadeInDown'        => 'Fade In Down',
        'fadeInLeft'        => 'Fade In Left',
        'fadeInRight'       => 'Fade In Right',
        'fadeInUpBig'       => 'Fade In Up Big',
        'fadeInDownBig'     => 'Fade In Down Big',
        'fadeInLeftBig'     => 'Fade In Left Big',
        'fadeInRightBig'    => 'Fade In Right Big',
        'bounceIn'          => 'Bounce In',
        'bounceInDown'      => 'Bounce In Down',
        'bounceInUp'        => 'Bounce In Up',
        'bounceInLeft'      => 'Bounce In Left',
        'bounceInRight'     => 'Bounce In Right',
        'rotateIn'          => 'Rotate In',
        'rotateInDownLeft'  => 'Rotate In Down Left',
        'rotateInDownRight' => 'Rotate In Down Right',
        'rotateInUpLeft'    => 'Rotate In Up Left',
        'rotateInUpRight'   => 'Rotate In Up Right',
        'lightSpeedIn'      => 'LightSpeed In',
        'hinge'             => 'Hinge',
        'rollIn'            => 'Roll In'
      ));
      
    }

endif;

/*
 * CSS3 Animation Effects
 */

if( !function_exists('ut_recognized_animation_effects_vc') ) :

    function ut_recognized_animation_effects_vc() {
     
      return apply_filters( 'ut_recognized_animation_effects_vc', array(
        'No Animation Effect'   => '',
        'Flash'                 => 'flash',
        'Bounce'                => 'bounce',
        'Shake'                 => 'shake',
        'Tada'                  => 'tada',
        'Swing'                 => 'swing',
        'Wobble'                => 'wobble',
        'Wiggle'                => 'wiggle',
        'Pulse'                 => 'pulse',
        'Slide In Up'           => 'slideInUp',
        'Slide In Left'         => 'slideInLeft',
        'Slide In Right'        => 'slideInRight',
        'Slide In Down'         => 'slideInDown',
        'Flip'                  => 'flip',
        'Flip In X'             => 'flipInX',
        'Flip In Y'             => 'flipInY',
        'Fade In'               => 'fadeIn',
        'Fade In Up'            => 'fadeInUp',
        'Fade In Down'          => 'fadeInDown',
        'Fade In Left'          => 'fadeInLeft',
        'Fade In Right'         => 'fadeInRight',
        'Fade In Up Big'        => 'fadeInUpBig',
        'Fade In Down Big'      => 'fadeInDownBig',
        'Fade In Left Big'      => 'fadeInLeftBig',
        'Fade In Right Big'     => 'fadeInRightBig',
        'Bounce In'             => 'bounceIn',
        'Bounce In Down'        => 'bounceInDown',
        'Bounce In Up'          => 'bounceInUp',
        'Bounce In Left'        => 'bounceInLeft',
        'Bounce In Right'       => 'bounceInRight',
        'Rotate In'             => 'rotateIn',
        'Rotate In Down Left'   => 'rotateInDownLeft',
        'Rotate In Down Right'  => 'rotateInDownRight',
        'Rotate In Up Left'     => 'rotateInUpLeft',
        'Rotate In Up Right'    => 'rotateInUpRight',
        'LightSpeed In'         => 'lightSpeedIn',
        'Hinge'                 => 'hinge',
        'Roll In'               => 'rollIn'
      ));
            
    }

endif;



/*
 * HEX to RGB
 */

if( !function_exists('ut_hex_to_rgb') ) :

    function ut_hex_to_rgb($hex) {
                
        $hex = preg_replace("/#/", "", $hex);
        $color = array();
     
        if(strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex, 0, 1) . $r);
            $color['g'] = hexdec(substr($hex, 1, 1) . $g);
            $color['b'] = hexdec(substr($hex, 2, 1) . $b);
        }
        else if(strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
        }
        
        $color = implode(',', $color);
        
        return $color;
    }

endif;

/*
 * Custom "get"_comments_popup_link
 */
if( !function_exists('ut_get_comments_popup_link') ) {
    
    function ut_get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
        
        global $wpcommentspopupfile, $wpcommentsjavascript;
     
        $id = get_the_ID();
     
        if ( false === $zero ) $zero = esc_html__( 'No Comments' , 'ut_shortcodes' );
        if ( false === $one ) $one = esc_html__( '1 Comment' , 'ut_shortcodes' );
        if ( false === $more ) $more = esc_html__( '% Comments' , 'ut_shortcodes' );
        if ( false === $none ) $none = esc_html__( 'Comments Off' , 'ut_shortcodes' );
     
        $number = get_comments_number( $id );
     
        $str = '';
     
        if ( 0 == $number && !comments_open() && !pings_open() ) {
            $str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
            return $str;
        }
     
        if ( post_password_required() ) {
            $str = esc_html__('Enter your password to view comments . ' , 'ut_shortcodes' );
            return $str;
        }
     
        $str = '<a href="';
        if ( $wpcommentsjavascript ) {
            if ( empty( $wpcommentspopupfile ) )
                $home = home_url();
            else
                $home = get_option('siteurl');
            $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
            $str .= '" onclick="wpopen(this.href); return false"';
        } else { // if comments_popup_script() is not in the template, display simple comment link
            if ( 0 == $number )
                $str .= get_permalink() . '#respond';
            else
                $str .= get_comments_link();
            $str .= '"';
        }
     
        if ( !empty( $css_class ) ) {
            $str .= ' class="' . $css_class . '" ';
        }
        $title = the_title_attribute( array('echo' => 0 ) );
     
        $str .= apply_filters( 'comments_popup_link_attributes', '' );
     
        $str .= ' title="' . esc_attr( sprintf( esc_html__('Comment on %s' , 'ut_shortcodes'), $title ) ) . '">';
        $str .= ut_get_comments_number_str( $zero, $one, $more );
        $str .= '</a>';
         
        return $str;
    }
}

if( !function_exists('ut_get_comments_number_str') ) {
    
    function ut_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
        if ( !empty( $deprecated ) )
            _deprecated_argument( __FUNCTION__, '1.3' );
     
        $number = get_comments_number();
     
        if ( $number > 1 )
            $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? esc_html__('% Comments', 'ut_shortcodes') : $more);
        elseif ( $number == 0 )
            $output = ( false === $zero ) ? esc_html__('No Comments', 'ut_shortcodes') : $zero;
        else // must be one
            $output = ( false === $one ) ? esc_html__('1 Comment', 'ut_shortcodes') : $one;
     
        return apply_filters('comments_number', $output, $number);
    }
    
}

/*
 * Fix Shortcodes
 */
 
if( !function_exists('ut_fix_shortcodes') ) {
    
    function ut_fix_shortcodes($content){   
    
        
        $block = join("|",array( "ut_animate_image" , "ut_button" , "ut_icon" , "ut_alert" , "ut_one_sixth" , "ut_one_sixth_last" , "ut_one_fifth" , "ut_one_fifth_last" , "ut_one_fourth" , "ut_one_fourth_last" , "ut_one_third" , "ut_one_third_last" , "ut_one_half" , "ut_one_half_last" , "ut_two_thirds" ,
                                 "ut_two_thirds_last" , "ut_service_icon_box", "ut_three_fourth" , "ut_three_fourth_last" , "ut_probar" , "ut_highlight" , "ut_tabgroup" , "ut_tab" , "ut_togglegroup" , "ut_toggle" , "ut_rotate_words" , "ut_fw_section" , "ut_showcase" , "ut_service_box" , "ut_quote_rotator" , 
                                 "ut_quote" , "ut_quote_rotator_alt" , "ut_quote_alt" , "ut_service_column" , "ut_service_column_vertical" , "ut_count_up" , "ut_parallax_quote" , "ut_social" , "ut_social_media", "ut_client_group" , "ut_client" , "ut_single_quote" , "ut_highlight_section" , 'ut_video_testimonial', 'ut_video_testimonials',
                                 "video", "ut_custom_box", "contact-form-7" ));
         
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
         
        return $rep;

    }
    
    add_filter('the_content', 'ut_fix_shortcodes');
        
}
























/*
 * Icons
 */

if( !function_exists('ut_create_icon') ) { 
 
    function ut_create_icon($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'icon'     => 'fa-off',
             'size'     => 'fa-4',
             'color'    => '',
             'bgcolor'  => '#CCC',
             'border'   => 'none',
             'spin'     => '',
             'rotate'   => '',
             'link'     => '',
             'target'   => 'self',
             'align'    => 'alignnone',
             'class'    => ''    
             
        ), $atts));

            $finalicon = NULL;
            $iconclass = NULL;
            
            if( $border == 'none' ) {
                
                /* default icon */
                $classes    = array('icon' , 'size' , 'spin', 'rotate', 'class');
    
                $style = (!empty($color)) ? 'style="color:' . $color . '"' : '';
                
                $span_open  = '<span class="' . $align . ' ut-custom-icon">';
                $span_close = '</span>';
                
                foreach($atts as $key => $att) {
                    
                    if( !empty($att) && in_array($key, $classes) )
                    $iconclass .= $att . ' ';
                    
                }
                
                if(!empty($link)) {
                    
                    $finalicon .= $span_open  . '<a class="ut-custom-icon-link" target="_' . $target . '" href="' . $link . '"><i class="fa ' . trim($iconclass) . '" ' . $style . '></i></a>' .  $span_close;
                    
                } else {
                    
                    $finalicon .= $span_open  . '<i class="fa ' . trim($iconclass) . '" ' . $style . '></i>' .  $span_close;
                    
                }
                
            } else {
            
                
                /* stacked icon */
                $classes    = array('icon' , 'spin', 'rotate', 'class');
                $style      = (!empty($color)) ? 'style="color:' . $color . '"' : '';
                
                foreach($atts as $key => $att) {
                    
                    if( !empty($att) && in_array($key, $classes) )
                    $iconclass .= $att . ' ';
                    
                }
                
                /* start output */
                $finalicon .= '<span class="fa-stack ut-custom-icon ' . $size . ' ' . $align . '">';
                    
                    if(!empty($link)) { $finalicon .= '<a target="_' . $target . '" href="' . $link . '">'; }
                                                
                        $finalicon .= '<i class="fa fa-' . $border . ' fa-stack-2x" style="color:' . $bgcolor . '"></i>';
                        $finalicon .= '<i class="fa ' . trim($iconclass) . ' fa-stack-1x" ' . $style . '></i>';
                        
                    if(!empty($link)) { $finalicon .= '</a>'; }
                
                $finalicon .= '</span>';
            
            }
                    
        
        return $finalicon;
        
    }
    add_shortcode('ut_icon', 'ut_create_icon');

}

/*
 * Spacer
 */
 
if( !function_exists('ut_create_spacer') ) {  

    function ut_create_spacer( $atts ) {
        
        extract(shortcode_atts(array(            
                'class'  => '',
                'margin_bottom' => '',
                'margin_top' => ''        
            ), $atts));
            
            /* create style */
            $style = 'style="';
            
            if(!empty($margin_bottom)) {
                $margin_bottom = is_numeric($margin_bottom) ? $margin_bottom  . 'px' : $margin_bottom ; 
                $style .= 'margin-bottom: ' . $margin_bottom . ';';
            }
            
            if(!empty($margin_top)) {
                $margin_top = is_numeric($margin_top) ? $margin_top  . 'px' : $margin_top ; 
                $style .= 'margin-top: ' . $margin_top . ';';
            }
            
            $style .= '"';            
            
            return '<div class="ut-spacer ' . $class . '" ' . $style . '></div>';
            
    }
    
    add_shortcode('ut_spacer', 'ut_create_spacer');
    
}

/*
 * Alerts
 */
 
if( !function_exists('ut_create_alert') ) {  

    function ut_create_alert( $atts, $content = null ) {
        
        extract(shortcode_atts(array(
                'class'        => '',
                'color'        => 'white',
                'effect'       => '',
                'animate_once' => 'no',
            ), $atts));
            
            /* animation effect */
            $dataeffect = $animated = NULL;
            if( !empty( $effect ) ) {
    
                $dataeffect = 'data-effect="' . $effect . '" data-animateonce="' . $animate_once . '"';
                $animated   = 'ut-animate-element animated';
                
            }
            
            return '<div ' . $dataeffect . ' class="ut-alert ' . $color . ' ' . $class . ' ' . $animated . '">' . do_shortcode($content) . '</div>';
            
    }
    
    add_shortcode('ut_alert', 'ut_create_alert');
    
}




/*
 * Highlights
 */ 

if( !function_exists('ut_highlight') ) { 
 
    function ut_highlight($atts, $content = null) {
        
        extract(shortcode_atts(array(
             'class'     => '',
             'color'    => '',
             'bgcolor'    => ''
        ), $atts));
        
        $extraStyle = 'style="';
        
        if( !empty($color) ) {
            $extraStyle .= 'color: ' . $color . ' ;';
        }
        
        if( !empty($bgcolor) ) {
            $extraStyle .= 'background: ' . $bgcolor . ' ;';
        }
        
        $extraStyle .= '"';
        
        
        return '<span ' . $extraStyle . ' class="ut-highlight ' . $class . '">' . do_shortcode($content) . '</span>';
    }
    add_shortcode('ut_highlight', 'ut_highlight');
}

/*
 * Tabs
 */ 

if( !function_exists('ut_tabgroup') ) {

    function ut_tabgroup( $atts, $content ){
            
            extract(shortcode_atts(array(
                'width'        => '',
                'last'        => 'false',
                'class'     => ''
            ), $atts));    
            
            $grid = array(  'third'  => 'ut-one-third',
                            'fourth' => 'ut-one-fourth',
                               'half'     => 'ut-one-half' );
        
            $last = $last == 'true' ? 'ut-column-last' : '';
            $return = '';
            
            /* fallback */
            $gridwidth = !empty($grid[$width]) ? $grid[$width] : '';
            
            
            $GLOBALS['tab_count'] = 0;
            $GLOBALS['tabs'] = array();
            
            do_shortcode( $content );        
        
            if( is_array( $GLOBALS['tabs'] ) ){
                
                $tabcount = 1;
                
                foreach( $GLOBALS['tabs'] as $tab ){
                    
                    $active = ($tabcount == 1) ? 'class="active"' : '';
                    $tabs[]     = '<li ' . $active . '><a href="#' . $tab['id'] . 'Tab" data-toggle="tab">' . $tab['title'] . '</a></li>';
                    
                    $active = ($tabcount == 1) ? 'active' : '';
                    $panes[]    = '<div class="tab-pane ' . $active . ' ' . $tab['class'] . ' clearfix" id="' . $tab['id'] . 'Tab">' . do_shortcode($tab['content']) . '</div>';
                    
                    $tabcount++;
                    
                }
                
                if( !empty($width) || !empty($class) ) {
                    $return .= '<div class="' . $gridwidth . ' ' . $class . ' ' . $last . '">';
                }
                
                $return .= "\n" . '<!-- the tabs --><ul class="ut-nav-tabs clearfix">' . implode( "\n", $tabs ) . '</ul>' . "\n" . '<!-- tab "panes" --><div class="ut-tab-content entry-content clearfix">' . implode( "\n", $panes ) . '</div>' . "\n";
                
                if( !empty($width) ) {
                    $return .= '</div>';
                }
                
                
            }
        
        return $return;
    
    }
    add_shortcode( 'ut_tabgroup', 'ut_tabgroup' );

}

if( !function_exists('ut_tab') ) {

    function ut_tab( $atts, $content ){
        
        extract(shortcode_atts(array(
            'title' => '%d',
            'id' => '%d',
            'class' => ''
        ), $atts));
        
                
        $x = $GLOBALS['tab_count'];
        $GLOBALS['tabs'][$x] = array(
            'title' => sprintf( $title, $GLOBALS['tab_count'] ),
            'content' =>  $content,
            'id' =>  $id,        
            'class' => $class );
        
        $GLOBALS['tab_count']++;
    }
    add_shortcode( 'ut_tab', 'ut_tab' );
}

/*
 * Video Testimonials
 */

$GLOBALS['ut_video_testimonial_total_count'] = NULL;
$GLOBALS['ut_video_testimonial_count'] = NULL; 
  
if( !function_exists('ut_video_testimonials') ) {

    function ut_video_testimonials( $atts, $content ){
    
        extract(shortcode_atts(array(
                'class' => ''
        ), $atts));
        
        global $ut_video_testimonial_total_count , $ut_video_testimonial_count; 
        
        $ut_video_testimonial_total_count = substr_count($content, '[/ut_video_testimonial]');
        $ut_video_testimonial_count = 0;
        
        $testimonials = NULL;
        
        $testimonials.= '<div class="ut-video-testimonial-wrapper grid-100 tablet-grid-100 mobile-grid-100 grid-parent ' . $class . '">';
            
            $testimonials.= do_shortcode( $content );
            
        $testimonials.= '</div>';
        
        return $testimonials;
        
    }    
    
    add_shortcode( 'ut_video_testimonials', 'ut_video_testimonials' );
    
}

if( !function_exists('ut_video_testimonial') ) {

    function ut_video_testimonial( $atts, $content ){
        
        extract(shortcode_atts(array(
                'author'        => '',
                'company'       => '',
                'box'           => 'off',
                'poster'        => get_template_directory_uri() . '/images/video-default-thumbnail.jpg',
                'width'         => '800',
                'height'        => '450',
                'style'         => 'dark',
                'effect'        => '',
                'animate_once'  => 'no',
                'class'         => ''
        ), $atts));
        
        $grid = array(  1 => '100',
                        2 => '50',
                        3 => '33'                    
                );
        
        global $ut_video_testimonial_total_count , $ut_video_testimonial_count; 
        
        /* animation effect */
        $dataeffect = $animated = NULL;
        if( !empty( $effect ) ) {

            $dataeffect = 'data-effect="' . $effect . '" data-animateonce="' . $animate_once . '"';
            $animated      = 'ut-animate-element animated';
            
        }        
        
        /* fallback if there is no global value */
        $ut_video_testimonial_total_count = empty($ut_video_testimonial_total_count) ? 3 : $ut_video_testimonial_total_count;
        
        $grid_items = ( $ut_video_testimonial_total_count >= 3 ) ? 3 : $ut_video_testimonial_total_count;
                
        $testimonial = NULL;
        
        $style = ( $box == 'on' ) ? 'ut-video-box-' . $style : '';
        
        $testimonial.= '<div ' . $dataeffect . ' class="grid-' . $grid[$grid_items] . ' tablet-grid-' . $grid[$grid_items] . ' mobile-grid-100 ' .  $animated  . '">';
            
            $testimonial.= '<div class="ut-video-testimonial ' . ( ($box == 'on') ? 'ut-video-testimonial-boxed' : '' ) . ' ' . $style . '">';
                
                $testimonial .= '<a class="ut-load-vtestimonial" href="#?custom=true&amp;width=' . $width . '&amp;height=' . $height . '">';
                    
                    if( !empty($poster) ) {
                        $testimonial .= '<img alt="' . ( !empty($author) ? $author : esc_html__('Video Testimonial','ut_shortcodes') ) . '" src="' . $poster . '" />';
                    }
                    
                    /* remove html tags, we need plain URL's */
                    $content = strip_tags($content);                    
                    $testimonial .= '<div style="display:none;">' . trim($content) . '</div>';
                    
                $testimonial .= '</a>';
                                
                if( !empty($author) ) {
                    $testimonial.= '<h3>' . $author . '</h3>';
                }
                
                if( !empty($company) ) {
                    $testimonial.= '<span>' . $company . '</span>';
                }                
                
            $testimonial.= '</div>';
            
        $testimonial.= '</div>';
        
        /* global counter */
        $ut_video_testimonial_count++;
        
        /* if counter has reached the maximum of 3 per row , decrease the total counter */
        if( $ut_video_testimonial_count ==  3 && $ut_video_testimonial_total_count > 3) {
            $ut_video_testimonial_total_count = $ut_video_testimonial_total_count - $ut_video_testimonial_count;
            $ut_video_testimonial_count = 0;
        }     
        
        return $testimonial;
        
    }
    
    add_shortcode( 'ut_video_testimonial', 'ut_video_testimonial' );
    
}


/*
 * Social Media List
 */ 
 
$GLOBALS['ut_social_total_count'] = NULL;
$GLOBALS['ut_social_count'] = NULL;

if( !function_exists('ut_social_media') ) {

    function ut_social_media( $atts, $content ){
            
        extract(shortcode_atts(array(
            'class' => ''
        ), $atts));        
        
        global $ut_social_total_count, $ut_social_count;
        
        $ut_social_total_count = substr_count($content, '[/ut_social]');
        $ut_social_count = 0;
        
        $social  = '<ul class="ut-social-network ' . $class . '">';
            $social .= do_shortcode( $content );
        $social .= '</ul>';
        
        return $social;
            
    }
    
    add_shortcode( 'ut_social_media', 'ut_social_media' );

}

if( !function_exists('ut_social') ) {

    function ut_social( $atts, $content ){
        
        extract(shortcode_atts(array(
            'title'        => '',
            'url'         => '#',
            'icon'        => 'fa-facebook',
            'target'    => '_blank',
            'avatar'     => '',
            'class'        => ''            
        ), $atts));        
        
        $grid = array(  1 => '100',
                        2 => '25',
                        3 => '33',
                        4 => '25',
                        5 => '20' );
        
        global $ut_social_total_count, $ut_social_count;
        
        $prefix = NULL;
        $suffix = NULL;        
                        
        //fallback if there is no global value
        $ut_social_total_count = empty($ut_social_total_count) ? 5 : $ut_social_total_count;
                
        // special case if we only have 2 items
        if( $ut_social_total_count == 2 && $ut_social_count == 0 ) {
            $prefix = "prefix-25 tablet-prefix-25";
        }
        
        if( $ut_social_total_count == 2 && $ut_social_count == 1 ) {
            $suffix = "suffix-25 tablet-suffix-25";
        }        
        
        $grid_items = ( $ut_social_total_count >= 5 ) ? 5 : $ut_social_total_count;
                
        $profile  = '<li class="grid-' . $grid[$grid_items] . ' tablet-grid-' . $grid[$grid_items] . ' mobile-grid-100 ' . $class . ' ' . $prefix . ' ' . $suffix . '">';
            $profile .= '<a target="' . $target . '" href="' . $url . '" class="ut-social-link">';
                $profile .= '<span class="ut-social-icon"><i class="fa ' . $icon . ' fa-4x"></i></span>';
                
                if( !empty($title) ) {
                    $profile .= '<h3 class="ut-social-title">' . $title . '</h3>';
                }
                
                if( !empty($content) ) {
                    $profile .= '<span class="ut-social-info">' . do_shortcode( $content ) . '</span>';
                }
                
            $profile .= '</a>';
        $profile .= '</li>';
        
        /* global counter */
        $ut_social_count++;        
        
        /* if counter has reached the maximum of 5 per row , decrease the total counter */
        if( $ut_social_count ==  5 && $ut_social_total_count > 5) {
            $ut_social_total_count = $ut_social_total_count - $ut_social_count;
            $ut_social_count = 1;
        }
                    
        return $profile;        
        
    }
    
    add_shortcode( 'ut_social', 'ut_social' );
    
}



/*
 * Toggles
 */ 
 
if( !function_exists('ut_togglegroup') ) {
    
    $togglegroupcount = 0;
    
    function ut_togglegroup( $atts, $content ){
        
        global $togglegroupcount;
        
        extract(shortcode_atts(array(
                'width'        => '',
                'last'        => 'false',
                'class'     => ''
        ), $atts));
        
        $grid = array( 'third'  => 'ut-one-third',
                       'fourth' => 'ut-one-fourth',
                       'half'    => 'ut-one-half');
        
        $last = $last == 'true' ? 'ut-column-last' : '';
        $return = '';
        
        /* fallback */
        $gridwidth = !empty($grid[$width]) ? $grid[$width] : '';        
        
        $togglegroupcount++;
        
        if( !empty($width) || !empty($class) ) {
            $return .= '<div class="' . $gridwidth . ' ' . $class . ' ' . $last . '">';
        }
           
        $return .= '<div id="ut-accordion-parent-' . $togglegroupcount . '" class="ut-accordion"><div class="ut-accordion-group">' . do_shortcode($content) . '</div></div>';
        
        if( !empty($width) || !empty($class) ) {
            $return .= '</div>';
        }
        
        
        return $return;
    
    }
    add_shortcode( 'ut_togglegroup', 'ut_togglegroup' );
}

if( !function_exists('ut_toggle') ) {

    $togglecount = 0;

    function ut_toggle( $atts, $content = null ) {
        
        global $togglecount , $togglegroupcount;    
            
        extract(shortcode_atts(array(
             'title'     => '',
             'state'     => 'closed',
             'class'    => ''
        ), $atts));
        
        $output = '';
        
        $hstate = ($state == 'closed') ? 'collapsed' : ''; 
        $state  = ($state == 'closed') ? 'collapse' : 'collapse in'; 
        $active = ($state == 'collapse') ? '' : 'active'; 
        
        $output .= '<div class="ut-accordion-heading ' . $class . '">';
            $output .= '<a data-parent="#ut-accordion-parent-' . $togglegroupcount . '" class="accordion-toggle ' . $hstate . ' ' . $active . '" data-toggle="collapse" data-target="#accordion' .$togglecount. '">';
                $output .= $title;
            $output .= '</a>';
        $output .= '</div>';
        $output .= '<div id="accordion' .$togglecount. '" class="ut-accordion-body ' . $state . '">';
            $output .= '<div class="ut-accordion-inner entry-content clearfix">';
                $output .= do_shortcode($content);
            $output .= '</div>';
        $output .= '</div>';
        
        $togglecount++;
        
        return $output;
        
    }
    add_shortcode('ut_toggle', 'ut_toggle');
}

/*
 * Blockquotes
 */ 

if( !function_exists('ut_blockquote_left') ) { 

    function ut_blockquote_left($atts, $content = null) {
        
        extract(shortcode_atts(array(
             'class'    => ''
        ), $atts));        
        
        return '<div class="ut-blockquote-left ' . $class . '"><blockquote><p>' . do_shortcode( $content ) . '</p></blockquote></div>';
    }
    add_shortcode('ut_blockquote_left', 'ut_blockquote_left');
}



if( !function_exists('ut_blockquote_right') ) { 

    function ut_blockquote_right($atts, $content = null) {
        
        extract(shortcode_atts(array(
             'class'    => ''
        ), $atts));    
        
        return '<div class="ut-blockquote-right ' . $class . '"><blockquote><p>' . do_shortcode( $content ) . '</p></blockquote></div>';
    }
    add_shortcode('ut_blockquote_right', 'ut_blockquote_right');
}


/*
 * Fancy Link
 */ 
if( !function_exists('ut_fancy_link') ) { 
 
    function ut_fancy_link($atts, $content = null) {
    
        extract(shortcode_atts(array(
             
             'url'            => '#',
             'class'        => ''
        
        ), $atts));
        
        $link = '<span class="cta-btn cl-effect-18 ' . $class . '"><a class="cl-effect-18" href="' . $url . '">' . do_shortcode($content) . '</a></span>';
                
        return $link;
    
    }

    add_shortcode('ut_fancy_link', 'ut_fancy_link');
    
}

/*
 * Dropcaps
 */ 

if( !function_exists('ut_dropcap') ) { 

    function ut_dropcap($atts, $content = null) {
        
        extract(shortcode_atts(array(
             'class'     => '',
             'style'    => 'one'
        ), $atts)); 
        
        return '<span class="ut-dropcap-' . $style . ' ' . $class . '">' . do_shortcode($content) . '</span>';
    }
    
    add_shortcode('ut_dropcap', 'ut_dropcap');
    
}


/*
 * Tweet Rotator , only available if ut witter plugin has been installed
 */ 
if( ut_is_plugin_active('ut-twitter/ut-twitter.php') ) {

    if( !function_exists( 'ut_twitter_rotator' ) ) {

        function ut_twitter_rotator($atts, $content = null) {
            
            extract(shortcode_atts(array(
                
                 'avatar'        => 'off',
                 'width'        => '',
                 'count'        => '3',
                 'speed'        => '9000',
                 'autoplay'        => 'off',
                 'class'        => '',
                 'last'            => 'false',
                 ''                => ''
        
            ), $atts));
            
            /* grid settings */
            $grid = array(     'third'          => 'ut-one-third',
                               'fourth'         => 'ut-one-fourth',
                               'half'            => 'ut-one-half',
                               'fullwdith'     => '');
        
            $last = $last == 'true' ? 'ut-column-last' : '';
            
            /* fallback */
            $gridwidth = !empty($grid[$width]) ? $grid[$width] : '';
            
            /* autoplay */
            $autoplay = ($autoplay == 'off') ? 'slideshow: false,' : NULL;
            
            /* twitter options */
            $twitter_options = ( is_array( get_option('ut_twitter_options') ) ) ? get_option('ut_twitter_options') : array();
            
            /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
            $settings = array(
                'oauth_access_token' => $twitter_options['oauth_access_token'],
                'oauth_access_token_secret' => $twitter_options['oauth_access_token_secret'],
                'consumer_key' => $twitter_options['consumer_key'],
                'consumer_secret' => $twitter_options['consumer_secret']
            );
            
            if( empty($twitter_options['oauth_access_token']) || empty($twitter_options['oauth_access_token_secret']) || empty($twitter_options['consumer_key']) || empty($twitter_options['consumer_secret']) ) {
        
                return '<div class="ut-alert themecolor">' . esc_html__( 'Please make sure you have entered all necessary Twitter API Keys under Dashboard -> Settings -> Twitter' , 'ut_shortcodes') . '</div>';
        
            } else {
                
                /* config */
                $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
                $getfield = '?count=' . $count;
                $requestMethod = 'GET';
                
                $twitter = new TwitterAPIExchange($settings);
                $tweets = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
                $tweets = json_decode( $tweets );
                
                /* create twitter feed option */
                if( !get_option('ut_twitter_feed') ) {
                    add_option('ut_twitter_feed');
                }                
                
                /* update feeds */
                if( !empty( $tweets ) && !isset( $tweets->errors[0]->code ) ) {
                    update_option('ut_twitter_feed' , $tweets);
                }
                
                /* we have an error - let's use the cached feeds */
                if( empty( $tweets ) || isset( $tweets->errors[0]->code ) ) {
                    $tweets = get_option( 'ut_twitter_feed' );
                }            
                
                if( empty($tweets) ) {
                    
                    return '<div class="ut-alert themecolor">' . esc_html__('An Error has occured, no Twitter Feeds are available','ut_shortcodes') . '</div>';
                    
                } else {
                                                
                    /* set unique ID for this rotator */
                    $id = uniqid("ut_tweet_");
                    
                    /* output for slider without avatar */
                    if( $avatar == 'off' ) { 
                        
                        $script = '
                        <script type="text/javascript">
                        /* <![CDATA[ */
                        
                        (function($){
                
                            $(document).ready(function(){
                                                
                                $("#' . $id . '").flexslider({
                                    useCSS: false,  
                                    animation: "fade",
                                    directionNav:true,
                                    controlNav:false,        
                                    smoothHeight: false,
                                    animationLoop:true,
                                    ' . $autoplay . '
                                    slideshowSpeed: ' . $speed . ',
                                    prevText: "",
                                    nextText: ""   
                                });
                        
                            });
                
                        })(jQuery);
                        
                         /* ]]> */    
                        </script>';
                        
                            
                        $quote_rotator  = '<div class="ut-testimonials ut-twitter-rotator ' . $gridwidth . ' ' . $last . '">';    
                            $quote_rotator  .= '<div class="ut-rotate-quote-alt flexslider" id="' . $id . '">';    
                                $quote_rotator .= '<ul class="slides">';
                                    
                                    foreach($tweets as $tweet) :
                                        
                                        $tweetdate = new DateTime($tweet->created_at);
                                        $tweetdate = strtotime($tweetdate->format('Y-m-d H:i:s'));
                                        $currentdate = strtotime(date('Y-m-d H:i:s'));  
                                        $days = ut_twitter_time_ago($tweetdate , $currentdate);
                                        
                                        $quote_rotator .= '<li><i class="ut-rq-icon-tw fa fa-twitter fa-3x"></i><h2>' . ut_twitterify($tweet->text) . '</h2><span class="ut-quote-name">' . $tweet->user->name . esc_html__(' about ' , 'ut_shortcodes') . $days . '</span></li>';
                                    
                                    endforeach;
                                                                    
                                $quote_rotator .= '</ul>';
                            $quote_rotator .= '</div>';
                        $quote_rotator .= '</div>';
                        
                        return $script . $quote_rotator;
                    
                    }
                
                    /* output for slider with avatar */
                    if( $avatar == 'on' ) { 
                        
                        $script = '
                        <script type="text/javascript">
                        /* <![CDATA[ */
                        
                        (function($){
                
                            $(document).ready(function(){
                                
                                $("#avatarSlider_' . $id . '").flexslider({
                                    animation: "fade",
                                    directionNav:false,
                                    controlNav:false,
                                    smoothHeight: true,
                                    animationLoop:true,
                                    ' . $autoplay . '
                                    slideshowSpeed: ' . $speed . ',        
                                    slideToStart: 0,
                                    prevText: "",
                                    nextText: ""   
                                });
                                
                                $("#quoteSlider_' . $id . '").flexslider({
                                    animation: "slide",
                                    directionNav:true,
                                    controlNav:false,
                                    ' . $autoplay . '    
                                    smoothHeight: true,
                                    animationLoop:true,
                                    sync: "#avatarSlider_' . $id . '",
                                    slideshowSpeed: ' . $speed . ',            
                                    slideToStart: 0,
                                    prevText: "",
                                    nextText: ""   
                                });
                        
                            });
                
                        })(jQuery);
                        
                         /* ]]> */    
                        </script>';
                        
                        $quote_rotator  = '<div class="ut-testimonials ut-twitter-rotator ' . $gridwidth . ' ' . $last . '">';
                            $quote_rotator .= '<div class="ut-rotate-twitter-avatar flexslider" id="avatarSlider_' . $id . '">';    
                                $quote_rotator .= '<ul class="slides">';
                                    
                                    foreach($tweets as $tweet) :
                                    
                                        $avatar = preg_replace('/_normal/' , '' , $tweet->user->profile_image_url );
                                        $quote_rotator .= '<li><img alt="' . $tweet->user->name . '" class="ut-twitter-avatar" src="' . $avatar . '" /></li>';
                                    
                                    endforeach;
                                    
                                $quote_rotator .= '</ul>';            
                            $quote_rotator .= '</div>';    
                        
                            $quote_rotator  .= '<div class="ut-rotate-quote" id="quoteSlider_' . $id . '">';    
                                $quote_rotator .= '<ul class="slides">';
                                    
                                    foreach($tweets as $tweet) :
                                        
                                        $tweetdate = new DateTime($tweet->created_at);
                                        $tweetdate = strtotime($tweetdate->format('Y-m-d H:i:s'));
                                        $currentdate = strtotime(date('Y-m-d H:i:s'));  
                                        $days = ut_twitter_time_ago($tweetdate , $currentdate);                                        
                                        
                                        $quote_rotator .= '<li><h3 class="ut-quote-comment">' . ut_twitterify($tweet->text) . '</h3><span class="ut-quote-name">' . $tweet->user->name . esc_html__(' about ' , 'ut_shortcodes') . $days . '</span></li>';
                                    
                                    endforeach;                                
                                    
                                $quote_rotator .= '</ul>';
                            $quote_rotator .= '</div>';
                        $quote_rotator .= '</div>';
                        
                        return $script . $quote_rotator;
                    
                    }
            
                }
                
            }

        }
        
        add_shortcode('ut_twitter_rotator', 'ut_twitter_rotator');
        
    }
    
}



/*
 * Highlight Section
 */

if( !function_exists('ut_highlight_section') ) { 
 
    function ut_highlight_section( $atts, $content = null ) {
        
        extract(shortcode_atts(array(
             'image'            => '',
             'imagetype'        => 'portrait',
             'alt'              => '',
             'imageeffect'      => '',
             'leftboxeffect'    => '',
             'rightboxeffect'   => '',
             'animate_once'     => 'no',
             'margin_bottom'    => '',
             'class'            => ''
        ), $atts));
        
        $highlight = NULL;
        
        /* margin bottom*/
        $margin_bottom = !empty($margin_bottom) ? 'style="margin-bottom:' . $margin_bottom . 'px"' : '';
        
        /* highlight wrapper */
        $highlight .= '<div class="ut-highlight-section-wrap clearfix" ' . $margin_bottom . '>';        
        
        /* animation effect */
        $dataeffect = $animated = NULL;
        if( !empty( $leftboxeffect ) ) {

            $dataeffect = 'data-effect="' . $leftboxeffect . '" data-animateonce="' . $animate_once . '"';
            $animated   = 'ut-animate-element animated';
            
        }
        
        /* left service columns */
        $highlight .= '<div ' . $dataeffect . ' class="grid-33 tablet-grid-33 mobile-grid-100 ut-highlight-section-right ' . $animated . '">';
            
            preg_match_all( '/' . get_shortcode_regex() . '/s', $content , $left_service_boxes );
                                    
            if (is_array($left_service_boxes[2]) && !empty($left_service_boxes[2]) ) {               
                
                foreach( $left_service_boxes[2] as $key => $box) {
                    
                    if( $box == 'ut_highlight_left' && !empty( $left_service_boxes[0][$key] ) ) {                    
                        $highlight .= do_shortcode( $left_service_boxes[0][$key] );
                    }
               
                }                
            
            }
            
        $highlight .= '</div><!-- grid-33 -->';
        
        
        /* image output */
        $image_class = ( $imagetype == 'portrait' ) ? 'ut-portrait' : 'ut-landscape';
                
        $highlight .= '<div class="grid-33 tablet-grid-33 mobile-grid-100">';
            $highlight .= '<div class="ut-highlight-section-image ' . $image_class . '">';

                if( !empty($image) ) {
                    
                    /* animation effect */
                    $dataeffect = $animated = NULL;
                    if( !empty( $imageeffect ) ) {
            
                        $dataeffect = 'data-effect="' . $imageeffect . '" data-animateonce="' . $animate_once . '"';
                        $animated   = 'ut-animate-element animated';
                        
                    }
                        
                    $highlight .= '<img ' . $dataeffect . ' class="' . $animated . '" alt="' . $alt . '" src="' . $image . '">';
                
                }
        
             $highlight .= '</div>';
        $highlight .= '</div><!-- grid-33 -->';
        
        
        /* animation effect */
        $dataeffect = $animated = NULL;
        if( !empty( $rightboxeffect ) ) {

            $dataeffect = 'data-effect="' . $rightboxeffect . '" data-animateonce="' . $animate_once . '"';
            $animated   = 'ut-animate-element animated';
            
        }
        
        /* right service columns */
        $highlight .= '<div ' . $dataeffect . ' class="grid-33 tablet-grid-33 mobile-grid-100 ' . $animated . '">';
            
            preg_match_all( '/' . get_shortcode_regex() . '/s', $content , $right_service_boxes );
                                    
            if (is_array($right_service_boxes[2]) && !empty($right_service_boxes[2]) ) {               
                
                foreach( $right_service_boxes[2] as $key => $box) {
                    
                    if( $box == 'ut_highlight_right' && !empty( $right_service_boxes[0][$key] ) ) {                    
                        $highlight .= do_shortcode( $right_service_boxes[0][$key] );
                    }
               
                }                
            
            }
            
        $highlight .= '</div><!-- grid-33 -->';
        
        /* end wrap */
        $highlight .= '</div><!-- ut-highlight-section-wrap -->';  
          
        return $highlight;
        
    }
    
    add_shortcode('ut_highlight_section', 'ut_highlight_section');

}


if( !function_exists('ut_highlight_section_box') ) { 
 
    function ut_highlight_section_box( $atts, $content = null ) {
    
        extract(shortcode_atts(array(
             'title'        => '',
             'icon'         => '',
             'color'        => '',
             'class'         => ''
        ), $atts));
        
        $ut_highlight_section_box = NULL;           
        
        /* set unique ID for this rotator */
        $id = uniqid("uthsbox_");
        
        if( !empty($color) ) {
            
            $ut_highlight_section_box .= '<style type="text/css" scoped>';
                $ut_highlight_section_box .= '#' . $id . ' . ut-highlight-section-box:hover h3 { color: ' . $color . '; }';
                $ut_highlight_section_box .= '#' . $id . ' .ut-highlight-section-icon { border-color: ' . $color . '; color: ' . $color . '; }';
            $ut_highlight_section_box .= '</style>';
        
        } elseif( empty($color) ) {
        
            $accentcolor = get_option('ut_accentcolor' , '#F1C40F');
            
            $ut_highlight_section_box .= '<style type="text/css" scoped>
                #' . $id . ' . ut-highlight-section-box:hover h3 { color: ' . $accentcolor . '; }
                #' . $id . ' .ut-highlight-section-icon { border-color: ' . $accentcolor . '; color: ' . $accentcolor . '; }                
            </style>';
        
        }
        
        $ut_highlight_section_box .= '<div id="' . $id . '" class="ut-highlight-section-box">';
            
            if( !empty($icon) ) {
                $ut_highlight_section_box .= '<div class="ut-highlight-section-icon hide-on-tablet"><i class="fa ' . $icon . '"></i></div>';
            }
            
            $ut_highlight_section_box .= '<div class="ut-highlight-section-content">';
                
                if( !empty($title) ) {
                    $ut_highlight_section_box .= '<h3>' . $title . '</h3>';
                }
                
                $ut_highlight_section_box .= do_shortcode( wpautop($content) );
                
            $ut_highlight_section_box .= '</div>';
            
        $ut_highlight_section_box .= '</div>';
        
        return $ut_highlight_section_box;
        
    }
    
    add_shortcode('ut_highlight_left', 'ut_highlight_section_box');
    add_shortcode('ut_highlight_right', 'ut_highlight_section_box');    
    
}


/*
 * Video Shortcode
 */ 

if( !function_exists('ut_video_player') ) {

    function ut_video_player( $atts, $content ){
        
        extract(shortcode_atts(array(
            'url'       => '',
            'caption'   => '',
            'poster'    => '',
            'maxwidth'  => '',
            'class'     => ''
        ), $atts));
        
        if( empty($url) ) {
            return;
        }
        
        $player = NULL;
        
        /* set unique ID for this video */
        $id = uniqid("utvs_");
        
        if( !empty( $maxwidth ) ) {
            
            $player .= '<style type="text/css" scoped>
                #' . $id . ' . ut-shortcode-video-wrap { max-width: ' . $maxwidth . '% ; }
            </style>';
        
        }
        
        $player .= '<div id="' . $id . '" class="ut-shortcode-video-wrap ' . $class . '">';
        
                $player .= '<figure class="ut-video-caption">';
                
                if( !empty($poster) ) {
                    
                    $player .= '<a class="ut-load-video" data-video="' . trim($url) . '">';
                        
                        $player .= '<img alt="' . ( !empty($caption) ? $caption : esc_html__('Video','ut_shortcodes') ) . '" src="' . $poster . '" />';
                        $player .= '<i class="fa fa-youtube-play fa-4x fa-border"></i>';
                    
                    $player .= '</a>';
                    
                } else {
                    
                    $player .= '<a class="ut-load-video" data-video="' . trim($url) . '" href="#?custom=true&amp;width=' . $width . '&amp;height=' . $height . '">';
                    
                        $player .= '<i class="fa fa-youtube-play fa-4x fa-border"></i>';
                    
                    $player .= '</a>';
                    
                }
                
                if(!empty($caption)) {
                    $player .= '<figcaption class="ut-video-caption-text">' . $caption . '</figcaption></figure>';
                }
                
                $player .= '</figure>';
                
                $player .= '<div class="ut-video-loading"><i class="fa fa-spinner fa-3x fa-spin"></i></div>';
                    
        $player .= '</div>';
        
        return $player;
        
    }
    
    add_shortcode( 'ut_united_video', 'ut_video_player' );
    
}



/*
|--------------------------------------------------------------------------
| custom box
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_custom_box' ) ) {
    
    function ut_custom_box( $atts, $content ) {
        
         extract(shortcode_atts(array(
            'title'             => '',
            'logo'              => '',
            'title_color'       => '',
            'text_color'        => '',
            'border_width'      => '1',
            'border_style'      => 'solid',            
            'border_color'      => '#FFF',
            'border_radius'     => '',
            'margin_top'        => '',
            'margin_right'      => '',
            'margin_bottom'     => '',
            'margin_left'       => '',
            'padding_top'       => '',
            'padding_right'     => '',
            'padding_bottom'    => '',
            'padding_left'      => '',
            'background'        => '',
            'effect'            => '',
            'animate_once'      => 'no',
            'class'             => ''                
        ), $atts));
        
        $box   = '<div class="clear"></div>';
        $style = '';
        
        /* set unique ID for this rotator */
        $id = uniqid("utcb_");
        
        /* animation effect */
        $dataeffect = $animated = NULL;
        if( !empty( $effect ) ) {

            $dataeffect = 'data-effect="' . $effect . '" data-animateonce="' . $animate_once . '"';
            $animated   = 'ut-animate-element animated';
            
        }
        
        /* box custom css */
        $style .= '<style type="text/css" scoped>';
            
            /* title color */
            if( !empty($text_color) ) {
                $style .= '#' . $id . ' p { color: ' . $text_color . '; }';
            }
            
            /* background color */
            if( !empty($background) ) {
                $style .= '#' . $id . ' { background: ' . $background . '; }';
            }
            
            /* border settings */
            if( $border_style != 'none' ) {
                
                $border_width = str_replace('px','',$border_width);
                $style .= '#' . $id . ' { border: ' . $border_width . 'px ' . $border_style . ' ' . $border_color . ' ; }'; 
                                           
            }
            
            /* border radius */
            if( !empty($border_radius) ) {
                
                $border_radius = str_replace('px','',$border_radius);
                $style .= '#' . $id . ' { border-radius: ' . $border_radius . 'px; }'; 
                
            }
            
            /* margin */
            if( !empty($margin_top) ) {
                
                $margin_top = str_replace('px','',$margin_top);                
                $style .= '#' . $id . ' { margin-top: ' . $margin_top . 'px; }';
                
            }
            
            if( !empty($margin_right) ) {
                
                $margin_right = str_replace('px','',$margin_right);
                $style .= '#' . $id . ' { margin-right: ' . $margin_right . 'px; }'; 
                
            }
            
            if( !empty($margin_bottom) ) {
                
                $margin_bottom = str_replace('px','',$margin_bottom);
                $style .= '#' . $id . ' { margin-bottom: ' . $margin_bottom . 'px; }'; 
                
            }
            
            if( !empty($margin_left) ) {
                
                $margin_left = str_replace('px','',$margin_left);
                $style .= '#' . $id . ' { margin-left: ' . $margin_left . 'px; }'; 
                
            }
            
            /* padding */
            if( !empty($padding_top) ) {
                
                $padding_top = str_replace('px','',$padding_top);
                $style .= '#' . $id . ' { padding-top: ' . $padding_top . 'px; }'; 
                
            }
            
            if( !empty($padding_right) ) {
                
                $padding_right = str_replace('px','',$padding_right);
                $style .= '#' . $id . ' { padding-right: ' . $padding_right . 'px; }'; 
                
            }
            
            if( !empty($padding_bottom) ) {
                
                $padding_bottom = str_replace('px','',$padding_bottom);
                $style .= '#' . $id . ' { padding-bottom: ' . $padding_bottom . 'px; }'; 
                
            }
            
            if( !empty($padding_left) ) {
                
                $padding_left = str_replace('px','',$padding_left);
                $style .= '#' . $id . ' { padding-left: ' . $padding_left . 'px; }'; 
                
            }
            
            
        $style .= '</style>';
        
        /* start box */
        $box .= '<div id="' . $id . '" class="ut-custom-box ' . $class . ' clearfix ' . $animated . '" ' . $dataeffect . '>';
            
            /* box image */
            if( !empty($logo) ) {
                
                $image_title = !empty($title) ? $title : 'Custom Image';
                
                $box .= '<div class="ut-custom-box-icon">';
                    
                    $box .= '<img alt="' . $image_title . '" src="' . $logo . '" />';
                    
                $box .= '</div>';
            
            }
            
            /* box content */
            $box .= '<div class="ut-custom-box-content">';
                
                /* box title */
                if( !empty($title) ) {
                    
                    /* title color */
                    if( !empty($title_color) ) {
                        $title_color = 'style="color: ' . $title_color . ' !important;"';
                    }
                    
                    $box .= '<h3 ' . $title_color . '>' . $title . '</h3>';
                    
                }
                
                $box .= '<p>' . do_shortcode($content) . '</p>';
            
            $box .='</div>';
        
        $box .= '</div>';
        
        return $style . $box;        
                
    }
    
    add_shortcode( 'ut_custom_box', 'ut_custom_box' );

}

/*
 * Blog
 */
 
if( !function_exists('ut_create_blog') ) {  

    function ut_create_blog( $atts, $content = null ) {
        
        extract(shortcode_atts(array(
                'numberposts'     => '3',
                'excerpt'         => '',
                'cat'             => '',
                'category_name'   => '',
                'class'           => '',
                'buttontext'      => esc_html__('Read More' , 'ut_shortcodes'),
                'order'           => 'DESC'
            ), $atts));
        
        
        $args = array(
        
            'post_type'      => 'post',
            'cat'            => $cat,
            'category_name'  => $category_name,
            'posts_per_page' => $numberposts,

        );
        
        /* blog output */
        $blog = '<div class="ut-bs-wrap">';
        
            /* initiate query */
            $blog_query = new WP_Query( $args );
            
            /* start loop */
            if ($blog_query->have_posts() ) : while ($blog_query->have_posts()) : $blog_query->the_post();
                
                /* post format */
                $post_format = get_post_format();
                
                /* start single blog entry */
                $blog .= '<div class="grid-33 tablet-grid-33 mobile-grid-100"><article id="post-' . $blog_query->post->ID . '" class="' . implode( " " ,get_post_class( "clearfix" ) ) . '">'; 
                
                /* entry header ( ho headline for quotes ) */
                if( $post_format != 'quote' ) {    
                    
                    $blog .= '<!-- entry-header --><header class="entry-header">';
                    
                        $blog .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark" title="' . sprintf(esc_html__("Permanent Link to %s", "ut_shortcodes"), get_the_title() ) . '">' . get_the_title() . '</a></h3>';
                        
                    $blog .= '</header>';
                    
                }
                
                /* entry meta */
                $blog .= '<div class="entry-meta">';
    
                    $blog .= '<span class="ut-sticky"><i class="fa fa-thumb-tack"></i>' . esc_html__("Sticky Post", "ut_shortcodes") . '</span>';
                    //$blog .= '<span class="author-links"><i class="fa fa-user"></i>' . esc_html__("By", "ut_shortcodes") . ' ' . get_author_posts_link() . '</span>';
                    $blog .= '<span class="date-format"><i class="fa fa-clock-o"></i>' . esc_html__("On", "ut_shortcodes") . ' <span>' . get_the_time( get_option("date_format") ) . '</span></span>';
                    
                    if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : 
                    
                        $blog .= '<span class="comments-link"><i class="fa fa-comments-o"></i>' . esc_html__("With", "ut_shortcodes") . ' ' . ut_get_comments_popup_link( esc_html__("No Comments", "ut_shortcodes"), esc_html__("1 Comment", "ut_shortcodes"), esc_html__("% Comments", "ut_shortcodes") ) . '</span>';
                    
                    endif;
                    
                $blog .= '</div>';
                                
                /* post thumbnail */
                if ( has_post_thumbnail() && ! post_password_required() ) {    
                
                    $postthumbnail = wp_get_attachment_url( get_post_thumbnail_id( $blog_query->post->ID ) );
                    
                    $blog .= '<div class="entry-thumbnail">';
                        
                        $blog .= '<a title="' . sprintf(esc_html__('Permanent Link to %s', 'ut_shortcodes'), get_the_title()) . '" href="' . get_permalink() . '">';
                            
                            //$blog .= '<img alt="' . get_the_title() . '" class="wp-post-image" src="' . $postthumbnail . '">';
                            $blog .= get_the_post_thumbnail($blog_query->post->ID , "medium");
                            
                        $blog .= '</a>';
                        
                    $blog .= '</div>';
                    
                }    
                
                /* post format gallery */
                if( $post_format == 'gallery' && function_exists("ut_flex_slider") ) {
                    
                    $blog .= ut_flex_slider( $blog_query->post->ID , true );
                    
                    if( !empty($excerpt) && (int)$excerpt ) {
                        
                        $the_content = ut_get_excerpt_by_id( $blog_query->post->ID , $excerpt );
                        
                    } else {
                        
                        /* default content without gallery shortcode */
                        $the_content = get_the_content( '<span class="more-link">' . esc_html__( 'Read more', 'ut_shortcodes' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
                        $the_content = preg_replace( '/(.?)\[(gallery)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', $the_content ); 
                        $the_content = apply_filters( 'the_content' , $the_content );
                        
                    }
                    
                    
                } elseif ( $post_format == 'gallery' && !function_exists("ut_flex_slider") ) {
                    
                    /* default content with wordPress gallery shortcode */
                    if( !empty($excerpt) && (int)$excerpt ) {
                        
                        $the_content = ut_get_excerpt_by_id( $blog_query->post->ID , $excerpt );
                        
                    } else {
                        
                        $the_content = get_the_content( '<span class="more-link">' . esc_html__( 'Read more', 'ut_shortcodes' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
                        $the_content = apply_filters( 'the_content' , $the_content );    
                        
                    }
                
                } else {
                    
                    /* content for all other post formats */
                    if( !empty($excerpt) && (int)$excerpt ) {
                        
                        $the_content = ut_get_excerpt_by_id( $blog_query->post->ID , $excerpt );
                        
                    } else {
                        
                        $the_content = get_the_content( '<span class="more-link">' . esc_html__( 'Read more', 'ut_shortcodes' ) . '<i class="fa fa-chevron-circle-right"></i></span>' );
                        $the_content = apply_filters( 'the_content' , $the_content );
                            
                    }
                
                }
                
                /* post content */
                $blog .= '<!-- entry-content --><div class="entry-content clearfix">';
                    
                    /* add content which has been defined above */
                    $blog .= $the_content;
                
                $blog .= '</div><!-- close entry-content -->';
                                
                /* end single blog entry */
                $blog .= '</article></div><!-- close post -->';
            
            /* loop finished */
            endwhile; endif;        
            
            /* Restore original Post Data */
            wp_reset_postdata();
        
        $blog .= '<div class="clear"></div>';
        
        /* create link to blog */
        $blog_id = get_option('page_for_posts');        
        $blog .= '<div class="ut-bs-holder"><a class="ut-bs-btn" href="' . get_permalink( $blog_id ) . '">' . $buttontext . '</a></div>';
        
        
        $blog .= '</div>';
        
        return $blog;     

    }
    
    add_shortcode('ut_blog', 'ut_create_blog');
    
}

/*
* Gets the excerpt of a specific post ID or object
* @param - $post - object/int - the ID or object of the post to get the excerpt of
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
*/

if ( !function_exists( 'ut_get_excerpt_by_id' ) ) {
    
    function ut_get_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>') {
        
        if( $post ) {
            
            $post = get_post($post);
            
        } elseif(!is_object($post)) {
            
            return false;
            
        }
         
        if( has_excerpt($post->ID) ) {
            
            $the_excerpt = $post->post_excerpt;
            $the_excerpt = apply_filters('the_content', $the_excerpt);
            $the_excerpt .= '<p><a class="more-link" href="' . get_permalink($post->ID) . '"><span class="more-link">' . esc_html__('Read More' , 'ut_shortcodes') . '<i class="fa fa-chevron-circle-right"></i></span></a></p>';
            return $the_excerpt;
            
        } else {
            
            $the_excerpt = $post->post_content;
            
        }
         
        $the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
        $the_excerpt = preg_split('/\s+/', $the_excerpt, $length + 1);
        $excerpt_waste = array_pop($the_excerpt);
        $the_excerpt = implode(" ",$the_excerpt);
        
        if( isset($the_excerpt) && !empty($the_excerpt) ) {
            
            $the_excerpt  = '<p>' . $the_excerpt . '</p>';
            $the_excerpt .= '<p><a class="more-link" href="' . get_permalink($post->ID) . '"><span class="more-link">' . esc_html__('Read More' , 'ut_shortcodes') . '<i class="fa fa-chevron-circle-right"></i></span></a></p>';
            
        } else {
            
            $the_excerpt = '<p><a class="more-link" href="' . get_permalink($post->ID) . '"><span class="more-link">' . esc_html__('Read More' , 'ut_shortcodes') . '<i class="fa fa-chevron-circle-right"></i></span></a></p>';
        }

        return $the_excerpt;
        
    }
    
}

/*
 * List Icons ( Helper Shortcode )
 */ 
if( !function_exists('ut_list_icons') ) { 
 
    function ut_list_icons($content = null) {
        
        $output = '<div class="ut-icon-list">';
        $counter = 1;
            
        foreach( ut_recognized_icons() as $icon ) {
            
            $last = '';
            $clear = '';
            
            if( $counter == 5 ) { $last = 'ut-column-last'; $clear = '<div class="clear"></div>'; } 

            $output .= '<div class="ut-one-fifth ' . $last . '">
                            <p>
                                <i class="fa ' . $icon . ' icon-list-item" style="margin-right:5px;"></i> ' . $icon . '
                            </p>
                        </div>' . $clear;
            
            if( $counter == 5 ) { $counter = 1; } else { $counter++; }    
                        
                  
        }
        
        $output .= '</div>';    
            
        return $output;
        
    }
    add_shortcode('ut_list_icons', 'ut_list_icons');

}

/*
 * Helper Shortcode : Displays available atrributes for a shortcode
 */

if( !function_exists('ut_show_atts') ) { 
 
    function ut_show_atts( $atts, $content = null ) {

        extract(shortcode_atts(array(
             'shortcode' => '',
        ), $atts));
        
        include( UT_SHORTCODES_DIR . '/admin/ut.sc.definitions.php');
        
        if( empty($shortcode) ) {
            return false;
        } 
        
        global $ut_shortcodes;
        
        $return = NULL;
        
        if( !empty($ut_shortcodes[$shortcode]['attr']) && is_array($ut_shortcodes[$shortcode]['attr']) ) {
            
            $return = '<table>';
            
            $return .= '<tr>';
                $return .= '<td><h6>Attribute</h6></td>';
                $return .= '<td><h6>Values</h6></td>';
            $return .= '<tr>';
            
            foreach( $ut_shortcodes[$shortcode]['attr'] as $attr => $values ) {
                
                $return .= '<tr>';
                    
                    $return .= '<td>' . $attr . '</td>';
                    
                    /* possible attribute values */
                    if( !empty($values['values']) ) {
                        $return .= '<td>' . esc_html__('value :' , 'ut_shortcodes') . implode(' or ' , $values['values']) . '</td>';
                    }
                    
                    /* hex color */
                    if( isset( $values['type'] ) && $values['type'] == 'colorpicker' ) {
                        $return .= '<td>' . esc_html__('value : color hex' , 'ut_shortcodes') . '</td>';
                    }
                    
                    /* font awesome icon */
                    if( isset( $values['type'] ) && $values['type'] == 'icon' ) {
                        $return .= '<td>' . esc_html__('value : iconname' , 'ut_shortcodes') . ' <a href="http://faq.unitedthemes.com/brooklyn/icon-usage/available-icons/" target="_blank">' . esc_html__('list of icons names' , 'ut_shortcodes') . ' </a></td>';
                    }
                    
                    /* class info */
                    if( $attr == 'class') {
                        $return .= '<td>' . esc_html__('optional CSS class or classes' , 'ut_shortcodes') . '</td>';    
                    }
                    
                    if( isset( $values['type'] ) && $values['type'] == 'input' && $attr != 'class' ) {
                        $return .= '<td>' . esc_html__('value: custom value' , 'ut_shortcodes') . '</td>';    
                    }
                    
                    /* available effects */
                    if( isset( $values['type'] ) && $values['type'] == 'effect' ) {
                        $return .= '<td>' . esc_html__('value : effectname' , 'ut_shortcodes') . ' <a href="http://faq.unitedthemes.com/brooklyn/available-animation-effects/" target="_blank">' . esc_html__('list of effect names' , 'ut_shortcodes') . ' </a></td>';
                    }
                    
                $return .= '</tr>';
                
            }
            
            $return .= '</table>';
        
        }
        
        return $return;
        
    }
    
    add_shortcode('ut_show_atts', 'ut_show_atts');

}
?>