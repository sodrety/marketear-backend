@component('mail::message')
    <section class="section section-auth w-50">
        <div class="container-fluid">
            <div class="content">
                <img src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1683565844/reminder_vcnjbc.png" alt="reminder">
                <h5 class="fw-700" style="font-size: 40px;">{{ $details['otp'] }}</h5>
                <p class="p-med">
                    Masukan OTP diatas untuk mengaktifkan akun anda.
                </p>
            </div>
        </div>
    </section>
@endcomponent
