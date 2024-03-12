<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                <h2 class="footer-heading"><a href="#" class="logo">SIPRIG GKJP</a></h2>
                <p>Sistem Informasi Peminjaman Ruangan dan Inventaris Gereja Kristen Jawa Pamulang</p>
                <a href="#about-us">Baca lebih lajut <span class="fa fa-chevron-right" style="font-size: 11px;"></span></a>
            </div>
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                <h2 class="footer-heading">Tag</h2>
                <div class="tagcloud">
                <a href="#" class="tag-cloud-link">gkj</a>
                <a href="#" class="tag-cloud-link">pamulang</a>
                <a href="#" class="tag-cloud-link">gereja</a>
                <a href="#" class="tag-cloud-link">online</a>
                <a href="#" class="tag-cloud-link">pinjam</a>
                <a href="#" class="tag-cloud-link">ruang</a>
                <a href="#" class="tag-cloud-link">inventaris</a>
            </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                <h2 class="footer-heading">Kunjungi Kami</h2>
                <ul class="list-unstyled">
                <li><a href="https://gkj-pamulang.org/" target="_blank" class="py-1 d-block">Website</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="w-30 mt-5 border-top py-5">
        <div class="container">
            <div class="row">

      <div class="col-md-6 col-lg-12 text-md-center">
          <p class="mb-0 list-unstyled">
              <a class="mr-md-3">SIPRIG GKJP</a>
          </p>
      </div>
    </div>
        </div>
    </div>
</footer>

<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/popper.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.animateNumber.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/technext/vacation-rental/js/bootstrap-datepicker.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/technext/vacation-rental/js/jquery.timepicker.min.js') }}"></script> --}}
<script src="{{ asset('vendor/technext/vacation-rental/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('vendor/technext/vacation-rental/js/scrollax.min.js') }}"></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> --}}
{{-- <script src="{{ asset('vendor/technext/vacation-rental/js/google-map.js') }}"></script> --}}

<!-- Datetime picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('vendor/technext/vacation-rental/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
    $(document).ready(function() {
        $('.multiple-select').select2({
            placeholder: "Perlengkapan (Opsional)",
        });

        $('.select2').select2()
    });
</script>



@yield('page-scripts')
