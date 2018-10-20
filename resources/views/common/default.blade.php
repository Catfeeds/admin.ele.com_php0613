@include('common._head')
@include('common._nav')
<div class="container">
    @include('common._notice')
    @yield('contents')
</div>
<div class="container-fluid">
    @yield('cont-lg')
</div>
@include('common._foot')



