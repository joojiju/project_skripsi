
<nav class="navbar navbar-expand-lg navbar-light ftco_navbar bg-light ftco-navbar-light" id="ftco-navbar">
<div class="container">
    <a class="navbar-brand" href="/" class="nav-link">SIPRIG<span> GKJP</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-bars"></span> Menu
  </button>
  <div class="collapse navbar-collapse" id="ftco-nav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item @if(\Request::is('/')) active @endif"><a href="/" class="nav-link">Beranda</a></li>
      <li class="nav-item"><a href="/#about-us" class="nav-link">Tentang</a></li>
      <li class="nav-item"><a href="/#list-room" class="nav-link">Daftar Ruangan</a></li>
      <li class="nav-item"><a href="/#form-borrow" class="nav-link">Pinjam Ruangan</a></li>
      <li class="nav-item"><a href="{{ route('status')}}" class="nav-link">Cek Status</a></li>
    </ul>
  </div>
</div>
</nav>
<!-- END nav -->

