<?php
// Página de inicio directa para NachoTechRD
// Redirección directa al login sin pasar por el framework

echo '<script>window.location.href = "index.php/user/login";</script>';

// Backup: meta refresh
echo '<meta http-equiv="refresh" content="0; url=index.php/user/login">';

// Backup: PHP redirect
header('Location: index.php/user/login');
exit;
?>
