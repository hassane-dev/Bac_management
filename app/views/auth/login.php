<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/theme/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/theme/fonts/inter/inter.css" id="main-font-link">
    <link rel="stylesheet" href="/theme/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="/theme/fonts/feather.css">
    <link rel="stylesheet" href="/theme/fonts/fontawesome.css">
    <link rel="stylesheet" href="/theme/fonts/material.css">
    <link rel="stylesheet" href="/theme/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="/theme/css/style-preset.css">
</head>
<body>
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                         <div class="text-center">
                            <a href="#"><img src="/theme/images/logo-dark.svg" alt="img"></a>
                         </div>
                        <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="/login">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <script src="/theme/js/plugins/popper.min.js"></script>
    <script src="/theme/js/plugins/simplebar.min.js"></script>
    <script src="/theme/js/plugins/bootstrap.min.js"></script>
    <script src="/theme/js/fonts/custom-font.js"></script>
    <script src="/theme/js/script.js"></script>
</body>
</html>