<?php
/**
 * Created by PhpStorm.
 * User: judah
 * Date: 1/4/17
 * Time: 4:46 PM
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Users_List extends WP_List_Table {

    public function __construct()
    {
        parent::__construct([
            'singular' => 'User',
            'plural' => 'Users',
            'ajax' => false
        ]);
    }

    public static function get_users($per_page = 20, $page_number = 1) {
        $ch = curl_init("https://api.uoltt.org/api/v4/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $Users = json_decode(curl_exec($ch),true);
        $Users = array_chunk($Users,$per_page)[$page_number - 1];

        curl_close($ch);

        for ($i=0;$i<sizeof($Users);$i++) {
            foreach ($Users[$i] as $key => $value) {
                if (!in_array($key,['id','name','fleet_id','squad_id'])) {
                    unset($Users[$i][$key]);
                }
            }
        }

        return $Users;
    }

}
