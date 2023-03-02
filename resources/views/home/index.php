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
        <?php echo auth()->user()->name; ?>
        <a href="<?php echo e(route('logout.perform')); ?>">logout</a>
    <?php else : ?>
        <a href="<?php echo e(route('login.perform')); ?>">login</a>
        <a href="<?php echo e(route('register.perform')); ?>">register</a>
    <?php endif; ?>

    <main>
        <?php if (auth()->check()) : ?>
            <h1>Dashboard</h1>
            <p>Only authenticated users can access this section.</p>
        <?php else : ?>
            <h1>Homepage</h1>
            <p>Your viewing the home page. Please login to view the restricted data.</p>
        <?php endif; ?>
    </main>
</body>

</html>