    <form action="" method="post" style="max-width: 500px;">
        <div style="margin-bottom: 15px;">
            <label for='username'>Username: </label>
            <input type="text" 
                   name='username' 
                   id='username' 
                   value="<?= htmlspecialchars($user['username']) ?>"
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for='user_password'>Password: </label>
            <input type="password" 
                   name='user_password' 
                   id='user_password'
                   value="<?= htmlspecialchars($user['user_password']) ?>" 
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for='email'>Email: </label>
            <input type="email" 
                   name='email' 
                   id='email'
                   value="<?= htmlspecialchars($user['user_password']) ?>" 
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>        
        <div style="margin-top: 20px;">
            <input type='submit' value='Update User' class="btn btn-primary" style="padding: 10px 20px; cursor: pointer;">
            <a href="user.php" class="btn btn-secondary" style="padding: 10px 20px; cursor: pointer;">Cancel</a>
        </div>
    </form>