<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
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

    <!-- Main content -->
    <main class="flex flex-col w-full h-full bg-gray-300 px-8 py-4 gap-8">
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
            <button>
                <div class="flex gap-4 text-white rounded-lg bg-blue-600 w-fit px-4 py-2">
                    <i class='bxr  bx-plus text-2xl'></i>
                    <span>Agregar inmueble</span>
                </div>
            </button>
        </div>
        <!-- Property list -->
        <div
            class="flex w-full h-full overflow-y-scroll bg-gray-600 rounded-lg scrollbar-none [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            <!-- Propery card -->
            <div class="w-[380px] h-[215px]  bg-blue-400 rounded-2xl shadow-lg relative overflow-hidden">
                <!-- Image -->
                <div class="w-full h-full">
                    <img src="https://picsum.photos/800" alt="Property Image" class="w-full h-full object-cover">
                </div>

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

                <!-- Content -->
                <div class="w-full h-full absolute inset-0 flex flex-col justify-between p-2">
                    <div class="flex justify-between">
                        <div class="px-3 py-1 text-sm bg-blue-600 rounded-lg text-white">
                            <p>Alquiler</p>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex gap-1 items-center text-white ">
                                <p class="font-semibold">1</p>
                                <i class='bx bx-bed text-xl'></i>
                            </div>
                            <div class="flex gap-1 items-center text-white ">
                                <p class="font-semibold">2</p>
                                <i class='bx bx-bath text-xl'></i>
                            </div>
                            <div class="flex gap-1 items-center text-white ">
                                <i class='bx bx-garage text-xl'></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between text-white ">
                        <div class="flex flex-col gap-1 justify-end">
                            <div class="flex gap-2">
                                <i class='bx bx-location-blank text-lg'></i>
                                <p class="text-xs font-semibold">Maipu</p>
                            </div>
                            <div class="flex gap-2">
                                <i class='bx bx-ruler text-lg'></i>
                                <p class="text-xs font-semibold">120 M2</p>
                            </div>
                            <div class="flex gap-2">
                                <p class="text-xs font-semibold">USD</p>
                                <p class="text-xs font-semibold"> $120.000
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
        </div>
    </main>
</body>

</html>