@component('mail::message')
    # Hello {{ $query->name }},

    Thank you for contacting {{ config('app.name') }}. You asked:

    > {{ $query->message }}

    ---

    **Our Reply:**
    {{ $reply_message }}

    If you have further questions, feel free to reply to this email.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
