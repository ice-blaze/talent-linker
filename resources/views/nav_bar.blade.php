<nav class="navbar navbar-light bg-faded">
    <a class="navbar-brand" href="/">{{ Trans('global.website_name') }}</a>
    <ul class="nav navbar-nav">
        <li class="nav-item {{Request::is('projects*') ? 'active':''}}">
            <a class="nav-link" href="/projects">{{ Trans('views.projects') }}</a>
        </li>
        <li class="nav-item {{Request::is('talents*') ? 'active':''}}">
            <a class="nav-link" href="/talents">{{ Trans('views.talents') }}</a>
        </li>
        <li class="nav-item {{Request::is('about*') ? 'active':''}}">
            <a class="nav-link" href="/about">{{ Trans('views.about') }}</a>
        </li>
    </ul>
    <ul class="nav navbar-nav pull-xs-right">
        @if (Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">{{ Trans('views.login') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">{{ Trans('views.register') }}</a></li>
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/talents/'.Auth::user()->id) }}"><i class="fa fa-btn fa-user"></i> {{ Trans('views.my_profile') }}</a></li>
                    <li><a href="{{ url('/talents/'.Auth::user()->id.'/projects') }}"><i class="fa fa-btn fa-cogs"></i> {{ Trans('views.my_projects') }}</a></li>
                    <li><a href="{{ url('/chat/inbox') }}"><i class="fa fa-btn fa-inbox"></i> {{ Trans('views.inbox') }}</a></li>
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ Trans('views.logout') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
