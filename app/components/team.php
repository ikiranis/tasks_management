<div class="card col-12 mt-3">
    <h1 class="card-header"><?= $team?->getName() ?? 'Some team' ?></h1>

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