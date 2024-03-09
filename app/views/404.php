<?php
use apps4net\tasks\libraries\App;
?>

<!DOCTYPE html>
<html lang="en">

<?php App::component('head'); ?>

<body>
<div class="container">
    <?php App::component('header'); ?>

    <section class="container">
        <div class="text-center">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Η σελίδα δεν υπάρχει!</h4>
                <p>Δυστυχώς, η σελίδα που αναζητάτε δεν υπάρχει ή δεν έχετε δικαιώματα πρόσβασης.</p>
                <hr>
                <p class="mb-0">Παρακαλούμε επιστρέψτε στην αρχική σελίδα ή επικοινωνήστε με τον διαχειριστή για περισσότερες πληροφορίες.</p>
            </div>
        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>
