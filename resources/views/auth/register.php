<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>

<body>
    <main>
        <form method="post" action="<?php echo e(route('register.perform')); ?>">

            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

            <h1>Register</h1>

            <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="name@example.com" required="required" autofocus>
            <label>Email address</label>
            <?php if ($errors->has('email')) : ?>
                <span><?php echo e($errors->first('email')); ?></span>
            <?php endif; ?>

            <input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username" required="required" autofocus>
            <label>Username</label>
            <?php if ($errors->has('username')) : ?>
                <span><?php echo e($errors->first('username')); ?></span>
            <?php endif; ?>

            <input type="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password" required="required">
            <label>Password</label>
            <?php if ($errors->has('password')) : ?>
                <span><?php echo e($errors->first('password')); ?></span>
            <?php endif; ?>

            <input type="password" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>" placeholder="Confirm Password" required="required">
            <label>Confirm Password</label>
            <?php if ($errors->has('password_confirmation')) : ?>
                <span><?php echo e($errors->first('password_confirmation')); ?></span>
            <?php endif; ?>

            <button type="submit">Register</button>

            <p>&copy; <?php echo date('Y'); ?></p>
        </form>
    </main>
</body>

</html>
