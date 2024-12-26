<nav class="navbar navbar-expand-lg" style="background-color: #D90166
; border-bottom: 2px solid #D90166;">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}" style="color:#FFFFFF; font-weight: bold;">
      Ecommerce App for Skin Care
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('home') }}" style="color:#FFFFFF;">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.show') }}" style="color:#FFFFFF;">Cart</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" style="color:#FFFFFF;">Logout</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
