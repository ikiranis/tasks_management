<div id="error" class="d-none d-flex alert fixed-bottom mb-5 mx-5 justify-content-between" role="alert">
    <span class="errorMessage my-auto"></span>
    <button type="button" class="btn btn-sm close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php
use apps4net\tasks\libraries\App;

// Load the error script
App::script('error');
?>
