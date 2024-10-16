<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use App\Controllers\AuthController;
    use App\Helpers\FlashMessage;

    $authController = new AuthController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seed_admin'])) {
        $authController->seedAdmin();
    }

    $successMsg = FlashMessage::getMessage('success');
    $errorMsg = FlashMessage::getMessage('error');

?>
<!DOCTYPE html>
<html class="h-full bg-slate-100" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
    * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
            'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
            'Helvetica Neue', sans-serif;
    }
    </style>

    <title>Bangubank</title>
</head>

<body class="flex flex-col items-baseline justify-center min-h-screen">
    <section class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-12">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl">
            BanguBank
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48">
            BanguBank is a simple banking application with features for both 'Admin'
            and 'Customer' users.
        </p>

        <?php if (isset($successMsg)): ?>
        <div class="max-w-screen-xl mx-64 mb-8 text-center bg-teal-200 border border-teal-200 text-teal-800 text-sm rounded-lg p-4"
            role="alert">
            <span class="font-bold"><?=$successMsg;?></span>
        </div>
        <?php elseif (isset($errorMsg)): ?>
        <div class="max-w-screen-xl mx-64 mb-8 text-center bg-red-200 border border-red-200 text-red-800 text-sm rounded-lg p-4"
            role="alert">
            <span class="font-bold"><?=$errorMsg;?></span>
        </div>
        <?php endif;?>

        <div class="flex flex-col gap-2 mb-8 lg:mb-8 md:flex-row md:justify-center">
            <a href="./login.php" type="button"
                class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                Login
            </a>

            <a href="./register.php" type="button"
                class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                Register
            </a>
            <a href="./admin/customers.php" type="button"
                class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                Admin View
            </a>
            <a href="./customer/dashboard.php" type="button"
                class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                Customer View
            </a>
            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="hidden" name="seed_admin">
                <button type="submit"
                    class="text-white bg-stone-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                    Seed Admin
                </button>
            </form>
        </div>

        <div class="max-w-screen-xl mx-64 mb-8 text-center bg-sky-200 border border-teal-200 text-sm text-teal-800 rounded-lg p-4"
            role="alert">
            <p class="font-bold mb-2 italic">Before proceed please seed the admin</p>
            <span class="font-semibold">admin: admin@gmail.com | password: password</span>
        </div>
    </section>
</body>

</html>