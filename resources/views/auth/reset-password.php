<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <h1>Reset Password</h1>

    <form method="POST" action="<?php route('password.update') ?>">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="token" value="<?php $request->route('token') ?>">

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php old('email') ?>" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</body>

</html>