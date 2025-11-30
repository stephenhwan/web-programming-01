<div id="forum" class="page">
    <h2 class="page-title">Forum Dashboard</h2>

    <a class="btn btn-primary" href="addquestion.php" style="margin-bottom: 1.5rem;">
        ➕ Add New Question
    </a>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">User</th>
                    <th scope="col">Module</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($questions)): ?>
                    <tr>
                        <td colspan="7" class="muted">No questions yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($questions as $q): ?>
                        <tr>
                            <td><?= htmlspecialchars($q['id']) ?></td>
                            <td><?= htmlspecialchars($q['title']) ?></td>
                            <td>
                                <?php 
                                    $content = htmlspecialchars($q['content']);
                                    echo strlen($content) > 100 
                                        ? substr($content, 0, 100) . '...' 
                                        : $content;
                                ?>
                            </td>                        
                            <td>
                                <?php if ($q['picture']): ?>
                                    <?php if ($q['is_video']): ?>
                                        <video style="max-width: 120px; max-height: 80px; object-fit: cover; border-radius: 4px;" controls>
                                            <source src="<?= htmlspecialchars($q['picture']) ?>">
                                            Your browser does not support video.
                                        </video>
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($q['picture']) ?>" 
                                             alt="Question image" 
                                             onclick="openLightbox('<?= htmlspecialchars($q['picture']) ?>')"
                                             style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer; transition: transform 0.2s;"
                                             onmouseover="this.style.transform='scale(1.1)'"
                                             onmouseout="this.style.transform='scale(1)'">
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="muted">No media</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('M d, Y', strtotime($q['created_day'])) ?></td>
                            <td><?= htmlspecialchars($q['username']) ?></td>
                            <td><?= htmlspecialchars($q['module_name']) ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-small" href="editquestion.php?id=<?= (int)$q['id'] ?>">Edit</a>
                                <a href="deletequestion.php?id=<?= $q['id'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this question?')"
                                   style="padding: 5px 15px; color: red; text-decoration: none; border-radius: 3px;">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>    
            </tbody>
        </table>
    </div>
</div>

<!-- LIGHTBOX MODAL -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <img id="lightbox-img" class="lightbox-content" alt="Full size image">
</div>

<?= get_lightbox_script() ?>