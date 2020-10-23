<nav class="navbar step-navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">{{ __('Needs Diagnosis') }} <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('Technical Lift') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('Quotation') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('Purchase Order') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('Assignment') }}</a>
            </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .step-navbar {
        box-shadow: none;
        background: transparent!important;
        margin-bottom: 10px;
    }

    .navbar.step-navbar .collapse .navbar-nav .nav-item .nav-link {
        margin-left: 25px;
    }

    .step-navbar .nav-item.active {
        color: white;
        background: transparent;
        border-radius: 4px;
        font-weight: bold;
    }

    .step-navbar .nav-item.active a {
        color: white;
        background: #32526f!important;
        border-radius: 4px;
        font-weight: bold;
    }

    .navbar.step-navbar .collapse .navbar-nav .nav-item .nav-link {
        font-weight: bold!important;
    }

</style>
