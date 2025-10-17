<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./styles/output.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">
                Registro
            </h2>
            <form action="auth/register.php" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <?php
                    if (isset($_GET['email'])) {

                        $email = $_GET['email'];
                        echo '<p class="text-red-500 text-sm mt-1">', htmlspecialchars($email), '</p>';
                    }
                    ?>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <?php if (isset($_GET['errors']['password'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($_GET['errors']['password']) ?></p>
                    <?php endif;
                    ?>
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Repetir
                        contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">


                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Registrarse
                    </button>
                </div>
            </form>


            <p class="text-center text-sm text-gray-500 mt-4">
                ¿Ya tenés una cuenta? <a class="text-blue-600 underline" href="/alquiloapp/login.php">Iniciá sesión</a>
            </p>

        </div>

    </div>
</body>

</html>