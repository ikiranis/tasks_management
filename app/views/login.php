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
                    <div class="card mt-5">
                        <div class="card-header">
                            <h3>Είσοδος Χρήστη</h3>
                        </div>
                        <div class="card-body text-start">
                            <form action="checkLogin" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Όνομα Χρήστη</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Κωδικός Πρόσβασης</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-primary w-75">Είσοδος</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <a href="register">Εγγραφή νέου χρήστη</a>
                                </div>
                            </form>
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
