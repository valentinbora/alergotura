
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

        <div class="maps_content">           
            <div id="map_canvas">
            </div>

        </div><!-- #content -->  
    </div><!-- #primary -->  

    <?php get_footer(); ?>  

    <style>
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
    </style>

    <script> 
        var BASE={};
        //Settings
        BASE.getSettings=function(){
            return {
                URI:"/wp-admin/admin-ajax.php",
                data:{
                    action:"runkeeper-get-update"            
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
                    alert("error");
                }                                
            });
        }
        
        
        $(document).ready(function() {            
            var map=BASE.initMap();
            
            var mover=0;
            var marker;
            setInterval(function(){  
                BASE.getLatestInformation(function(){                    
                })
                var minus=((Math.floor(Math.random()*2))%2)==0;
                var random=Math.random(8);
                if(minus)
                    random=-random;
                mover+=0.05*random;
                if(marker)
                    marker.setMap(null);
                marker=null;
                var position=new google.maps.LatLng(45.7494444+mover, 21.2272222+mover);
                marker = new google.maps.Marker({
                    position:position,
                    icon:'wp-content/themes/alergotura/images/runner.png',
                    map: map,
                    title: 'Hello World!'
                });
                google.maps.event.trigger(map, 'resize'); 
            },500);
        });
        
     
      

         

    
    </script>