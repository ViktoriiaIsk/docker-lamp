<?php
require('functions.inc.php');

// Получаем текущую страницу из URL, по умолчанию устанавливаем 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Формируем URL для запроса
$url = "https://api.disneyapi.dev/character?page={$page}&pageSize=5 0";

// Выполняем запрос к API
$items = makeRequest($url);

// Если запрос не удался
if ($items === false) {
    die('No connection with API.');
}


// Получаем общее количество страниц
$totalPages = $items->info->totalPages ?? 1;
// print '<pre>'; print_r($items); exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disney API Characters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Disney API Characters</h1>

        <!-- Таблица с результатами -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Movies</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Выводим данные персонажей
                foreach ($items->data as $item) {
                    print '<tr>';
                    print '<td>' . $item->_id . '</td>';
                    if (isset($item->imageUrl)) {
                        print '<td><img src="' . $item->imageUrl . '" width="100" /></td>';
                    } else {
                        print '<td>(image not set)</td>';
                    }
                    print '<td>' . $item->name . '</td>';
                    print '<td>' . implode(', ', $item->films) . '</td>';

                    print '</tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Пагинация -->
        <div class="d-flex justify-content-between">
            <!-- Кнопка Previous -->
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="btn btn-primary">Previous</a>
            <?php else: ?>
                <button class="btn btn-secondary" disabled>Previous</button>
            <?php endif; ?>

            <!-- Кнопка Next -->
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a>
            <?php else: ?>
                <button class="btn btn-secondary" disabled>Next</button>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>