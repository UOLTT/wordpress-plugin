<?php
$GuzzleClient = new GuzzleHttp\Client(['base_uri'=>'https://api.uoltt.org/api/v4/']);
$Response = $GuzzleClient->get('ships');
$Ships = json_decode($Response->getBody());
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="notice-success is-dismissible" id="success_message" style="display: none"></div>
<div class="notice-error is-dismissible" id="error_message" style="display: none"></div>

<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>Add New User</h2>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
            <tr>
                <td>Name:<small>(optional)</small>:</td>
                <td>
                    <input type="text" id="name">
                </td>
            </tr>
            <tr>
                <td>Email Address<small>(optional)</small>:</td>
                <td>
                    <input type="email" id="email">
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" id="username">
                </td>
            </tr>
            <tr>
                <td>Game Handle:</td>
                <td>
                    <input type="text" id="game_handle">
                </td>
            </tr>
            <tr>
                <td>Ships:</td>
                <td>
                    <input id="shipsList"><br>
                    <button type="button" class="button-primary">Add Ship</button><br>
                    <select multiple disabled id="ships" style="width: 218px"></select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="submit">
                        <button type="button" onclick="AddUser()" class="button-primary">Add User</button>
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

    function AddUser() {
        jQuery.post('https://api.uoltt.org/api/v4/users',{
            name: jQuery('#name').val(),
            username: jQuery('#username').val(),
            game_handle: jQuery('#game_handle').val(),
            email: jQuery('#email').val(),
            password: '',
            ships: jQuery('#ships').val()
        }).always(function(data) {
            if (data.error == undefined) {
                jQuery('#success_message').html('<p>User has been successfully added</p>');
                jQuery('#error_message').hide();
                jQuery('#success_message').show();
            }else {
                jQuery('#error_message').html('<p>An error has occured. Either you didnt enter in all the data or you need to bug judahnator.</p>');
                jQuery('#success_message').hide();
                jQuery('#error_message').show();
            }
        });
    }
</script>