@extends("admin.template")

@section("title")
    @lang('pages.countries_add')
@endsection

@section("h3")
    <h3>@lang('pages.countries_add')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/countries.css')}}">

    <div class="countries">
        <form action="{{ route('country-add-save') }}" method="POST">
            @csrf
            <div>
                <label for="country">
                    @lang('pages.countries_country')
                </label>
            </div>
            <input type="text" name="name" id="country" autofocus>
            <br>
            <br>
            <input type="checkbox" name="add_more" id="add_more">
             - <label for="add_more">@lang('pages.countries_add_more')</label>
            <br>
            <br>
            <input type="submit" value="@lang('pages.country_add_save')" class="button">
        </form>
    </div>
@endsection
