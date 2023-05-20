@extends('layout.master')

{{-- START - additional meta --}}
@section('add_meta')
    <title>HMS - Subscription Failed</title>
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
                <img class="mb-5" src="{{ asset('images/email/subscription-failed.png') }}"
                    alt="subscription-failed">
                <h5 class="fw-700">Pembayaran Gagal</h5>
                <p class="p-med">
                    Terjadi kegagalan dalam pembayaran, silahkan mencoba lagi atau hubungi customer service kami jika masih
                    mengalami kendala
                    <br><br>
                    <a href="#">Email Customer Service</a>
                    <br>
                    <a href="#">Whatsapp Customer Service</a>
                </p>
            </div>
            <div class="footer py-6">
                <p class="small" style="opacity: 0.3">© 2022 Hire My Squad</p>
            </div>
        </div>
    </section>

@endsection
{{-- END CONTENT --}}
