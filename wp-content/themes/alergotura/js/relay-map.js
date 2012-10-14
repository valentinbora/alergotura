var BASE={};
//Settings
BASE.getSettings=function(){
    return {
        URI:"/wp-admin/admin-ajax.php",
        data:{
            action:"runkeeper_get_update"            
        },
        type:"POST"
    };            
} 

//Create Google Map
BASE.initMap=function initialize() {
    // Creating the map and setting options
    return map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 14,
        center: new google.maps.LatLng(45.7494444, 21.2272222),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR   
        },
        navigationControl: true,
        navigationControlOptions: {
            style: google.maps.NavigationControlStyle.ZOOM_PAN,
            position: google.maps.ControlPosition.TOP_RIGHT
        },
        scaleControl: true,
        scaleControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
        }
    });
}

//Get latest information 
BASE.getLatestInformation=function(callback){            
    var settings=BASE.getSettings();
    $.ajax({
        url:settings.URI,
        type:settings.type,
        data:settings.data,
        success:function(message){
            callback(message);
        },
        error:function(){
        }                                
    });
}


$(document).ready(function() {            
    var map=BASE.initMap();
    
    var mover=0;
    var marker;
    var prevPosLat = -1;
    var prevPosLong = -1;
    var prevProgress = 0;
    var targetDistance = 3000;
    
    if ($('.map_canvas').length  || 1) {
      setInterval(function() {
          BASE.getLatestInformation(function(message) {
            var curDistance = parseFloat(message['runkeeper_total_distance']);
            var beautifulCurDistance = String(curDistance).split('.');
            var beautifulRemainingDistance = String(targetDistance - curDistance).split('.');
            $("#metric-run-distance").html('<span class="major">' + beautifulCurDistance[0] + '</span><span class="minor">.' + beautifulCurDistance[1] + '</span>');
            $("#metric-remaining-distance").html('<span class="major">' + beautifulRemainingDistance[0] + '</span><span class="minor">.' + beautifulRemainingDistance[1] + '</span>');
            
            var progress = curDistance/targetDistance * 100;
            
            if (progress < 10) progress = 10;
            
            if (progress > prevProgress) {
              $('.progress-box .progress').animate({
                'width': Math.round(progress) + '%'
              }, 600);
              
              $('.progress-box .progress span, #metric-progres').text(Math.round(progress) + '%');
              
              prevProgress = progress;
            }
            
            if (marker) {
              marker.setMap(null);
            }
            
            marker=null;
          
            var position=new google.maps.LatLng(parseFloat(message['runkeeper_last_point_lat']), parseFloat(message['runkeeper_last_point_long']));
          
            marker = new google.maps.Marker({
                position:position,
                icon:'/wp-content/themes/alergotura/images/relay/runner.png',
                shadow:'/wp-content/themes/alergotura/images/relay/runner-gray.png',
                map: map,
                title: 'Hello World!'
            });
            map.setCenter(position);
            google.maps.event.trigger(map, 'resize');
          });
      }, 1000);
    }
});