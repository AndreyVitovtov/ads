@extends("admin.template")

@section("title")
    @lang('pages.ads_list')
@endsection

@section("h3")
    <h3>@lang('pages.ads_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/ads.css')}}">
{{--    <form action="">--}}
{{--        <label>@lang('pages.ads_search')</label>--}}
{{--        <input type="text" name="search">--}}
{{--        <br>--}}
{{--        <br>--}}
{{--        <input type="submit" value="@lang('pages.ads_search')" class="button">--}}
{{--        <br>--}}
{{--        <br>--}}
{{--    </form>--}}
    <div class="ads">
        <div>
            <table>
                <tr>
                    <td>ID</td>
                    <td>@lang('pages.ads_title')</td>
                    <td>@lang('pages.ads_rubric')</td>
                    <td>@lang('pages.ads_subsection')</td>
                    <td>@lang('pages.ads_action')</td>
                </tr>
                @foreach($ads as $ad)
                    <tr>
                        <td>{{ $ad->id }}</td>
                        <td><a href="{{ route('ads-read', $ad->id) }}" class="link">{{ $ad->title }}</a></td>
                        <td>{{ $ad->subsection->rubric->name }}</td>
                        <td>{{ $ad->subsection->name }}</td>
                        <td class="actions">
                            <div>
                                <form action="{{ route('ads-edit') }}" method="POST" id="form-ad-edit-{{ $ad->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $ad->id }}">
                                    <button form="form-ad-edit-{{ $ad->id }}">
                                        <i class='icon-pen'></i>
                                    </button>
                                </form>

                                <form action="{{ route('ads-delete') }}" method="POST" id="form-delete-{{ $ad->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $ad->id }}">
                                    <input type="hidden" name="moderation" value="moderation">
                                    <button form="form-delete-{{ $ad->id }}">
                                        <i class='icon-trash-empty'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
