@extends('layouts.default')
@section('content')

    <div class="hero-wrap js-fullheight" style="background-image: url('vendor/media/bg-1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Selamat datang di SIPRIG (Sistem Informasi Peminjaman Ruangan dan Inventaris Gereja Kristen Jawa Pamulang)</h2>
          	<h1 class="mb-4">Pinjam ruangan mudah dan cepat</h1>
            <p><a href="{{ route('rooms') }}" class="btn btn-primary">Cek Ketersediaan</a> <a href="#" class="btn btn-white">Cek Status Pengajuan</a></p>
          </div>
        </div>
      </div>
    </div>

    <section id="form-pinjam-ruang" class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-end">
	    		<div class="col-lg-5">
						<form method="POST" action="{{ route('api.v1.borrow-room-with-college-student', []) }}" class="appointment-form">
                            @csrf
                            {{-- Show any errors --}}
                            @if ($errors->isNotEmpty())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $message)
                                        @if ($message == 'login_for_more_info')
                                            <a href="{{ route('admin.login') }}">Masuk</a> untuk melihat aktivitas peminjaman.
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
                                    Pinjam ruang berhasil, silahkan cek status peminjaman <a href="{{ route('admin.login') }}">disini</a>. Masuk menggunakan email dan password nomor telepon.
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
	                                <select name="status_peminjam" id="" class="form-control">
	                      	        <option value="" selected disabled>Status Peminjam</option>
	                      	        <option value="jemaat" @if(old('status_peminjam') == 'jemaat') selected @endif>Jemaat</option>
	                      	        <option value="umum" @if(old('status_peminjam') == 'umum') selected @endif>Umum</option>
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
                                    <option value="{{ $room->id }}" @if(old('room') == $room->id) selected @endif>
                                    {{ $room->building->name . ' - ' . $room->name }}
                                    </option>
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
			    					<div class="form-field">
	          					<div class="select-wrap">
	                                <div class="icon"><span class="fa fa-chevron-down"></span></div>
	                                <select name="inventory" id="" class="form-control">
	                      	        <option value="" selected disabled>Pilih Inventaris</option>
                                    @forelse ($data['inventories'] as $inventory)
                                    <option value="{{ $inventory->id }}" @if(old('inventory') == $inventory->id) selected @endif>
                                    {{ $inventory->name }}
                                    </option>
                                    @empty
                                    <option value="" disabled>Belum ada inventaris yang tersedia</option>
                                    @endforelse
	                                </select>
	                            </div>
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
        </script>

        {{-- If any error scroll to form --}}
        @if ($errors->isNotEmpty())
            <script>
                $(document).ready(function(){
                    // Scroll only in mobile device
                    if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                        document.getElementById("form-pinjam-ruang").scrollIntoView();
                    }
                });
            </script>
        @endif
    @endsection
@endsection