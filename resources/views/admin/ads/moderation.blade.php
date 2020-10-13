@extends("admin.template")

@section("title")
    @lang('pages.ads_list')
@endsection

@section("h3")
    <h3>@lang('pages.ads_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/ads.css')}}">
    <form action="" method="POST">
        <label>@lang('pages.ads_search')</label>
        <input type="text" name="search">
        <br>
        <br>
        <input type="submit" value="@lang('pages.ads_search')" class="button">
        <br>
        <br>
    </form>
    <div class="ads">
        <div>
            <table>
                <tr>
                    <td>ID</td>
                    <td>@lang('pages.ads_title')</td>
                    <td>@lang('pages.ads_rubric')</td>
                    <td>@lang('pages.ads_action')</td>
                </tr>
                @foreach($ads as $ad)
                    <tr>
                        <td>{{ $ad->id }}</td>
                        <td>{{ $ad->title }}</td>
                        <td>{{ $ad->rubric->name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
