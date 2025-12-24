<?php
$pageTitle = 'Create Matiere';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Create New Matiere</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Matiere Details</h5>
            </div>
            <div class="card-body">
                <form action="/matieres/store" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Matiere Name</label>
                        <input type="text" class="form-control" name="nom_matiere" required>
                    </div>
                    <a href="/matieres" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Matiere</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
