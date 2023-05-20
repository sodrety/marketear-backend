@extends('layout.master')

{{-- START - additional meta --}}
@section('add_meta')
    <title>HMS - Reminder</title>
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
                <img class="mb-5" src="{{ asset('images/brand/logo.png') }}" alt="logo">
            </div>
            <div class="content">
                <img src="{{ asset('images/email/reminder.png') }}" alt="reminder">
                <h5 class="fw-700">Eh, Bentar Lagi Subscription Kamu Habis Nih</h5>
                <p class="p-med">
                    Padahal kita suka banget kerja bareng kalian, kalo kamu masih tertarik but perpanjang, kamu bisa
                    langsung <a href="#">klik disini</a>
                </p>
            </div>
            <div class="footer py-6">
                <p class="small" style="opacity: 0.3">© 2022 Hire My Squad</p>
            </div>
        </div>
    </section>

@endsection
{{-- END CONTENT --}}
