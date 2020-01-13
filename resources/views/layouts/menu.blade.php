<div class="bd-navbar">
    <div class="container">
        <header class="navbar navbar-expand navbar-dark flex-column flex-md-row">
            <a class="navbar-brand pr-0 pr-md-3" href="/">
                @section('header_icon')
                    <i class="fas fa-heading d-block"></i>
                @show
            </a>
            <div class="navbar-nav-scroll">
                <ul class="navbar-nav bd-navbar-nav flex-row">
                    @yield('links')
                </ul>
            </div>
        </header>
    </div>
</div>
