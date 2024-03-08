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

    <?php
    echo $_SESSION['username'];

    echo \apps4net\tasks\libraries\Permission::getPermissionFor('index');
    ?>

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

            <div class="d-flex justify-content-center">
                <a href="/login">
                    <button class="btn btn-primary mt-3 mx-3" type="button">Είσοδος</button>
                </a>
                <a href="/register">
                    <button class="btn btn-primary mt-3 mx-3" type="button">Εγγραφή</button>
                </a>
            </div>

        </div>
    </section>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</div>
</body>
</html>
