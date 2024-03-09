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
            <h3>Καλωσορίσατε στην Πλατφόρμα Διαχείρισης Εργασιών</h3>

            <p>Η πλατφόρμα διαχείρισης εργασιών είναι μια εφαρμογή που σας βοηθάει να οργανώσετε τις εργασίες σας και να
                τις ολοκληρώσετε εγκαίρως. Μπορείτε να δημιουργήσετε λίστες εργασιών και να τις οργανώσετε σε
                ομάδες.</p>

            <div class="row mt-5">
                <div class="col-12 col-lg my-auto">
                    <img src="images/add_tasks.svg" alt="Add Tasks" width="80%">
                </div>
                <div class="col-12 col-lg mt-3 mt-lg-0 my-auto">
                    <img src="images/organize_tasks.svg" alt="Organize Tasks" width="80%">
                </div>
            </div>

            <?php
            // Display the login and register buttons if the user is not logged in

            if (!isset($_SESSION['username'])) {
                ?>
                <div class="d-flex justify-content-center">
                    <a href="/login">
                        <button class="btn btn-primary mt-3 mx-3" type="button">Είσοδος</button>
                    </a>
                    <a href="/register">
                        <button class="btn btn-primary mt-3 mx-3" type="button">Εγγραφή</button>
                    </a>
                </div>
                <?php
            }
            ?>

        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>
