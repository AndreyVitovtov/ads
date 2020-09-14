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
            <form action="{{ route('subsections-go') }}" method="POST">
                @csrf
                <label>@lang('pages.subsections_select_rubric')</label>
                <select name="rubric">
                    @foreach($rubrics as $rubric)
                        <option value="{{ $rubric->id }}">{{ $rubric->name }}</option>
                    @endforeach
                </select>
                <br>
                <br>
                <input type="submit" value="@lang('pages.subsections_go')" class="button">
            </form>
        </div>
    </div>
@endsection
