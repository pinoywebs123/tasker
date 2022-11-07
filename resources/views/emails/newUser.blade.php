@component('mail::message')
This is your verification email to access your DocuArk Account. Below are your account details. Click the link below to verify your account, the link will expire in 3 days

@component('mail::button', ['url' => route('verify',$user['email'])])
Click to verify
@endcomponent

Username:
<br>
{{strtolower($user['first_name'].'.'.$user['last_name'])}}
<br>
Password:
<br>
{{$user['password']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
