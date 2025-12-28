<?php
$page_title = "Modifier le Centre d'Examen";
ob_start();
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Modifier le Centre : <?= htmlspecialchars($centre['nom_centre']) ?></h5>
            </div>
            <div class="card-body">
                <form action="/centres/update/<?= $centre['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="nom_centre" class="form-label">Nom du Centre</label>
                        <input type="text" class="form-control" id="nom_centre" name="nom_centre" value="<?= htmlspecialchars($centre['nom_centre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="code_centre" class="form-label">Code du Centre</label>
                        <input type="text" class="form-control" id="code_centre" name="code_centre" value="<?= htmlspecialchars($centre['code_centre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" value="<?= htmlspecialchars($centre['ville']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacite" class="form-label">Capacité</label>
                        <input type="number" class="form-control" id="capacite" name="capacite" value="<?= htmlspecialchars($centre['capacite']) ?>" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="/centres" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>