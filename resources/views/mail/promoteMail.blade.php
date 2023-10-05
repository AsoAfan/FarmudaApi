<x-mail::message>
# Introduction

Welcome, {{ucfirst($admin_name)}} tried to promote {{ucfirst($username)}} from {{$f_role}} to {{$role}}
please click `Approve` button to approve promotion

<x-mail::button url={{route('promote_action')}}>
    Approve
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
