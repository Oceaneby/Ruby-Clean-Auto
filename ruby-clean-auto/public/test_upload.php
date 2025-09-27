<?php

// Chemin absolu vers ton dossier "gallery"
$folder = __DIR__ . '/uploads/gallery';
$file = $folder . '/test.txt';

if (!is_dir($folder)) {
    die("⛔ Le dossier n'existe pas ! ➜ " . $folder);
}

if (!is_writable($folder)) {
    die("❌ Le dossier existe mais n'est PAS accessible en écriture !");
}

$result = file_put_contents($file, "Hello world!");

if ($result === false) {
    die("❌ Impossible d'écrire dans le dossier !");
}

echo "✅ Test réussi, le fichier test.txt a été écrit dans le dossier gallery.";