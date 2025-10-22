<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./styles/output.css">
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

  <!-- Trix -->
  <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
  <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
</head>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  // Not logged in, redirect to login
  header("Location: /alquiloapp/login.php");

  exit;
}
?>

<body class="flex flex-col sm:flex-row w-full h-screen overflow-x-hidden bg-bg">
  <!-- Sidebar -->
  <div
    class="hidden sm:flex flex-col items-center lg:items-start gap-2  lg:w-[280px] h-screen bg-primary p-4 rounded-r-4xl">
    <div class="flex gap-4 items-center">
      <!-- Logo -->
      <div class="w-8 h-8">
        <?php include './public/logo.svg'; ?>
      </div>

      <h1 class="hidden lg:block text-2xl font-semibold text-white">AlquiloApp</h1>
    </div>
    <div class="flex flex-col justify-between items-center lg:items-start h-full w-full mt-10">
      <div
        class="text-white w-full h-fit flex items-center justify-center lg:justify-start gap-4 p-4 rounded-2xl bg-gradient-to-r from-[#014EFF] to-[#578AFF]">
        <i class='bxr  bx-dashboard text-2xl'></i>
        <h2 class="hidden lg:block font-semibold">Administrador</h2>
      </div>
      <ul class="flex text-gray-300 flex-col gap-2 p-4">
        <li class="flex items-center gap-4">
          <i class='bxr  bx-arrow-in-left-square-half '></i>
          <a class="hidden lg:block" href="auth/logout.php">
            Cerrar sesión
          </a>
        </li>
        <li class="flex items-center gap-4">
          <i class='bxr  bx-help-circle'></i>
          <a class="hidden lg:block" href="#">
            Ayuda
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Navbar mobile -->
  <div class="sm:hidden w-full h-16 bg-primary flex items-center justify-between px-4">
    <div class="flex gap-2 items-center">
      <div class="w-8 h-8">
        <?php include './public/logo.svg'; ?>
      </div>
      <h1 class="text-2xl font-semibold text-white">AlquiloApp</h1>
    </div>
    <div class="flex gap-4">
      <i class='bxr  bx-help-circle text-white text-2xl'></i>
      <a href="auth/logout.php">
        <i class='bxr  bx-arrow-in-left-square-half  text-white text-2xl'></i>
      </a>
    </div>
  </div>

  <!-- Main content -->
  <main class="flex flex-col p-2 sm:w-full sm:px-8 sm:py-4 gap-8">
    <div class="flex flex-col gap-4">
      <div class="flex gap-4 items-center ">
        <div class="p-4 rounded-full bg-btn-primary text-white">
          <i class='bx  bx-user text-[54px]'></i>
        </div>
        <div class="flex-col gap-4">
          <h3 class="text-2xl font-semibold capitalize">Hola, <?php echo $_SESSION['user_name'] ?></h3>
          <p>Administra tus inmuebles aqui</p>
        </div>
      </div>
      <button id="openCreate">
        <div class="flex gap-4 text-white rounded-lg bg-btn-primary w-fit px-4 py-2">
          <i class='bxr  bx-plus text-2xl'></i>
          <span>Agregar inmueble</span>
        </div>
      </button>
    </div>

    <!-- Property list -->
    <div
      class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 p-4 w-full h-full overflow-y-scroll shadow-2xl rounded-2xl scrollbar-none [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
      <?php
      //  DB connection
      require_once 'db_connect.php';

      // Use a prepared statement and cast user_id to int to avoid SQL injection and parsing issues
      $userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
      $stmt = $conn->prepare("SELECT * FROM property WHERE user_id = ? ORDER BY id DESC");
      $stmt->bind_param("i", $userId);
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
                <div class="flex flex-col gap-2">
                  <form method="POST" action="property/delete.php" onsubmit="return confirm('¿Eliminar este inmueble?');">
                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                    <button type="submit" class="flex items-center justify-center p-2 bg-red-600 rounded-lg text-white">
                      <i class="bx bx-trash text-xl"></i>
                    </button>
                  </form>

                  <button type="button"
                    class="editBtn flex items-center justify-center p-2 bg-blue-600 rounded-lg text-white"
                    data-id="<?= $row['id'] ?>" data-title="<?= htmlspecialchars($row['title']) ?>"
                    data-type="<?= $row['type'] ?>" data-price="<?= (int) $row['price'] ?>"
                    data-location="<?= htmlspecialchars($row['location']) ?>" data-area="<?= (int) $row['area'] ?>"
                    data-beds="<?= (int) $row['beds'] ?>" data-baths="<?= (int) $row['baths'] ?>"
                    data-garage="<?= (int) $row['garage'] ?>"
                    data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                    data-image="<?= htmlspecialchars($row['image'] ? '/' . ltrim($row['image'], '/') : '') ?>">
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
  w-[min(600px,92vw)] max-h-[90svh] overflow-auto rounded-2xl p-0 shadow-xl
  [&::backdrop]:bg-black/50 [&::backdrop]:backdrop-blur-sm">

      <!-- Header -->
      <div class="flex items-center justify-between p-4 border-b">
        <h2 id="modalTitle" class="text-lg font-semibold">Crear inmueble</h2>
        <button id="closeCreate" class="p-2 rounded hover:bg-gray-100">
          <i class="bx bx-x text-2xl"></i>
        </button>
      </div>

      <!-- Form for update-delete -->
      <form id="propertyForm" action="property/create.php" method="POST" enctype="multipart/form-data"
        class="p-4 space-y-4">
        <!-- Hidden for EDIT -->
        <input type="hidden" name="id" id="propId">
        <input type="hidden" name="image_old" id="imageOld">

        <!-- Preview imagen -->
        <div id="currentImageWrap" class="hidden">
          <p class="text-sm text-gray-600 mb-1">Imagen actual:</p>
          <img id="currentImage" src="" alt="Imagen actual" class="w-full max-h-56 object-cover rounded">
        </div>

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
              <input type="checkbox" id="garage" name="garage" class="size-4">
              <span class="text-sm">Garage</span>
            </label>
          </div>
        </div>

        <!-- Description -->
        <div class="flex flex-col gap-1">
          <input id="description" type="hidden" name="description" value="">
          <trix-editor input="description" class="border rounded-lg px-3 py-2"></trix-editor>
        </div>

        <!-- Image -->
        <div class="grid gap-1">
          <label for="image" class="text-sm font-medium">Imagen principal (opcional)</label>
          <input id="image" name="image" type="file" accept="image/*" class="border w-full rounded-lg px-3 py-2">
          <p class="text-xs text-gray-500">JPG/PNG/WEBP.</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-2 pt-2 border-t">
          <button type="button" id="cancelCreate" class="px-4 py-2 rounded-lg border">Cancelar</button>
          <button id="submitBtn" type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            Guardar
          </button>
        </div>
      </form>
    </dialog>

  </main>




  <script>
    // Elements
    const openBtn = document.getElementById('openCreate');
    const modal = document.getElementById('createModal');
    const closeBtn = document.getElementById('closeCreate');
    const cancelBtn = document.getElementById('cancelCreate');

    const form = document.getElementById('propertyForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');

    // Inputs
    const idInput = document.getElementById('propId');
    const imgOldInp = document.getElementById('imageOld');

    const titleInp = document.getElementById('title');
    const typeSel = document.getElementById('type');
    const priceInp = document.getElementById('price');
    const locInp = document.getElementById('location');
    const areaInp = document.getElementById('area');
    const bedsInp = document.getElementById('beds');
    const bathsInp = document.getElementById('baths');
    const garageChk = document.getElementById('garage');
    const descTxt = document.getElementById('description');
    const imageInp = document.getElementById('image');

    const trixInput = document.getElementById('description');
    const trixEditor = document.querySelector('trix-editor[input="description"]');


    // Current image preview for edit
    const currentImageWrap = document.getElementById('currentImageWrap');
    const currentImage = document.getElementById('currentImage');

    // Helpers
    function openDialog() {
      if (typeof modal.showModal === 'function') modal.showModal();
      else modal.setAttribute('open', '');
    }

    function closeDialog() {
      modal.close();
      form.reset();
    }

    function decodeHtml(str = '') {
      const t = document.createElement('textarea');
      t.innerHTML = str;
      return t.value;
    }


    function setModeCreate() {
      modalTitle.textContent = 'Crear inmueble';
      submitBtn.textContent = 'Guardar';
      form.action = 'property/create.php';

      // Clear all fields
      idInput.value = '';
      imgOldInp.value = '';
      titleInp.value = '';
      typeSel.value = 'rent';
      priceInp.value = '';
      locInp.value = '';
      areaInp.value = '';
      bedsInp.value = 0;
      bathsInp.value = 0;
      garageChk.checked = false;
      descTxt.value = '';
      imageInp.value = '';

      currentImageWrap.classList.add('hidden');
      currentImage.src = '';

      trixInput.value = '';
      trixEditor.editor.loadHTML(''); // clears the editor
    }

    function setModeEdit(data) {
      modalTitle.textContent = 'Editar inmueble';
      submitBtn.textContent = 'Guardar cambios';
      form.action = 'property/update.php';

      idInput.value = data.id || '';
      imgOldInp.value = data.image || '';

      titleInp.value = data.title || '';
      typeSel.value = data.type || 'rent';
      priceInp.value = data.price || 0;
      locInp.value = data.location || '';
      areaInp.value = data.area || 0;
      bedsInp.value = data.beds || 0;
      bathsInp.value = data.baths || 0;
      garageChk.checked = (String(data.garage) === '1');
      descTxt.value = data.description || '';
      imageInp.value = "";
      document.getElementById('description').value = data.description || '';



      if (data.image) {
        currentImage.src = data.image.startsWith('/')
          ? window.location.origin + '/alquiloapp' + data.image
          : window.location.origin + '/alquiloapp/' + data.image;
        currentImageWrap.classList.remove('hidden');
      } else {
        currentImageWrap.classList.add('hidden');
        currentImage.src = '';
      }

      const html = decodeHtml(data.description || '');

      // Sets the hidden input value (source of truth of the trix editor)
      trixInput.value = html;

      // Update the visual editor
      trixEditor.editor.loadHTML(html);
    }

    // Open create
    openBtn?.addEventListener('click', () => {
      setModeCreate();
      openDialog();
    });

    // Open edit
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.editBtn');
      if (!btn) return;

      const data = {
        id: btn.dataset.id,
        title: btn.dataset.title,
        type: btn.dataset.type,
        price: btn.dataset.price,
        location: btn.dataset.location,
        area: btn.dataset.area,
        beds: btn.dataset.beds,
        baths: btn.dataset.baths,
        garage: btn.dataset.garage,
        description: btn.dataset.description,
        image: btn.dataset.image
      };

      setModeEdit(data);
      openDialog();
    });

    // Close
    closeBtn?.addEventListener('click', closeDialog);
    cancelBtn?.addEventListener('click', closeDialog);

    // Backdrop click
    modal.addEventListener('click', (e) => {
      const rect = modal.getBoundingClientRect();
      const inDialog = (
        e.clientX >= rect.left && e.clientX <= rect.right &&
        e.clientY >= rect.top && e.clientY <= rect.bottom
      );
      if (!inDialog) closeDialog();
    });
  </script>

</body>

</html>