<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="./styles/output.css">
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <title>AlquiloApp</title>
</head>

<body class="flex flex-col">
  <div class="flex flex-col w-full h-screen max-h-[800px]">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    <div class="flex flex-1 h-full ">
      <div class="relative basis-[100%] lg:basis-[40%] h-full ">
        <div class="lg:hidden absolute inset-0 w-full h-full">
          <img class="w-full h-full object-cover" src="public/index_pic.png" alt="">
        </div>
        <!-- overlay -->
        <div
          class="absolute w-full h-full inset-0 bg-black/70 lg:bg-transparent px-8 flex flex-col items-center xl:items-start">

          <div class="flex flex-col xl:flex-row items-center gap-4 mt-12">
            <div class="w-24">
              <?php include './public/logo.svg'; ?>
            </div>
            <h2 class="text-[55px] font-bold text-white lg:text-black">AlquiloApp</h2>
          </div>
          <p class="max-w-[480px] mt-12 ml-4 text-lg text-center xl:text-left text-white lg:text-black">Buscas
            el hogar de tus sueños?
            Nosotros lo hacemos posible, busca en AlquiloApp y hacelo realidad</p>

          <button class="px-8 py-2 text-white bg-blue-500 w-fit rounded-full font-semibold text-2xl mt-12">
            <a href="">Publica Gratis</a>
          </button>
        </div>
      </div>
      <div class="relative hidden sm:block flex-1 w-full h-full">
        <div class="absolute inset-0 w-full h-full">
          <img class="w-full h-full object-cover" src="public/index_pic.png" alt="">
        </div>
      </div>
    </div>
  </div>

  <!-- Property list -->
  <h3 class="text-2xl text-center font-semibold my-8 sm:my-16">Ultimas oportunidades</h3>

  <div
    class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 p-4 w-full px-4 sm:px-8">
    <?php
    //  DB connection
    require_once 'db_connect.php';

    // Use a prepared statement and cast user_id to int to avoid SQL injection and parsing issues
    $stmt = $conn->prepare("SELECT * FROM property ORDER BY id DESC LIMIT 10");
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
        ?>

        <!-- Propery card -->
        <div class="w-full h-[215px] bg-blue-400 rounded-2xl shadow-lg relative overflow-hidden">
          <!-- Image -->
          <div class="w-full h-full">
            <img src="<?= htmlspecialchars($row['image'] ?: 'https://picsum.photos/800') ?>" alt="Property Image"
              class="w-full h-full object-cover">
          </div>

          <!-- Overlay -->
          <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

          <!-- Content -->
          <div class="w-full h-full absolute inset-0 flex flex-col justify-between p-2">
            <div class="flex justify-between">
              <div class="px-3 py-1 text-sm bg-blue-600 rounded-lg text-white">
                <p><?= $row['type'] === 'rent' ? 'Alquiler' : 'Venta' ?></p>
              </div>
              <div class="flex gap-2">
                <div class="flex gap-1 items-center text-white ">
                  <p class="font-semibold">
                    <?= $row['beds'] ?? '0' ?>
                  </p>
                  <i class='bx bx-bed text-xl'></i>
                </div>
                <div class="flex gap-1 items-center text-white ">
                  <p class="font-semibold">
                    <?= $row['baths'] ?? '0' ?>
                  </p>
                  <i class='bx bx-bath text-xl'></i>
                </div>
                <div class="flex gap-1 items-center text-white ">
                  <?php if ($row['garage']): ?>
                    <i class='bx bx-garage text-xl'></i>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="flex justify-between text-white ">
              <div class="flex flex-col gap-1 justify-end">
                <div class="flex gap-2">
                  <i class='bx bx-location-blank text-lg'></i>
                  <p class="text-xs font-semibold">
                    <?= htmlspecialchars($row['location'] ?? 'N/A') ?>
                  </p>
                </div>
                <div class="flex gap-2">
                  <i class='bx bx-ruler text-lg'></i>
                  <p class="text-xs font-semibold">
                    <?= htmlspecialchars($row['area'] ?? '0') ?> m²
                  </p>
                </div>
                <div class="flex gap-2">
                  <p class="text-xs font-semibold">USD</p>
                  <p class="text-xs font-semibold"> <?= number_format($row['price'] ?? 0, 0, ',', '.') ?>
                  </p>
                </div>
              </div>
   
            </div>
          </div>
        </div>
        <?php
      endwhile;
    endif;
    ?>

  </div>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
</body>

</html>