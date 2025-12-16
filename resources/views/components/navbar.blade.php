<nav>
    <a href="{{ url('/') }}">Home</a>
    @auth
        <span>Welcome, {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth
</nav>
