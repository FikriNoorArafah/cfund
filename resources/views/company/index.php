<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company CareerFund</title>
</head>

<body>
    <p><?php
        if (session()->has('success')) {
            echo session()->get('success');
        }
        ?>
    </p>
    <main id="nav">
        <?php if (auth()->guard('company')->check()) : ?>
            <h1>Dashboard</h1>
            <p>Anda sudah login</p>
            <li><?php echo auth()->guard('company')->user()->name; ?></li>
            <li><?php echo auth()->guard('company')->user()->email; ?></li>
            <li><?php echo auth()->guard('company')->user()->username; ?></li>
            <li><?php echo auth()->guard('company')->user()->url_icon; ?></li>
            <a href="<?php echo e(route('logout.company')); ?>">logout</a>
        <?php else : ?>
            <h1>Homepage</h1>
            <p>Anda belum login</p>
            <a href="<?php echo e(route('login.perform')); ?>">login</a>
            <a href="<?php echo e(route('register.perform')); ?>">register</a>
        <?php endif; ?>

    </main>

</body>

</html>