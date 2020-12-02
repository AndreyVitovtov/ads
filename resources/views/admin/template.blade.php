<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") | @lang('template.title')</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/developer.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontello.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/admin-panel/common.js')}}"></script>
    <script src="{{asset('js/admin-panel/drawChart.js')}}"></script>
    <script src="{{asset('https://www.gstatic.com/charts/loader.js')}}"></script>
</head>
<body>
<div class="pop-up-window">
</div>
<header>
    <section class="left-panel">
        @lang('template.left_panel_panel')
    </section>
    <section class="right-panel">
        <nav class="open-menu mob-hidden">
            <i class="icon-menu"></i>
        </nav>
        <nav class="open-menu-mob pc-hidden">
            <i class="icon-menu"></i>
        </nav>
        <div class="right-panel-lang-user">
            <div class="languages">
                <div>
                    <a href="{{ route('locale', App::getLocale()) }}">
                        <img src="{{ url('/img/language/'.App::getLocale().'.png') }}" alt="">
                    </a>
                </div>
                <div class="languages-other">
                    @if(App::getLocale() == "ru")
                        <a href="{{ route('locale', 'us') }}">
                            <img src="{{ url('/img/language/us.png') }}" alt="">
                        </a>
                    @else
                        <a href="{{ route('locale', 'ru') }}">
                            <img src="{{ url('/img/language/ru.png') }}" alt="">
                        </a>
                    @endif
                </div>
            </div>
            <nav class="open-user-menu">
                <img src="{{asset('img/avatar5.png')}}" alt="avatar">
                <span>
                @lang('template.left_panel_administrator')
            </span>
            </nav>
        </div>
        <div class="dropdown-menu">
            <img src="{{asset('img/avatar5.png')}}" alt="avatar">
            <div class="title">
                <div>
                    @lang('template.top_panel_administrator')
                </div>
                <div>
                    {{ Auth::user()->name }}
                </div>
            </div>
            <div class="dropdown-menu-nav">
                <div>
                    <form action="/admin/settings" method="POST">
                        @csrf
                        <button class="button user-settings">@lang('template.top_panel_settings')</button>
                    </form>
                </div>
                <div>
                    <form action="/logout">
                        <button data-go="exit" class="button">@lang('template.top_panel_log_off')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</header>
<main>
    <section class="sidebar no-active">
        <div class="user-panel">
            <img src="{{asset('img/avatar5.png')}}" alt="avatar">
            <span>
                @lang('template.left_panel_administrator')
            </span>
        </div>
        <ul class="sidebar-menu">
            <li class="header">@lang('template.left_panel_menu')</li>
            @access('statistics')
            @component('menu.menu-item', [
                'name' => 'statistics',
                'icon' => 'icon-gauge',
                'menu' => 'statistics',
                'url' => '/admin'])
            @endcomponent
            @endaccess
            @access('users')
            @component('menu.menu-item', [
                'name' => 'users',
                'icon' => 'icon-users-3',
                'menu' => 'users',
                'url' => '/admin/users'])
            @endcomponent
            @endaccess
            @access('mailing')
            @component('menu.menu-item', [
                'name' => 'mailing',
                'icon' => 'icon-mail-4',
                'menu' => 'mailing',
                'url' => '/admin/mailing'])
            @endcomponent
            @endaccess
            @access('countries')
            @component('menu.menu-rolled', [
                'nameItem' => 'countries',
                'icon' => 'icon-map-2',
                'name' => 'countries',
                'items' => [[
                        'name' => 'countries_list',
                        'menu' => 'countrieslist',
                        'url' => '/admin/countries/list'
                    ],[
                       'name' => 'countries_add',
                       'menu' => 'countriesadd',
                       'url' => '/admin/countries/add'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('cities')
            @component('menu.menu-rolled', [
                'nameItem' => 'cities',
                'icon' => 'icon-location-3',
                'name' => 'cities',
                'items' => [[
                        'name' => 'cities_list',
                        'menu' => 'citieslist',
                        'url' => '/admin/cities/list'
                    ],[
                       'name' => 'cities_add',
                       'menu' => 'citiesadd',
                       'url' => '/admin/cities/add'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('rubrics')
            @component('menu.menu-rolled', [
                'nameItem' => 'rubrics',
                'icon' => 'icon-th-large-outline',
                'name' => 'rubrics',
                'items' => [[
                        'name' => 'rubrics_list',
                        'menu' => 'rubricslist',
                        'url' => '/admin/rubrics/list'
                    ],[
                        'name' => 'rubrics_add',
                        'menu' => 'rubricsadd',
                        'url' => '/admin/rubrics/add'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('subsections')
            @component('menu.menu-rolled', [
                'nameItem' => 'subsections',
                'icon' => 'icon-th-outline',
                'name' => 'subsections',
                'items' => [[
                        'name' => 'subsections_list',
                        'menu' => 'subsectionslist',
                        'url' => '/admin/subsections/list'
                    ],[
                        'name' => 'subsections_add',
                        'menu' => 'subsectionsadd',
                        'url' => '/admin/subsections/add'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('ads')
            @component('menu.menu-rolled', [
                'nameItem' => 'ads',
                'icon' => 'icon-docs-1',
                'name' => 'ads',
                'items' => [[
                       'name' => 'ads_moderation',
                       'menu' => 'adsmoderation',
                       'url' => '/admin/ads/moderation'
                    ],[
                       'name' => 'ads',
                       'menu' => 'ads',
                       'url' => '/admin/ads'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('moderators')
            @component('menu.menu-rolled', [
                'nameItem' => 'moderators',
                'icon' => 'icon-users-2',
                'name' => 'moderators',
                'items' => [[
                       'name' => 'moderators_list',
                       'menu' => 'moderatorslist',
                       'url' => '/admin/moderators'
                    ],[
                       'name' => 'moderators_add',
                       'menu' => 'moderatorsadd',
                       'url' => '/admin/moderators/add'
                    ],[
                       'name' => 'moderators_permissions',
                       'menu' => 'moderatorspermissions',
                       'url' => '/admin/moderators/permissions'
                    ]
                ]])
            @endcomponent
            @endaccess
{{--            @access('languages')--}}
{{--            @component('menu.menu-rolled', [--}}
{{--                'nameItem' => 'languages',--}}
{{--                'icon' => 'icon-language-1',--}}
{{--                'name' => 'languages',--}}
{{--                'items' => [[--}}
{{--                        'name' => 'languages_list',--}}
{{--                        'menu' => 'languageslist',--}}
{{--                        'url' => '/admin/languages/list'--}}
{{--                    ],[--}}
{{--                       'name' => 'languages_add',--}}
{{--                       'menu' => 'languagesadd',--}}
{{--                       'url' => '/admin/languages/add'--}}
{{--                    ]--}}
{{--                ]])--}}
{{--            @endcomponent--}}
{{--            @endaccess--}}
            @access('contacts')
            @component('menu.menu-rolled', [
                'nameItem' => 'contacts',
                'icon' => 'icon-book',
                'name' => 'contacts',
                'items' => [[
                        'name' => 'contacts_general',
                        'menu' => 'contactsgeneral',
                        'url' => '/admin/contacts/general'
                    ],
                    [
                       'name' => 'contacts_access',
                       'menu' => 'contactsaccess',
                       'url' => '/admin/contacts/access'
                    ],
                    [
                       'name' => 'contacts_advertising',
                       'menu' => 'contactsadvertising',
                       'url' => '/admin/contacts/advertising'
                    ],[
                       'name' => 'contacts_offers',
                       'menu' => 'contactsoffers',
                       'url' => '/admin/contacts/offers'
                    ]
                ]])
            @endcomponent
            @endaccess
            @access('answers')
            @component('menu.menu-rolled', [
                'nameItem' => 'answers',
                'icon' => 'icon-help-1',
                'name' => 'answers',
                'items' => [[
                        'name' => 'answers_list',
                        'menu' => 'answerslist',
                        'url' => '/admin/answers/list'
                    ],[
                       'name' => 'answers_add',
                       'menu' => 'answersadd',
                       'url' => '/admin/answers/add'
                    ]
                ]])
            @endcomponent
            @endaccess
{{--            @access('payment')--}}
{{--            @component('menu.menu-rolled', [--}}
{{--                'nameItem' => 'payment',--}}
{{--                'icon' => 'icon-money-2',--}}
{{--                'name' => 'admin_pay',--}}
{{--                'items' => [[--}}
{{--                        'name' => 'admin_qiwi',--}}
{{--                        'menu' => 'payqiwi',--}}
{{--                        'url' => '/admin/payment/qiwi'--}}
{{--                    ],[--}}
{{--                       'name' => 'admin_yandex_noney',--}}
{{--                       'menu' => 'payyandex',--}}
{{--                       'url' => '/admin/payment/yandex'--}}
{{--                    ],[--}}
{{--                       'name' => 'admin_webmoney',--}}
{{--                       'menu' => 'paywebmoney',--}}
{{--                       'url' => '/admin/payment/webmoney'--}}
{{--                    ],[--}}
{{--                       'name' => 'admin_paypal',--}}
{{--                       'menu' => 'paypaypal',--}}
{{--                       'url' => '/admin/payment/paypal'--}}
{{--                    ]--}}
{{--                ]])--}}
{{--            @endcomponent--}}
{{--            @endaccess--}}
            @access('settings')
            @component('menu.menu-rolled', [
                'nameItem' => 'settings',
                'icon' => 'icon-cog-alt',
                'name' => 'settings',
                'items' => [
                    [
                    'name' => 'settings_main',
                    'menu' => 'settingsmain',
                    'url' => '/admin/settings/main'
                    ],
                    [
                       'name' => 'settings_pages',
                       'menu' => 'settingspages',
                       'url' => '/admin/settings/pages'
                    ],[
                       'name' => 'settings_buttons',
                       'menu' => 'settingsbuttons',
                       'url' => '/admin/settings/buttons'
                    ]
                ]])
            @endcomponent
            @endaccess
        </ul>
    </section>
    <section class="content">
        <div class="container">
            @yield("h3")
            <div>
                @yield("main")
            </div>
        </div>
        <footer>
            Copyright © 2020 <a href="https://vitovtov.info" target="_blank">vitovtov.info</a>
        </footer>
    </section>
</main>

@if(isset($menuItem))
    <script>
        $('.item-menu').removeClass('active');
        $('main section.sidebar .menu-hidden div').removeClass('active');
        $('.{{ $menuItem }}').addClass('active');
        $('.{{ $menuItem }}').parents('span.rolled-hidden').children('li.item-menu').addClass('active');
        $('.{{ $menuItem }}').parents('li').addClass('menu-active');
        $('.{{ $menuItem }}').parents('li').toggle();
    </script>
@endif

@if(isset($notification))
    <script>
        setTimeout(function() {
            popUpWindow({{ $notification }})
        }, 300);
    </script>
@endif
</body>
</html>

