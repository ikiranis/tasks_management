<form id="registerUserForm" action="registerUser" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Όνομα Χρήστη</label>
        <input type="text" class="form-control" name="username" id="username"
               required maxlength="25"
               title="Το όνομα χρήστη πρέπει να είναι μέχρι 25 χαρακτήρες">
        <span id="usernameError" class="text-danger small d-none"></span>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Ονοματεπώνυμο</label>
        <input type="text" class="form-control" name="name" id="name"
               maxlength="50"
               title="Το ονοματεπώνυμο πρέπει να είναι μέχρι 50 χαρακτήρες">
        <span id="nameError" class="text-danger small d-none"></span>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required
               maxlength="50"
               title="Το email πρέπει να είναι μέχρι 50 χαρακτήρες">
        <span id="emailError" class="text-danger small d-none"></span>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Κωδικός Πρόσβασης</label>
        <input type="password" class="form-control" name="password" id="password" required
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Ο κωδικός πρέπει να αποτελείται από τουλάχιστον 8 χαρακτήρες, εκ
                                           των οποίων τουλάχιστον ένας αριθμητικός και ένα κεφαλαίο γράμμα">
        <span id="passwordError" class="text-danger small d-none"></span>
    </div>

    <div class="mb-3">
        <label for="verify_password" class="form-label">Επιβεβαίωση Κωδικού</label>
        <input type="password" class="form-control" name="verify_password"
               id="verify_password" required
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Ο κωδικός πρέπει να αποτελείται από τουλάχιστον 8 χαρακτήρες, εκ
                                           των οποίων τουλάχιστον ένας αριθμητικός και ένα κεφαλαίο γράμμα">
        <span id="verifyPasswordError" class="text-danger small d-none"></span>
    </div>

    <div class="row justify-content-center">
        <button type="submit" class="btn btn-primary w-75">Εγγραφή</button>
    </div>
</form>
