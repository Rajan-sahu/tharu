<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

$month = (isset($_POST['month']) && !empty($_POST['month'])) ? $_POST['month'] : date("Y-m");

?>

<style>
   .sunday {
      background-color: #ffe5e5 !important;
   }

   /* light red for Sundays */
   th,
   td {
      text-align: center;
      vertical-align: middle;
      font-size: 13px;
   }

   .emp-name {
      font-weight: bold;
   }

   .in-row {
      background: #e8fff1;
   }

   /* light green shade for IN */
   .out-row {
      background: #e8f4ff;
      border-bottom: 1px solid #efbebe;
   }

   /* light blue shade OUT */
   .table-sticky-header thead th {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 2;
   }
</style>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title d-flex align-items-center">
            <h4 class="card-title mb-0 me-2">Attendance History for <?= date('M,Y', strtotime($month))  ?></h4>

            <!-- Filter toggle button -->
            <button class="btn btn-sm btn-outline-primary" id="filterToggle" type="button">
               <i class="fa-solid fa-filter"></i>
            </button>
         </div>


      </div>

      <!-- Hidden Filter Form -->
      <div class="card-body border-top pt-3" id="filterForm" style="display: none;">
         <form method="POST" action="attendance_history.php">
            <div class="row g-3">
               <!-- Station -->
               <div class="col-md-4">
                  <?php
                  $station_sql = $conn->query("SELECT id,station_name FROM `zuraud_station`");

                  ?>
                  <label for="station" class="form-label">Railway Station</label>
                  <select class="form-select" id="station" name="station">
                     <option value="" selected disabled>-- Select Station --</option>
                     <?php
                     if ($station_sql && $station_sql->num_rows > 0) {

                        while ($station = $station_sql->fetch_assoc()) {
                           $select = ($station['id'] == @$_POST['station']) ? "selected" : '';
                     ?>
                           <option value="<?= $station['id'] ?>" <?= $select ?>><?= $station['station_name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>

               <!-- Department -->
               <div class="col-md-4">
                  <?php
                  $department_sql = $conn->query("SELECT id,title AS name FROM `zuraud_department`");

                  ?>
                  <label for="department" class="form-label">Department</label>
                  <select class="form-select" id="department" name="department">
                     <option value="" selected disabled>-- Select Department --</option>
                     <?php
                     if ($department_sql && $department_sql->num_rows > 0) {

                        while ($department = $department_sql->fetch_assoc()) {
                           $select = ($department['id'] == @$_POST['department']) ? "selected" : '';
                     ?>
                           <option value="<?= $department['id'] ?>" <?= $select ?>><?= $department['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>
               <!-- Designation -->
               <div class="col-md-4">
                  <?php
                  $designation_sql = $conn->query("SELECT id,title AS name FROM `zuraud_designation`");

                  ?>
                  <label for="designation" class="form-label">Designation</label>
                  <select class="form-select" id="designation" name="designation">
                     <option value="" selected disabled>-- Select Designation --</option>
                     <?php
                     if ($designation_sql && $designation_sql->num_rows > 0) {

                        while ($designation = $designation_sql->fetch_assoc()) {
                           $select = ($designation['id'] == @$_POST['designation']) ? "selected" : '';
                     ?>
                           <option value="<?= $designation['id'] ?>" <?= $select ?>><?= $designation['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>

               <!-- Shift -->
               <div class="col-md-4">
                  <?php
                  $shift_sql = $conn->query("SELECT id, name FROM `zuraud_shift`");

                  ?>
                  <label for="shift" class="form-label">Shift</label>
                  <select class="form-select" id="shift" name="shift">
                     <option value="" selected disabled>-- Select Shift --</option>
                     <?php
                     if ($shift_sql && $shift_sql->num_rows > 0) {

                        while ($shift = $shift_sql->fetch_assoc()) {
                           $select = ($shift['id'] == @$_POST['shift']) ? "selected" : '';
                     ?>
                           <option value="<?= $shift['id'] ?>" <?= $select ?>><?= $shift['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>
               <div class="col-md-4">

                  <label for="month" class="form-label">Month</label>
                  <input type="month" name="month" value="<?= $month ?>" id="month">
               </div>
            </div>
            <div class="mt-3 text-end">
               <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa-solid fa-search"></i> Apply Filter
               </button>
               <a href="attendance_history.php" class="btn btn-secondary btn-sm">
                  <i class="fa-solid fa-rotate-left"></i> Reset
               </a>
            </div>
         </form>
      </div>
      <div class="card-body">
         <?php
         $employees = [];
         $sql = "SELECT e.id,e.name,e.mobile_no FROM `zuraud_employee` e LEFT JOIN zuraud_station st ON st.id=e.station LEFT JOIN zuraud_department dp ON dp.id= e.department LEFT JOIN zuraud_designation dg ON dg.id= e.designation LEFT JOIN zuraud_shift sf ON sf.id = e.shift WHERE 1 ";

         if (isset($_POST['station']) && !empty($_POST['station'])) {
            $sql .= "AND e.station = '{$_POST['station']}' ";
         }
         if (isset($_POST['department']) && !empty($_POST['department'])) {
            $sql .= "AND e.department = '{$_POST['department']}' ";
         }
         if (isset($_POST['designation']) && !empty($_POST['designation'])) {
            $sql .= "AND e.designation = '{$_POST['designation']}' ";
         }
         if (isset($_POST['shift']) && !empty($_POST['shift'])) {
            $sql .= "AND e.shift = '{$_POST['shift']}' ";
         }

         $result = $conn->query($sql);
         if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $employees[] = $row;
            }
         }
         if (!empty($employees)) {
            $daysInMonth = date("t", strtotime($month));
         ?>
            <button id="exportExcel" class="btn btn-success mb-2">
               <i class="fa fa-file-excel"></i> Export to Excel
            </button>
            <div class="table-responsive rounded">
               <table class="table table-bordered table-striped table-sticky-header">

                  <thead>
                     <tr style="border-bottom: 1px solid #efbebe">
                        <th>Employee</th>
                        <th></th>
                        <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                           <?php
                           $dateString = $month . "-" . str_pad($d, 2, "0", STR_PAD_LEFT);
                           $isSunday = (date("N", strtotime($dateString)) == 7); // 7 = Sunday
                           ?>
                           <th class="<?= $isSunday ? "sunday" : "" ?>">
                              <?= str_pad($d, 2, "0", STR_PAD_LEFT) ?> <br>
                              <small><?= date("D", strtotime($dateString)) ?></small>
                           </th>
                        <?php endfor; ?>
                     </tr>
                  </thead>

                  <tbody>

                     <?php foreach ($employees as $emp): ?>

                        <?php
                        // Fetch attendance for this employee for selected month
                        $attendanceData = [];
                        $empattendance = $conn->query("SELECT punch_in_date_time, punch_out_date_time, date FROM zuraud_attendance WHERE user_id = '{$emp['id']}' AND DATE_FORMAT(`date`, '%Y-%m') = '$month' ");

                        // Convert attendance result into array indexed by date
                        while ($row = $empattendance->fetch_assoc()) {
                           $attendanceData[$row['date']] = $row;
                        }
                        ?>

                        <!-- PUNCH IN ROW -->
                        <tr class="in-row">
                           <td rowspan="2" class="emp-name">
                              <?= $emp["name"] ?><br>
                              [<?= $emp["mobile_no"] ?>]
                           </td>

                           <td>In Time</td>

                           <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                              <?php
                              $dateString = $month . "-" . str_pad($d, 2, "0", STR_PAD_LEFT);
                              $isSunday = (date("N", strtotime($dateString)) == 7);
                              $val = isset($attendanceData[$dateString]) ? $attendanceData[$dateString]['punch_in_date_time'] : "";
                              ?>
                              <td class="<?= $isSunday ? "sunday" : "" ?>">
                                 <?= $val ? date("h:i A", strtotime($val)) : "-" ?>
                              </td>
                           <?php endfor; ?>
                        </tr>

                        <!-- PUNCH OUT ROW -->
                        <tr class="out-row">
                           <td>Out Time</td>

                           <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                              <?php
                              $dateString = $month . "-" . str_pad($d, 2, "0", STR_PAD_LEFT);
                              $isSunday = (date("N", strtotime($dateString)) == 7);
                              $val = isset($attendanceData[$dateString]) ? $attendanceData[$dateString]['punch_out_date_time'] : "";
                              ?>
                              <td class="<?= $isSunday ? "sunday" : "" ?>">
                                 <?= $val ? date("h:i A", strtotime($val)) : "-" ?>
                              </td>
                           <?php endfor; ?>
                        </tr>

                     <?php endforeach; ?>

                  </tbody>


               </table>
            </div>
         <?php } else { ?>
            <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
               <div class="card shadow-sm w-100">
                  <div class="card-body text-center py-5">
                     <i class="fas fa-database fa-3x text-muted mb-3"></i>
                     <h5 class="text-muted">No Employee Available</h5>
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



<script>
document.getElementById("exportExcel").addEventListener("click", function () {

   // Get the table element
   var table = document.querySelector(".table-sticky-header");

   // Convert HTML table to SheetJS workbook
   var wb = XLSX.utils.table_to_book(table, { sheet: "Attendance" });

   // Prepare filename like "Attendance_Month_2025-11.xlsx"
   var month = "<?= $month ?>"; // Provided from your PHP
   var fileName = "Attendance_" + month + ".xlsx";

   // Export
   XLSX.writeFile(wb, fileName);
});
</script>

<!-- DataTable Init -->
<script>
   $(document).ready(function() {

      $('#filterToggle').on('click', function() {
         $('#filterForm').slideToggle();
      });

   });
</script>