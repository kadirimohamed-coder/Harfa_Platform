<div class="portal-sidebar">
  <div class="sidebar-section">
    <div class="sidebar-section-label">Principal</div>
    <a href="{{ route('craftsman.dashboard') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2"></i> Tableau de bord
    </a>
    <a href="{{ route('craftsman.profile') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.profile') ? 'active' : '' }}">
      <i class="bi bi-person-badge"></i> Mon profil
    </a>
    <a href="{{ route('craftsman.categories') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.categories') ? 'active' : '' }}">
      <i class="bi bi-tags"></i> Mes catégories
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Activité</div>
    <a href="{{ route('craftsman.bookings') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.bookings') ? 'active' : '' }}">
      <i class="bi bi-calendar-check"></i> Réservations
    </a>
    <a href="{{ route('craftsman.earnings') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.earnings') ? 'active' : '' }}">
      <i class="bi bi-check-circle"></i> Travaux terminés
    </a>
    <a href="{{ route('craftsman.inbox') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.inbox*') ? 'active' : '' }}">
      <i class="bi bi-chat-dots"></i> Messages
    </a>
    <a href="{{ route('craftsman.reviews') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.reviews') ? 'active' : '' }}">
      <i class="bi bi-star"></i> Avis reçus
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Plateforme</div>
    <a href="{{ route('craftsman.billing') }}"
       class="sidebar-link {{ request()->routeIs('craftsman.billing') ? 'active' : '' }}">
      <i class="bi bi-coin"></i> Mes points
      <span class="ms-auto" style="font-size:11px;font-weight:700;color:#34d399;background:rgba(52,211,153,.15);padding:2px 8px;border-radius:20px">
        {{ auth()->user()->points }} pts
      </span>
    </a>
  </div>

  <div class="sidebar-user">
    <div class="sidebar-user-card">
      <div class="user-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div>
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">Artisan</div>
      </div>
    </div>
  </div>
</div>