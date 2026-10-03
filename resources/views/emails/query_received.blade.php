@component('mail::message')
    # Query Received

    Hello {{ $query->name }},

    Thank you for contacting N & S Handicrafts. We have received your query:

    - **Subject:** {{ $query->subject }}
    - **Message:** {{ $query->message }}

    Our team will get back to you shortly.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
