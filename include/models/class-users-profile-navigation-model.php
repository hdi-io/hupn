<?php
namespace Hdi\Users_Profile_Navigation\Models;

class Model {

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

		$data_for_navigation['current_profile_page_user_id']   = $this->profile_page_user_id;
		$data_for_navigation['previous_user_id']               = $this->get_profile_page_users_id_from_query( $query_string_for_previous_profile_page_user_id );
		$data_for_navigation['next_user_id']                   = $this->get_profile_page_users_id_from_query( $query_string_for_next_profile_page_user_id );
		$data_for_navigation['total_number_of_users']          = $this->total_number_of_users;
		$data_for_navigation['current_user_row_record_number'] = $this->get_current_user_row_record_number( $this->profile_page_user_id );

		return $data_for_navigation;
	}

	private function get_profile_page_users_id_from_query( $query_string_for_profile_page_user_id ) {
		global $wpdb;
		$query_result = $wpdb->get_results( $query_string_for_profile_page_user_id );
		if ( count( $query_result ) == 1 ) {
			$profile_page_users_id = $query_result[0]->ID;
		} else {
			$profile_page_users_id = null;
		}

		return $profile_page_users_id;
	}

	private function get_current_user_row_record_number( $profile_page_user_id ) {
		global $wpdb;
		$query_result = $wpdb->get_results( "SELECT num FROM (SELECT @row_number:=@row_number + 1 AS num, ID FROM wp_users, (SELECT @row_number:=0) as t ORDER BY ID ASC) as t2 WHERE ID = $profile_page_user_id;" );

		return $query_result[0]->num;
	}
}
