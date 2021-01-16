<body>
<script type="text/javascript">

</script>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="{{ url('/') }}">
                    OIS
                </a>

            </li>

            <li>
                @guest
                    Welcome
                @else
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            Welcome {{ Auth::user()->name }}
                        </a>
                @endguest
            </li>

            <li>
                <a href="{{{url('bank_accounts')}}}">Bank Account</a>
            </li>

{{--            <li>--}}
{{--                <a href="{{{url('user')}}}">Agent</a>--}}
{{--            </li>--}}

{{--            <li>--}}
{{--                <a href="{{{url('property')}}}">Property</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{{url('report')}}}">Agent Report</a>--}}
{{--            </li>--}}
            <li>
                @guest
                <a href="{{{url('login')}}}">Sign In</a>
                @endguest
            </li>

            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    Sign Out
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            @yield('sidebar')

        </ul>

    </div>
    <!-- /#sidebar-wrapper -->
