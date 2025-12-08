<?php
$pageTitle = 'Users';
ob_start();
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Users</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>User List</h5>
                    <a href="/users/create" class="btn btn-primary">Add User</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom'] . ' ' . $row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom_utilisateur']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom_role']); ?></td>
                                <td><span class="badge <?php echo $row['statut'] == 'actif' ? 'bg-success' : 'bg-danger'; ?>"><?php echo htmlspecialchars($row['statut']); ?></span></td>
                                <td>
                                    <a href="/users/edit/<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="/users/delete/<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>