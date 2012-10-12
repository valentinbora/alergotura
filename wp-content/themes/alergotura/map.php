
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.8.0.js"></script>  
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.22/jquery-ui.js"></script>  
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<?php
/**
 * Template Name: Google Maps Template
 * Description: A Page Template that lets us created a dedicated Google Maps page
 *
 * @package WordPress
 * @subpackage Alergotura
 * @since Twenty Eleven 1.0
 */
get_header();
?>  
<div id="primary">  
    <div id="content" role="main">  

        <div id="progressBar" class="meter animate" style="">
            <span style="width:10%;position:absolute"></span>
            <div style="text-align:center;font-size:20px;color:#FFA319;font-weight: bold;padding:2px">10%</div>
        </div>
        <div class="maps_content">           
            <div id="map_canvas">
            </div>



        </div><!-- #content -->  
    </div><!-- #primary -->  

    <?php get_footer(); ?>  



    <script> 
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
                error:function(message){
                    callback(message);
                    console.log("Error ajax call");
                }                                
            });
        }
        
        
        $(document).ready(function() {            
            var map=BASE.initMap();
            
            var mover=0;
            var marker;
            setInterval(function(){  
                BASE.getLatestInformation(function(message){
                    if(marker)
                        marker.setMap(null);
                    marker=null;
                    var position =new google.maps.LatLng(45.7494444, 21.2272222),
                    //var position=new google.maps.LatLng(parseFloat(message['runkeeper_last_point_lat']), parseFloat(message['runkeeper_last_point_long']));
                  
                    marker = new google.maps.Marker({
                        position:position,
                        icon:'wp-content/themes/alergotura/images/runner.png',
                        map: map,
                        title: 'Hello World!'
                    });
                    map.setCenter(position);
                    google.maps.event.trigger(map, 'resize');
                });
            }, 3000);
        });
        
     
      

         

    
    </script>

    <style>

        #progressBar{
height:30px;

        }
        .maps_content{
            float:left;
            width:100%;
            height:500px;
            background-color: #6d6d6d;       
            border-radius: 0px;
            box-shadow: 4px 0px 7px 9px #6d6d6d,-4px 0px 7px 8px teal;
        }

        #map_canvas{
            width:100%;
            height:100%;
        }
        .meter { 
            height: 30px!important;  /* Can be anything */
            position: relative;
            margin: 0px 0 20px 0; /* Just for demo spacing */
            background: #555;
            -moz-border-radius: 25px;
            -webkit-border-radius: 25px;
            border-radius: 0px;
            padding: 0px;
            -webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
            -moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
            box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);
            
            box-shadow: 4px 0px 7px 9px #6d6d6d,-4px 0px 7px 8px teal;
        }
        .meter > span {
            display: block;
            height: 100%;
            -webkit-border-top-right-radius: 8px;
            -webkit-border-bottom-right-radius: 8px;
            -moz-border-radius-topright: 8px;
            -moz-border-radius-bottomright: 8px;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
            -webkit-border-top-left-radius: 20px;
            -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
            -moz-border-radius-bottomleft: 20px;
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
            background-color: rgb(43,194,83);
            background-image: -webkit-gradient(
                linear,
                left bottom,
                left top,
                color-stop(0, rgb(43,194,83)),
                color-stop(1, rgb(84,240,84))
                );
            background-image: -moz-linear-gradient(
                center bottom,
                rgb(43,194,83) 37%,
                rgb(84,240,84) 69%
                );
            -webkit-box-shadow: 
                inset 0 2px 9px  rgba(255,255,255,0.3),
                inset 0 -2px 6px rgba(0,0,0,0.4);
            -moz-box-shadow: 
                inset 0 2px 9px  rgba(255,255,255,0.3),
                inset 0 -2px 6px rgba(0,0,0,0.4);
            box-shadow: 
                inset 0 2px 9px  rgba(255,255,255,0.3),
                inset 0 -2px 6px rgba(0,0,0,0.4);
            position: relative;
            overflow: hidden;
        }
        .meter > span:after, .animate > span > span {
            content: "";
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
            background-image: 
                -webkit-gradient(linear, 0 0, 100% 100%, 
                color-stop(.25, rgba(255, 255, 255, .2)), 
                color-stop(.25, transparent), color-stop(.5, transparent), 
                color-stop(.5, rgba(255, 255, 255, .2)), 
                color-stop(.75, rgba(255, 255, 255, .2)), 
                color-stop(.75, transparent), to(transparent)
                );
            background-image: 
                -moz-linear-gradient(
                -45deg, 
                rgba(255, 255, 255, .2) 25%, 
                transparent 25%, 
                transparent 50%, 
                rgba(255, 255, 255, .2) 50%, 
                rgba(255, 255, 255, .2) 75%, 
                transparent 75%, 
                transparent
                );
            z-index: 1;
            -webkit-background-size: 50px 50px;
            -moz-background-size: 50px 50px;
            background-size: 50px 50px;
            -webkit-animation: move 2s linear infinite;
            -moz-animation: move 2s linear infinite;
            -webkit-border-top-right-radius: 8px;
            -webkit-border-bottom-right-radius: 8px;
            -moz-border-radius-topright: 8px;
            -moz-border-radius-bottomright: 8px;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
            -webkit-border-top-left-radius: 20px;
            -webkit-border-bottom-left-radius: 20px;
            -moz-border-radius-topleft: 20px;
            -moz-border-radius-bottomleft: 20px;
            border-top-left-radius: 00px;
            border-bottom-left-radius: 00px;
            overflow: hidden;
        }

        .animate > span:after {
            display: none;
        }

        @-webkit-keyframes move {
            0% {
            background-position: 0 0;
        }
        100% {
            background-position: 50px 50px;
        }
        }

        @-moz-keyframes move {
            0% {
            background-position: 0 0;
        }
        100% {
            background-position: 50px 50px;
        }
        }


        .orange > span {
            background-color: #f1a165;
            background-image: -moz-linear-gradient(top, #f1a165, #f36d0a);
            background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #f1a165),color-stop(1, #f36d0a));
            background-image: -webkit-linear-gradient(#f1a165, #f36d0a); 
        }

        .red > span {
            background-color: #f0a3a3;
            background-image: -moz-linear-gradient(top, #f0a3a3, #f42323);
            background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #f0a3a3),color-stop(1, #f42323));
            background-image: -webkit-linear-gradient(#f0a3a3, #f42323);
        }

        .nostripes > span > span, .nostripes > span:after {
            -webkit-animation: none;
            -moz-animation: none;
            background-image: none;
        }
    </style>