@extends("admin.template")

@section("title")
    @lang('pages.ads_read')
@endsection

@section("h3")
    <h3>@lang('pages.ads_read')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/ads.css')}}">
    <table>
        <tr>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_photo')
            </td>
            <td>
                <a href="{{ url('/photo_ad/'.$ad->photo) }}" target="_blank">
                    <img src="{{ url('/photo_ad/'.$ad->photo) }}" height="100px" alt="Photo">
                </a>
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_title')
            </td>
            <td>
                {{ $ad->title }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_description')
            </td>
            <td>
                {{ $ad->description }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_phone')
            </td>
            <td>
                {{ $ad->phone }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_country')
            </td>
            <td>
                {{ $ad->city->country->name }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_city')
            </td>
            <td>
                {{ $ad->city->name }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_rubric')
            </td>
            <td>
                {{ $ad->subsection->rubric->name }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_subsection')
            </td>
            <td>
                {{ $ad->subsection->name }}
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_location')
            </td>
            <td>
                <a href="http://maps.google.com/maps?q={{ $ad->lat }},{{ $ad->lon }}+(My+Point)&z=11&ll={{ $ad->lat }},{{ $ad->lon }}"
                target="_blank" class="link">
                    {{ $ad->lat }}, {{ $ad->lon }}
                </a>
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_user')
            </td>
            <td>
                <a href="{{ route('user-profile', $ad->user->id) }}" class="link">{{ $ad->user->username }}</a>
            </td>
        </tr>
        <tr>
            <td>
                @lang('pages.ads_date')
            </td>
            <td>
                {{ $ad->date }} {{ $ad->time }}
            </td>
        </tr>
    </table>
    <br>
    @if($ad->active == 0)
        <form action="{{ route('ads-activate') }}" method="POST" id="activate">
            @csrf
            <input type="hidden" name="id" value="{{ $ad->id }}">
        </form>
    @endif

    <form action="{{ route('ads-edit') }}" method="POST" id="edit">
        @csrf
        <input type="hidden" name="id" value="{{ $ad->id }}">
    </form>

    <form action="{{ route('ads-delete') }}" method="POST" id="delete">
        @csrf
        <input type="hidden" name="id" value="{{ $ad->id }}">
    </form>


    @if($ad->active == 0)
        <button form="activate" class="button"><i class="icon-play-1"></i> @lang('pages.ads_activate')</button>
    @endif
    <button form="edit" class="button"><i class="icon-pen"></i> @lang('pages.ads_edit')</button>
    <button form="delete" class="button"><i class="icon-trash-empty"></i> @lang('pages.ads_delete')</button>
@endsection

