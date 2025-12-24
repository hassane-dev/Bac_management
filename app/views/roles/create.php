<?php
$pageTitle = 'Create Role';
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Create New Role</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Role Details</h5>
            </div>
            <div class="card-body">
                <form action="/roles/store" method="POST">
                    <div class="mb-3">
                        <label for="nom_role" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="nom_role" name="nom_role" placeholder="Enter role name" required>
                    </div>
                    <a href="/roles" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
