<?php
/*
* Plugin Name: Product Tags on a Single Page
* Plugin URI:
* Description: A simple plugin to list all Woocommerce product tags on a single page.
* Version: 1.0.1
* Author: Peter Petrenko
* Author URI: https://petrenko.net
* License: GPLv3 or later
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: product-tags-single-page

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PTSPPlugin {
    
    private $plugin_name = "Product Tags on Single Page";
    private $text_domain = 'product-tags-single-page';    
    
    function __construct() {		
		    
		$this->public_hooks();
		$this->admin_hooks();

	}
        
        private function public_hooks() {

		// Adding shortcode
		add_action('init', array( $this, 'wooc_shortcode_init'));
	}

	   private function admin_hooks() {

	        if ( ! is_admin() ) {
		     	return;
	        }
		    
	        add_action( 'admin_menu', array( $this, 'add_menu_to_admin_settings' ));           
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_action_links' ));
	}		
         
        public function add_menu_to_admin_settings() {        
			   
                 add_options_page(
                                esc_html__('Product Tags on Single Page', 'product-tags-single-page'),
                                esc_html__('Product Tags on Single Page', 'product-tags-single-page'),
                                'manage_options',
                                $this->text_domain, array($this, 'display_plugin_setup_page')
                                );      
        }
                
        public function add_action_links( $links ) {
     
                 $settings_link = array(
                      '<a href="' . admin_url( 'options-general.php?page=' . $this->text_domain ) . '">' . __('Settings', $this->text_domain) . '</a>',
                        );
             return array_merge(  $settings_link, $links );

        }
        
        public function display_plugin_setup_page() {
            
               include_once( 'product-tags-single-page-public-display.php' );
        }	
                
        public function wooc_shortcode_init()   {
            
	    function wooc_shortcode($atts = [], $html = null)
              {      
               $terms = get_terms( array( 
               'hide_empty' => false, 
               'taxonomy' => 'product_tag',
               ) 
              );	
     
	    if($terms){		 
		
          
	   $ptsp_products_per_tag = get_option( 'ptsp_products_per_tag'); 
	   $ptsp_columns = get_option( 'ptsp_columns');
	   $ptsp_num = get_option( 'ptsp_num'); 
	   $ptsp_bootstrap = get_option( 'ptsp_bootstrap'); 	 
		   
		if (!$ptsp_products_per_tag)   $ptsp_products_per_tag == 0;
		if (!$ptsp_columns)   $ptsp_columns == 3;
		if (!$ptsp_num)   $ptsp_num == 'yes';
		if (!$ptsp_bootstrap)   $ptsp_bootstrap == 'no'; 
		
		$temp_count = 0;
			foreach($terms as $term){     
				
             if($term->count >=$ptsp_products_per_tag   ) { 
				             $temp_count++;}             
			}	
		
        $one_half=floor($temp_count/2);
	    $one_third=floor($temp_count/3);
		 
	   if   ($ptsp_bootstrap == 'no') {
		  if ($ptsp_columns < 3) {
			        	 $html = '<table width="100%"><tr><td width="50%">';	
						}
	   else  {
			        	$html = '<table width="100%"><tr><td width="34%">';
						}
	   
	   }
		 
	   else {	 
	       if ($ptsp_columns == 2) {
			        	 $html = '<div class="container"><div class="row"><div class="col-6">';	
						}
	       elseif ($ptsp_columns == 3) {
			        	 $html = '<div class="container"><div class="row"><div class="col-4">';	
						}
	       else     $html = '<div class="container"><div class="row"><div class="col-12">';
	  }
		 
	  $tag_number=1;
	    	
	    	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
				
               foreach($terms as $term){
			 
			      $tag_title = $term->name; // tag name
                  $tag_link = get_term_link( $term );// tag archive link
			      $tag_count = $term->count; // tag usage
				   
			     	if ($tag_count<$ptsp_products_per_tag) { 
					   continue;
					   }
				   
				  if ($ptsp_num =='yes') { 
				   $html .= '<li><a href="'.$tag_link.'">'.$tag_title.'</a> - '.$tag_count. '</li>';
                  } 
		          else $html .= '<li><a href="'.$tag_link.'">'.$tag_title.'</a></li>';
				   
				  if (($ptsp_columns == 3) && ($tag_number == $one_third || $tag_number == $one_third*2) ) {					   
			        
					  if    ($ptsp_bootstrap == 'no') {
						  $html .= '</td><td width="33%">';
					  } 
					  else 
					  {
					   $html .= '</div><div class="col-4">';	
					  }
						
		          }	
				  if ($ptsp_columns == 2 && $tag_number == $one_half) {
					 
						if    ($ptsp_bootstrap == 'no') {
						  $html .= '</td><td width="50%">';
					  } 
					  else 
					  {
			        	 $html .= '</div><div class="col-6">';	
					  }
		          }	 
		    
		      $tag_number++;	
             }
		 }	
		 if   ($ptsp_bootstrap == 'no') {
			  $html .= '</td></tr></table>';
		 } 
		 else         $html .= '</div></div></div>';
		
      }
			
	  echo $html;
      }
	 
    add_shortcode('woocshcd', 'wooc_shortcode');
	}        
     
}

$enable = get_option( 'ptsp_active'); // check if the plugin enabled in Settings.
if ($enable != 'no' ) {
$obj = new PTSPPlugin();
}