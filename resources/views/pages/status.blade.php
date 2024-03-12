@extends('layouts.default')

@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('vendor/media/bg-1.jpg');background-size:cover; height:100vh" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center mt-5">
            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="{{ route('home') }}">Beranda <i class="fa fa-chevron-right"></i></a></span> <span>Cek Status Pengajuan <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="mb-0 bread">Status Pengajuan Ruangan</h1>
        </div>

        <div class="col-md-6 ftco-animate bg-white p-4 border-radius mt-5" style="border-radius:15px;">
            <form action="" method="GET" class="appointment-form">
                {{-- @csrf --}}
                <div class="form-group">
                    <input type="text" name="resi" id="" class="form-control" value="{{ old('resi')}}" placeholder="Masukan Nomor Resi" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary py-3 px-4 w-100">CEK STATUS</button>
                </div>
            </form>

            {{-- {{ $status_pengajuan->admin_approval_status }} --}}

            @if(request('resi'))
            @if($status_pengajuan && $status_pengajuan->id)
            <table class="table">
                <tr>
                    <td>Nomor Resi</td>
                    <th>: {{ $status_pengajuan->id }}</th>
                </tr>
                <tr>
                    <td>Nama Peminjam</td>
                    <th>: {{ $status_pengajuan->full_name }}</th>
                </tr>
                <tr>
                    <td>Status Peminjam</td>
                    <th>: {{ $status_pengajuan->borrower_status }}</th>
                </tr>
                <tr>
                    <td>Status</td>
                    <th>: @php

                            if ($status_pengajuan->admin_approval_status == 1) {
                                if ($status_pengajuan->returned_at != null)
                                    $val = ['success', 'Peminjaman selesai'];
                                else if ($status_pengajuan->processed_at != null)
                                    $val = ['success', 'Ruangan sedang digunakan'];
                                    else
                                        $val = ['success', 'Sudah disetujui']; }

                                else if ($status_pengajuan->admin_approval_status == null)
                                    $val = ['info', 'Menunggu persetujuan'];
                                    else
                                        $val = ['danger', 'Ditolak'];
                                if ($status_pengajuan->deleted_at != null)
                                    $val = ['danger', 'Dibatalkan'];

                        @endphp
                            @if($status_pengajuan->admin_approval_status != null)
                                <span class="badge badge-{{$val[0]}}" >{{$val[1]}}</span>
                            @else
                            <span class="badge badge-info" >{{ $status_pengajuan->id ? 'Menunggu Persetujuan' : '' }}</span>
                            @endif

                    </th>
                </tr>
                <tr>
            </table>
            @else
                    <p class="text-danger">Nomor Resi tidak ditemukan. Silakan coba lagi.</p>
                @endif
            @endif
        </div>
      </div>


    </div>
  </section>
@endsection
