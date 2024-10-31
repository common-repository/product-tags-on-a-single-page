<?php

/**
 * Provide a Settings view for the plugin
 */

 //Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptsp_active = get_option( 'ptsp_active' );
	if (( $ptsp_active != 'no' )&&($ptsp_active != 'yes')) {
		update_option( 'ptsp_active', 'yes' );
	}

	if ( !current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	$ptsp_active = get_option( 'ptsp_active' );	
    $ptsp_products_per_tag = get_option( 'ptsp_products_per_tag' );	
    $ptsp_columns = get_option( 'ptsp_columns' );	
    $ptsp_num = get_option( 'ptsp_num' );
    $ptsp_bootstrap = get_option( 'ptsp_bootstrap' );
	if ( !$ptsp_active ) $ptsp_active = 'yes';
    if ( !$ptsp_products_per_tag ) $ptsp_products_per_tag = '0';
    if ( !$ptsp_columns ) $ptsp_columns = '1';
    if ( !$ptsp_num ) $ptsp_num = 'yes';
    if ( !$ptsp_bootstrap ) $ptsp_bootstrap = 'no';
    
	if ( isset($_POST[ 'ptsp_submit_hidden' ]) && $_POST[ 'ptsp_submit_hidden' ] == 'Y' && wp_verify_nonce( $_POST['ptsp_submit_nonce_field'], 'ptsp_submit_action' ) ) {
		if ( isset( $_POST[ 'ptsp_active' ] ) ) $ptsp_active = filter_var ( $_POST[ 'ptsp_active' ], FILTER_SANITIZE_STRING ); else $ptsp_active = 'yes';
		if ( isset( $_POST[ 'ptsp_products_per_tag' ] ) ) $ptsp_products_per_tag = filter_var ( $_POST[ 'ptsp_products_per_tag' ], FILTER_SANITIZE_STRING ); else $ptsp_products_per_tag = '1';
		if ( isset( $_POST[ 'ptsp_columns' ] ) ) $ptsp_columns = filter_var ( $_POST[ 'ptsp_columns' ], FILTER_SANITIZE_STRING ); else $ptsp_columns = '1';
		if ( isset( $_POST[ 'ptsp_num' ] ) ) $ptsp_num = filter_var ( $_POST[ 'ptsp_num' ], FILTER_SANITIZE_STRING ); else $ptsp_num = 'yes';
		if ( isset( $_POST[ 'ptsp_bootstrap' ] ) ) $ptsp_bootstrap = filter_var ( $_POST[ 'ptsp_bootstrap' ], FILTER_SANITIZE_STRING ); else $ptsp_bootstrap = 'no';
	update_option( 'ptsp_active', $ptsp_active );
	update_option( 'ptsp_products_per_tag', $ptsp_products_per_tag );
	update_option( 'ptsp_columns', $ptsp_columns );	
	update_option( 'ptsp_num', $ptsp_num );		
	update_option( 'ptsp_bootstrap', $ptsp_bootstrap );	

	}

?>
<h1><?php echo $this->plugin_name; ?></h1>
<form name="form1" method="post" action="">
	<?php  wp_nonce_field( 'ptsp_submit_action', 'ptsp_submit_nonce_field' ); ?>
		<input type="hidden" name="ptsp_submit_hidden" value="Y">
	<table>
				<tr>
					<td><strong><?php echo __( 'Enable Plugin', 'product-tags-single-page' ); ?></strong><br /> <?php echo __( 'Enable or disable the plugin', 'product-tags-single-page' ); ?></td>
					<td>
						<input type="radio" name="ptsp_active" value="yes"<?php echo ($ptsp_active=='yes' ? ' checked' : ''); ?>><span><strong><?php _e( 'Enable', 'product-tags-single-page' ); ?></strong></span></td>
					<td>	
						<input type="radio" name="ptsp_active" value="no"<?php echo ($ptsp_active!='yes' ? ' checked' : ''); ?>><span><?php _e( 'Disable', 'product-tags-single-page' ); ?></span></td>				
					
				</tr>	
		       <tr>
					<td><strong><?php echo __( 'Min Products per Tag', 'product-tags-single-page' ); ?></strong><br /> <?php echo __( 'How many products must have a same tag to be shown', 'product-tags-single-page' ); ?></td>
					<td colspan="2">
						<select name='ptsp_products_per_tag'>
		<option value='0' <?php echo ($ptsp_products_per_tag=='0' ? ' selected' : ''); ?>>Show All</option>					
		<option value='1' <?php echo ($ptsp_products_per_tag=='1' ? ' selected' : ''); ?>>1</option>
		<option value='2' <?php echo ($ptsp_products_per_tag=='2' ? ' selected' : ''); ?>>2</option>
							<option value='3' <?php echo ($ptsp_products_per_tag=='3' ? ' selected' : ''); ?>>3</option>
							<option value='4' <?php echo ($ptsp_products_per_tag=='4' ? ' selected' : ''); ?>>4</option>
							<option value='5' <?php echo ($ptsp_products_per_tag=='5' ? ' selected' : ''); ?>>5</option>
							<option value='6' <?php echo ($ptsp_products_per_tag=='6' ? ' selected' : ''); ?>>6</option>
							<option value='7' <?php echo ($ptsp_products_per_tag=='7' ? ' selected' : ''); ?>>7</option>
							<option value='8' <?php echo ($ptsp_products_per_tag=='8' ? ' selected' : ''); ?>>8</option>
							<option value='9' <?php echo ($ptsp_products_per_tag=='9' ? ' selected' : ''); ?>>9</option>
							<option value='10' <?php echo ($ptsp_products_per_tag=='10' ? ' selected' : ''); ?>>10</option>
							<option value='25' <?php echo ($ptsp_products_per_tag=='25' ? ' selected' : ''); ?>>25</option>
							<option value='50' <?php echo ($ptsp_products_per_tag=='50' ? ' selected' : ''); ?>>50</option>
							<option value='100' <?php echo ($ptsp_products_per_tag=='100' ? ' selected' : ''); ?>>100</option>
	</select></td>	
				</tr>
	         <tr>
					<td><strong><?php echo __( 'Show Counter', 'product-tags-single-page' ); ?></strong><br /> <?php echo __( 'Show product quantity for each tag', 'product-tags-single-page' ); ?></td>
					<td>
						<input type="radio" name="ptsp_num" value="yes"<?php echo ($ptsp_num=='yes' ? ' checked' : ''); ?>><span><strong><?php _e( 'Enable', 'product-tags-single-page' ); ?></strong></span></td>
					<td>	
						<input type="radio" name="ptsp_num" value="no"<?php echo ($ptsp_num!='yes' ? ' checked' : ''); ?>><span><?php _e( 'Disable', 'product-tags-single-page' ); ?></span></td>
				</tr>	
		      <tr>
					<td><strong><?php echo __( 'Columns to Display Tags', 'product-tags-single-page' ); ?></strong><br /> <?php echo __( 'How many columns to use to display a product tag listing', 'product-tags-single-page' ); ?></td>
					<td colspan="2">
						<select name='ptsp_columns'>
		<option value='1' <?php echo ($ptsp_columns=='1' ? ' selected' : ''); ?>>1</option>					
		<option value='2' <?php echo ($ptsp_columns=='2' ? ' selected' : ''); ?>>2</option>
		<option value='3' <?php echo ($ptsp_columns=='3' ? ' selected' : ''); ?>>3</option>
	</select></td>		
				</tr>
		<tr>
					<td><strong><?php echo __( 'Enable Bootstrap Wrapper', 'product-tags-single-page' ); ?></strong><br /> <?php echo __( 'Enable Bootstrap  wrapper if you use Bootstrap based theme', 'product-tags-single-page' ); ?></td>
					<td>
						<input type="radio" name="ptsp_bootstrap" value="yes"<?php echo ($ptsp_bootstrap=='yes' ? ' checked' : ''); ?>><span><strong><?php _e( 'Enable', 'product-tags-single-page' ); ?></strong></span></td>
					<td>	
						<input type="radio" name="ptsp_bootstrap" value="no"<?php echo ($ptsp_bootstrap!='yes' ? ' checked' : ''); ?>><span><?php _e( 'Disable', 'product-tags-single-page' ); ?></span></td>
				</tr>	
		</table>
		<p>
			<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
		</p>
	</form>
<div id="answer"></div>
<?php
	if ( isset($_POST[ 'ptsp_submit_hidden' ]) && $_POST[ 'ptsp_submit_hidden' ] == 'Y') {
	echo '<div style="color:green;font-weight:bold;">Saved!</div>';
	}
?>


