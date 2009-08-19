<form>

    <input type="hidden" name="id" value="<?php echo $user->id ?>" />
    
    <p>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $user->username ?>" />
    </p>
    
    <p>
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo $user->email ?>" />
    </p>
    
    <p>
        <label for="password">Password</label>
        <input type="text" name="password" />
    </p>

    <p>
        <label for="password_confirm">Password (again)</label>
        <input type="text" name="password_confirm" />
    </p>

</form>
