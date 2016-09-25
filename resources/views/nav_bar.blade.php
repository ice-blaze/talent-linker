<nav class="navbar navbar-light bg-faded">
  <a class="navbar-brand" href="/">Talent Linker</a>
  <ul class="nav navbar-nav">
    <li class="nav-item {{Request::is('projects*') ? 'active':''}}">
      <a class="nav-link" href="/projects">Projects</a>
    </li>
    <li class="nav-item {{Request::is('talents*') ? 'active':''}}">
      <a class="nav-link" href="/talents">Talents</a>
    </li>
    <li class="nav-item {{Request::is('about*') ? 'active':''}}">
      <a class="nav-link" href="/about">About</a>
    </li>
  </ul>
  <ul class="nav navbar-nav pull-xs-right">
    @if (Auth::guest())
      <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
    @else
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
          <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
        </ul>
      </li>
    @endif
  </ul>
</nav>
