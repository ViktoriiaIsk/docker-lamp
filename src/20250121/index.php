<?php
require('db.inc.php');
$errors = [];

// print '<pre>';
// print_r($_FILES);
// print '</pre>';

$uploadDir = 'uploads/'; // Directory where images will be stored
$allowedTypes = ['image/jpeg', 'image/png']; // Allowed image types
$maxFileSize = 1 * 1024 * 1024; // 1MB file size limit

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imgupload'])) {
    $file = $_FILES['imgupload'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'An error occurred while uploading.';
    } else {
        $fileType = mime_content_type($file['tmp_name']); // Get file type
        $fileSize = $file['size']; // Get file size

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Only JPG and PNG files are allowed.';
        }

        if ($fileSize > $maxFileSize) {
            $errors[] = 'File size must not exceed 1MB.';
        }

        if (!count($errors)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION); // Get file extension
            $newFileName = uniqid('', true) . '.' . $ext; // Generate a unique file name
            $uploadPath = $uploadDir . $newFileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create upload directory if it doesn't exist
            }

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                insertDbImage($uploadPath); // Save file path to database
            } else {
                $errors[] = 'Error saving the file.';
            }
        }
    }
}

$items = getDbImages(); // Retrieve uploaded images from database
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DB Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        img.thumb {
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <section>
            <h2>Upload Image</h2>
            <hr />
            <?php if (count($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="post" action="index.php" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <label for="imgupload" class="col-sm-2 col-form-label">Image: *</label>
                    <div>
                        <input type="file" name="imgupload" id="imgupload">
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div>
                        <button type="submit" class="btn btn-primary" name="formSubmit" style="width: 100%">Add</button>
                    </div>
                </div>
            </form>
        </section>
        <main>
            <h2>Images</h2>
            <div class="table-responsive small">
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $item['id']; ?></td>
                                <td><img src="<?= htmlspecialchars($item['path']); ?>" class="thumb" /></td>
                                <td><?= $item['created_date']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>