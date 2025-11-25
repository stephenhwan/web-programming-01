<div id="users" class="page">
    <h2 class="page-title">Users Dashboard</h2>

    <a class="btn btn-primary" href="adduser.php" style="margin-bottom: 1.5rem;">
        ➕ Add New User
    </a>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="muted">No users yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['user_type']) ?></td>                            
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-small" href="edituser.php?id=<?= (int)$u['id'] ?>">Edit</a>
                                
                                <a href="deleteuser.php?id=<?= $u['id'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this user?')"
                                   style="padding: 5px 10px; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;">
                                    🗑️ Delete
                                </a>                                           
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>    
            </tbody>
        </table>
    </div>
</div>