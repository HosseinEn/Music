@component('mail::message')
# Changes in website

User {{$user->name}} has {{$operation}}d a {{$modelName}}

@component('mail::button', ['url' => "mailto:".$user->email])
Send email to {{$user->name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
