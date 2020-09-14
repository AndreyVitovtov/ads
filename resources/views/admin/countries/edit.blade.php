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
        <form action="{{ route('country-edit-save') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $country->id }}">
            <div>
                <label for="country">
                    @lang('pages.countries_country')
                </label>
            </div>
            <input type="text" name="name" id="country" value="{{ $country->name }}" autofocus>
            <br>
            <br>
            <input type="submit" value="@lang('pages.country_edit_save')" class="button">
        </form>
    </div>
@endsection
