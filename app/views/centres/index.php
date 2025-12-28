<?php
$page_title = "Gestion des Centres d'Examen";
ob_start();
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Liste des Centres d'Examen</h5>
                    <a href="/centres/create" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus"></i> Ajouter un Centre
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Centre</th>
                                <th>Code</th>
                                <th>Ville</th>
                                <th>Capacité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($centres)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucun centre trouvé.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($centres as $centre): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($centre['id']) ?></td>
                                        <td><?= htmlspecialchars($centre['nom_centre']) ?></td>
                                        <td><?= htmlspecialchars($centre['code_centre']) ?></td>
                                        <td><?= htmlspecialchars($centre['ville']) ?></td>
                                        <td><?= htmlspecialchars($centre['capacite']) ?></td>
                                        <td>
                                            <a href="/centres/edit/<?= $centre['id'] ?>" class="btn btn-info btn-sm">
                                                <i class="ti ti-pencil"></i> Modifier
                                            </a>
                                            <a href="/centres/delete/<?= $centre['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce centre ?');">
                                                <i class="ti ti-trash"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>