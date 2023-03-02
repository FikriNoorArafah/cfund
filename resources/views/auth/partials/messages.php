//notif klo ada error

<?php if (isset($errors) && count($errors) > 0) : ?>
    <ul>
        <?php foreach ($errors->all() as $error) : ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;
if (Session::get('success', false)) :
    $data = Session::get('success');
    if (is_array($data)) :
        foreach ($data as $msg) :
            echo $msg;
        endforeach;
    else :
        echo $data;
    endif;
endif; ?>