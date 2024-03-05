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
                <div class="card col-12 mt-3">
                    <h1 class="card-header">Ομάδα Α</h1>

                    <div class="card-body">
                        <div class="d-flex justify-content-center mt-3">
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 1
                                </div>
                            </div>
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 2
                                </div>
                            </div>
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 3
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <form class="input-group mt-3 w-75 row mx-auto">
                                <div class="col-12 col-lg-8 mt-2 mt-lg-0">
                                    <input type="text" class="form-control mx-1" placeholder="Όνομα μέλους"
                                           aria-label="Όνομα μέλους">
                                </div>

                                <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                                    <button class="form-control btn btn-primary mx-1 text-nowrap" type="button">Προσθήκη
                                        Μέλους
                                    </button>
                                </div>
                            </form>
                        </div>

                        <form class="row mt-5">
                            <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                                <select class="form-select mx-1" aria-label="Εργασία">
                                    <option selected value="1">Εργασία 1</option>
                                    <option value="2">Εργασία 2</option>
                                    <option value="3">Εργασία 3</option>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                                <select class="form-select mx-1" aria-label="Μέλος">
                                    <option selected value="1">Μέλος 1</option>
                                    <option value="2">Μέλος 2</option>
                                    <option value="3">Μέλος 3</option>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                                <button class="form-control btn btn-primary mx-1" type="button">Ανάθεση Εργασίας
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card col-12 mt-3">
                    <h1 class="card-header">Ομάδα B</h1>

                    <div class="card-body">
                        <div class="d-flex justify-content-center mt-3">
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 1
                                </div>
                            </div>
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 2
                                </div>
                            </div>
                            <div class="card mx-3 text-center">
                                <div class="card-body">
                                    Μέλος 3
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <form class="input-group mt-3 w-75 row mx-auto">
                                <div class="col-12 col-lg-8 mt-2 mt-lg-0">
                                    <input type="text" class="form-control mx-1" placeholder="Όνομα μέλους"
                                           aria-label="Όνομα μέλους">
                                </div>

                                <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                                    <button class="form-control btn btn-primary mx-1 text-nowrap" type="button">Προσθήκη
                                        Μέλους
                                    </button>
                                </div>
                            </form>
                        </div>

                        <form class="row mt-5">
                            <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                                <select class="form-select mx-1" aria-label="Εργασία">
                                    <option selected value="1">Εργασία 1</option>
                                    <option value="2">Εργασία 2</option>
                                    <option value="3">Εργασία 3</option>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                                <select class="form-select mx-1" aria-label="Μέλος">
                                    <option selected value="1">Μέλος 1</option>
                                    <option value="2">Μέλος 2</option>
                                    <option value="3">Μέλος 3</option>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                                <button class="form-control btn btn-primary mx-1" type="button">Ανάθεση Εργασίας
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <form class="input-group mt-3 w-75 mx-auto row">
                    <div class="col-12 col-lg-8 mt-2 mt-lg-0">
                        <input type="text" class="form-control mx-1" placeholder="Όνομα Ομάδας"
                               aria-label="Όνομα Ομάδας">
                    </div>

                    <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                        <button class="form-control btn btn-primary mx-1" type="button">Προσθήκη Ομάδας</button>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</div>
</body>
</html>
