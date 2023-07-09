@component('mail::message')
    <div class="content text-center">
        <img class="mb-30" src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1688840288/email-logo_ydmeaq.png" alt="Marketer" />
        <p class="p-med text-center mb-30"style="font-size: 14px;">
            Masukkan kode OTP di Marketer untuk memvalidasi email.
        </p>
        <strong class="fw-700 d-block text-black" style="font-size: 18px;">Kode OTP Anda</strong>
        <strong class="fw-700 d-block mb-30" style="font-size: 64px;color: #2F59BF;">{{ $details['otp'] }}</strong>
        <p class="p-med text-center mb-20">
        Password hanya berlaku 10 menit.<br/>
        Mohon jangan bagikan kode rahasia ini kesiapa pun.
        </p>
        <div class="d-flex">
            <img src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1688840288/footer-img_dzewak.png" alt="footer image" />
            <img src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1688840289/footer-logo_b533d7.png" alt="footer logo" />
        </div>
    </div>
@endcomponent
