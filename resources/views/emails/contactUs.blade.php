@component('mail::message')
# پیام از طرف وبسایت موسیقی - انتقادات و پیشنهادات

.شما یک پیام از طرف {{$messenger["name"]}} دارید

تلفن همراه: {{$messenger["phone"]}}


{{$messenger["message"]}}

@component('mail::button', ['url' => "mailto:{$messenger['email']}"])
{{$messenger["email"]}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
