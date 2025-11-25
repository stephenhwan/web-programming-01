<div class="form-container">
    <div class="form-header">
        <h2>Edit Question</h2>
        <p>Update your question information</p>
    </div>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">
                Question Title <span class="required">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   class="form-control" 
                   required
                   value="<?= htmlspecialchars($currentTitle) ?>">
        </div>
        
        <div class="form-group">
            <label for="module_id">
                Select Module <span class="required">*</span>
            </label>
            <select id="module_id" name="module_id" class="form-control" required>
                <?php foreach ($modules as $module): ?>
                    <option value="<?= $module['id'] ?>" 
                            <?= ($question['module_id'] == $module['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($module['module_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="user_id">
                Select User <span class="required">*</span>
            </label>
            <select id="user_id" name="user_id" class="form-control" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"
                            <?= ($question['user_id'] == $user['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="content">
                Question Details <span class="required">*</span>
            </label>
            <textarea id="content" 
                      name="content" 
                      class="form-control" 
                      required><?= htmlspecialchars($currentContent) ?></textarea>
        </div>
        
            <label for="picture" style="margin-top: 15px;">
                Upload New Image/Video (Optional)
            </label>
            <div class="upload-area" onclick="document.getElementById('picture').click()">
                <div class="icon">📁</div>
                <p><strong>Click to upload</strong> or drag and drop</p>
                <p class="file-types">PNG, JPG, GIF, MP4, MOV (Max 50MB)</p>
            </div>
            <input type="file" 
                   id="picture" 
                   name="picture" 
                   accept="image/*,video/*"
                   style="display: none;"
                   onchange="updateFileName(this)">
            <p id="file-name" style="margin-top: 10px; font-weight: bold;"></p>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                ✅ Update Question
            </button>
            <a href="forum.php" class="btn btn-secondary">
                ❌ Cancel
            </a>
        </div>
    </form>
</div>

<?= get_upload_script() ?>