@extends('layouts.app')

@section('content')


@if(isset($query))
  <h2 class="ui header std-border-margin">Search results for "{{ $query['query'] }}{{ ($query['query'] && $query['diet'])? ', ':''}}{{ $query['diet']? $query['diet']:''}}{{( $query['diet'] && $query['health'])? ', ':''}}{{ $query['health']? $query['health']:''}}" :</h2>
@endif

<div class="ui four column centered stackable grid" style="padding: 30px 5px">  


  @if(isset($data) || !is_null($data->hits) )
          @foreach($data->hits as $hit)
          <div class="column rcp-card" data-modal-id="{{substr($hit->recipe->uri, strpos($hit->recipe->uri,'_')+strlen('_'))}}">
            <div class="ui centered card">
              <a class="ui fluid medium image" >
                <img style="max-height: 200px" src="{{$hit->recipe->image}}">
              </a>
              <a href="{{route('bookmark', ['uri' => substr($hit->recipe->uri, strpos($hit->recipe->uri,'#')+strlen('#')) ])}}" class="ui right {{isset($hit->userBooked)? 'green' : 'blue'}} corner label sv">
                    <i style="cursor:pointer" class="heart {{isset($hit->userBooked)? 'outline' : 'white'}} icon sv-ico"></i>
                <span class="tooltiptext">{{isset($hit->userBooked)? 'Remove from saved.' : 'Save this recipe!'}}</span>
              </a>
              <div class="content">

            {{--      <a class="right floated">
                  <i class="heart outline like icon"></i>
                  Favorite
                </a> --}}
                <a class="header">{{$hit->recipe->label}}</a>
                <div class="meta">
                  <span class="date">{{$hit->recipe->source}}</span>
                </div>
                <div class="description relaxed grid">
                    @foreach($hit->recipe->dietLabels as $dLabel)
                        <a class="ui blue basic label">{{$dLabel}}</a>
                    @endforeach
                    <div class="ui divider"></div>
                    @foreach($hit->recipe->healthLabels as $hLabel)
                        <a class="ui green basic label">{{$hLabel}}</a>
                    @endforeach
                </div>
              </div>

            </div>
          </div>



        <div class="ui medium modal" id="{{substr($hit->recipe->uri, strpos($hit->recipe->uri,'_')+strlen('_'))}}">

         
          <div class="header">
            <i class="close icon x-modal"></i>
            {{$hit->recipe->label}}
            <div class="sub header"><h4 class="grey text"> {{$hit->recipe->source}}</h4></div>
          </div>

          <a class="ui right ribbon label {{isset($hit->userBooked)? 'green' : 'grey'}}" href="{{route('bookmark', ['uri' => substr($hit->recipe->uri, strpos($hit->recipe->uri,'#')+strlen('#')) ])}}" >
            <i class="bookmark icon {{isset($hit->userBooked)? 'yellow' : 'white'}}" style="padding:0px 5px 10px 5px"></i>
          </a>
          

          <div class="image content">


            <div class="ui medium image">
              <img src="{{$hit->recipe->image}}">          
               <h4 class="ui header">{{$hit->recipe->label}}</h4>
            </div>

            <div class="description">

              <div class="ui header">Ingredients:</div>
                <p>
                  <ul>
                  @foreach($hit->recipe->ingredientLines as $ingLine)
                    <li>{{$ingLine}}</li>
                  @endforeach
                  </ul>
                </p>

             <div class="ui header">Calories:</div>
              <p>
                {{$hit->recipe->calories}}
              </p>

              <div class="ui header">Tags:</div>
              <p>
                @foreach($hit->recipe->dietLabels as $dLabel)
                    <a class="ui blue basic label">{{$dLabel}}</a>
                @endforeach
                <div class="ui divider"></div>
                @foreach($hit->recipe->healthLabels as $hLabel)
                    <a class="ui green basic label">{{$hLabel}}</a>
                @endforeach
              </p>



            </div>

          </div>

          <div class="actions">
            <a href="{{$hit->recipe->url}}" target="_blank" class="ui green right labeled icon button">
              Visit source
              <i class="external icon"></i>
            </a>
            <a href="{{$hit->recipe->shareAs}}" target="_blank" class="ui green right labeled icon button">
              View on edamam
              <i class="external icon"></i>
            </a>
          </div>


        </div>

         @endforeach


 @else
        <h2 class="ui header centered std-border-margin">No recipe found for "{{ $query['query'] }}{{ ($query['query'] && $query['diet'])? ', ':''}}{{ $query['diet']? $query['diet']:''}}{{( $query['diet'] && $query['health'])? ', ':''}}{{ $query['health']? $query['health']:''}}"</h2>

 @endif

</div>


<div class="ui centered grid">
    <div class="center aligned column">
        <div class="ui compact menu">
        @if(isset($pageIndexes))
        @foreach($pageIndexes as $k=>$idx)

          <a class="item pg-btn" data-from="{{$idx['from']}}" data-to="{{$idx['to']}}">
            {{$k+1}}
          </a>

        @endforeach
        @endif
        
        </div>        
    </div>
</div>


<div id="edamam-badge" style="position:fixed;bottom:5px;right:5px;z-index:2" data-color="white"></div>
@endsection


@section('scripts')
<script type="text/javascript">


</script>
@endsection
