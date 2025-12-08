<?php
$pageTitle = 'General Settings';
ob_start();
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">General Settings</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Application Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/setting/update" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Country Name</label>
                        <input type="text" class="form-control" name="nom_pays" value="<?php echo htmlspecialchars($settings['nom_pays']); ?>" required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Number of Official Languages</label>
                        <select class="form-select" name="nombre_langues">
                            <option value="1" <?php echo $settings['nombre_langues'] == '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo $settings['nombre_langues'] == '2' ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Language 1</label>
                        <input type="text" class="form-control" name="langue_1" value="<?php echo htmlspecialchars($settings['langue_1']); ?>">
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Language 2</label>
                        <input type="text" class="form-control" name="langue_2" value="<?php echo htmlspecialchars($settings['langue_2']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Baccalaureate Year</label>
                        <input type="number" class="form-control" name="annee_bac" value="<?php echo htmlspecialchars($settings['annee_bac']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admission Threshold</label>
                        <input type="text" class="form-control" name="seuil_admission" value="<?php echo htmlspecialchars($settings['seuil_admission']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Second Round Threshold</label>
                        <input type="text" class="form-control" name="seuil_second_tour" value="<?php echo htmlspecialchars($settings['seuil_second_tour']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Official Logo</label>
                        <input type="file" class="form-control" name="logo_officiel">
                        <?php if(!empty($settings['logo_officiel'])): ?> <img src="<?php echo htmlspecialchars($settings['logo_officiel']); ?>" height="50"/> <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Signature</label>
                        <input type="file" class="form-control" name="signature">
                        <?php if(!empty($settings['signature'])): ?> <img src="<?php echo htmlspecialchars($settings['signature']); ?>" height="50"/> <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seal</label>
                        <input type="file" class="form-control" name="cachet">
                         <?php if(!empty($settings['cachet'])): ?> <img src="<?php echo htmlspecialchars($settings['cachet']); ?>" height="50"/> <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">QR Code</label>
                        <input type="file" class="form-control" name="qr_code">
                         <?php if(!empty($settings['qr_code'])): ?> <img src="<?php echo htmlspecialchars($settings['qr_code']); ?>" height="50"/> <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>