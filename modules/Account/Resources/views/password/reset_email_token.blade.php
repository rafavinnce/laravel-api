@extends('account::layouts.master')

@section('content')
    <h3>{{ __('Hello') }}, {{$user['full_name']}}!</h3>
    <p>
        {{__('It looks like you forgot your password. You can reset it by clicking on the link')}},
        <a href="{{config('app.web_url')}}/auth/password_reset/{{$token}}/{{$user['email']}}">{{strtolower(__('Redefine password'))}}</a>.
        <br />
        {{__('If you have not requested to change your password')}},
        <a href="{{config('app.web_url')}}/auth/report_password_reset/{{$token}}">{{strtolower(__('Report here'))}}</a>.
    </p>

    <p>
        {{__('Thank you')}},
        <br />
        <a href="{{config('app.web_url')}}">{{config('app.name')}}</a>
    </p>
@stop
