
var selectElement=document.getElementById('bus_type');
selectElement.addEventListener('change', function(event) {
    event.preventDefault(); // Prevent the default form submission
    var selectedOption=selectElement.options[selectElement.selectedIndex].value;
    // console.log("selectedOption: ",selectedOption);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "service/add-buss.service.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            var data=JSON.parse(xhr.response);
            console.log('data ', data )
            document.getElementById("bus_level").value=data.BusLevel;
            document.getElementById("seat_numbers").value=data.BusSeatNumbers;
        } else {
            console.error('Request failed. Returned status: ' + xhr.status);
        }
    };

    var busType = {"bus_type":selectedOption};
    // console.log("bus type: ",busType);
    var encodedData = new URLSearchParams(busType).toString();
    console.log("encoded : ",encodedData);
    xhr.send(encodedData);

});
