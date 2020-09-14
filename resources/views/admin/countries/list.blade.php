@extends("admin.template")

@section("title")
    @lang('pages.countries_list')
@endsection

@section("h3")
    <h3>@lang('pages.countries_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/countries.css')}}">

    <div class="countries">
        <div>
            <table>
                <tr>
                    <td>
                        №
                    </td>
                    <td>
                        @lang('pages.country_name')
                    </td>
                    <td>
                        @lang('pages.country_actions')
                    </td>
                </tr>
                @foreach($countries as $country)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="/admin/cities/country/{{ $country->id }}" class="link">{{ $country->name }}</a>
                        </td>
                        <td class="actions">
                            <div>
                                <form action="{{ route('country-edit') }}" method="POST" id="form-country-edit-{{ $country->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $country->id }}">
                                    <button form="form-country-edit-{{ $country->id }}">
                                        <i class='icon-pen'></i>
                                    </button>
                                </form>

                                <form action="{{ route('country-delete') }}" method="POST" id="form-delete-{{ $country->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $country->id }}">
                                    <button form="form-delete-{{ $country->id }}">
                                        <i class='icon-trash-empty'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $countries->links() }}
        </div>
    </div>
@endsection
