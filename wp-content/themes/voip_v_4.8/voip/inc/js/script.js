jQuery(document).ready(function ($) {
  "use strict";


  var wd_font_family = "";
  var wd_font_weight = "";
  var wd_font_subsets = "";

  $("#tabs-2 select.font_familly").on('change',function () {
    wd_font_family = $(this).find(":selected").val();

    $("#wd-google-fonts-css").attr("href", "http://fonts.googleapis.com/css?family=" + wd_font_family + ":" + wd_font_weight + "&subset=" + wd_font_subsets);
    $(this).closest("tbody").find("p").css("font-family", wd_font_family);
    $(this).closest("tbody").find("h2").css("font-family", wd_font_family);
    $(this).closest("tbody").find("ul li").css("font-family", wd_font_family);
  });

  $("#tabs-2 select.font_weight").on('change',function () {
    wd_font_family = $(this).find(":selected").val();

    $(this).closest("tbody").find("p").css("font-weight", wd_font_family);
    $(this).closest("tbody").find("h2").css("font-weight", wd_font_family);
    $(this).closest("tbody").find("ul li").css("font-weight", wd_font_family);
  });

  $("#tabs-2 select.font_subsets").on('change',function () {
    wd_font_family = $(this).find(":selected").val();
    $("#wd-google-fonts-css").attr("href", "http://fonts.googleapis.com/css?family=" + wd_font_family + ":" + wd_font_weight + "&subset=" + wd_font_subsets);
  });



  /*--------------------------------------*/
  var curent_sreen = '';

  function wd_add_ckeckbox_class() {
    curent_sreen = $("input:radio[name='wd_start_screan']:checked").val();
    $("input[name='wd_start_screan']").parent().removeClass('selected');

    $("input[value='" + curent_sreen + "'][name='wd_start_screan']").parent().addClass('selected');
  }

  $('.wd-color-picker').wpColorPicker(
    {format: 'rgba'}
  );
  $('ul.g_tab li').on('click',function(){
    var tab_id = $(this).attr('data-tab');
    var fromParent = $(this).closest('.groups_tabs');
    console.log(fromParent);
    $('ul.g_tab li', fromParent).removeClass('current');
    $('.tab-content', fromParent).removeClass('current');
    $(this).addClass('current');
    $("#"+tab_id, fromParent).addClass('current');
  });
  
  $("#tabs").tabs(); //initialize tabs
  $(function () {
    $("#tabs").tabs({
      activate: function (event, ui) {
        var scrollTop = $(window).scrollTop(); // save current scroll position
        window.location.hash = ui.newPanel.attr('id'); // add hash to url
        $(window).scrollTop(scrollTop); // keep scroll at current position
      }
    });
  });
  // reload the form when the checkbox is changed
  wd_add_ckeckbox_class();
  $('.wd_start_screan').on('click',function (e) {
    if (curent_sreen != $(this).val()) {
      wd_add_ckeckbox_class();
      $(this).closest('form').submit();
    }
  });

  if (typeof wp.media !== 'undefined') {

    var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;

    $('.uploader .button').on('click',function (e) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      var id = button.attr('id').replace('_button', '');
      _custom_media = true;
      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          $("#" + id).val(attachment.url);
        } else {
          return _orig_send_attachment.apply(this, [props, attachment]);
        }
        ;
      };

      wp.media.editor.open(button);
      return false;
    });

    $('.add_media').on('click', function () {
      _custom_media = false;
    });

  }


  $('.import-demo-screenshot').on('change', 'input[name=demo_screenshot]:radio', function (e) {
    var input_value = $(this).attr('id');
    $('.import-demo-screenshot label').removeClass("label_selected");
    $("." + input_value).addClass("label_selected");
  });

  $(".revblue.tp-be-button").on('click', function (e) {
    if ($("#input_import_slider").val() == '') {
      alert("Please select the revslider file");
      e.preventDefault();
      return false;
    }
  });

});

jQuery(window).load(function () {
  jQuery(".wd-cpanel").show();
});