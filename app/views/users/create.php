<?php
$pageTitle = 'Add User';
ob_start();
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Add User</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Create a New User</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/users/store">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="nom_utilisateur" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="mot_de_passe" required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="id_role" required>
                            <?php while ($row = $roles->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nom_role']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="statut" required>
                           <option value="actif">Active</option>
                           <option value="inactif">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>