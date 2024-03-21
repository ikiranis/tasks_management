<form action="checkLogin" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Όνομα Χρήστη</label>
        <input type="text" class="form-control" name="username" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Κωδικός Πρόσβασης</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="row justify-content-center">
        <button type="submit" class="btn btn-primary w-75">Είσοδος</button>
    </div>

    <div class="mt-3 text-center">
        <a href="register">Εγγραφή νέου χρήστη</a>
    </div>
</form>
