<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./styles/output.css">
  <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col flex-1">

  <!-- Navbar  -->
  <?php include 'includes/navbar.php'; ?>

  <div class="h-full flex flex-1 items-center justify-center">
    <div class="bg-white rounded-2xl px-8 py-16 shadow-md w-full max-w-md">
      <!-- Logo -->
      <div class="w-24 mx-auto mb-8">
        <?php include './public/logo.svg'; ?>
      </div>

      <h2 class="text-2xl font-bold mb-6 text-center">Iniciar sesión</h2>

      <?php if (!empty($_GET['errors']) && is_array($_GET['errors'])): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
          <ul class="list-disc pl-5">
            <?php foreach ($_GET['errors'] as $msg): ?>
              <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/alquiloapp/auth/login.php" method="POST" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email"
            value="<?= isset($_GET['old']['email']) ? htmlspecialchars($_GET['old']['email']) : '' ?>" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <?php if (isset($_GET['field_errors']['email'])): ?>
            <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($_GET['field_errors']['email']) ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" id="password" name="password" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <?php if (isset($_GET['field_errors']['password'])): ?>
            <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($_GET['field_errors']['password']) ?></p>
          <?php endif; ?>
        </div>

        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Entrar
        </button>
      </form>

      <p class="text-center text-sm text-gray-500 mt-4">
        ¿No tenés cuenta? <a class="text-blue-600 underline" href="/alquiloapp/register.php">Registrate</a>
      </p>
    </div>
  </div>
</body>

</html>