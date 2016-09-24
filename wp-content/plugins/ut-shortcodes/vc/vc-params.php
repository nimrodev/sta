<?php

/*
 * Range Slider 
 *
 * since 4.0
 */


if( !function_exists('ut_add_vc_range_slider_param_type') ) :

    function ut_add_vc_range_slider_param_type( $settings, $value ) {
        
        $value = empty( $value ) && $value != 0 ? 0 : $value;
        
        $out = '<div class="ut_range_slider_block">'; 
            
            $out .= '<div class="ut-range-slider-wrap">';
                
                $out .= '<div data-value="' . esc_attr( $value ) . '" data-min="' . esc_attr( $settings['value']['min'] ) . '" data-max="' . esc_attr( $settings['value']['max'] ) . '" data-step="' . esc_attr( $settings['value']['step'] ) . '" data-for="ut_range_slider_' . esc_attr( $settings['param_name'] ) . '" class="ut-range-slider"></div>';
                $out .= '<span data-unit="' . esc_attr( $settings['value']['unit'] ) . '" class="ut-range-value">' . esc_attr( $value ) . '</span>';
                $out .= '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />';
            
            $out .= '</div>'; 
                
        $out .= '</div>'; 
        
        return $out; 
        
    }    
    
    vc_add_shortcode_param( 'range_slider', 'ut_add_vc_range_slider_param_type', UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/range-slider.js' );

endif;