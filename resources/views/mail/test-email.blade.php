@include('mail.email-header', ['titel' => $subject])

{!! $body !!}

@include('mail.email-footer')
