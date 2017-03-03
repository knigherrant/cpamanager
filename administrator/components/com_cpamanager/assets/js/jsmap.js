/*
 # mod_jvcontact - JV jSont
 # @version		3.4
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/



var jSont = (function($){
	var fn = {
		initialize : function(options){
			var jdefault	= {
					hosturl		: 'http://localhost/joomla25',
					moduleid	: 0,
					jsmapid		: 'jsmap',
					lat			: '10.784513',
					lng			: '106.630744',
					address		: '',
					zoom		: 17,
					zoomControlOptions: {
						style: 1	//google.maps.ZoomControlStyle.SMALL
					},
					mapTypeId	: 'roadmap', //HYBRID ROADMAP SATELLITE TERRAIN
					iconmarker	: '', //administrator/templates/bluestork/images/notice-info.png
					addevent	: 0,
					infotext	: 'I am here',
                                        autopopup       : 0
					
				}
			this.options = $.extend({}, jdefault, options);
                        console.log(this.options);
			this.showMap();
			if(this.options.addevent) this.addEventMap();
                        
                        
                        
		},
                
                
                codeAddress : function (address) {
                    
                    geocoder.geocode( { 'address': address}, function(results, status) {
                      if (status == 'OK') {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                      } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                      }
                    });
                  },
                
                
		//show map
		showMap:function(){
			this.options.center = this.getLatLng(this.options.lat, this.options.lng);
			this.map = new google.maps.Map(document.getElementById (this.options.jsmapid) ,this.options);
			this.placeMarker(this.options.lat, this.options.lng,this.options.infotext,this.options.iconmarker);
			
			
			return this.map;
		},
		//add Event for administrator
		addEventMap:function(){
			var This = this;
			google.maps.event.addListener(This.map, 'rightclick', function(event) {
				var 
					lat 	= event.latLng.lat(),
					lng 	= event.latLng.lng(),
					text	= prompt('Info text',''),

					input	= $('<input>',{'class': 'mapmarker', 'type':'hidden','name':'jform[params][map_marker][]'})
				;
				
				if(text){
					input.val(lat + '|' + lng + '|' + text);
					input.appendTo($('#'+This.options.jsmapid));
					
					This.placeMarker(lat,lng,text);
					
				}
			});
		},
		//get center
		getLatLng:function(lat,lng){
			return new google.maps.LatLng(lat, lng);
		},
		//show an icon at options.center
		placeMarker:function(lat,lng,infotext,icon,ani){
			var This = this;
			var animation = 'google.maps.Animation.'+ani;//DROP - BOUNCE
			var marker = new google.maps.Marker({
			  draggable:true,//true / false
			  icon:icon,
			  animation: animation, 
			  position: This.getLatLng(lat,lng),
			  map: this.map
			});
			marker.addListener('dragend', function(event){
                            console.log(event);
                            jQuery('#jform_latitude').val(event.latLng.lat());
                            jQuery('#jform_longitude').val(event.latLng.lng());
                        });
			this.showInfoWindow(marker, 'click', infotext);
		   

			return marker;
		},
              
		showInfoWindow:function(marker, mapevent, message, widthinfo, heightinfo){
			var infowindow = new google.maps.InfoWindow({ 
					content: message,
					size: new google.maps.Size( widthinfo, heightinfo)
				});
                        infowindow.open(this.map,marker);
			google.maps.event.addListener(marker, mapevent, function() {
				infowindow.open(this.map,marker);
			});
			//marker.position.lat()
			if(this.options.addevent){
				google.maps.event.addListener(marker, "rightclick", function() {
					if( confirm("Are you sure remove this marker ?")){
						
						$(".mapmarker").each(function(){
							var el = $(this);
							var data = marker.position.lat() + '|' + marker.position.lng() + '|' + message;
							if(el.val() ==data){
								//el.destroy();
								marker.setMap(null);
							} 
						});
						
					}
				});
			}
			
			
			return;
		}
		
	}
	return fn;

})(jQuery)

