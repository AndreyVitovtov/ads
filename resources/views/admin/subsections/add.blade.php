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
            <form action="{{ route('subsections-add-save') }}" method="POST">
                @csrf
                <label for="select_country">@lang('pages.subsections_select_rubric')</label>
                <select name="rubric_id" id="select_rubric">
                    @foreach($rubrics as $rubric)
                        <option value="{{ $rubric->id }}">{{ $rubric->name }}</option>
                    @endforeach
                </select>
                <br>
                <label for="name">@lang('pages.subsections_name')</label>
                <input type="text" name="name" id="name">
                <br>
                <br>
                <input type="checkbox" name="add_more" id="add_more">
                - <label for="add_more">@lang('pages.subsections_add_more')</label>
                <br>
                <br>
                <input type="submit" value="@lang('pages.subsections_add_save')" class="button">
            </form>
        </div>
    </div>
@endsection
