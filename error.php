<?php
include './_partials/header.php';
require_once './router/index.php';

?>
<body class="h-100" data-gr-c-s-loaded="true">
<div class="container-fluid h-100 mt-5">
    <div class="row h-100">
        <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0">
            <div class="error">
                <div class="error__content">
                    <form action="./index.php" method="post">
                        <h2>500</h2>
                        <h3>Something went wrong!</h3>
                        <p>There was a problem on our end. Please try again later.</p>
                        <button type="submit" class="btn btn-primary btn-pill">← Go Back</button>
                    </form>
                </div> <!-- / .error_content -->
            </div>
        </main>
    </div>
</div>
</body>

</html>
