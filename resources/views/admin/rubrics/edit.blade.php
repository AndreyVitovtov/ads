@extends("admin.template")

@section("title")
    @lang('pages.rubrics_edit')
@endsection

@section("h3")
    <h3>@lang('pages.rubrics_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/rubrics.css')}}">

    <div class="rubrics">
        <form action="{{ route('rubric-edit-save') }}" method="POST">
            <input type="hidden" name="id" value="{{ $rubric->id }}">
            @csrf
            <div>
                <label for="rubric">
                    @lang('pages.rubrics_rubric')
                </label>
            </div>
            <input type="text" name="name" id="rubric" autofocus value="{{ $rubric->name }}">
            <br>
            <br>
            <input type="submit" value="@lang('pages.rubric_edit_save')" class="button">
        </form>
    </div>
@endsection
