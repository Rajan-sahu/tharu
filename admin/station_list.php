<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title">
            <h4 class="card-title mb-0">Railway Station List</h4>
         </div>
         <a href="station_add.php" class="btn btn-sm btn-primary">
            <i class="fa-sharp fa-solid fa-plus"></i> Add New
         </a>
      </div>
      <div class="card-body">
         <?php
         $stations = [];
         $sql = "SELECT s.id,s.station_name,s.address,s.latitude,s.longitude,st.name AS state_name,c.city AS city_name 
                 FROM zuraud_station s 
                 LEFT JOIN tbl_states st ON st.id = s.state 
                 LEFT JOIN tbl_cities c ON c.id = s.city";
         $result = $conn->query($sql);
         if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $stations[] = $row;
            }
         }
         if (!empty($stations)) { ?>
            <button id="exportStations" class="btn btn-success mb-2">Export Stations to Excel</button>
            <div class="table-responsive">
               <table id="stationTable" class="table table-bordered table-striped align-middle">
                  <thead class="table-light">
                     <tr>
                        <th>#</th>
                        <th>Station Name</th>
                        <th>Address</th>
                        <th>Coordinates</th>
                        <th>Location</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($stations as $index => $station) { ?>
                        <tr>
                           <td><?= $index + 1 ?></td>
                           <td><?= $station['station_name'] ?></td>
                           <td><?= $station['address'] ?></td>
                           <td><?= $station['latitude'] ?>, <?= $station['longitude'] ?></td>
                           <td><?= $station['city_name'] ?>, <?= $station['state_name'] ?></td>
                           <td class="text-center">
                              <a title="Edit" href="station_add.php?id=<?= $station['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                 <i class="fas fa-edit"></i>
                              </a>
                              <a title="Delete" href="#" class="btn btn-sm btn-outline-danger delete-station" data-del_id=<?= $station['id'] ?>>
                                 <i class="fas fa-trash"></i>
                              </a>
                           </td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         <?php } else { ?>
            <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
               <div class="card shadow-sm w-100">
                  <div class="card-body text-center py-5">
                     <i class="fas fa-database fa-3x text-muted mb-3"></i>
                     <h5 class="text-muted">No Data Available</h5>
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>

<!-- DataTable Init -->
<script>
   $(document).ready(function() {
      $('#stationTable').DataTable({
         pageLength: 10, // default rows per page
         lengthMenu: [5, 10, 25, 50, 100],
         ordering: true, // enable column sorting
         searching: true, // enable search bar
         language: {
            search: "_INPUT_",
            searchPlaceholder: "Search stations..."
         }
      });
   });
</script>


<script>
   const stationData = <?= json_encode($stations); ?>;
   document.getElementById("exportStations").addEventListener("click", function() {

      // Select required data: id, station_name, address
      const refinedData = stationData.map(item => ({
         ID: item.id,
         Station_Name: item.station_name,
         Address: item.address
      }));

      // Convert JSON → Worksheet
      const worksheet = XLSX.utils.json_to_sheet(refinedData);

      // Create Workbook
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Stations");

      // Download Excel
      XLSX.writeFile(workbook, "Stations_List.xlsx");
   });
</script>