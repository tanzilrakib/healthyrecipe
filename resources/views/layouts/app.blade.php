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
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">
    <script src="https://developer.edamam.com/attribution/badge.js"></script>

    <style type="text/css">
      .content{
          padding: 60px 5px;
      }
      .basic.label{
        margin: 2px 1px;
      }

      .sv .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        top: 100%;
        left: 50%;
        margin-left: -60px;
      }

      .sv:hover .tooltiptext {
          visibility: visible;
      }

      @media(max-width:550px){
        .nav-menu-search>input{ 
            transition: all 1s linear;
            width: 50px;
        }
        .nav-menu-search:hover>input{
            width:145px;
        }
      }

      .popup{
        background:#ccc;
      }

      .std-border-margin{
        padding: 10px 15px !important; 
        margin: 10px 0px !important;    
      }

    </style>
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
  {{-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('js/semantic.min.js') }}"></script> --}}

  <script>


  $('.ui.search')
    .search({
      {{-- source: content --}}
    });

  $('.ui.dropdown')
    .dropdown();


  $('#dfilt').on('DOMSubtreeModified',function(){
      if($('#dfilt').text().trim()==='None'){
          $('#dfilt').text('Diet Filter');
      }
  });

  $('#hfilt').on('DOMSubtreeModified',function(){
      if($('#hfilt').text().trim()==='None'){
          $('#hfilt').text('Health Filter');
      }
  });

  $("#q").keyup(function(event){
      $("#from").val("");
      $("#to").val("");
  });

  $("#q").change(function(event){
      $("#from").val("");
      $("#to").val("");
  });


  $("#q").keypress(function(event){
   if(event.which == 13) {
      setAndSend();
    }
  });

  $("#search-btn").click(function() {
   setAndSend();
  });

  function setAndSend(){

    $("#query").val($("#q").val());
    $("#diet").val($('#dfilt').text().trim());
    $("#health").val($('#hfilt').text().trim());

    if($("#q").val()===''){
      $("#query").val('');
    }

    if($('#dfilt').text().trim()==='Diet Filter'){
          $('#diet').val('');
    }
    if($('#hfilt').text().trim()==='Health Filter'){
          $('#health').val('');
    }
    if($('#diet').val()=='' && $('#health').val()=='' && $("#query").val()==''){
      return;
    } else {

    $('#qForm').submit();

    console.log(url);
    }
  
  }


  $(function(){
    
      $(".rcp-card").click(function(e){
          if($(e.target).is('.sv') || $(e.target).is('.sv-ico') ){
                  return;
          }
          var target = $(this).data('modal-id');
              $("#"+target)
                .modal({
                  blurring: true,
                  closable:false
                })
                .modal('show')
                .modal('refresh');
      });

      $('.x-modal').click(function(e){
          $('.modal').modal('hide');
      });


  });

  $(".pg-btn").click(function(e){
      $("#from").val($(this).data('from'));
      $("#to").val($(this).data('to'));
      setAndSend();
  });

  
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

<div id="rSign"></div>
<div id="revR"></div>

<style>


#rSign{
  width: 30px;
  height: 30px;
  position: fixed;
  bottom:10px;
  color: #333;
  left: 30px;
  border: 1px #333 solid;
  border-radius: 30px;
  transition: all linear .2s;
  text-align: center;
  line-height: 28px;
  font-weight:bolder;
}


#revR{
  width: 30px;
  height: 30px;
  position: fixed;
  bottom:10px;
  border-radius: 30px;
  left: 33px;
  content:'';
  z-index:-1;
  color: transparent;
  border-color:#333;
  transition: width linear .1s, color linear .2s, border-color linear .2s;
}

#rSign:hover~#revR{
  background-color: #fafafa;
  color:#222;
  text-align: center;
  padding-left: 18px;
  font-weight: bold;
  width: 200px;
  border: 1px #222 solid;
  border-style: solid solid solid none;
  line-height: 28px;
  z-index:1;
}

#revR:after{
  display:none;
}
#rSign:hover~#revR:after{ 
  display:block;
  content:'tanzil.rakib@gmail.com';
}

#rSign:after{
  content:'R';
}

#rSign:hover,
#rSign:active{
    background-color: #fafafa;
    color:#222;
    border-color:#222;
    -webkit-transform: rotate(720deg);
    transform: rotate(720deg);
    z-index:2;
}


</style>




</body>
</html>
