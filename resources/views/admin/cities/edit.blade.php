@extends("admin.template")

@section("title")
    @lang('pages.cities_list')
@endsection

@section("h3")
    <h3>@lang('pages.cities_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/cities.css')}}">

    <div class="cities">
        <div>
            <form action="{{ route('city-edit-save') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $city->id }}">
                <label for="select_country">@lang('pages.countries_select_country')</label>
                <select name="country_id" id="select_country">
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                        @if($country->id === $city->country_id)
                            selected
                        @endif
                        >{{ $country->name }}</option>
                    @endforeach
                </select>
                <br>
                <label for="name">@lang('pages.countries_name')</label>
                <input type="text" name="name" id="name" value="{{ $city->name }}">
                <br>
                <br>

                <input type="submit" value="@lang('pages.cities_edit_save')" class="button">
            </form>
        </div>
    </div>
@endsection
