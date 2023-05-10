@extends('layout.master')

{{-- START - additional meta --}}
@section('add_meta')
    <title>HMS - Proposal</title>
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
                <img class="mb-5" src="{{ asset('images/email/proposal.png') }}" alt="proposal">
                <h5 class="fw-700">Yeay ! Proposal kamu sudah jadi</h5>
                <p class="p-med mb-2">
                    Setelah melalui proses brainstorming yang cukup panjang, kami menemukan ide/solusi untuk menyelesaikan
                    masalah kamu
                    <br><br>
                    Kamu bisa donload proposalnya disini
                </p>
                <div class="d-grid">
                    <button class="btn btn-primary">Download Proposal</button>
                </div>
            </div>
            <div class="footer py-6">
                <p class="small" style="opacity: 0.3">© 2022 Hire My Squad</p>
            </div>
        </div>
    </section>

@endsection
{{-- END CONTENT --}}
