function fnc_summernote(el,phold){
    el.summernote({
        lang: 'pt-BR',
        placeholder: phold,
        tabsize: 2,
        height: 300,
        toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link", "picture", "video"]]
            ],
      });
  }

  function fnc_onlynumber(el){
    el.value=el.value.replace(/[^0-9]/g,'')
  }

  $('.counter').each(function() {
    var $this = $(this),
        countTo = $this.attr('data-count'),
        durationTime = $this.attr('data-duration');

    $({ countNum: $this.text()}).animate({
      countNum: countTo
    },

    {

      duration: parseInt(durationTime),
      easing:'linear',
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum);
        //alert('finished');
      }

    });

  });

