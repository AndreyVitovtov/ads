@extends("admin.template")

@section("title")
    @lang('pages.subsections_edit')
@endsection

@section("h3")
    <h3>@lang('pages.subsections_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/subsections.css')}}">

    <div class="cities">
        <div>
            <form action="{{ route('subsections-edit-save') }}" method="POST">
                <input type="hidden" name="id" value="{{ $subsection->id }}">
                @csrf
                <label for="select_country">@lang('pages.subsections_select_rubric')</label>
                <select name="rubric_id" id="select_rubric">
                    @foreach($rubrics as $rubric)
                        <option value="{{ $rubric->id }}"
                        @if($rubric->id === $subsection->rubrics_id)
                            selected
                        @endif
                        >{{ $rubric->name }}</option>
                    @endforeach
                </select>
                <br>
                <label for="name">@lang('pages.subsections_name')</label>
                <input type="text" name="name" id="name" value="{{ $subsection->name }}">
                <br>
                <br>
                <input type="submit" value="@lang('pages.subsections_edit_save')" class="button">
            </form>
        </div>
    </div>
@endsection
