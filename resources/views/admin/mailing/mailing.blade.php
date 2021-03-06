@extends("admin.template")

@section("title")
    @lang('pages.mailing')
@endsection

@section("h3")
    <h3>@lang('pages.mailing')</h3>
@endsection

@section("main")
    <link rel="stylesheet" href="{{asset('css/mailing.css')}}">

    <div class="mailing">
        <form action="{{ route('send-mailing') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label>@lang('pages.mailing_select_country')</label>
            </div>
            <div>
                <select name="country" class="country_mailing">
                    <option value="%">@lang('pages.mailing_all')</option>
                    @foreach($countries as $key => $country)
                        <option value="{{ $key }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>@lang('pages.mailing_text_message')</label>
            </div>
            <div>
                <textarea name="text" {{ $disable }}></textarea>
            </div>
            <div>
                <label>@lang('pages.mailing_messenger')</label>
            </div>
            <div>
                <input type="radio" name="messenger" value="%" id="all_messenger" checked>
                <label for="all_messenger">@lang('pages.mailing_all')</label>

                <input type="radio" name="messenger" value="Viber" id="viber">
                <label for="viber">Viber</label>

                <input type="radio" name="messenger" value="Telegram" id="telegram">
                <label for="telegram">Telegram</label>
            </div>
            <br>
            <div>
                <label>@lang('pages.mailing_ads')</label>
            </div>
            <div>
                <input type="radio" name="with_ads" value="all" id="ads_holders_all" checked>
                <label for="ads_holders_all">@lang('pages.mailing_all')</label>

                <input type="radio" name="with_ads" value="yes" id="ads_holders_yes">
                <label for="ads_holders_yes">@lang('pages.mailing_yes')</label>

                <input type="radio" name="with_ads" value="no" id="ads_holders_no">
                <label for="ads_holders_no">@lang('pages.mailing_no')</label>
            </div>
            <div class="block_buttons">
                <button class="button">@lang('pages.mailing_send')</button>
                <div>
                    <a href="/admin/mailing/analize">
                        <div class="button">
                            @lang('pages.mailing_analize')
                        </div>
                    </a>
                    <a href="/admin/mailing/log">
                        <div class="button">
                            @lang('pages.mailing_log')
                        </div>
                    </a>
                </div>
            </div>
        </form>
        <div>
            @if(is_array($task))
                <div class="mailing-task">
                    @lang('pages.mailing_created') {{ $task['create'] }}
                    <br>
                    @lang('pages.mailing_sending') ≈
                    @if($task['start'] > $task['count'])
                        {{ $task['count'] }}
                    @else
                        {{ $task['start'] }}
                    @endif
                    @lang('pages.mailing_of') {{ $task['count'] }}
                    <div>
                        <form action="/admin/mailing/cancel" method="POST">
                            @csrf
                            <button class="button">@lang('pages.mailing_cancel')</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection



