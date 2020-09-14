@extends("admin.template")

@section("title")
    @lang('pages.subsections_list')
@endsection

@section("h3")
    <h3>@lang('pages.subsections_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/subsections.css')}}">

    <div class="cities">
        <div>
            <label>{{ $rubric->name }}</label>
            <table>
                <tr>
                    <td>@lang('pages.subsections_subsection')</td>
                    <td>@lang('pages.subsections_actions')</td>
                </tr>
                @foreach($subsections as $subsection)
                    <tr>
                        <td>{{ $subsection->name }}</td>
                        <td class="actions">
                            <div>
                                <form action="{{ route('subsection-edit') }}" method="POST" id="form-city-edit-{{ $subsection->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $subsection->id }}">
                                    <button form="form-city-edit-{{ $subsection->id }}">
                                        <i class='icon-pen'></i>
                                    </button>
                                </form>

                                <form action="{{ route('subsection-delete') }}" method="POST" id="form-delete-{{ $subsection->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $subsection->id }}">
                                    <input type="hidden" name="rubric_id" value="{{ $rubric->id }}">
                                    <button form="form-delete-{{ $subsection->id }}">
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
