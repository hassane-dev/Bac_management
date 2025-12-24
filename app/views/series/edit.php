<?php
$pageTitle = 'Edit Serie';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Edit Serie</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Serie Details</h5>
            </div>
            <div class="card-body">
                <form action="/series/update/<?php echo $serie['id']; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Serie Name</label>
                        <input type="text" class="form-control" name="nom_serie" value="<?php echo htmlspecialchars($serie['nom_serie']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"><?php echo htmlspecialchars($serie['description']); ?></textarea>
                    </div>
                    <a href="/series" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Serie</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
