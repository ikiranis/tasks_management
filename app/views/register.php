<?php

use apps4net\tasks\libraries\App;

?>

<!DOCTYPE html>
<html lang="en">

<?php App::component('head'); ?>

<body>
<div class="container">
    <?php App::component('header'); ?>

    <section class="mb-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Εγγραφή Χρήστη</h3>
                        </div>
                        <div class="card-body text-start">
                            <?php App::component('registerForm'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>

<?php
// Load the JavaScript for register
App::component('error');
App::script('register');
?>
