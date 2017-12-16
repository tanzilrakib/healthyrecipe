

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
