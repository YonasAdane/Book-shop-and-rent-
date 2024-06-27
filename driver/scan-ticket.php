<?php 
session_start();
if (!isset($_SESSION['driver_id'])) {
    header("Location: /LetsGO/auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetsGO Ticketing System</title>
    <?php include("./partials/imports.php")?>

</head>
<body x-data="{thisPath:window.location.pathname ,isOpen: false }" class="bg-gray-100 font-family-karla flex">

<?php include("./partials/aside.php")?>
    
    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <?php include("./partials/header.php")?>
        <!-- Mobile Header & Nav -->
        <?php include("./partials/mobile-header.php")?>
    
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow ">
                
                <!-- Content -->

                <section class='w-full border rounded-lg shadow-lg'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">Ticket Scanner</h1>
                    </div>
                    <div class="container lg:w-1/2 mx-auto p-8">
                        <div class="container bg-[white] w-[28rem] mx-auto shadow-[0_2px_6px_rgba(0,0,0,0.1)] text-center p-8 rounded-lg">
                            <h1 class="text-2xl text-center">Ticket Scanner</h1>
                            <div id="qr-reader" class="w-[300px] h-[300px] mb-4 border-2 border-gray-600 "></div>
                            <div id="qr-reader-results" class="text-2xl font-bold"></div>
                            <form class="hidden" id="form" action="validate-ticket.php" method="GET">
                            
                            </form>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // window.onload
    window.onload = function() {
    
        document.querySelector('#qr-reader__scan_region').style.display = "flex";
        document.querySelector('#qr-reader__scan_region').style.justifyContent = "center";

}
    function onScanSuccess(decodedText, decodedResult) {
    const qrData = parseQRCodeData(decodedText);
    
    document.getElementById('form').classList.remove("hidden");
    document.getElementById('form').innerHTML=`
        <input type="hidden" name='TicketID' value=${qrData.TicketID}>
        <input type="hidden" name='UserID' value=${qrData.UserID}>
        <input type="hidden" name='Departure' value=${qrData.Departure}>
        <input type="hidden" name='Destination' value=${qrData.Destination}>
        <input type="hidden" name='ScheduleID' value=${qrData.ScheduleID}>
    `;
    document.getElementById('form').submit();

    }
    function onScanError(errorMessage) {
        // Handle any errors here
        console.error(errorMessage);
    }
    function parseQRCodeData(data) {
        const params = new URLSearchParams(data);
        const qrData = {};
        for (const [key, value] of params.entries()) {
            qrData[key] = value;
        }
        return qrData;
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 }, /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>
</body>
</html>
