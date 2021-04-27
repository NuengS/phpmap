<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
 

<title>แผนที่</title>

  <!-- Bootstrap core CSS -->
 <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" crossorigin="anonymous">
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="jquery-3.2.1.min.js" ></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp_FN3Dh8jNvkI0FNZQf6RALmqNhTHfQs&callback=initMap"
type="text/javascript"></script>
<script>
function w3_open() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "block";
}
</script>

<script language="JavaScript">

var map,infowindow;
function initMap() { 
	var myOptions = {
	  zoom: 15,
	  center: new google.maps.LatLng(7.187270,100.594966),
	  
	};
	var marker2 = new  google.maps.Marker({
		map:map,
		position: new google.maps.LatLng(7.187270,100.594966),
		draggalbe:true
	});

	 map = new google.maps.Map(document.getElementById('map_canvas'),
		myOptions);


	 infowindow = new google.maps.InfoWindow({
		map:map,
	});
	sarchLocation();
	google.maps.event.addListener(map,'rightclick',function(event){
		infowindow.open(map,marker2);
		infowindow.setContent("LatLng = " + event.latLng);
		infowindow.setPosition(event.latLng);
		marker2.setPosition(event.latLng);
		$("#lat").val(event.latLng.lat());
		$("#lng").val(event.latLng.lng());
		
	});	
	
	
	
	
}




function saveLocation(){

var location_name  = $("#location_name").val();
var lat  = $("#lat").val();
var lng  = $("#lng").val();
var location_detail = $("textarea#location_detail").val();
var imgname = $('input[type=file]').val();
var size = $('#image_file')[0].files[0].size;
var ext = imgname.substr((imgname.lastIndexOf('.')+1));
	ext = ext.toLowerCase();
if(ext == 'jpg'||ext == 'png'){
	if(size <= 1000000){
			
		
		$.ajax({
			method:"POST",
			url:"insert.php",
			data: new FormData($('form')[0]),
			enctype: 'multipart/form-data',
			cache:false,
			contentType:false,
			processData:false
		}).done(function(){
			alert("OK");
		});
		
	}else{
		alert('ขนาดไฟล์ใหญ่เกินกว่าที่กำหนด');
	}
}else{
	alert('ไฟล์ที่เลือกต้องเป็นชนิดรูปภาพเท่านั้น');
}


}
function sarchLocation(){
	$.ajax({
		type:"POST",
		url: "jsonsearch.php",
	}).done(function(text){
		var json = $.parseJSON(text);
		if(json.length > 0){
			removeMarker();
			var t="";
		for(var i = 0 ;i<json.length;i++){
			
			var lat = json[i].lat;
			var lng = json[i].lng;
			var location_name =  json[i].location_name;
			var latlng = new google.maps.LatLng(lat,lng);
			var location_detail = json[i].location_detail;
			var image_name = json[i].image_name;

			var html = '<div style="text-align:center"><h5>'+ location_name +'</h5></div>';
				html += '<div style="text-align:center"><img height="150px"  src="images/'+ image_name +'" /><div>';
				html += '<p style="text-align:center"></br>'+json[i].location_detail+'</p>';
			var makeroption = {
				map:map,
				html:html,
				position:latlng,
				};
			var marker = new google.maps.Marker(makeroption);
			markers.push(marker);	
			marker.setAnimation(google.maps.Animation.BOUNCE);
			google.maps.event.addListener(marker,'click',function(e){
				
				infowindow.setContent(this.html);
				infowindow.open(map,this);
			});

		}
			$("#divContent").css("display","");
		}else{
			$("#divDetail").html('ไม่พบข้อมูล');
		}


	});
}

var markers = [];
function removeMarker(){
for(var i =0;i<markers.length;i++){
markers[i].setMap(null);
}
markers = [];
}



</script>
</head>
<body>


<div class="w3-sidebar w3-bar-block  w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-red"
  onclick="w3_close()">Close &times;</button>
  		<div style="margin:10px;">
				<form enctype="multipart/form-data ">
						<div class="form-group">
						  <label for="location_name">ชื่อสถานที่</label>
						  <input type="text" class="form-control" id="location_name" name="location_name" >
						</div>
						<div class="form-group">
							<label for="Lng">รายละเอียดสถานที่</label>
							<textarea id="location_detail" name="location_detail" class="form-control" rows="3"></textarea>
						</div>
						
						<div class="form-group">
								<label for="lat">ละติจูด</label>
								<input type="text" class="form-control" id="lat" name="lat" >
						</div>

						<div class="form-group">
							<label for="Lng">ลองจิจูด</label>
							<input type="text" class="form-control" id="lng" name="lng">
						</div>
						



						<div class="form-group">
							<label for="image_file">รูปภาพ</label>
							<input type="file" id="image_file" name="image_file">
						
						</div>
						</br></br></br></br></br></br></br></br></br>
						<button type="button" onclick="saveLocation()" class="btn btn-danger" style="width:340px">เพิ่มข้อมูล</button>
					  </form>
	

		</div>
</div>
<div id="main">
	<div class="w3-red">
  		<button id="openNav" class="w3-button w3-red w3-xlarge" onclick="w3_open()">&#9776;</button>
	</div>
  <div class="row">

<div id="main" class="col-12">
		<div id="map_canvas" style="width:100%;height:90vh"></div>
</div>
  
	</div>
	</div>
</div>
	</body>
	</html>