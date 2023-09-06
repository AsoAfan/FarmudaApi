<x-mail::message>
# Introduction

Welcome {{ucfirst($username)}} we glad see you at this last step
just write the code below to verify that this email is valid and exist

<x-mail::panel>
## {{$otp}}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
