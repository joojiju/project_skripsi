@extends('layouts.default')
@section('content')

  <section id="welcome" class="ftco-intro position-relative" style="background-image: url(vendor/media/bg-1.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center slider-text align-items-center" data-scrollax-parent="true">
					<div class="col-md-7 text-center ftco-animate">
						<h2>SIPRIG GKJP</h2>
						<p class="mb-4">Pinjam ruangan dengan cepat dan mudah secara online! Pinjam ruangan dalam satu klik atau kirim pertanyaan anda kepada kami.</p>
						<p class="mb-0"><a href="#form-borrow" class="btn btn-primary px-4 py-3">PINJAM SEKARANG</a> <a href="#list-room" class="btn btn-white px-4 py-3">CEK KETERSEDIAAN</a></p>
					</div>
				</div>
			</div>
		</section>

    <section id="about-us" class="ftco-section bg-light">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-5 wrap-about">
						<div class="img img-2 mb-4" style="background-image: url(vendor/media/bg-1.jpg);">
						</div>
					</div>
					<div class="col-md-7 wrap-about ftco-animate">
	          <div class="heading-section">
	          	<div class="pl-md-5">
		            <h2 class="mb-2">Tentang Kami</h2>
	            </div>
	          </div>
	          <div class="pl-md-5">
							<p>GKJ Pamulang pada tahun 2024 diharapkan mampu memberikan pelayanan yang lebih baik dan berkualitas bagi jemaat dan masyarakat di lingkungan sekitar Gereja. Salah satunya dalam pelayanan peminjaman ruangan dan inventaris gereja untuk berbagai kegiatan baik untuk warga jemaat GKJ Pamulang sendiri ataupun masyarakat umum yang sekiranya membutuhkan peminjaman ruangan ataupun inventaris.</p>
							<div class="row">
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
                    <span class="fa-solid fa-check"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Peminjaman Mudah</h3>
		                <p>Sistem ini menawarkan proses peminjaman yang mudah dan dapat dilakukan dimana saja dan kapan saja</p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
                    <span class="fa-solid fa-forward"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Peminjaman Cepat</h3>
		                <p>Sistem ini menawarkan proses peminjaman yang cepat dengan dilengkapi pengecekan status pengajuan secara <i>real-time</i></p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
                    <span class="fa-solid fa-globe"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Peminjaman Praktis</h3>
		                <p>Sistem ini menawarkan proses peminjaman yang praktis hanya dengan mengisi form secara online</p>
		              </div>
		            </div>
		            </div>
		            </div>
		          </div>
						</div>
					</div>
				</div>
			</div>
		</section>

        <section id="list-room" class="ftco-section bg-light ftco-no-pt ftco-no-pb">
            <div class="container-fluid px-md-0">
                <div class="row no-gutters custom-row">
                @foreach ($data['rooms'] as $key => $room)
                @php
                $room_status = $room->status;
                $borrower_status = [];

                    // Check if any borrow rooms
                    if ($room->borrow_rooms->isNotEmpty()) {
                        // Check each borrow_rooms
                        foreach ($room->borrow_rooms as $key => $borrow_room) {
                            // Show details if not finished yet by checking status first
                            if (
                            $borrow_room->returned_at == null
                            && $borrow_room->admin_approval_status == App\Enums\ApprovalStatus::Disetujui
                        ) {
                            $room_status = 1; // Set status room to Booked
                    
                            $borrow_at = Carbon\Carbon::parse($borrow_room->borrow_at);
                            $until_at = Carbon\Carbon::parse($borrow_room->until_at);

                            if ($borrow_at->isSameDay($until_at)) {
                                // If the borrow period is one day, show start and end times
                                $borrower_status[] = $borrow_at->format('d M Y H:i') . ' s.d ' . $until_at->format('H:i');
                          } else {
                                // If the borrow period is more than one day, show start and end dates
                                $count_days = $borrow_at->diffInDays($until_at) + 1;
                                $borrower_status[] = $borrow_at->format('d M Y H:i') . ' s.d ' . $until_at->format('d M Y H:i');
                            }
                        }
                    }
                }
                @endphp
                <div class="col-lg-6">
                    <div class="room-wrap d-md-flex">
                        <a href="#" class="img" style="background-image: url({{ asset($room->image) }});"></a>
                        <div class="half left-arrow d-flex align-items-center">
                            <div class="text p-4 p-xl-5 text-center">
                                <p class="star mb-0"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
                                <p class="mb-0">{{ $room->building->name }}</p>
                                <h3 class="mb-3">{{ $room->name }}</h3>
                                <ul class="list-accomodation">
                                    <li><span>Maks:</span> {{ $room->max_people }} Orang</li>
                                    <li><span>Fasilitas:</span> {{ $room->facility }}</li>
                                    @if (!empty($borrower_status))
                                    <li><span>Sudah Dibooking:</span><br>{!! implode('<br>', $borrower_status) !!}</li>
                                    @endif
                                </ul>
                                <a href="javascript:void(0)" onclick="setRoomId({{ $room->id }})" class="btn-custom px-3 py-2" style="text-decoration: none;">Pinjam Ruang Ini <span class="icon-long-arrow-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach
          </div>
          </div>
      </section>

    <div id="form-borrow" class="hero-wrap js-fullheight" style="background-color: #fd7792;" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-6 ftco-animate">
          	<h2 class="subheading">Pinjam Ruangan dan Inventaris</h2>
          	<h1 class="mb-4">Sistem Informasi Peminjaman Ruangan dan Inventaris Gereja</h1>
          </div>
        </div>
      </div>
    </div>
    <section id="form-siprig" class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-end">
	    		<div class="col-lg-6">
						<form method="POST" action="{{ route('api.v1.borrow-room-with-borrower', []) }}" class="appointment-form">
                            @csrf
                            {{-- Show any errors --}}
                            @if ($errors->isNotEmpty())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $message)
                                        @if ($message == 'login_for_more_info')
                                            <a href="{{ route('status') }}">Cek status</a> untuk melihat status peminjaman.
                                        @else
                                            {{ $message }}<br>
                                        @endif
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Pinjam ruang berhasil, silahkan cek email untuk melihat nomor resi dan silahkan cek status <a href="{{ route('status') }}">disini</a>.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="row">

								<div class="col-md-12">
									<div class="form-group">
			    					<input name="email" value="{{ old('email') }}" type="text" class="form-control" placeholder="Email">
			    				</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
			    					<input name="full_name" value="{{ old('full_name') }}" type="text" class="form-control" placeholder="Nama Lengkap">
			    				</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
			    					<input name="phone_number" value="{{ old('phone_number') }}" type="text" class="form-control" placeholder="Nomor Telepon">
			    				</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
			    					<div class="form-field">
	          					    <div class="select-wrap">
	                                <div class="icon"><span class="fa fa-chevron-down"></span></div>
	                                <select name="borrower_status" id="" class="form-control">
	                      	            <option value="" selected disabled>Status Peminjam</option>
	                      	            <option value="jemaat" @if(old('borrower_status') == 'jemaat') selected @endif>Jemaat</option>
	                      	            <option value="umum" @if(old('borrower_status') == 'umum') selected @endif>Umum</option>
	                                </select>
	                            </div>
			                    </div>
			    				</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
			    					<input name="activity" value="{{ old('activity') }}" type="text" class="form-control" placeholder="Kegiatan">
			    				</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
			    					<div class="input-wrap">
			            		    <div class="icon"><span class="ion-md-calendar"></span></div>
			            		    <input id="borrow_at" name="borrow_at" value="{{ old('borrow_at') }}" type="text" class="form-control appointment_date-check-in datetimepicker-input" placeholder="Tanggal Mulai" data-toggle="datetimepicker" data-target="#borrow_at">
		            		    </div>
			    				</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
			    					<div class="input-wrap">
			            		    <div class="icon"><span class="ion-md-calendar"></span></div>
			            		    <input id="until_at" name="until_at" value="{{ old('until_at') }}" type="text" class="form-control appointment_date-check-out datetimepicker-input" placeholder="Tanggal Selesai" data-toggle="datetimepicker" data-target="#until_at">
		            		    </div>
			    				</div>
								</div>

								<div class="col-md-12">
								    <div class="form-group">
                                    <div class="form-field">
                                    <div class="select-wrap">
                                    <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                    <select name="room" id="" class="form-control">
                                      <option value="" selected disabled>Pilih Ruangan</option>
                                      @forelse ($data['rooms'] as $room)
                                      <option value="{{ $room->id }}">{{ $room->building->name . ' - ' . $room->name }}</option>
                                      @empty
                                      <option value="" disabled>Belum ada ruangan yang tersedia</option>
                                      @endforelse
                                    </select>
                                </div>
                                </div>
			    				</div>
								</div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                    <div class="select2-purple">
                                    <select name="inventory[]" class="select2 custom-select" multiple="multiple" data-placeholder="Perlengkapan (Opsional)" data-dropdown-css-class="select2-purple">
                                        @forelse ($data['inventories'] as $inventory)
                                        <option value="{{ $inventory->id }}" @if(in_array($inventory->id, old('inventory', []))) selected @endif>
                                        {{ $inventory->name }}
                                        </option>
                                        @empty
                                        <option value="" disabled>Belum ada inventaris yang tersedia</option>
                                        @endforelse
                                        </select>
                                </div>
                                </div>
                                </div>

								<div class="col-md-12">
									<div class="form-group">
			                        <input type="submit" value="Ajukan Peminjaman" class="btn btn-primary py-3 px-4">
			                    </div>
								</div>
							    </div>
	    			</form>
	    		</div>
	    	</div>
	    </div>
    </section>

    @section('scripts')
        <script>
          // ready
          $(document).ready(function() {
            console.log('ready');
            // Datetimepicker
            $('.appointment_date-check-in-alt').datetimepicker({
                format:'DD-MM-YYYY HH:mm',
            });
            $('.appointment_date-check-out-alt').datetimepicker({
                format:'DD-MM-YYYY HH:mm',
            });
          });

          function setRoomId(roomId) {
          // Set the value of the room dropdown in the form
            document.querySelector('select[name="room"]').value = roomId;

          // Optionally, if you want to automatically scroll to the form
            document.querySelector('.appointment-form').scrollIntoView({ behavior: 'smooth' });
}
        </script>

        <script>
        $(document).ready(function() {
            // Check if there are error messages or success messages
            var hasError = $('.alert-danger').length > 0;
            var hasSuccess = $('.alert-success').length > 0;

            // Scroll to the form section if there are error messages or success messages
            if (hasError || hasSuccess) {
            $('html, body').animate({
                scrollTop: $('#form-borrow').offset().top
            }, 1000);
            }
        });
        </script>

        {{-- If any error scroll to form --}}
        @if ($errors->isNotEmpty())
            <script>
                
                $(document).ready(function(){
                    // Scroll only in mobile device
                    if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                        document.getElementById("form-borrow").scrollIntoView();
                    }
                });
            </script>
        @endif
    @endsection
@endsection

