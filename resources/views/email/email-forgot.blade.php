@component('mail::message')
    <section class="section section-auth w-50">
        <div class="container-fluid">
            <div class="content">
                <img src="https://res.cloudinary.com/dmjkiarn3/image/upload/v1683565844/reminder_vcnjbc.png" alt="reminder">
                <h5 class="fw-700" style="font-size: 40px;">Forget Password Email</h5>
                <p class="p-med">
                You can reset password from bellow link:
                <br/>
                <a href="{{ env('CLIENT_URL').'/change-password/'.$token }}">Reset Password</a>
                </p>
            </div>
        </div>
    </section>
@endcomponent
