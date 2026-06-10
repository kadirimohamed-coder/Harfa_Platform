<nav class="harfa-nav navbar navbar-expand-lg fixed-top">
  <div class="container">

    {{-- Brand --}}
    <a class="nav-brand navbar-brand" href="{{ route('home') }}">
      <div class="brand-icon"><i class="bi bi-tools"></i></div>
      Harfa.ma</span>
    </a>

    {{-- Mobile toggler --}}
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <i class="bi bi-list fs-4"></i>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      {{-- Center links --}}
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('craftsmen.*','categories.*') ? 'active' : '' }}"
            href="{{ route('craftsmen.index') }}">
            Parcourir les artisans
          </a>
        </li>
        {{-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('craftsmen.*','categories.*') ? 'active' : '' }}"
             href="#" data-bs-toggle="dropdown">Trouver un artisan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('craftsmen.index') }}">
              <i class="bi bi-search me-2 text-green"></i>Parcourir les artisans
            </a></li>
            <li><a class="dropdown-item" href="{{ route('craftsmen.index') }}">
              <i class="bi bi-grid me-2 text-green"></i>Par catégorie
            </a></li>
          </ul>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('find-work') ? 'active' : '' }}" href="{{ route('find-work') }}">Trouver du travail</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">À propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Tarifs</a>
        </li>
      </ul>

      {{-- Right side --}}
      <div class="nav-actions d-flex align-items-center gap-2">
        @auth
          {{-- Role badge --}}
          <span class="nav-role-badge d-none d-lg-inline">
            @if(auth()->user()->isAdmin()) Admin
            @elseif(auth()->user()->isCraftsman()) Artisan
            @else Client
            @endif
          </span>

          {{-- Dashboard quick link --}}
          @if(auth()->user()->isAdmin())
            <a class="btn-nav-outline" href="{{ route('admin.dashboard') }}">
              <i class="bi bi-speedometer2 me-1"></i>Admin
            </a>
          @elseif(auth()->user()->isCraftsman())
            <a class="btn-nav-outline" href="{{ route('craftsman.dashboard') }}">
              <i class="bi bi-grid me-1"></i>Dashboard
            </a>
          @else
            <a class="btn-nav-outline" href="{{ route('client.dashboard') }}">
              <i class="bi bi-grid me-1"></i>Dashboard
            </a>
          @endif

          {{-- User avatar dropdown --}}
          <div class="user-menu dropdown">
            <div class="user-avatar dropdown-toggle" data-bs-toggle="dropdown" role="button">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="px-3 py-2">
                <div class="fw-bold text-sm" style="font-size:14px">{{ auth()->user()->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ auth()->user()->email }}</div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="bi bi-person-gear me-2"></i>Mon profil
              </a></li>
              @if(auth()->user()->isCraftsman())
                <li><a class="dropdown-item" href="{{ route('craftsman.profile') }}">
                  <i class="bi bi-person-badge me-2"></i>Profil artisan
                </a></li>
                <li><a class="dropdown-item" href="{{ route('craftsman.billing') }}">
                  <i class="bi bi-coin me-2"></i>Points ({{ auth()->user()->points }})
                </a></li>
              @endif
              @if(auth()->user()->isClient())
                <li><a class="dropdown-item" href="{{ route('client.billing') }}">
                  <i class="bi bi-receipt me-2"></i>Facturation
                </a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                  </button>
                </form>
              </li>
            </ul>
          </div>

        @else
          <a class="btn-nav-outline" href="{{ route('login') }}">Connexion</a>
          <a class="btn-nav-primary" href="{{ route('register') }}">
            <i class="bi bi-person-plus me-1"></i>S'inscrire
          </a>
        @endauth
      </div>

    </div>
  </div>
</nav>
