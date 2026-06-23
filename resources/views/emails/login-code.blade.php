<x-mail::message>
# Your login code

Use the button below to sign in instantly, or enter this 6-digit code on the verification page:

<x-mail::panel>
**{{ $otp }}**
</x-mail::panel>

<x-mail::button :url="$magicLink">
Sign in with Magic Link
</x-mail::button>

This code and link expire in 15 minutes. If you did not request this email, you can safely ignore it.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
