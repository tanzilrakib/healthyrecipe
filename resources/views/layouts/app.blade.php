<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div class="ui top fixed menu">
      <a class="item" href="/">
        {{ config('app.name', 'Laravel') }}
      </a>



@if(Route::current()->getName() !== 'landing')
          
          <div class=" item ">
                <div class="ui icon input nav-menu-search">
                  <input id="q" type="text" placeholder="Search recipes, ingredients.." value="{{isset($query)? $query['query'] : ''}}">
                  <i id="search-btn" class="circular search link icon"></i>
                </div>
          </div> 
                

              {{-- filter --}}

            <div class="item hidden-sm hidden-xs grid">
              <div class="ui dropdown labeled icon button">
                <i class="filter icon"></i>
                <span id="dfilt" class="text">Diet Filter</span>
                <div class="menu">

                  <div class="scrolling menu">
                    <div class="item">
                          <div class="ui empty circular label"></div>
                       None
                    </div>
                    @foreach($dFilter as $diet)
                    <div class="item">
                      <div class="ui green empty circular label"></div>
                      {{$diet}}
                    </div>
                    @endforeach
                  
                  </div>
                </div>
              </div>
            </div>
                      
             
            {{-- filter --}}

            {{-- filter --}}

            <div class="item hidden-sm hidden-xs grid"> 
                <div class="ui dropdown labeled icon button">
                  <i class="filter icon"></i>
                  <span id="hfilt" class="text">Health Filter</span>
                  <div class="menu">
                    <div class="scrolling menu">
                    <div class="item">
                          <div class="ui empty circular label"></div>
                       None
                    </div>
                    @foreach($hFilter as $health)
                      <div class="item">
                        <div class="ui orange empty circular label"></div>
                        {{$health}}
                      </div>
                    @endforeach
                    </div>
                  </div>
              </div>
          </div>
             

            {{-- filter --}}

@endif
      

      @if (Auth::guest())
      <div class="menu right">
          <a class="item" href="{{ route('login') }}">Login</a>
          <a class="item" href="{{ route('register') }}">Register</a>
      </div>
      @else

      <div class="ui right dropdown item">
        <i class="user circle outline icon"></i>
        {{Auth::user()->name}}
        <i class="dropdown icon"></i>
        <div class="menu  inverted">
          <a class="item" href="{{ route('saved') }}">
          <i class="heart icon"></i>
          <div class="ui vertical divider"></div>
           Saved Recipes</a>
          {{-- <div class="divider"></div> --}}
          <a class="item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
           <i class="power icon"></i>
           Logout 
           </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
          </div>
      </div>
      @endif


    </div>
    {{-- top menu nav --}}

    <div class="content">
    @yield('content')

    <form id="qForm" method="get" action="{{route('search')}}">
      {{-- {{csrf_field()}} --}}
      <input id="query" name="query" type="hidden" value=""> 
      <input id="diet" name="diet" type="hidden" value=""> 
      <input id="health" name="health" type="hidden" value=""> 
      <input id="from" name="from" type="hidden" value=""> 
      <input id="to" name="to" type="hidden" value="">

    </form>


    </div>


  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

  <script src="https://developer.edamam.com/attribution/badge.js"></script>
  <script>

  
  </script>


@if(isset($query['diet']))
    <script>
      {{-- var activeDiet =  JSON.parse("{{ json_encode($query['diet']) }}"); 
      //for objects--}}
      var activeDiet =  {!! json_encode($query['diet']) !!}; 

      var menu = $('#dfilt').siblings( ".menu" );
      menu.find('.item').each(function( i ) {
        if($(this).text().trim()  === activeDiet ){
          $(this).addClass('active selected').trigger( "click" );
        }
      });

    </script>
@endif
@if(isset($query['health']))
    <script>
      var activeHealth =  {!! json_encode($query['health']) !!}; 

      var menu = $('#hfilt').siblings( ".menu" );
      menu.find('.item').each(function( i ) {
        if($(this).text().trim()  === activeHealth ){
          $(this).addClass('active selected').trigger( "click" );
        }
      });

    </script>
@endif

@yield('scripts')
   

   
</body>
</html>
