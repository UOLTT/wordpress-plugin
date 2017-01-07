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
                <td colspan="2">
                    <p class="submit">
                        <input type="submit" value="Add User" class="button-primary" name="Submit">
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <pre>
        <?= print_r($_POST,true);?>
    </pre>
</div>

<?php

// TODO add ships?
// Only fire on submit, not every page load
if (array_key_exists('Submit',$_POST)) {
    $GuzzleClient = new GuzzleHttp\Client(['base_uri' => 'https://api.uoltt.org/api/v4/']);
    $Response = $GuzzleClient->post('users',[
        'body' => [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'game_handle' => $_POST['game_handle']
        ]
    ]);
}

?>