<?php

include("db_connect.php");

// Redirect to index.php if 'id' parameter is not set
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
} else {
    $property_id = $_GET["id"];

    $sql = "SELECT * FROM property WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: index.php");
        exit();
    }

    $stmt->close();
}

// Fetch user owner details
$user_id = $row['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$owner = $result->fetch_assoc();
if ($owner) {
    $user_email = $owner['email'];
    $user_phone = $owner['phone'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $row['title']; ?>
    </title>
    <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/output.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Wrapper -->
    <div class="max-w-[1400px] w-full mx-auto">

        <!-- Property Detail -->
        <div
            class="flex flex-col lg:flex-row justify-between gap-8  items-center w-full max-w-[1400px] mx-auto my-8 px-4">
            <div class="w-full flex flex-col lg:flex-1 h-[600px] gap-8">
                <div class="relative flex flex-1 w-full shadow-2xl border border-gray-100 rounded-2xl overflow-hidden">
                    <div class="absolute inset-0 w-full h-full">
                        <img class="w-full h-full object-contain" src="<?php echo htmlspecialchars($row['image']); ?>"
                            alt="">
                    </div>
                    <div class="absolute inset-0 w-full h-full">
                        <div class="w-full h-full flex items-center justify-between">
                            <!-- Arrow back -->
                            <i class='bxr  bx-chevron-left text-4xl text-white'></i>

                            <!-- Arrow forward -->
                            <i class='bxr  bx-chevron-right text-4xl text-white'></i>

                        </div>
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col w-full lg:w-[450px] h-[600px] gap-16 p-8 shadow-2xl rounded-2xl text-2xl border border-gray-200">
                <div class="px-4 py-1 bg-blue-600 rounded-lg text-white w-fit">
                    <p><?= $row['type'] === 'rent' ? 'Alquiler' : 'Venta' ?></p>
                </div>
                <div class="flex gap-2">
                    <p class="text-2xl font-semibold">USD</p>
                    <p class="text-2xl font-semibold"><?php echo "$" . number_format($row['price'] ?? 0, 0, ',', '.') ?>
                    </p>
                </div>
                <div class="flex gap-2">
                    <i class='bx bx-location-blank text-2xl'></i>
                    <p class="text-2xl font-semibold">
                        <?= htmlspecialchars($row['location'] ?? 'N/A') ?>
                    </p>
                </div>
                <div class="flex gap-2">
                    <i class='bx bx-ruler text-2xl'></i>
                    <p class="text-2xl font-semibold">
                        <?= htmlspecialchars($row['area'] ?? '0') ?> m²
                    </p>
                </div>

                <div class="flex gap-8">
                    <div class="flex gap-2 items-center justify-center">
                        <p class="font-semibold">
                            <?= $row['beds'] ?? '0' ?>
                        </p>
                        <i class='bx bx-bed text-2xl translate-y-0.5'></i>
                    </div>
                    <div class="flex gap-2 items-center justify-center">
                        <p class="font-semibold">
                            <?= $row['baths'] ?? '0' ?>
                        </p>
                        <i class='bx bx-bath text-2xl'></i>
                    </div>
                    <div class="flex gap-2 items-center justify-center">
                        <?php if ($row['garage']): ?>
                            <i class='bx bx-garage text-2xl'></i>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="flex gap-8 text-lg">
                    <a href="<?php echo 'https://wa.me/' . $user_phone; ?>"
                        class="px-4 py-1 bg-blue-700 rounded-lg text-white w-fit">
                        <p>Whatsapp</p>
                    </a>
                    <a href="mailto:<?php echo $user_email; ?>"
                        class="px-8 py-1 bg-blue-700 rounded-lg text-white w-fit">
                        <p>Email</p>
                    </a>
                </div>
            </div>


        </div>

        <!-- Description -->
        <div class="max-w-[1400px] mx-auto my-8 prose prose-sm px-8">
            <?= $row['description'] ?>
        </div>
    </div>


    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

</body>

</html>