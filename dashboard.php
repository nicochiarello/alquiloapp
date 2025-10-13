<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body class="flex flex-col sm:flex-row w-full h-screen overflow-x-hidden">
  <!-- Sidebar -->
  <div
    class="hidden sm:flex flex-col items-center lg:items-start gap-2  lg:w-[280px] h-screen bg-blue-500 p-4 rounded-r-4xl">
    <div class="flex gap-2 items-center">
      <p>L</p>
      <h1 class="hidden lg:block text-2xl font-semibold text-white">AlquiloApp</h1>
    </div>
    <div class="flex flex-col justify-between items-center lg:items-start h-full w-full bg-red-300">
      <div class="text-white w-full h-fit flex justify-center lg:justify-start gap-8 p-4 rounded-2xl bg-blue-900">
        <p>Icon</p>
        <h2 class="hidden lg:block">Administrador</h2>
      </div>
      <ul class="flex text-gray-700 flex-col p-4">
        <li class="flex gap-8">
          <p>Icon</p>
          <a class="hidden lg:block" href="#">
            Cerrar sesión
          </a>
        </li>
        <li class="flex gap-8">
          <p>Icon</p>
          <a class="hidden lg:block" href="#">
            Ayuda
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Navbar mobile -->
  <div class="sm:hidden w-full h-16 bg-blue-500 flex items-center justify-between px-4">
    <div class="flex gap-2 items-center">
      <p>L</p>
      <h1 class="text-2xl font-semibold text-white">AlquiloApp</h1>
    </div>
    <div class="flex gap-4">
      <p>Icon</p>
      <p>Icon</p>
    </div>
  </div>

  <!-- Main content -->
  <main class="flex flex-col bg-gray-300 p-2 sm:w-full sm:px-8 sm:py-4 gap-8">
    <div class="flex flex-col gap-4">
      <div class="flex gap-4 items-center ">
        <div class="p-4 rounded-full bg-blue-600 text-white">
          <i class='bx  bx-user text-[54px]'></i>
        </div>
        <div class="flex-col gap-4">
          <h3 class="text-2xl font-semibold">Hola, Nicolas Chiarello</h3>
          <p>Administra tus inmuebles aqui</p>
        </div>
      </div>
      <button id="openCreate">
        <div class="flex gap-4 text-white rounded-lg bg-blue-600 w-fit px-4 py-2">
          <i class='bxr  bx-plus text-2xl'></i>
          <span>Agregar inmueble</span>
        </div>
      </button>
    </div>

    <!-- Property list -->
    <div
      class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 p-4 w-full h-full overflow-y-scroll bg-gray-600 rounded-lg scrollbar-none [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
      <?php
      //  DB connection
      require_once 'db_connect.php';

      $result = $conn->query("SELECT * FROM property ORDER BY id DESC");


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
                <div class="flex flex-col gap-2">
                  <button class="flex items-center justify-center p-2 bg-red-600 rounded-lg text-white">
                    <i class="bx bx-trash text-xl"></i>
                  </button>
                  <button class="flex items-center justify-center p-2 bg-blue-600 rounded-lg text-white">
                    <i class="bx bx-edit text-xl"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <?php
        endwhile;
      endif;
      ?>

    </div>

    <!-- Create Property Modal -->
    <dialog id="createModal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
         w-[min(600px,92vw)] max-h-[90svh] overflow-auto rounded-2xl p-0
         shadow-xl
         [&::backdrop]:bg-black/50 [&::backdrop]:backdrop-blur-sm">
      <!-- Header -->
      <div class="flex items-center justify-between p-4 border-b">
        <h2 class="text-lg font-semibold">Crear inmueble</h2>
        <button id="closeCreate" class="p-2 rounded hover:bg-gray-100">
          <i class="bx bx-x text-2xl"></i>
        </button>
      </div>

      <!-- Form -->
      <form action="property/create.php" method="POST" enctype="multipart/form-data" class="p-4 space-y-4">
        <!-- CSRF (server should generate this token) -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <!-- Title -->
        <div class="flex flex-col gap-1">
          <label for="title" class="text-sm font-medium">Título</label>
          <input id="title" name="title" type="text" required maxlength="120"
            class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Depto 2 ambientes en Maipú">
        </div>

        <!-- Type & Price -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="grid gap-1">
            <label for="type" class="text-sm font-medium">Tipo</label>
            <select id="type" name="type" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
              <option value="rent">Alquiler</option>
              <option value="sale">Venta</option>
            </select>
          </div>
          <div class="flex flex-col gap-1">
            <label for="price" class="text-sm font-medium">Precio</label>
            <input id="price" name="price" type="number" min="0" step="1" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="120000">
          </div>
        </div>

        <!-- Location & Area -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="grid gap-1">
            <label for="location" class="text-sm font-medium">Ubicación</label>
            <input id="location" name="location" type="text" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Maipú, Mendoza">
          </div>
          <div class="flex flex-col gap-1">
            <label for="area" class="text-sm font-medium">Superficie (m²)</label>
            <input id="area" name="area" type="number" min="0" step="1" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" placeholder="120">
          </div>
        </div>

        <!-- Beds / Baths / Garage -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1">
            <label for="beds" class="text-sm font-medium">Dorm.</label>
            <input id="beds" name="beds" type="number" min="0" step="1" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" value="1">
          </div>
          <div class="flex flex-col gap-1">
            <label for="baths" class="text-sm font-medium">Baños</label>
            <input id="baths" name="baths" type="number" min="0" step="1" required
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" value="1">
          </div>
          <div class="flex flex-col content-end">
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="garage" class="size-4">
              <span class="text-sm">Garage</span>
            </label>
          </div>
        </div>

        <!-- Description -->
        <div class="flex flex-col gap-1">
          <label for="description" class="text-sm font-medium">Descripción</label>
          <textarea id="description" name="description" rows="4" required
            class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Luminoso, cercano a..."></textarea>
        </div>

        <!-- Image -->
        <div class="grid gap-1">
          <label for="image" class="text-sm font-medium">Imagen principal</label>
          <input id="image" name="image" type="file" accept="image/*" class="border w-full rounded-lg px-3 py-2">
          <p class="text-xs text-gray-500">JPG/PNG hasta 2MB.</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-2 pt-2 border-t">
          <button type="button" id="cancelCreate" class="px-4 py-2 rounded-lg border">Cancelar</button>
          <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            Guardar
          </button>
        </div>
      </form>
    </dialog>
  </main>




  <script>
    // Minimal, accessible open/close logic (no external deps)
    const openBtn = document.getElementById('openCreate');
    const modal = document.getElementById('createModal');
    const closeBtn = document.getElementById('closeCreate');
    const cancelBtn = document.getElementById('cancelCreate');

    // Remember last focused element to restore focus after close
    let lastFocus = null;

    function openModal() {
      lastFocus = document.activeElement;
      if (typeof modal.showModal === 'function') {
        modal.showModal();
        // Focus first input
        const firstInput = modal.querySelector('input, select, textarea, button');
        firstInput?.focus();
      } else {
        // Fallback if <dialog> not supported
        modal.setAttribute('open', '');
      }
    }
    function closeModal() {
      modal.close();
      lastFocus?.focus();
    }

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);

    // Optional: close on backdrop click
    modal.addEventListener('click', (e) => {
      const rect = modal.getBoundingClientRect();
      const inDialog = (
        e.clientX >= rect.left && e.clientX <= rect.right &&
        e.clientY >= rect.top && e.clientY <= rect.bottom
      );
      if (!inDialog) closeModal();
    });
  </script>
</body>

</html>