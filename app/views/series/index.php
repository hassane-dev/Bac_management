<?php
$pageTitle = 'Series';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Series Management</h2>
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
                    <h5>All Series</h5>
                    <a href="/series/create" class="btn btn-primary">Add New Serie</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Serie Name</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $series->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom_serie']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td class="text-end">
                                    <a href="/matieres/manage/<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary">
                                        <i class="ti ti-book"></i> Manage Matieres
                                    </a>
                                    <a href="/series/edit/<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="ti ti-edit"></i> Edit
                                    </a>
                                    <a href="/series/delete/<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                        <i class="ti ti-trash"></i> Delete
                                    </a>
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
