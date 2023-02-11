<?php 
	global $wpdb, $pmpro_membership_card_user, $pmpro_currency_symbol, $post;
	if( (in_array('small',$print_sizes)) || (in_array('Small',$print_sizes)) || (in_array('all',$print_sizes)) || empty($print_sizes) )
		$print_small = true;
	else
		$print_small = false;
		
	if( (in_array('medium',$print_sizes)) || (in_array('Medium',$print_sizes)) || (in_array('all',$print_sizes)) || empty($print_sizes) )
		$print_medium = true;
	else
		$print_medium = false;
		
	if( (in_array('large',$print_sizes)) || (in_array('Large',$print_sizes)) || (in_array('all',$print_sizes)) || empty($print_sizes) )
		$print_large = true;
	else
		$print_large = false;


?>
<style>
	/* Hide any thumbnail that might be on the page. */
	.page .attachment-post-thumbnail, .page .wp-post-image {display: none;}
	.post .attachment-post-thumbnail, .post .wp-post-image {display: none;}
	
	/* Page Styles */
	.pmpro_membership_card {
        max-width: 550px;
    }

    .pmpro_membership_card.Silver .card-inner{
        background: linear-gradient(180deg, rgb(220, 220, 220) 0%, rgb(151 151 151) 100%);
    }

    .pmpro_membership_card.Gold .card-inner{
        background: linear-gradient(180deg, rgba(255,215,0,1) 0%,rgb(198, 167, 1) 100%);
    }

    .pmpro_membership_card.Classic .card-inner{
        background: linear-gradient(180deg, rgba(89,154,255,1) 0%, rgba(54,99,171,1) 100%);
    }
		/* Print Styles */
	@media print
	{
		.page, .page .pmpro_membership_card #nav-below {visibility: hidden !important;}
		.page .pmpro_membership_card {left: 2%; position: fixed; top: 2%; visibility: visible !important; width: 96%;}
	}

    .pmpro_membership_card-print-custom .card-inner {
        width: 100%;
        aspect-ratio: 700/400;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        padding: 3%;
        background: gray;
        border-radius: 4vw;
        color: #fff;
        border: 8px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        position: relative;
    }

    .pmpro_membership_card-print-custom h1 {
        color: inherit;
        font-size: 170%;
        font-weight: 600;
        margin: 0;
        padding: 0;
    }

    .pmpro_membership_card-print-custom p {
        color: inherit;
        font-size: 90%;
        line-height: 1.5em;
    }

    .pmpro_membership_card-print-custom p strong {
        font-weight: 600;
    }

    .pmpro_membership_card-print-custom .right-content {
        width: 38%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .pmpro_membership_card-print-custom .user-image {
        width: 35%;
        height: auto;
        aspect-ratio: 1/1;
        border-radius: 2vw;
        overflow: hidden;
        border: 2px solid rgba(0, 0, 0, 0.2);
        margin-bottom: 1em;
    }

    .pmpro_membership_card-print-custom img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .pmpro_membership_card-print-custom .site-logo {
        width: 100%;
        height: auto;
        aspect-ratio: 1/1;
        border-radius: 2vw;
        overflow: hidden;
    }

    .pmpro_membership_card-print-custom .user-qr {
        width: 100%;
        height: auto;
        aspect-ratio: 1/1;
        text-align: center;
    }

    .pmpro_membership_card-print-custom .user-qr img {
        width: 80%
    }
    .pmpro_membership_card-print-custom p {
        margin: 0;
    }

    .pmpro_membership_card-print-custom .user-level {
        position: absolute;
        top: 3%;
        right: 0;
        text-align: center;
        width: 100%;
        font-weight: bold;
        font-size: 150%;
        color: #00000069;
    }

    .print-button {
        display: inline-block;
        font-size: 15px;
        background: #3a86fe;
        color: #fff;
        border: none;
        margin-bottom: 2rem;
        padding: 5px 15px;
        border-radius: 50px;
    }

</style>
<div class="pmpro_membership_card <?php pmpro_membership_card_output_levels_for_user( $pmpro_membership_card_user ); ?>">
	<?php 
		$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		if(function_exists("pmpro_getMemberStartDate") && isset( $pmpro_membership_card_user->ID ) )
			$since = pmpro_getMemberStartDate($pmpro_membership_card_user->ID);
		else
			$since = isset( $pmpro_membership_card_user->user_registered ) ? $pmpro_membership_card_user->user_registered : '';
	?>
    <div class="pmpro_membership_card-print-custom">
        <div class="card-inner">
            <div class="left-content">
                <div class="user-image">
                    <img src="<?php echo pmpro_membership_card_return_avatar_url( $pmpro_membership_card_user ); ?>" border="0"  alt="user profil image"/>
                </div>
                <div class="user-name">
                    <h1><?php echo pmpro_membership_card_get_full_name( $pmpro_membership_card_user ); ?><br/></h1>
                </div>
                <div class="user-level">
                    <?php if(function_exists("pmpro_hasMembershipLevel")) { ?>

                        <span> <?php pmpro_membership_card_output_levels_for_user( $pmpro_membership_card_user ); ?> </span>
                    <?php } ?>
                </div>
                <div class="user-since-date">
                    <?php
                    if(!empty($since))
                    {
                        ?>
                        <p><strong><?php _e( 'Member Since', 'pmpro-membership-card' ); ?>:</strong> <?php echo date_i18n(get_option("date_format"), strtotime($pmpro_membership_card_user->user_registered));?></p>
                        <?php
                    }
                    ?>
                </div>
                <div class="user-exp-date">
                    <?php if(function_exists("pmpro_hasMembershipLevel")) { ?>
                        <p><strong><?php _e("Date d'expiration", 'pmpro-membership-card');?>:</strong>
                            <?php
                            echo pmpro_membership_card_return_end_date( $pmpro_membership_card_user );
                            ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
            <div class="right-content">
                <div class="site-logo">
                    <?php
                    $featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    ?>
                    <img src="<?php echo $featured_image; ?>" border="0"  alt="site logo"/>
                </div>
                <div class="user-qr">
                    <?php if( has_action( 'pmpro_membership_card_after_card' ) ){ ?>
                        <div class="pmpro_membership_card-after">
                            <?php do_action( 'pmpro_membership_card_after_card', $pmpro_membership_card_user, $print_sizes, $qr_code, $qr_data ); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:window.print()" class="print-button"> <?php _e("Télécharger ma carte", 'pmpro-membership-card');?> </a>
</div>
<nav id="nav-below" class="navigation" role="navigation">
    <div class="nav-previous alignleft">
        <?php if(function_exists("pmpro_hasMembershipLevel") && isset( $pmpro_membership_card_user->ID ) && pmpro_hasMembershipLevel(NULL, $pmpro_membership_card_user->ID)) { ?>
            <a href="<?php echo pmpro_url("account")?>"><?php _e('&larr; Return to Your Account', 'pmpro-membership-card');?></a>
        <?php } else { ?>
            <a href="<?php echo home_url()?>">&larr;<?php _e( 'Return to Home', 'pmpro-membership-card' );?></a>
        <?php } ?>
    </div>
</nav>
<!-- end #pmpro_membership_card -->
