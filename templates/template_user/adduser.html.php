<div class="page">
    <h2 class="page-title">Add New User</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger" style="padding: 10px; margin-bottom: 15px; background: #f8d7da; color: #721c24; border-radius: 4px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form action="" method="post" style="max-width: 500px;">
        <div style="margin-bottom: 15px;">
            <label for='username'>Username: </label>
            <input type="text" 
                   name='username' 
                   id='username' 
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for='user_password'>Password: </label>
            <input type="password" 
                   name='user_password' 
                   id='user_password' 
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>
                <div style="margin-bottom: 15px;">
            <label for='email'>email: </label>
            <input type="email" 
                   name='email' 
                   id='email' 
                   required 
                   style="width: 60%; padding: 8px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for='user_type'>User Type: </label>
            <select name='user_type' 
                    id='user_type' 
                    required 
                    style="width: 62%; padding: 8px; margin-top: 5px;">
                <option value='user'>User</option>
                <option value='admin'>Admin</option>
            </select>
        <div style="margin-top: 20px;">

            <input type='submit' value='Add User' class="btn btn-primary" style="padding: 10px 20px; cursor: pointer;">
            <a href="user.php" class="btn btn-secondary" style="padding: 10px 20px; cursor: pointer;">Cancel</a>
        </div>
    </form>
</div>