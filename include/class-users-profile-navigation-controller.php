<?php
if ( ! class_exists( 'Hdi_Users_Profile_Navigation_Controller' ) ) {

	class Hdi_Users_Profile_Navigation_Controller {
		public function init() {
			add_action( "edit_user_profile", array( $this, "show_users_profile_navigation" ), 100 );
			add_action( "admin_enqueue_scripts", array( $this, "register_plugin_styles" ) );
		}

		public function show_users_profile_navigation() {
			require_once( 'models/class-users-profile-navigation-model.php' );
			$hdi_users_profile_navigation_model = new Hdi_Users_Profile_Navigation_Model();
			require_once( 'views/class-users-profile-navigation-html-view.php' );
			$hdi_users_profile_navigation_view = new Hdi_Users_Profile_Navigation_Html_View();
			$hdi_users_profile_navigation_view->render_users_profile_navigation( $hdi_users_profile_navigation_model->collect_data_for_navigation() );
		}

		public function register_plugin_styles() {
			wp_register_style( 'hdi_users_nav', plugins_url( 'users-profile-navigation/assets/style.css' ) );
			wp_enqueue_style( 'hdi_users_nav' );
		}
	}

	$hdi_users_nav = new Hdi_Users_Profile_Navigation_Controller();
	$hdi_users_nav->init();
}