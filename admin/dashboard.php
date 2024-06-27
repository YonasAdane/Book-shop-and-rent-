<?php 
include("../database/connection.php");
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
$sql = "SELECT UserName, UserPhone, UserEmail, UserAddress FROM User";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <?php include("./partials/imports.php")?>

</head>
<body x-data="{thisPath:window.location.pathname , isOpen: false}" class="bg-gray-100 font-family-karla flex">

<?php include("./partials/aside.php")?>
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <?php include("./partials/header.php")?>
        <!-- Mobile Header & Nav -->
        <?php include("./partials/mobile-header.php")?>

                <!-- Content  -->
    
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Dashboard</h1>
    
                <div class="flex flex-wrap mt-6">
                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-plus mr-3"></i> Monthly Reports
                        </p>
                        <div class="p-6 bg-white">
                            <canvas id="chartOne" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-check mr-3"></i> Resolved Reports
                        </p>
                        <div class="p-6 bg-white">
                            <canvas id="chartTwo" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
    
                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> All Users
                    </p>
                    <div class="bg-white overflow-auto">
                        <table class="min-w-full ">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Phone</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Address</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php 
                                while($row = $result->fetch_assoc()) { ?>
                                    <tr class="odd:bg-white even:bg-slate-200 ">
                                        <td class="text-left py-3 px-4"><?php echo  $row["UserName"]?></td>
                                        <td class="text-left py-3 px-4"><?php echo  $row["UserPhone"]?></td>
                                        <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="mailto:"><?php echo  $row["UserEmail"]?></a></td>
                                        <td class="text-left py-3 px-4"><a class="hover:text-blue-500" ><?php echo  $row["UserAddress"]?></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<?php 


// Fetch the number of tickets bought in the last 6 days
$sql = "
SELECT DATE(DepartureDateTime) AS Date, COUNT(*) AS NumberOfTickets 
FROM Ticket 
WHERE DepartureDateTime >= CURDATE() - INTERVAL 6 DAY 
GROUP BY DATE(DepartureDateTime)
ORDER BY DATE(DepartureDateTime) ASC";
$result = $conn->query($sql);

$days = [];
$numberOfTickets = [];
while ($row = $result->fetch_assoc()) {
    $formattedDate = date("M-d", strtotime($row["Date"]));
    $days[] = $formattedDate;
    $numberOfTickets[] = $row["NumberOfTickets"];
}

$conn->close();

$daysJson = json_encode($days);
$numberOfTicketsJson = json_encode($numberOfTickets);
?>

    <script>
        var days = <?php echo $daysJson; ?>;
    var numberOfTickets = <?php echo $numberOfTicketsJson; ?>;

    var chartOne = document.getElementById('chartOne');
    var myChart = new Chart(chartOne, {
        type: 'bar',
        data: {
            labels: days,
            datasets: [{
                label: 'Number of tickets',
                data: numberOfTickets,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: '# of Tickets',
                    data: numberOfTickets,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>