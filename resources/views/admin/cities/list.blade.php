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
            <form action="{{ route('cities-go') }}" method="POST">
                @csrf
                <label>@lang('pages.countries_select_country')</label>
                <select name="country">
                @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
                </select>
                <br>
                <br>
                <input type="submit" value="@lang('pages.cities_go')" class="button">
            </form>
        </div>
    </div>
@endsection
