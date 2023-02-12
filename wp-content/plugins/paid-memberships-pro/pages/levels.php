<?php
/**
 * Template: Levels
 *
 * See documentation for how to override the PMPro templates.
 * @link https://www.paidmembershipspro.com/documentation/templates/
 *
 * @version 2.0
 *
 * @author Paid Memberships Pro
 */
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;

$pmpro_levels = pmpro_sort_levels_by_order( pmpro_getAllLevels(false, true) );
$pmpro_levels = apply_filters( 'pmpro_levels_array', $pmpro_levels );

if($pmpro_msg)
{
?>
<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<table id="pmpro_levels_table" class="<?php echo pmpro_get_element_class( 'pmpro_table pmpro_checkout', 'pmpro_levels_table' ); ?>">
<thead>
  <tr>
	<th><?php esc_html_e("Choisir un niveau d'adhésion", 'paid-memberships-pro' );?></th>
	<th>&nbsp;</th>
  </tr>
</thead>
<tbody>
	<?php	
	$count = 0;
	$has_any_level = false;
	foreach($pmpro_levels as $level)
	{
		$user_level = pmpro_getSpecificMembershipLevelForUser( $current_user->ID, $level->id );
		$has_level = ! empty( $user_level );
		$has_any_level = $has_level ?: $has_any_level;
	?>
	<tr class="level <?php echo "{$level->name}" ?> <?php if($count++ % 2 == 0) { ?>odd<?php } ?><?php if( $has_level ) { ?> active<?php } ?>">
		<td class="level__name">
            <?php echo $has_level ? "<strong>{$level->name}</strong>" : $level->name?>
            <?php echo "<img class='level__image' src='" . get_site_url() . "/wp-content/uploads/2023/02/card-photo-{$level->name}.png' />"?>
        </td>
		<td class="level__detail">
			<?php
				$cost_text = pmpro_getLevelCost($level, true, true); 
				$expiration_text = pmpro_getLevelExpiration($level);
				if(!empty($cost_text) && !empty($expiration_text))
					echo $cost_text . "<br />" . $expiration_text;
				elseif(!empty($cost_text))
					echo $cost_text;
				elseif(!empty($expiration_text))
					echo $expiration_text;
			?>
		</td>
		<td class="level__action">
		<?php if ( ! $has_level ) { ?>                	
			<a class="<?php echo pmpro_get_element_class( 'pmpro_btn pmpro_btn-select', 'pmpro_btn-select' ); ?>" href="<?php echo esc_url( pmpro_url( "checkout", "?level=" . $level->id, "https" ) ) ?>"><?php esc_html_e('Select', 'paid-memberships-pro' );?></a>
		<?php } else { ?>      
			<?php
				//if it's a one-time-payment level, offer a link to renew	
				if( pmpro_isLevelExpiringSoon( $user_level ) && $level->allow_signups ) {
					?>
						<a disabled class="<?php echo pmpro_get_element_class( 'pmpro_btn pmpro_btn-select', 'pmpro_btn-select' ); ?>" href="<?php echo esc_url( pmpro_url( "checkout", "?level=" . $level->id, "https" ) ) ?>"><?php esc_html_e('Renew', 'paid-memberships-pro' );?></a>
					<?php
				} else {
					?>
						<a class="<?php echo pmpro_get_element_class( 'pmpro_btn disabled', 'pmpro_btn' ); ?>" href="<?php echo esc_url( pmpro_url( "account" ) ) ?>"><?php esc_html_e('Your&nbsp;Level', 'paid-memberships-pro' );?></a>
					<?php
				}
			?>
		<?php } ?>
		</td>
	</tr>
	<?php
	}
	?>
</tbody>
</table>
<p class="<?php echo pmpro_get_element_class( 'pmpro_actions_nav' ); ?>">
	<?php if( $has_any_level ) { ?>
		<a href="<?php echo esc_url( pmpro_url("account" ) ) ?>" id="pmpro_levels-return-account">&larr; <?php esc_html_e('Return to Your Account', 'paid-memberships-pro' );?></a>
	<?php } else { ?>
		<a href="<?php echo esc_url( home_url() ) ?>" id="pmpro_levels-return-home">&larr; <?php esc_html_e('Return to Home', 'paid-memberships-pro' );?></a>
	<?php } ?>
</p> <!-- end pmpro_actions_nav -->
