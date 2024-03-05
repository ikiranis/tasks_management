<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Πλατφόρμα Διαχείρισης Εργασιών</title>

    <link href="../css/custom.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <section class="mb-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <strong>Δημιουργία του site</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div>Υλοποίηση του frontend</div>
                                <div>Υλοποίηση του backend</div>
                                <div>Σύνδεση frontend με backend</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <strong>Συντήρηση του site</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div>Επιδιόρθωση σφαλμάτων</div>
                                <div>Προσθήκη νέων λειτουργιών</div>
                                <div>Ενημέρωση του backend</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form class="mt-5 row">
                <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                    <input type="text" class="form-control" placeholder="Τίτλος Λίστας" aria-label="Τίτλος Λίστας">
                </div>

                <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                    <select class="form-select" aria-label="Κατηγορία">
                        <option selected value="1">Κατηγορία 1</option>
                        <option value="2">Κατηγορία 2</option>
                        <option value="3">Κατηγορία 3</option>
                    </select>
                </div>

                <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                    <button class="form-control btn btn-primary" type="button">Δημιουργία
                        Λίστας
                    </button>
                </div>

            </form>
        </div>
    </section>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</div>
</body>
</html>
