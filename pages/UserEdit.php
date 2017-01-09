<?php
/**
 * Created by PhpStorm.
 * User: judah
 * Date: 1/9/17
 * Time: 8:51 AM
 */

@ini_set('display_errors',1);
error_reporting(E_ALL);

if (!array_key_exists('UserID',$_GET)) {
    ?>
    <script>
        window.location = "<?= get_admin_url().'?page=UserMenu'; ?>";
    </script>
    <?php
    exit();
}

?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>Add New User</h2>

    <table class="form-table">
        <tbody>

        </tbody>
    </table>
</div>