@extends('layouts.app')

@section('content')
<style type="text/css">
    .popup{
        background:#ccc;
    }

</style>


 @if(isset($q))
    <h2 class="ui header">Search results for "{{$q}}" :</h2>
  @endif


<div class="ui four column centered stackable grid">  
  @if(isset($data))
        
        @foreach($data as $data)

        <div class="column rcp-card" data-modal-id="{{substr($data->uri, strpos($data->uri,'_')+strlen('_'))}}">
            <div class="ui centered card">
              <a class="ui fluid medium image" >
                <img style="max-height: 200px" src="{{$data->image}}">
              </a>
              <a href="{{route('bookmark', ['uri' => substr($data->uri, strpos($data->uri,'#')+strlen('#')) ])}}" class="ui right green corner label sv">
                    <i style="cursor:pointer" class="heart outline icon sv-ico"></i>
                <span class="tooltiptext">Remove from saved</span>
              </a>
              <div class="content">

            {{--      <a class="right floated">
                  <i class="heart outline like icon"></i>
                  Favorite
                </a> --}}
                <a class="header">{{$data->label}}</a>
                <div class="meta">
                  <span class="date">{{$data->source}}</span>
                </div>
                <div class="description relaxed grid">
                    @foreach($data->dietLabels as $dLabel)
                        <a class="ui blue basic label">{{$dLabel}}</a>
                    @endforeach
                    <div class="ui divider"></div>
                    @foreach($data->healthLabels as $hLabel)
                        <a class="ui green basic label">{{$hLabel}}</a>
                    @endforeach
                </div>
              </div>

            </div>
          </div>




        <div class="ui medium modal" id="{{substr($data->uri, strpos($data->uri,'_')+strlen('_'))}}">

         
          <div class="header">
            <i class="close icon x-modal"></i>
            {{$data->label}}
            <div class="sub header"><h4 class="grey text"> {{$data->source}}</h4></div>
          </div>

          <a class="ui right ribbon label green" href="{{route('bookmark', ['uri' => substr($data->uri, strpos($data->uri,'#')+strlen('#')) ])}}" >
            <i class="bookmark icon yellow" style="padding:0px 5px 10px 5px"></i>
          </a>
          

          <div class="image content">


            <div class="ui medium image">
              <img src="{{$data->image}}">          
               <h4 class="ui header">{{$data->label}}</h4>
            </div>

            <div class="description">

              <div class="ui header">Ingredients:</div>
                <p>
                  <ul>
                  @foreach($data->ingredientLines as $ingLine)
                    <li>{{$ingLine}}</li>
                  @endforeach
                  </ul>
                </p>

             <div class="ui header">Calories:</div>
              <p>
                {{$data->calories}}
              </p>

              <div class="ui header">Tags:</div>
              <p>
                @foreach($data->dietLabels as $dLabel)
                    <a class="ui blue basic label">{{$dLabel}}</a>
                @endforeach
                <div class="ui divider"></div>
                @foreach($data->healthLabels as $hLabel)
                    <a class="ui green basic label">{{$hLabel}}</a>
                @endforeach
              </p>



            </div>

          </div>

          <div class="actions">
            <a href="{{$data->url}}" target="_blank" class="ui green right labeled icon button">
              Visit source
              <i class="external icon"></i>
            </a>
            <a href="{{$data->shareAs}}" target="_blank" class="ui green right labeled icon button">
              View on edamam
              <i class="external icon"></i>
            </a>
          </div>


        </div>
         @endforeach
 @endif

</div>
  
<div id="edamam-badge" style="position:fixed;bottom:5px;right:5px;z-index:2" data-color="white"></div>
@endsection


@section('scripts')
<script type="text/javascript">

</script>
@endsection