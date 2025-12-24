<?php
$pageTitle = 'Manage Matieres for ' . htmlspecialchars($serie['nom_serie']);
ob_start();
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Manage Matieres for Serie: <?php echo htmlspecialchars($serie['nom_serie']); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Form to assign a new matiere -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Assign New Matiere</h5>
            </div>
            <div class="card-body">
                <form action="/matieres/assign/<?php echo $serie['id']; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Matiere</label>
                        <select class="form-select" name="id_matiere" required>
                            <option value="">Select a Matiere</option>
                            <?php while ($matiere = $all_matieres->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $matiere['id']; ?>"><?php echo htmlspecialchars($matiere['nom_matiere']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coefficient</label>
                        <input type="text" class="form-control" name="coefficient" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="obligatoire">Obligatoire</option>
                            <option value="facultatif">Facultatif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Matiere</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Table of assigned matieres -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Assigned Matieres</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Matiere Name</th>
                                <th>Coefficient</th>
                                <th>Type</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $assigned_matieres->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom_matiere']); ?></td>
                                <td><?php echo htmlspecialchars($row['coefficient']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td class="text-end">
                                    <a href="/matieres/detach/<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                        <i class="ti ti-trash"></i> Detach
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
