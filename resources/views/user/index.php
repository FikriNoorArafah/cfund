<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerFund</title>
</head>

<body>
    <?php if (auth()->check()) : ?>

        <li><?php echo auth()->user()->name; ?></li>
        <li><?php echo auth()->user()->email; ?></li>
        <li><?php echo auth()->user()->telephone; ?></li>
        <li><?php echo auth()->user()->username; ?></li>
        <li><?php echo auth()->user()->url_icon; ?></li>
        <a href="<?php echo e(route('logout.perform')); ?>">logout</a>
    <?php else : ?>
        <a href="<?php echo e(route('login.perform')); ?>">login</a>
        <a href="<?php echo e(route('register.perform')); ?>">register</a>
    <?php endif; ?>

    <main>
        <?php if (auth()->check()) : ?>
            <h1>Dashboard</h1>
            <p>Anda sudah login</p>
        <?php else : ?>
            <h1>Homepage</h1>
            <p>Anda belum login</p>
        <?php endif; ?>
    </main>
    <main id="partners">
        <h1>Perusahaan yang berkerjasama dengan kami:</h1>
        <ul>
            <?php foreach ($partners as $partner) { ?>
                <li><?php echo $partner->name ?></li>
                <li><?php echo $partner->url_icon ?></li>
            <?php } ?>
        </ul>
    </main>
</body>

</html>