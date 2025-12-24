<?php
$pageTitle = 'Edit Role';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Edit Role: <?php echo htmlspecialchars($role['nom_role']); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Role Details and Permissions</h5>
            </div>
            <div class="card-body">
                <form action="/roles/update/<?php echo $role['id']; ?>" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom_role" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="nom_role" name="nom_role" value="<?php echo htmlspecialchars($role['nom_role']); ?>" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Assign Permissions</h5>
                    <div class="row mt-3">
                        <?php while ($permission = $all_permissions->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" id="perm_<?php echo $permission['id']; ?>"
                                        <?php echo in_array($permission['id'], $assigned_permissions) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="perm_<?php echo $permission['id']; ?>">
                                        <?php echo htmlspecialchars($permission['nom_permission']); ?>
                                    </label>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="mt-4">
                        <a href="/roles" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
