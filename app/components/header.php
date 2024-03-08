<header>
    <div class="bg-dark text-center text-light py-3">
        <h1>Πλατφόρμα Διαχείρισης Εργασιών</h1>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light my-0">
        <a class="navbar-brand" href="/">
            <img src="images/logo.svg" alt="Logo" width="100">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <a class="nav-link btn btn-light active" href="/">Αρχική</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link btn btn-light" href="tasks">Λίστα εργασιών</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link btn btn-light" href="teams">Ομάδες</a>
                </li>
            </ul>

            <?php
            if (!isset($_SESSION['username'])) {
                ?>

                <a class="btn ms-auto" href="login" title="Είσοδος">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd"
                              d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>

                <?php
            } else {
                ?>

                <a class="btn ms-auto" href="logout" title="Έξοδος">
                    <?php echo $_SESSION['username']; ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                        <path fill-rule="evenodd"
                              d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                    </svg>
                </a>

                <?php
            }
            ?>
        </div>
    </nav>
</header>
