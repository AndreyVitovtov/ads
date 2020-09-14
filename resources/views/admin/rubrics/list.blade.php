@extends("admin.template")

@section("title")
    @lang('pages.rubrics_list')
@endsection

@section("h3")
    <h3>@lang('pages.rubrics_list')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/rubrics.css')}}">

    <div class="rubrics">
        <div>
            <table>
                <tr>
                    <td>
                        №
                    </td>
                    <td>
                        @lang('pages.rubric_name')
                    </td>
                    <td>
                        @lang('pages.rubric_action')
                    </td>
                </tr>
                @foreach($rubrics as $rubric)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="/admin/subsections/rubric/{{ $rubric->id }}" class="link">{{ $rubric->name }}</a>
                        </td>
                        <td class="actions">
                            <div>
                                <form action="{{ route('rubric-edit') }}" method="POST" id="form-rubric-edit-{{ $rubric->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $rubric->id }}">
                                    <button form="form-rubric-edit-{{ $rubric->id }}">
                                        <i class='icon-pen'></i>
                                    </button>
                                </form>

                                <form action="{{ route('rubric-delete') }}" method="POST" id="form-delete-{{ $rubric->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $rubric->id }}">
                                    <button form="form-delete-{{ $rubric->id }}">
                                        <i class='icon-trash-empty'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $rubrics->links() }}
        </div>
    </div>
@endsection
