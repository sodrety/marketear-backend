@extends('layout.master')

{{-- START - additional meta --}}
@section('add_meta')
    <title>HMS - Subscription Success</title>
@endsection
{{-- END - additional meta --}}

{{-- START - additional style --}}
@section('add_style')

@endsection
{{-- END - additional style --}}

{{-- START - additional script --}}
@section('add_script')

@endsection
{{-- END - additional script --}}


{{-- START CONTENT --}}
@section('content')

    <section class="section section-auth w-50">
        <div class="container-fluid">
            <div class="logo mb-6">
                <img src="{{ asset('images/brand/logo.png') }}" alt="logo">
            </div>
            <div class="content">
                <img class="mb-5" src="{{ asset('images/email/subscription-success.png') }}"
                    alt="subscription-success">
                <h5 class="fw-700">Berhasil Langganan</h5>
                <p class="p-med">
                    Selamat datang dan selamat bergabung dengan HMS Hire My Squad, kamu akan segera
                    dihubungi oleh tim kami paling lambat 1x24 jam
                    <br><br>
                    Belum dihubungi dalam 1x24jam ?
                    <br>
                    <a href="#">Hubungi Customer Service</a>
                </p>
            </div>
            <div class="footer py-6">
                <p class="small" style="opacity: 0.3">© 2022 Hire My Squad</p>
            </div>
        </div>
    </section>

@endsection
{{-- END CONTENT --}}
