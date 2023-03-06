<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerFund</title>
</head>

<body>
    <main id="nav">
        <?php if (auth()->check()) : ?>
            <h1>Dashboard</h1>
            <p>Anda sudah login</p>
            <li><?php echo auth()->user()->name; ?></li>
            <li><?php echo auth()->user()->email; ?></li>
            <li><?php echo auth()->user()->telephone; ?></li>
            <li><?php echo auth()->user()->username; ?></li>
            <li><?php echo auth()->user()->url_icon; ?></li>
            <a href="<?php echo e(route('logout.perform')); ?>">logout</a>
        <?php else : ?>
            <h1>Homepage</h1>
            <p>Anda belum login</p>
            <a href="<?php echo e(route('login.perform')); ?>">login</a>
            <a href="<?php echo e(route('register.perform')); ?>">register</a>
        <?php endif; ?>
    </main>
    <main id="partners">
        <h1>Perusahaan yang berkerjasama dengan kami:</h1>
        <?php foreach ($partners as $partner) { ?>
            <ul>
                <li><?php echo $partner->name ?></li>
                <li><?php echo $partner->url_icon ?></li>
            </ul>
        <?php } ?>
    </main>
    <main id="wts">
        <h1>Apa kata mereka</h1>
        <?php foreach ($wts as $childwts) { ?>
            <ul>
                <li><?php echo $childwts->author ?></li>
                <li><?php echo $childwts->position ?></li>
                <li><?php echo $childwts->quote ?></li>
            </ul>
        <?php } ?>
    </main>
</body>

</html>