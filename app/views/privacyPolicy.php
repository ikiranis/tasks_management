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
        <h1 class="my-4">Πολιτική Απορρήτου</h1>

        <div class="card mb-4">
            <div class="card-header">1. Εισαγωγή</div>
            <div class="card-body">
                <p>Στην ιστοσελίδα μας, σεβόμαστε την ιδιωτικότητά σας και κατανοούμε τη σημασία της προστασίας των
                    προσωπικών σας δεδομένων.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">2. Συλλογή Προσωπικών Δεδομένων</div>
            <div class="card-body">
                <p>Μπορεί να συλλέγουμε προσωπικά δεδομένα όπως το όνομα, η διεύθυνση email, η διεύθυνση IP και άλλες
                    πληροφορίες που παρέχετε εθελοντικά μέσω της ιστοσελίδας μας.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">3. Χρήση Προσωπικών Δεδομένων</div>
            <div class="card-body">
                <p>Χρησιμοποιούμε τα προσωπικά σας δεδομένα για να παρέχουμε τις υπηρεσίες μας, να απαντήσουμε στις
                    ερωτήσεις σας και να βελτιώσουμε την εμπειρία σας στην ιστοσελίδα μας.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">4. Προστασία Προσωπικών Δεδομένων</div>
            <div class="card-body">
                <p>Λαμβάνουμε όλα τα απαραίτητα μέτρα για να προστατεύσουμε τα προσωπικά σας δεδομένα από ανεξέλεγκτη
                    πρόσβαση, τροποποίηση, διαγραφή ή διαρροή.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">5. Τροποποιήσεις</div>
            <div class="card-body">
                <p>Διατηρούμε το δικαίωμα να τροποποιήσουμε αυτήν την Πολιτική Απορρήτου ανά πάσα στιγμή. Οι
                    τροποποιημένοι όροι θα ισχύουν από την ημερομηνία δημοσίευσής τους στην ιστοσελίδα μας.</p>
            </div>
        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>
