@extends("admin.template")

@section("title")
    @lang('pages.rubrics_add')
@endsection

@section("h3")
    <h3>@lang('pages.rubrics_add')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/rubrics.css')}}">

    <div class="rubrics">
        <form action="{{ route('rubric-add-save') }}" method="POST">
            @csrf
            <div>
                <label for="rubric">
                    @lang('pages.rubrics_rubric')
                </label>
            </div>
            <input type="text" name="name" id="rubric" autofocus>
            <br>
            <br>
            <input type="checkbox" name="add_more" id="add_more">
            - <label for="add_more">@lang('pages.rubric_add_more')</label>
            <br>
            <br>
            <input type="submit" value="@lang('pages.rubric_add_save')" class="button">
        </form>
    </div>
@endsection
