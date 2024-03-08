<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Πλατφόρμα Διαχείρισης Εργασιών</title>

    <link href="css/custom.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <?php require_once __DIR__ . '/../components/header.php'; ?>

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

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</div>
</body>
</html>
