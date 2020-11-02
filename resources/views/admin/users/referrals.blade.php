@extends("admin.template")

@section("title")
    @lang('pages.users_referrals') "{{ $profile->username }}"
@endsection

@section("h3")
    <h3>@lang('pages.users_referrals') "{{ $profile->username }}"</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/users.css')}}">

    <table>
        <tr>
            <td>@lang('pages.users_username')</td>
            <td>@lang('pages.users_date')</td>
        </tr>
        @foreach($profile->ref as $ref)
            <tr>
                <td>
                    <a href="{{ route('user-profile', $ref->user->id) }}" class="link">{{ $ref->user->username }}</a>
                </td>
                <td>
                    {{ $ref->user->date }} {{ $ref->user->time }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
