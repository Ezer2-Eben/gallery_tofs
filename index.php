<?php
// Racine : redirection vers le dossier public
if (file_exists(__DIR__.'/public/index.php')) {
    require __DIR__.'/public/index.php';
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo '<h1>Laravel Application</h1>';
    echo '<p>public/index.php not found</p>';
    echo '<pre>';
    print_r(scandir(__DIR__));
    echo '</pre>';
}
?>