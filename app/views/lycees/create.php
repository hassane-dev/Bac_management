<?php
$pageTitle = 'Create Lycee';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Create New Lycee</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Lycee Details</h5>
            </div>
            <div class="card-body">
                <form action="/lycees/store" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="nom" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="ville">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact</label>
                                <input type="text" class="form-control" name="contact">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Director</label>
                                <input type="text" class="form-control" name="directeur">
                            </div>
                        </div>
                    </div>
                    <a href="/lycees" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Lycee</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
