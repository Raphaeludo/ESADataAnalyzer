$(document).ready(function() {

  $(".main-header-section").backgroundCycle({
      imageUrls: [
        'assets/img/carousel/slide1.jpg',
        'assets/img/carousel/slide2.jpg',
        'assets/img/carousel/slide3.jpg'
      ],
      fadeSpeed: 1000,
      duration: 4000,
      backgroundSize: SCALING_MODE_COVER
  });

  // load bootstrap dateandtime pickcer
  $('#selectDate').click(function(){
    $('#selectDate').datetimepicker({
      format:'d M Y H:i',
    });
  });

  // loads location json into state and city
  $.ajax({
    url: 'assets/js/locations.json',
    type: 'GET',
    dataType: 'json'
  })
  .done(function(error) {
    mydata = error;
    for (var state in mydata.States) {
        $('#state').append('<option value="' + String(state) + '">' + String(state) + ' </option>');
    }
  })
  $('#state').change(function(event) {
      var selectedState = $(this).val();
      $('#city').empty();
      //Get cities for selectedState
      var cities = mydata.States[String(selectedState)];
      $('#city').append('<option value="" selected disabled>Please select</option>');

      for (var i = 0; i < cities.length; i++) {
          $('#city').append('<option value="' + String(cities[i]) + '">' + String(cities[i]) + ' </option>');
      }
  });

  $('#login').click(function (){
    $('#modalSelect').hide();
    $('#artisanLogin').show();
  });
  $('#register').click(function (){
    $('#modalSelect').hide();
    $('#artisanReg').show();
  });
  $('#back1').click(function (){
    $('#modalSelect').show();
    $('#artisanReg').hide();
    $('#artisanLogin').hide();
  });
  $('#back2').click(function (){
    $('#modalSelect').show();
    $('#artisanReg').hide();
    $('#artisanLogin').hide();
  });
  $('#requestBtn').click(function (){
    $('.requestForm').css("display","block");
    $('#closeBtn').css("display","block");
    $('#requestBtn').css("display","none");
  });
  $('#closeBtn').click(function (){
    $('.requestForm').css("display","none");
    $('#closeBtn').css("display","none");
    $('#requestBtn').css("display","block");
  });

});
