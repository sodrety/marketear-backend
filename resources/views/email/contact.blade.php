@component('mail::message')
<strong>Inquiry details: </strong><br>
<strong>Name: </strong>{{ $data['name'] }} <br>
<strong>Company: </strong>{{ $data['company'] }} <br>
<strong>Email: </strong>{{ $data['email'] }} <br>
<strong>Phone: </strong>{{ $data['phone'] }} <br>
<strong>Subject: </strong>{{ $data['subject'] }} <br>
<strong>Message: </strong>{{ $data['message'] }} <br>
@endcomponent