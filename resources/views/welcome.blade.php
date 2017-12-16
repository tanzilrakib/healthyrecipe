@extends('layouts.app')

@section('content')
        <style>

            .full-height {
                padding: 20px 5px;
                height: 80vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .landing-filters-btn{
                margin: 15px 5px !important;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            @media(min-width:768px){
            .title {
                font-size: 20px;
            }
            .ui.icon.input input {
                width: 400px;
              }
            }

        </style>


             <div class="flex-center position-ref full-height">
                <div class="title m-b-md">

               <div class="ui huge header">{{config('app.name')}}</div>
               
                {{-- search modules --}}

            <div class="ui item">
                <div class="ui icon input">
                  <input id="q" type="text" placeholder="Search for recipes or ingredients">
                  <i id="search-btn" class="circular search link icon"></i>
                </div>
            </div>



          {{-- filter --}}
                    
            <div class="ui dropdown labeled icon button landing-filters-btn">
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




            {{-- filter --}}

            {{-- filter --}}


              <div class="ui dropdown labeled icon button landing-filters">
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



            {{-- filter --}}


        {{-- search modules end--}}
        </div>
                {{--mbm end--}}

{{--                 <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> --}}
            </div>


<div id="edamam-badge" style="position:fixed;bottom:5px;right:5px;z-index:2" data-color="white"></div>
@endsection