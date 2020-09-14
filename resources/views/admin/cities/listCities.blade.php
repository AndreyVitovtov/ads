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
            <label>{{ $country->name }}</label>
            <table>
                <tr>
                    <td>@lang('pages.cities_city')</td>
                    <td>@lang('pages.cities_actions')</td>
                </tr>
                @foreach($cities as $city)
                    <tr>
                        <td>{{ $city->name }}</td>
                        <td class="actions">
                            <div>
                                <form action="{{ route('city-edit') }}" method="POST" id="form-city-edit-{{ $city->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $city->id }}">
                                    <button form="form-city-edit-{{ $city->id }}">
                                        <i class='icon-pen'></i>
                                    </button>
                                </form>

                                <form action="{{ route('city-delete') }}" method="POST" id="form-delete-{{ $city->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $city->id }}">
                                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                                    <button form="form-delete-{{ $city->id }}">
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
