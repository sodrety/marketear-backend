@component('mail::message')
    <section class="section section-auth w-50">
        <div class="container-fluid">
            <div class="content">
                <img src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1686681707/subscription-success_levgzp.png" alt="reminder">
                <h5 class="fw-700" style="font-size: 40px;">Konfirmasi OTP</h5>
                <p class="p-med">
                    Untuk validasi akun kamu, silahkan masukkan OTP dibawah ini.
                </p>
                <h5 class="fw-700" style="font-size: 40px;">{{ $details['otp'] }}</h5>
                <p class="p-med">
                    Kode berlaku selama 10 menit.
                </p>
            </div>
        </div>
    </section>
@endcomponent
