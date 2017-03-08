<?php

if ( ! class_exists( 'Hdi_Users_Profile_Navigation_Model' ) ) {
	class Hdi_Users_Profile_Navigation_Model {

		private $current_user_id = '';
		private $profile_page_user_id = '';
		private $total_number_of_users = '';

		public function __construct() {
			$this->current_user_id       = get_current_user_id();
			$this->profile_page_user_id  = $_GET['user_id'];
			$this->total_number_of_users = count_users()['total_users'];
		}

		public function collect_data_for_navigation() {
			$query_string_for_next_profile_page_user_id     = "SELECT ID FROM wp_users WHERE ID = (SELECT min(ID) FROM wp_users WHERE ID > $this->profile_page_user_id AND ID != $this->current_user_id)";
			$query_string_for_previous_profile_page_user_id = "SELECT ID FROM wp_users WHERE ID = (SELECT max(ID) from wp_users where ID < $this->profile_page_user_id AND ID != $this->current_user_id)";
			$data_for_navigation                            = [];

			$data_for_navigation['current_profile_page_user_id'] = $this->profile_page_user_id;
			$data_for_navigation['previous_user_id'] = $this->get_profile_page_users_id_from_query( $query_string_for_previous_profile_page_user_id );
			$data_for_navigation['next_user_id'] = $this->get_profile_page_users_id_from_query( $query_string_for_next_profile_page_user_id );
			$data_for_navigation['total_number_of_users']        = $this->total_number_of_users;

			return $data_for_navigation;
		}

		private function get_profile_page_users_id_from_query( $query_string_for_profile_page_user_id ) {
			global $wpdb;
			$query_result = $wpdb->get_results( $query_string_for_profile_page_user_id );
			if ( count( $query_result ) == 1 ) {
				$profile_page_users_id = $query_result[0]->ID;
			} else {
				$profile_page_users_id = '';
			}

			return $profile_page_users_id;
		}
	}
}