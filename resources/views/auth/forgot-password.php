<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
            <?php if ($errors->has('email')) : ?>
                <span role="alert"><?php echo e($errors->first('email')); ?></span>
            <?php endif; ?>
        </div>

        <div>
            <button type="submit">
                Send Password Reset Link
            </button>
        </div>
    </form>
</body>

</html>