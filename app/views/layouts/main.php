<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $pageTitle ?? 'Baccalaureate Management'; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/theme/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/theme/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="/theme/fonts/tabler-icons.min.css" >
    <link rel="stylesheet" href="/theme/fonts/feather.css" >
    <link rel="stylesheet" href="/theme/fonts/fontawesome.css" >
    <link rel="stylesheet" href="/theme/fonts/material.css" >
    <link rel="stylesheet" href="/theme/css/style.css" id="main-style-link" >
    <link rel="stylesheet" href="/theme/css/style-preset.css" >
</head>
<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <?php include 'partials/sidebar.php'; ?>
    <?php include 'partials/header.php'; ?>
    <div class="pc-container">
        <div class="pc-content">
            <?php echo $content; ?>
        </div>
    </div>
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Able Pro ♥ crafted by Team <a href="https://www.phoenixcoded.net" target="_blank">Phoenixcoded</a></p>
                </div>
            </div>
        </div>
    </footer>
    <script src="/theme/js/plugins/popper.min.js"></script>
    <script src="/theme/js/plugins/simplebar.min.js"></script>
    <script src="/theme/js/plugins/bootstrap.min.js"></script>
    <script src="/theme/js/fonts/custom-font.js"></script>
    <script src="/theme/js/script.js"></script>
</body>
</html>
