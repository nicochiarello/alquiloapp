<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex w-screen h-screen">
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
</body>

</html>