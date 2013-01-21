function googlemapjsv3(params) {
	var _this = this;
	//初始化地址解析
	var geocoder=new google.maps.Geocoder();
    var geocoderLL=new google.maps.Geocoder(); 
    var map;	
	var Ginfowindow = new google.maps.InfoWindow(); 
    var p = params;
	var inimarker=true;
	if (p.lat=="" || p.lng==""){
		p.lat=geoip_latitude();
	    p.lng=geoip_longitude();
		inimarker=false;
	}
    //load map
    var latlng = new google.maps.LatLng(p.lat,p.lng);
    var myOptions = {
        zoom: 12,      //放大级别
        center: latlng,       //地图中心
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP      //地图类型
    };
    map = new google.maps.Map(document.getElementById("mapLayout"),myOptions);
	
	//initialize marker and infowindow   
	var marker;		
	if (inimarker) {		  
        marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: "公司地理位置"
        });	
		if (p.strCompany=="") return;	
		else {
			var strInfoW = "<div><strong>" + p.strCompany[0] + "</strong></div><div>电话：" + p.strCompany[1] + "</div><div>地址：" + p.strCompany[2] + "</div><div>网址：<a href='" + p.strCompany[3] + "'target='_blank'>" + p.strCompany[3] + "<a/></div>";	
			var infowindow = new google.maps.InfoWindow({
				content: strInfoW,
				size: new google.maps.Size(60, 100)
			});			
			infowindow.open(map, marker);
			google.maps.event.addListener(marker, 'click',function() {
				infowindow.open(map, marker);	
			});
		}
	}
	//地址解析
    _this.codeAddress=function() {
        var address = document.getElementById("geostrPosition").value;
        if (geocoder) {
            geocoder.geocode({'address': address},function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
					map.setZoom(12);
                } else $("#geostrPosition").val("请重新输入要查询的地址");
            });
        } 
    }
	
	//数据返回
	var cityName="";
	google.maps.event.addListener(map,"bounds_changed",function(){
	   var latlng = map.getCenter();
	   if (geocoderLL) {
		  geocoderLL.geocode({'latLng': latlng},function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK && results[1]) {                   
				  cityName=results[1].formatted_address.slice(2);						
			  } 
	       });
	   }
	});
	
	_this.getMapData=function(){	  
	   var strPosition={
		   zoom:map.getZoom(),
		   center:map.getCenter(),
		   northEast:map.getBounds().getNorthEast(),
		   southWest:map.getBounds().getSouthWest(),
		   cityName:cityName
	   }
	   return strPosition;
	   //alert(strPosition.zoom+strPosition.center+strPosition+strPosition.northEast+strPosition.southWest+strPosition.cityName);
    }
	//添加标记
	var comMarkersArray = [];
	_this.addComMarkers=function(comStr){	
	    var latlng = new google.maps.LatLng(comStr.lat,comStr.lng);		
		var strInfoW = "<div><strong>" + comStr.strCompany[0] + "</strong></div><div>电话：" + comStr.strCompany[1] + "</div><div>地址：" + comStr.strCompany[2] + "</div><div>网址：<a href='" + comStr.strCompany[3] + "'target='_blank'>" + comStr.strCompany[3] + "<a/></div>";	
		var eMarker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: "公司地理位置"
		});
		comMarkersArray.push(eMarker);  //添加到数组
		var einfoWindow = new google.maps.InfoWindow({
			content:strInfoW
		});
		einfoWindow.open(map,eMarker);
		google.maps.event.addListener(eMarker, 'click',function() {
			einfoWindow.open(map, eMarker);
		});
	}    

    //反向地址解析		
    _this.codeLatLng=function() {        
        var latlng = map.getCenter();
        if (geocoderLL) {
            geocoderLL.geocode({'latLng': latlng},function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
						cityName=results[1].formatted_address;
                    }
                } 
            });
        }
    }	
	
	if (p.pChange==false) return;

    //点击添加临时标记
    var markersArray = [];
    var nowLatLng;
    google.maps.event.addListener(map,"click",function(event){
        nowLatLng = event.latLng;
        if (markersArray.length != 0) {
            markersArray[0].setMap(null);
            markersArray.length = 0;   //删除之前的临时标记
        }
        var eMarker = new google.maps.Marker({  //hehe
            position: nowLatLng,
            map: map,
            title: "新标记?",
            icon: "../images/mark.png"
        });
        markersArray.push(eMarker);  //添加到数组
        var einfoWindow = new google.maps.InfoWindow({
            content: "<div>您确定在这里标记公司的位置吗？</div><br/><div style='text-align:center'><input type='button' id='redefine' value='确定标记'/></div>"
        });
        einfoWindow.open(map,eMarker);
        google.maps.event.addListener(eMarker, 'click',function() {
            einfoWindow.open(map, eMarker);
        });
    });

    //重标记公司地址
    $("#redefine").live("click",function() {
		if(marker !=null) {
			marker.setMap(null);
			marker = new google.maps.Marker({
				position: nowLatLng,
				map: map,
				title: "公司地理位置"
			});
			var infowindow = new google.maps.InfoWindow({
				content: strInfoW,
				size: new google.maps.Size(60, 100)
			});
			infowindow.open(map, marker);
			google.maps.event.addListener(marker,'click',function() {
				infowindow.open(map, marker);
			});
			markersArray[0].setMap(null);
			markersArray.length = 0;
		} else {
			marker = new google.maps.Marker({
            position: nowLatLng,
            map: map,
            title: "公司地理位置"
			});
			var infowindow = new google.maps.InfoWindow({
				content: strInfoW,
				size: new google.maps.Size(60, 100)
			});
			infowindow.open(map, marker);
			google.maps.event.addListener(marker,'click',function() {
				infowindow.open(map, marker);	
			});			
			 markersArray[0].setMap(null);
			 markersArray.length = 0;
		 }
		 $("#comlatlng").val(nowLatLng);//存储公司的新地址。
    });    						
}