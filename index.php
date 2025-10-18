<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="./styles/output.css">
    <title>Document</title>
</head>

<body class="flex flex-col">
    <div class="flex flex-col w-full h-screen max-h-[1100px]">
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
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>