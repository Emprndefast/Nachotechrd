<?php
/**
 * Router para servidor PHP built-in
 * Sirve archivos estáticos directamente y solo usa index.php para rutas de aplicación
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Directorios de archivos estáticos que deben servirse directamente
$static_dirs = ['assets', 'css', 'js', 'img', 'fonts', 'uploads', 'Pagos', 'DB'];

// Verificar si la solicitud es para un archivo estático
$is_static = false;
foreach ($static_dirs as $dir) {
    if (strpos($uri, '/' . $dir . '/') === 0 || $uri === '/' . $dir || strpos($uri, '/' . $dir) === 0) {
        $is_static = true;
        break;
    }
}

// Si es un archivo estático, verificar si existe y servirlo
if ($is_static) {
    $file = __DIR__ . $uri;
    
    // Verificar que el archivo existe y está dentro del directorio raíz
    if (file_exists($file) && is_file($file) && strpos(realpath($file), realpath(__DIR__)) === 0) {
        // Determinar el tipo MIME
        $mime_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
        ];
        
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mime = $mime_types[$ext] ?? mime_content_type($file);
        
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($file));
        
        // Cache headers para assets
        header('Cache-Control: public, max-age=31536000');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        
        readfile($file);
        exit;
    }
    
    // Si el archivo no existe, devolver 404
    http_response_code(404);
    exit('File not found');
}

// Si no es un archivo estático, usar index.php (CodeIgniter)
if (file_exists(__DIR__ . '/index.php')) {
    require __DIR__ . '/index.php';
} else {
    http_response_code(404);
    exit('Application not found');
}

