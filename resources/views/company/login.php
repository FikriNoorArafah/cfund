<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login company</title>
</head>

<body>
    <form method="post" action="<?php echo e(route('login.perform')); ?>">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

        <h1>Login</h1>

        <?php include('partials/messages.php'); ?>

        <input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username" required="required" autofocus>
        <label>Email or Username</label>
        <?php if ($errors->has('username')) : ?>
            <span><?php echo e($errors->first('username')); ?></span>
        <?php endif; ?>

        <input type="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password" required="required">
        <label>Password</label>
        <?php if ($errors->has('password')) : ?>
            <span><?php echo e($errors->first('password')); ?></span>
        <?php endif; ?>

        <button type="submit">Login</button>

        <p>&copy; <?php echo date('Y'); ?></p>
    </form>
</body>

</html>
