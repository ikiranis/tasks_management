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
                            <form action="registerUser" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Όνομα Χρήστη</label>
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Ονοματεπώνυμο</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Κωδικός Πρόσβασης</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="verify_password" class="form-label">Επιβεβαίωση Κωδικού</label>
                                    <input type="password" class="form-control" name="verify_password" id="verify_password" required>
                                </div>

                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-primary w-75">Εγγραφή</button>
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
