<?php

use GuzzleHttp\Exception\ClientException;

$GuzzleClient = new GuzzleHttp\Client(['base_uri'=>'https://api.uoltt.org/api/v4/']);

$Response = $GuzzleClient->get('ships');
$Ships = json_decode($Response->getBody());

if (array_key_exists('Submit',$_POST)) {
    try{
        $Response = $GuzzleClient->post('users',['form_params'=>[
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'game_handle' => $_POST['game_handle'],
            'email' => $_POST['email'],
            'password' => '',
            'ships' => $_POST['ships'],
            'organization_id' => 1
        ]]);
        $ResponseBody = json_decode($Response->getBody());
        ?>
        <div class="notice notice-success is-dismissible" id="success_message">
            <p><?= $ResponseBody->username; ?> has been successfully added with <?= count($ResponseBody->ships); ?> ships!</p>
        </div>
        <?php
    }catch (ClientException $e) {
        $Response = json_decode($e->getResponse()->getBody());
        ?>
        <div class="notice notice-error is-dismissible" id="error_message">
            <p><?= $Response->error; ?></p>
        </div>
        <?php
    }
}

?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>Add New User</h2>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
            <tr>
                <td>Name:<small>(optional)</small>:</td>
                <td>
                    <input type="text" name="name">
                </td>
            </tr>
            <tr>
                <td>Email Address<small>(optional)</small>:</td>
                <td>
                    <input type="email" name="email">
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username">
                </td>
            </tr>
            <tr>
                <td>Game Handle:</td>
                <td>
                    <input type="text" name="game_handle">
                </td>
            </tr>
            <tr>
                <td>Ships:</td>
                <td>
                    <input id="shipsList"><br>
                    <button type="button" class="button-primary">Add Ship</button><br>
                    <select multiple readonly name="ships[]" id="ships" style="width: 218px"></select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="submit">
                        <input type="submit" class="button-primary" name="Submit" value="Add User">
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script>
    var ShipIdMap = {
        <?php
        $map = [];
        foreach ($Ships as $Ship) {
            $map[] = "'".$Ship->shipname."': ".$Ship->id;
        }
        echo implode(',',$map);
        ?>
    };

    jQuery( function() {
        var availableTags = [
            <?php
            $ids = [];
            foreach ($Ships as $Ship) {
                $ids[] = '"'.$Ship->shipname.'"';
            }
            echo implode(',',$ids);
            ?>
        ];
        jQuery( "#shipsList" ).autocomplete({
            source: availableTags
        });
    } );

    jQuery('#shipsList').on('autocompletechange',function (event, ui) {
        var ShipName = ui.item.label;
        console.log(ShipName + ": " + ShipIdMap[ShipName]);
        jQuery('#ships').html(
            jQuery('#ships').html() + '<option selected value="' + ShipIdMap[ShipName] + '">' + ShipName + '</option>'
        );
    });
</script>