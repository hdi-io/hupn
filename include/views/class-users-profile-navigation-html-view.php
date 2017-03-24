<?php
namespace Hdi\Users_Profile_Navigation\Views;

class Navigation {
	public function render( $data_for_navigation ) {
		?>
        <h2>
			<?php _e( 'Users profile navigation', 'users-profile-navigation' ); ?>
        </h2>
        <div class='actions'>
			<?php
			if ( $data_for_navigation['previous_user_id'] ) {
				$prev_link = get_edit_user_link( $data_for_navigation['previous_user_id'] );
				?>
                <div><a class="button alignleft hupn-prev"
                        href='<?= $prev_link; ?>'>&larr; <?php _e( 'Previous', 'users-profile-navigation' ); ?></a>
                </div>
				<?php
			} else {
				?>
                <div class="alignleft hupn-end-of-users"></div>
				<?php
			} ?>
            <div class="hupn-count alignleft"><?php printf( __( '%1s of %2s, User ID: %3s', 'users-profile-navigation' ), $data_for_navigation['current_user_row_record_number'], $data_for_navigation['total_number_of_users'], $data_for_navigation['current_profile_page_user_id'] ); ?></div>
			<?php
			if ( $data_for_navigation['next_user_id'] ) {
				$next_link = get_edit_user_link( $data_for_navigation['next_user_id'] );
				?>
                <div><a class="button hupn-next"
                        href='<?= $next_link; ?>'><?php _e( 'Next', 'users-profile-navigation' ); ?> &rarr;</a>
                </div>
				<?php
			} else {
				?>
                <div class="hupn-end-of-users"></div>
				<?php
			}
			?>
        </div>
		<?php
	}
}
