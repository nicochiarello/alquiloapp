<?php
require_once 'db_connect.php';

// Read filters from GET
$type = $_GET['type'] ?? '';
$beds = $_GET['beds'] ?? '';
$order = $_GET['order'] ?? 'newest';

// Order mapping
$orderMap = [
    'newest' => 'id DESC',
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
];

$orderSql = $orderMap[$order] ?? $orderMap['newest'];

$where = [];
$params = [];
$types = '';

if ($type !== '') {
    $where[] = 'type = ?';
    $params[] = $type;
    $types .= 's';
}
if ($beds !== '') {
    $where[] = 'beds >= ?';
    $params[] = (int) $beds;
    $types .= 'i';
}

// Initialize the base SQL query
$sql = 'SELECT * FROM property';

// Append WHERE clauses if any
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// Append ORDER BY clause
$sql .= " ORDER BY $orderSql";

$stmt = $conn->prepare($sql);

// Bind parameters if any
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/output.css" />
    <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">
    <title>Todas las propiedades | AlquiloApp</title>
</head>

<body class="flex flex-col min-h-screen bg-gray-50">

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <main class="py-8">
        <section class="px-4 sm:px-8 mt-2 mb-4">
            <h1 class="text-2xl font-semibold">Propiedades</h1>

            <!-- Filters -->
            <form method="GET" class="w-full py-4 flex flex-wrap gap-3 items-center">

                <!-- Type -->
                <select name="type" class="border rounded-lg p-2">
                    <option value="">Venta o Alquiler</option>
                    <option value="rent" <?= $type === 'rent' ? 'selected' : '' ?>>Alquiler</option>
                    <option value="sale" <?= $type === 'sale' ? 'selected' : '' ?>>Venta</option>
                </select>

                <!-- Beds -->
                <select name="beds" class="border rounded-lg p-2">
                    <option value="">Dormitorios (mín.)</option>
                    <option value="1" <?= $beds === '1' ? 'selected' : '' ?>>1+</option>
                    <option value="2" <?= $beds === '2' ? 'selected' : '' ?>>2+</option>
                    <option value="3" <?= $beds === '3' ? 'selected' : '' ?>>3+</option>
                    <option value="4" <?= $beds === '4' ? 'selected' : '' ?>>4+</option>
                </select>

                <!-- Order -->
                <select name="order" class="border rounded-lg p-2">
                    <option value="newest" <?= $order === 'newest' ? 'selected' : '' ?>>Más recientes</option>
                    <option value="price_asc" <?= $order === 'price_asc' ? 'selected' : '' ?>>Precio (menor a mayor)
                    </option>
                    <option value="price_desc" <?= $order === 'price_desc' ? 'selected' : '' ?>>Precio (mayor a menor)
                    </option>
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Aplicar</button>

                <?php if ($type !== '' || $beds !== '' || $order !== 'newest'): ?>
                    <a href="properties.php" class="text-sm underline ml-2">Limpiar</a>
                <?php endif; ?>
            </form>
        </section>

        <!-- List -->
        <section class="px-4 sm:px-8 pb-10">
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">

                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="w-full h-[215px] bg-blue-400 rounded-2xl shadow-lg relative overflow-hidden">
                            <div class="w-full h-full">
                                <img src="<?= htmlspecialchars($row['image'] ?: 'https://picsum.photos/800') ?>"
                                    alt="Property Image" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>
                            <a href="property_detail.php?id=<?= $row['id']; ?>">
                                <div class="w-full h-full absolute inset-0 flex flex-col justify-between p-2">
                                    <div class="flex justify-between">
                                        <div class="px-3 py-1 text-sm bg-blue-600 rounded-lg text-white">
                                            <?= $row['type'] === 'rent' ? 'Alquiler' : 'Venta' ?>
                                        </div>
                                        <div class="flex gap-2 text-white">
                                            <div class="flex gap-1 items-center">
                                                <?= $row['beds'] ?> <i class='bx bx-bed text-xl'></i>
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <?= $row['baths'] ?> <i class='bx bx-bath text-xl'></i>
                                            </div>
                                            <?php if (!empty($row['garage'])): ?>
                                                <i class='bx bx-garage text-xl'></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-white">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex gap-2">
                                                <i class='bx bx-location-blank text-lg'></i>
                                                <p class="text-xs font-semibold"><?= $row['location'] ?></p>
                                            </div>
                                            <div class="flex gap-2">
                                                <i class='bx bx-ruler text-lg'></i>
                                                <p class="text-xs font-semibold"><?= $row['area'] ?> m²</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 p-4">
                                            <p class="text-lg font-semibold">USD</p>
                                            <p class="text-lg font-semibold">$<?= number_format($row['price'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="col-span-full text-center text-gray-500">No se encontraron propiedades</p>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>