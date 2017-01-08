<?php

/**
 * Created by PhpStorm.
 * User: judah
 * Date: 1/6/17
 * Time: 5:58 PM
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class UsersListTable extends WP_List_Table
{

    private $Users;

    public function __construct()
    {
        $GuzzleClient = new GuzzleHttp\Client(['base_uri'=>'https://api.uoltt.org/api/v4/']);
        $Response = $GuzzleClient->get('users');
        $Users = json_decode($Response->getBody(),true);

        for ($i = 0; $i < sizeof($Users); $i++) {
            foreach ($Users[$i] as $key => $value) {
                if (!in_array($key, ['id', 'username', 'game_handle', 'fleet_id', 'squad_id'])) {
                    unset($Users[$i][$key]);
                } elseif (is_null($value)) {
                    $Users[$i][$key] = "";
                }
            }
        }
        $this->Users = $Users;
        parent::__construct();
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'username':
            case 'game_handle':
            case 'fleet_id':
            case 'squad_id':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    public function get_columns()
    {
        $columns = array(
            'id' => 'User ID',
            'username' => 'Users Name',
            'game_handle' => 'Game Handle',
            'fleet_id' => 'Fleet',
            'squad_id' => 'Squadron'
        );
        return $columns;
    }

    public function get_sortable_columns()
    {
        return [
            'id' => ['id', false],
            'username' => ['username', false],
            'game_handle' => ['game_handle', false]
        ];
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->Users, array(&$this, 'usort_reorder'));
        $this->items = $this->Users;
    }

    public function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (isset($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        // Determine sort order
        if ($orderby == "id") {
            $result = $a[$orderby] - $b[$orderby];
        } else {
            $result = strcmp($a[$orderby], $b[$orderby]);
        }
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }

}
