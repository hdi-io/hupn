<?php
namespace Hdi\Users_Profile_Navigation\Controllers;

use Hdi\Users_Profile_Navigation\Models\Model;
use Hdi\Users_Profile_Navigation\Views\Navigation;

class Main {
	public function init() {
		add_action( "plugins_loaded", array( $this, "load_textdomain" ) );
		add_action( "edit_user_profile", array( $this, "show_users_profile_navigation" ), 100 );
		add_action( "admin_enqueue_scripts", array( $this, "register_plugin_styles" ) );
	}

	public function show_users_profile_navigation() {
		require_once( 'models/class-users-profile-navigation-model.php' );
		$model = new Model();
		require_once( 'views/class-users-profile-navigation-html-view.php' );
		$navigation = new Navigation();
		$navigation->render( $model->collect_data_for_navigation() );
	}

	public function register_plugin_styles() {
		wp_register_style( 'hdi_users_profile_navigation', plugins_url( 'users-profile-navigation/assets/style.css' ) );
		wp_enqueue_style( 'hdi_users_profile_navigation' );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'users-profile-navigation', false, "users-profile-navigation/languages" );
	}
}

$hdi_users_profile_navigation = new Main();
$hdi_users_profile_navigation->init();