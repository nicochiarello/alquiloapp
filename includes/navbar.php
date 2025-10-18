<div class="w-full py-4 bg-primary flex items-center justify-between px-8">
    <div class="flex gap-2 items-center">
        <div class="w-8 h-8">
            <?php include './public/logo.svg'; ?>
        </div>
        <h1 class="hidden sm:block font-semibold text-2xl text-white">AlquiloApp</h1>
    </div>
    <?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        echo '<div class="flex items-center gap-12 text-white">
                        <a href="./dashboard.php">Administrador</a>
                      </div>';
    } else {
        echo '<div class="flex items-center gap-12 text-white">
                <a href="./login.php">Iniciar Sesión</a>
                <a href="./register.php">Registrarse</a>
            </div>';
    }
    ?>

</div>