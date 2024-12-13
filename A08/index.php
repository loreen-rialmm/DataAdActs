<?php
include("connect.php");

$departureFilter = $_GET['departureAirportCode'] ?? '';
$arrivalFilter = $_GET['arrivalAirportCode'] ?? '';
$aircraftFilter = $_GET['aircraftType'] ?? '';
$sort = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? '';

$flightsQuery = "SELECT * FROM flightlogs";

$conditions = [];
if ($departureFilter) {
    $conditions[] = "departureAirportCode='$departureFilter'";
}
if ($arrivalFilter) {
    $conditions[] = "arrivalAirportCode='$arrivalFilter'";
}
if ($aircraftFilter) {
    $conditions[] = "aircraftType='$aircraftFilter'";
}
if (count($conditions) > 0) {
    $flightsQuery .= " WHERE " . implode(' AND ', $conditions);
}

if ($sort) {
    $flightsQuery .= " ORDER BY $sort";
    if ($order !== '') {
        $flightsQuery .= " $order";
    }
}

$flightResults = executeQuery($flightsQuery);

$departureQuery = "SELECT DISTINCT departureAirportCode FROM flightlogs";
$departureResults = executeQuery($departureQuery);

$arrivalQuery = "SELECT DISTINCT arrivalAirportCode FROM flightlogs";
$arrivalResults = executeQuery($arrivalQuery);

$aircraftQuery = "SELECT DISTINCT aircraftType FROM flightlogs";
$aircraftResults = executeQuery($aircraftQuery);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airport Flight Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css2?family=Asul:wght@400;700&family=Chango&family=Goldman:wght@400;700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Rubik+Mono+One&family=Rubik:ital,wght@0,300..900;1,300..900&family=Slabo+27px&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand">
                <div class="logoContainer">
                    <img src="https://img.freepik.com/premium-vector/airplane-logo_640251-15485.jpg" alt="Logo"
                        width="100" height="100" class="d-inline-block align-text-center">
                </div>
                Airport Flight Tracker
            </a>
        </div>
    </nav>

    <div class="container actionContainer py-5">
        <div class="row my-5">
            <div class="col">
                <form>
                    <div class="card p-4 rounded-2 mb-3">
                        <div class="h5">Filter</div>
                        <div class="d-flex flex-wrap flex-lg-row flex-column align-items-center filterGroup">

                            <label for="departureSelect">Departure Code</label>
                            <select id="departureSelect" name="departureAirportCode" class="me-3 form-control"
                                style="width: fit-content">
                                <option value="">Any</option>
                                <?php
                                while ($departureRow = mysqli_fetch_assoc($departureResults)) {
                                    echo "<option value='" . $departureRow['departureAirportCode'] . "' " .
                                        ($departureFilter === $departureRow['departureAirportCode'] ? "selected" : "") .
                                        ">" . $departureRow['departureAirportCode'] . "</option>";
                                }
                                ?>
                            </select>

                            <label for="arrivalSelect">Arrival Code</label>
                            <select id="arrivalSelect" name="arrivalAirportCode" class="me-3 form-control"
                                style="width: fit-content">
                                <option value="">Any</option>
                                <?php
                                while ($arrivalRow = mysqli_fetch_assoc($arrivalResults)) {
                                    echo "<option value='" . $arrivalRow['arrivalAirportCode'] . "' " .
                                        ($arrivalFilter === $arrivalRow['arrivalAirportCode'] ? "selected" : "") .
                                        ">" . $arrivalRow['arrivalAirportCode'] . "</option>";
                                }
                                ?>
                            </select>

                            <label for="aircraftSelect">Aircraft</label>
                            <select id="aircraftSelect" name="aircraftType" class="me-3 form-control"
                                style="width: fit-content">
                                <option value="">Any</option>
                                <?php
                                while ($aircraftRow = mysqli_fetch_assoc($aircraftResults)) {
                                    echo "<option value='" . $aircraftRow['aircraftType'] . "' " .
                                        ($aircraftFilter === $aircraftRow['aircraftType'] ? "selected" : "") .
                                        ">" . $aircraftRow['aircraftType'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="card p-4 rounded-2 mb-3">
                        <label for="sort" class="ms-2 h5">Sort By</label>
                        <select id="sort" name="sort" class="form-control">
                            <option value="">None</option>
                            <option <?php if ($sort === "flightNumber")
                                echo "selected"; ?> value="flightNumber">Flight
                                Number</option>
                            <option <?php if ($sort === "departureDatetime")
                                echo "selected"; ?> value="departureDatetime">
                                Departure Date Time</option>
                            <option <?php if ($sort === "arrivalDatetime")
                                echo "selected"; ?> value="arrivalNumber">
                                Arrival Date Time</option>
                            <option <?php if ($sort === "pilotName")
                                echo "selected"; ?> value="pilotName">Pilot Name
                            </option>
                        </select>
                    </div>

                    <div class="card p-4 rounded-2 mb-3">
                        <label for="order" class="ms-2 h5">Order</label>
                        <select id="order" name="order" class="ms-2 form-control" style="width: fit-content">
                            <option <?php if ($order === "ASC")
                                echo "selected"; ?> value="ASC">Ascending</option>
                            <option <?php if ($order === "DESC")
                                echo "selected"; ?> value="DESC">Descending</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary ms-2 mt-4" style="width: fit-content">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-5">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table">
                            <tr>
                                <th scope="col" class="fs-4">Flight Number</th>
                                <th scope="col" class="fs-4">Departure Code</th>
                                <th scope="col" class="fs-4">Arrival Code</th>
                                <th scope="col" class="fs-4">Departure Date</th>
                                <th scope="col" class="fs-4">Arrival Date</th>
                                <th scope="col" class="fs-4">Aircraft</th>
                                <th scope="col" class="fs-4">Pilot Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($flightResults) > 0) {
                                while ($flightRow = mysqli_fetch_assoc($flightResults)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $flightRow['flightNumber'] ?></th>
                                        <td><?php echo $flightRow['departureAirportCode'] ?></td>
                                        <td><?php echo $flightRow['arrivalAirportCode'] ?></td>
                                        <td><?php echo $flightRow['departureDatetime'] ?></td>
                                        <td><?php echo $flightRow['arrivalDatetime'] ?></td>
                                        <td><?php echo $flightRow['aircraftType'] ?></td>
                                        <td><?php echo $flightRow['pilotName'] ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No flight records found</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>