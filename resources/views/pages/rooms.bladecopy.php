@extends('layouts.default')
@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('vendor/media/bg-1.jpg');background-size:cover; height:100vh" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs mb-2"><span class="mr-2"><a href="{{ route('home') }}">Beranda <i class="fa fa-chevron-right"></i></a></span> <span>Cek Ketersediaan <i class="fa fa-chevron-right"></i></span></p>
        </div>

        <div class="col-md-12 bg-white p-5">
            <div  id='calendar'></div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('page-scripts')
<script>

    document.addEventListener('DOMContentLoaded', async function () {
        try {
            const response = await fetch('http://127.0.0.1:8000/schedule', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                events: data.map(item => ({
                    title: `${item.room_name} - ${item.activity}`,
                    start: moment(item.borrow_at).format('YYYY-MM-DD')
                })),
                eventColor: '#378006'
            });

            calendar.render();
        } catch (error) {
            console.error('Error:', error);
        }
    });
    </script>
@endsection
