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
        $ch = curl_init("https://api.uoltt.org/api/v4/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $Users = json_decode(curl_exec($ch), true);
        curl_close($ch);

        for ($i = 0; $i < sizeof($Users); $i++) {
            foreach ($Users[$i] as $key => $value) {
                if (!in_array($key, ['id', 'name', 'fleet_id', 'squad_id'])) {
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
            case 'name':
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
            'name' => 'Users Name',
            'fleet_id' => 'Fleet',
            'squad_id' => 'Squadron'
        );
        return $columns;
    }

    public function get_sortable_columns()
    {
        return [
            'id' => ['id', false],
            'name' => ['name', false]
        ];
    }

    public function pagination($current_page = 1)
    {
        /*
        $screen = get_current_screen();
        if (!is_null($screen->get_option('users_per_page','default'))) {
            $per_page = 20;
        }else {
            $per_page = $screen->get_option('users_per_page','default');
        }
        */
        $this->Users = array_chunk($this->Users,20)[$current_page - 1];
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->Users, array(&$this, 'usort_reorder'));
        $this->pagination();
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
