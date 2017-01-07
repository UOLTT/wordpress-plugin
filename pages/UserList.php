<?php
/**
 * Created by PhpStorm.
 * User: judah
 * Date: 1/4/17
 * Time: 4:46 PM
 */

require_once UOLTT_EXTENSION_DIR.'/library/UserListTable.php';

$UsersListTable = new UsersListTable();

?>

<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>My List Table Test</h2>
    <?php
    $UsersListTable->prepare_items();
    $UsersListTable->display();
    ?>
</div>