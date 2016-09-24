<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Team_Member' ) ) {
	
    class UT_Team_Member {
        
        private $shortcode;
        private $link;
        private $social;
        private $output;
        private $name;
        private $occupation;
        private $content;
             
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_team_member';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Team Member', 'ut_shortcodes' ),
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/team-member.png',
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( 4.0 )',
                        'content_element' => true,
                        'params'          => array(
                            
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__( 'Name', 'ut_shortcodes' ),
                                'param_name'    => 'name',
                                'admin_label'   => true,
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'attach_image',
                                'heading'       => esc_html__( 'Avatar', 'ut_shortcodes' ),
                                'param_name'    => 'avatar',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__( 'Occupation', 'ut_shortcodes' ),
                                'param_name'    => 'occupation',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'textarea',
                                'heading'       => esc_html__( 'Description', 'ut_shortcodes' ),
                                'param_name'    => 'content',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'param_group',
                                'heading'       => esc_html__( 'Social Profiles', 'ut_shortcodes' ),
                                'group'         => 'General',
                                'param_name'    => 'social',
                                'params' => array(
                                    array(
                                        'type'          => 'iconpicker',
                                        'heading'       => esc_html__( 'Icon', 'ut_shortcodes' ),
                                        'param_name'    => 'icon'                                        
                                    ),
                                    array(
                                        'type'          => 'textfield',
                                        'heading'       => esc_html__( 'Title', 'ut_shortcodes' ),
                                        'admin_label'   => true,
                                        'param_name'    => 'title',
                                    ),
                                    array(
                                        'type'          => 'vc_link',
                                        'heading'       => esc_html__( 'Profile Link', 'ut_shortcodes' ),
                                        'param_name'    => 'link',
                                    ),
                                    
                                ),

                            ),
                            
                            /* box design */
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Box Style', 'ut_shortcodes' ),
								'param_name'        => 'style',
								'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'Member Style One'  , 'ut_shortcodes' ) => 'member-style-1',
                                    esc_html__( 'Member Style Two'  , 'ut_shortcodes' ) => 'member-style-2',
                                    esc_html__( 'Member Style Three', 'ut_shortcodes' ) => 'member-style-3',
                                    esc_html__( 'Member Style Four' , 'ut_shortcodes' ) => 'member-style-4',
                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Alignment', 'ut_shortcodes' ),
								'param_name'        => 'align',
                                'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'center', 'ut_shortcodes' ) => 'center',
                                    esc_html__( 'left'  , 'ut_shortcodes' ) => 'left',
                                    esc_html__( 'right' , 'ut_shortcodes' ) => 'right',
                                ),
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1' ),
                                ),
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Name Color', 'ut_shortcodes' ),
								'param_name'        => 'name_color',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Occupation Color', 'ut_shortcodes' ),
								'param_name'        => 'ocupation_color',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Description Color', 'ut_shortcodes' ),
								'param_name'        => 'description_color',
								'group'             => 'Box Design',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1','member-style-2' ),
                                ),
                                
						  	),                            
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Decoration Line Color', 'ut_shortcodes' ),
								'param_name'        => 'line_color',
								'group'             => 'Box Design',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1','member-style-2' ),
                                ),
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Social Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_color',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Social Icon Hover Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_color_hover',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Overlay Color', 'ut_shortcodes' ),
								'param_name'        => 'overlay_color',
								'group'             => 'Box Design',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-3','member-style-4' ),
                                ),
						  	),
                            /* css */
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
        
        function create_member_box_style_one() {
            
            $this->output .= '<div class="bklyn-team-member-info">';
                    
                if( $this->name ) {        
                    
                    $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                    
                }
                
                if( $this->occupation ) {
                    
                    $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                    
                }
                
                if( $this->content ) {
                    
                    $this->output .= '<p class="bklyn-team-member-description">' . $this->content . '</p>';
                    
                }
                
            $this->output .= '</div>';
            
            $this->create_social_link();
               
        }
        
        
        function create_member_box_style_two() {
            
            $this->output .= '<div class="bklyn-team-member-info">';
                    
                if( $this->name ) {        
                    $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                }
                
                if( $this->occupation ) {
                    $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                }
                
                if( $this->content ) {
                    $this->output .= '<p class="bklyn-team-member-description">' . $this->content . '</p>';
                }
                
            $this->output .= '</div>';
            
            $this->create_social_link();
               
        }
        
        function create_member_box_style_three() {
            
            $this->output .= '<div class="bklyn-team-member-overlay">';
                
                $this->output .= '<div class="bklyn-team-member-overlay-caption">';
                    
                    $this->output .= '<div class="bklyn-team-member-info">';
                    
                        if( $this->name ) {        
                            $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                        }
                        
                        if( $this->occupation ) {
                            $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                        }
                        
                        $this->create_social_link();
                            
                    $this->output .= '</div>';
            
                $this->output .= '</div>';
                
            $this->output .= '</div>';                
               
        }
        
        function create_member_box_style_four() {
            
             $this->output .= '<div class="bklyn-team-member-overlay">';
                
                $this->output .= '<div class="bklyn-team-member-overlay-caption">';
                    
                    $this->output .= '<div class="bklyn-team-member-info">';
                    
                        if( $this->name ) {        
                            $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                        }
                        
                        if( $this->occupation ) {
                            $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                        }
                        
                        $this->create_social_link();
                            
                    $this->output .= '</div>';
            
                $this->output .= '</div>';
                
            $this->output .= '</div>';           
               
        }
        
        
        function create_social_link() {
            
            if( !empty( $this->social ) && is_array( $this->social ) ) {
                    
                $this->output .= '<div class="bklyn-team-member-social-icons">';
                    
                    $this->output .= '<ul>';
                        
                        foreach( $this->social as $profile ) {
                            
                            if( !empty( $profile['link'] ) ) {
                            
                                /* link settings */
                                $link = vc_build_link( $profile['link'] );
                                
                                $url    = !empty( $link['url'] )    ? $link['url'] : '#';
                                $target = !empty( $link['target'] ) ? $link['target'] : '_self';
                                $title  = !empty( $link['title'] )  ? $link['title'] : '';
                                $rel    = !empty( $link['rel'] )    ? 'rel="' . esc_attr( trim( $link['rel'] ) ) . '"' : '';
                                
                                /* profile icon */
                                $icon   = !empty( $profile['icon'] )?  $profile['icon'] : 'fa fa-circle';
                                       
                                $this->output .= '<li>';
                                    $this->output .= '<a title="' . esc_attr( $title ) . '" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" ' . $rel . '><i class="' . esc_attr( $icon ) . '"></i></a>';
                                $this->output .= '</li>';
                            
                            }
                        
                        }
                        
                    $this->output .= '</ul>';
                
                $this->output .= '</div>';
            
            }
        
        }        
        
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'style'             => 'member-style-1',
                'align'             => 'center',
                'avatar'            => '',
                'name'              => '',
                'name_color'        => '',
                'line_color'        => '',
                'occupation'        => '',
                'ocupation_color'   => '',
                'description_color' => '',
                'social'            => '',
                'icon_color'        => '',
                'icon_color_hover'  => '',
                'overlay_color'     => '',
                'css'               => ''
            ), $atts ) ); 
            
            $this->name       = $name;
            $this->occupation = $occupation;
            $this->content    = $content;
                        
            /* extract social items */
            if( function_exists('vc_param_group_parse_atts') && !empty( $social ) ) {
                
                $this->social = vc_param_group_parse_atts( $social );    
                            
            }            
            
            /* avatar */
            $image_meta = get_post( $avatar );
            $alt        = '';
            
            if( get_post( $avatar ) ) {
                $alt = $image_meta->post_title;
            }
            
            if( $style == 'member-style-2' ) {
            
                $avatar = ut_resize( wp_get_attachment_url( $avatar ) , '280', '280', true, true, true );
                
            } else {
            
                $avatar = ut_resize( wp_get_attachment_url( $avatar ) , '800', '600', true, true, true );
            
            }            
                        
            /* fallback */
            if( empty( $avatar ) ) {
                
                $avatar = vc_asset_url( 'vc/no_image.png' );
                
            }
            
            
            /* unique listz ID */
            $id = uniqid("ut_tm_");
            
            $css_style = '<style type="text/css" scoped>';
                
                if( $name_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-name { color: ' . $name_color . '; }'; 
                }
                
                if( $line_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons { border-color: ' . $line_color . '; }'; 
                }
                
                if( $ocupation_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-ocupation { color: ' . $ocupation_color . '; }'; 
                }
                
                if( $description_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-description { color: ' . $description_color . '; }'; 
                }
                
                if( $icon_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a { color: ' . $icon_color . '; }';
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:visited { color: ' . $icon_color . '; }';  
                }
                
                if( $icon_color_hover ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:hover { color: ' . $icon_color_hover . '; }';
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:focus { color: ' . $icon_color_hover . '; }'; 
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:active { color: ' . $icon_color_hover . '; }';  
                }
                
                if( $overlay_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-overlay { background: ' . $overlay_color . '; }'; 
                }
                
            $css_style.= '</style>';
            
            /* start output */
            $this->output = '';
            
            $this->output .= ut_minify_inline_css( $css_style );
            
            $this->output .= '<div id="' . esc_attr( $id ) . '" class="bklyn-team-member bklyn-team-' . esc_attr( $style ) . ' bklyn-team-member-' . $align . '">';
                
                if( !empty( $avatar ) ) {
                
                    $this->output .= '<div class="bklyn-team-member-avatar">';
                        
                        $this->output .= '<img alt="' . esc_attr( $alt ) . '" src="' . esc_url( $avatar ) .  '">';
                        
                    $this->output .= '</div>';
                
                }  
                
                if( $style == 'member-style-1' ) {
                    $this->create_member_box_style_one();    
                }
                
                if( $style == 'member-style-2' ) {
                    $this->create_member_box_style_two();
                }
                
                if( $style == 'member-style-3' ) {
                    $this->create_member_box_style_three();
                }
                
                if( $style == 'member-style-4' ) {
                    $this->create_member_box_style_four();
                }
                
            $this->output .= '</div>';
            
            return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $this->output . '</div>';
        
        }
            
    }

}

new UT_Team_Member;