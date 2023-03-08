<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')) ?>">
</head>

<body>
    <header>
        <h1>My Documentation</h1>
        <nav>
            <ul>
                <li><a href="#Postman">Postman</a></li>
                <li><a href="#Guest">Guest</a></li>
                <li><a href="#section2">User</a></li>
                <li><a href="#section3">Compay</a></li>
                <li><a href="#section4">Compay</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <details class="parent" id="Postman">
            <summary>Postman</summary>
            <details>
                <summary>GET</summary>
                <p>untuk nampilin dalam bentuk json > copy link get, buka headers lalu tambahkan <b>X-Requested-With</b> : <b>XMLHttpRequest</b>
                </p>
            </details>
            <details>
                <summary>POST</summary>
                <p>untuk laravel itu punya Cross-Site Request Forgery (CSRF)</p>
                <p>buat tau token csrf kita pake <i>GET</i>: baseurl/get-csrf-token </p>
                <p>buat ngepost ini kita harus ngirim juga csrf tokennya, contohnya <?php echo html_entity_decode('<input type="hidden" name="_token" value="csrf_token()" />'); ?>.</p>
                <p>buat di postman cuma nambahin di header aja <b>X-CSRF-TOKEN</b> : <b>(token csrf kita)</b></p>
            </details>
        </details>
        <details class="parent" id="Guest">
            <summary>Guest</summary>
            <details>
                <summary>Landing</summary>
                <p>Route : baseurl/</p>
                <p></p>
            </details>
            <details>
                <summary>Login</summary>
                <p>Route : baseurl/login</p>
                <p>Post : username, password</p>
                <p>buat nama input username, input bisa email bisa username</p>
            </details>
            <details>
                <summary>Register</summary>
                <p>Route : baseurl/register</p>
                <p>Post : name, telephone, email, password, password_confirmation</p>
            </details>
        </details>
        <details class="parent" id="User">
            <summary>User</summary>
        </details>
        <details class="parent" id="Company">
            <summary>Company</summary>
        </details>
        <details class="parent" id="Admin">
            <summary>Admin</summary>
        </details>
    </main>
    <footer>
        <p>Copyright &copy; <?php echo date('Y'); ?> My Documentation.
            All rights reserved.</p>
    </footer>
</body>

</html>