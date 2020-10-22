@extends("admin.template")

@section("title")
    @lang('pages.ads_edit')
@endsection

@section("h3")
    <h3>@lang('pages.ads_edit')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/ads.css')}}">
    <script src="{{asset('js/admin-panel/editAd.js')}}"></script>

    <form action="{{ route('ads-edit-save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $ad->id }}">
        <div>
            <label for="title">@lang('pages.ads_title')</label>
            <input type="text" name="title" value="{{ $ad->title }}" id="title">
        </div>
        <div>
            <label for="description">@lang('pages.ads_description')</label>
            <textarea name="description" id="description">{{ $ad->description }}</textarea>
        </div>
        <div>
            <label for="phone">@lang('pages.ads_phone')</label>
            <input type="text" name="phone" value="{{ $ad->phone }}" id="phone">
        </div>
        <div>
            <label for="location">@lang('pages.ads_location')</label>
            <input type="text" name="location" value="{{ $ad->lat }}, {{ $ad->lon }}" id="location">
        </div>
        <div>
            <label for="photo">@lang('pages.ads_photo')</label>
            <br>
            <input type="file" name="photo">
        </div>
        <div>
            <label for="rubric">@lang('pages.ads_rubric')</label>
            <select name="rubric" id="rubric">
                @foreach($rubrics as $rubric)
                    <option value="{{ $rubric->id }}"
                        @if($rubric->id == $ad->subsection->rubric->id)
                            selected
                        @endif
                    >{{ $rubric->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="subsection">@lang('pages.ads_subsection')</label>
            <select name="subsection" id="subsection">
                @foreach($subsections as $subsection)
                    <option value="{{ $subsection->id }}"
                        @if($subsection->id == $ad->subsection->id)
                            selected
                        @endif
                    >{{ $subsection->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="country">@lang('pages.ads_country')</label>
            <select name="country" id="country">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}"
                        @if($country->id == $ad->city->country->id)
                            selected
                        @endif
                    >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="city">@lang('pages.ads_city')</label>
            <select name="city" id="city">
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                            @if($city->id == $ad->city->id)
                            selected
                        @endif
                    >{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <input type="submit" value="@lang('pages.ads_edit_save')" class="button">
        </div>
    </form>
@endsection
