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
    function AddUser() {
        jQuery.post('https://api.uoltt.org/api/v4/users',{
            name: jQuery('#name').val(),
            username: jQuery('#username').val(),
            game_handle: jQuery('#game_handle').val(),
            email: jQuery('#email').val(),
            password: ''
        }).done(function(data) {
            jQuery('#success_message').html('<p>User has been successfully added</p>');
            jQuery('#success_message').show();
        }).fail(function(data) {
            jQuery('#error_message').html('<p>An error has occured. Either you didnt enter in all the data or you need to bug judahnator.</p>');
            jQuery('#error_message').show();
        });
    }
</script>