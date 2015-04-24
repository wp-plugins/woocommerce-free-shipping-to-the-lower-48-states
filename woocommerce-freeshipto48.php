<?php
/*
Plugin Name: WooCommerce - Free Shipping to Lower 48
Plugin URI: http://dunfordenterprises.com
Description: Free Shipping only to the lower 48 states in WooCommerce
Version: 0.1
Author: Jonathon Dunford
Author Email: jonathon@dunfordenterprises.com
License:

  Copyright 2011 Jonathon Dunford (jonathon@dunfordenterprises.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class WooCommerce_FreeShippingtoLower48 {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'WooCommerce - Free Shipping to Lower 48';
	const slug = 'woocommerce-freeshipto48';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_woocommerce_freeshipto48' ) );
	}
  
	/**
	 * Runs when the plugin is activated
	 */  
	function install_woocommerce_freeshipto48() {
		// do not generate any output here
	}
	
	function init_woocommerce_freeshipto48() {		
		add_filter( 'woocommerce_shipping_free_shipping_is_available', array(&$this, 'restrict_free_shipping'));
		add_filter( 'woocommerce_shipping_flat_rate_is_available', array(&$this, 'restrict_flat_rate'));
	}
  
	/**
	 * Runs when the plugin is initialized
	 */
	 
	 /**
	 * Limit the availability of this shipping method based on the destination state
	 *
	 * Restricted locations include Alaska, American Samoa, Guam, Hawaii, North Mariana Islands, Puerto Rico,
	 * US Minor Outlying Islands, and the US Virgin Islands
	 *
	 * @param bool $is_available Is this shipping method available?
	 * @return bool
	 */
	function restrict_free_shipping( $is_available ) {
	  $restricted = array( 'AK', 'AS', 'GU', 'HI', 'MP', 'PR', 'UM', 'VI' );
	  foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted ) ) {
		  return false;
		}
	  }
	  return $is_available;
	}
	
	//flat rate only if not in lower 48 and not international
	function restrict_flat_rate( $is_available ) {
	  $restricted = array( 'AK', 'AS', 'GU', 'HI', 'MP', 'PR', 'UM', 'VI' );
	  foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( !in_array( $package['destination']['state'], $restricted ) ) {
		  return false;
		}
	  }
	  return $is_available;
	}
  
} // end class
new WooCommerce_FreeShippingtoLower48();

?>