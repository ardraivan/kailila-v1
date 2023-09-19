<nav style="background-color: #F1F2F6" class="main-header navbar navbar-expand sticky-top">
    <!-- Left navbar links -->
    <ul id="listmenuheader" class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="profileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="color: #34333A" class="fas fa-cog"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    @if (Auth::check() && Auth::user()->role->name === 'superadmin')
                        <a class="dropdown-item" href="{{ route('profile.edit', ['user' => Auth::user()->id]) }}">Kelola Profil</a>
                    @endif
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i style="color: #34333A" class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
