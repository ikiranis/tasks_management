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
    <header>
        <div class="bg-dark text-center text-light py-3">
            <h1>Πλατφόρμα Διαχείρισης Εργασιών</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light my-0">
            <a class="navbar-brand" href="../index.html">
                <img src="../images/logo.svg" alt="Logo" width="100">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-light" href="../index.html">Αρχική</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-light active" href="tasks.html">Λίστα εργασιών</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-light" href="groups.php">Ομάδες</a>
                    </li>
                </ul>

                <a class="btn ms-auto" href="login.php" title="Είσοδος">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd"
                              d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>
            </div>
        </nav>
    </header>

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

    <footer class="fixed-bottom">
        <div class="container bg-dark text-light py-1 text-center">
            <div class="d-flex justify-content-center">
                <span class="mx-1"><a href="#" class="text-light">Όροι Χρήσης</a></span>
                <span class="mx-1">|</span>
                <span class="mx-1"><a href="#" class="text-light">Πολιτική Απορρήτου</a></span>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
