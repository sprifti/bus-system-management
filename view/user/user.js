function loading() {
	$.ajax({
        url: "index.php?controller=bus&action=getBusName",
        method: "POST",
        success: function (response) {
        	console.log(JSON.parse(response));
        	var button = document.createElement("button");
			button.innerHTML = response["bus_name"];
			document.body.appendChild(button);
        }

    });
}

function map(){
	var x = document.getElementById("message");
	var address = document.getElementById("address").value; 
	if(address != ""){

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);

		}
	}else{
		x.innerHTML = "Jepni adresen!";
	}
	// window.location.href = "index.php?controller=user&action=showMap";

}

// function getLocation() {
// 	var x = document.getElementById("message");
// 	if (navigator.geolocation) {
// 		navigator.geolocation.getCurrentPosition(showPosition);

// 	} else { 
// 		x.innerHTML = "Geolocation is not supported by this browser.";
// 	}

// }

function showPosition(position) {
	var address = document.getElementById("address").value;
    $.ajax({
        url: "index.php?controller=user&action=saveUserLocation",
        method: "POST",
        data: {lat: position.coords.latitude,
        		lng:position.coords.longitude,
        		add: address},
        success: function (response) {
           	window.location.href = "index.php?controller=user&action=showMap&address="+address+"&lat="+position.coords.latitude+"&lng="+position.coords.longitude;


        }

    });
	// alert("Latitude: " + position.coords.latitude + 
	// "<br>Longitude: " + position.coords.longitude);
}

function changeColor(){

}

function busMap(id){
	window.location.href = "index.php?controller=user&action=busMap&bus="+id;
}
