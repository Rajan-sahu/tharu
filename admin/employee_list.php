<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title d-flex align-items-center">
            <h4 class="card-title mb-0 me-2">Employee List</h4>

            <!-- Filter toggle button -->
            <button class="btn btn-sm btn-outline-primary" id="filterToggle" type="button">
               <i class="fa-solid fa-filter"></i>
            </button>
         </div>

         <a href="employee_add.php" class="btn btn-sm btn-primary">
            <i class="fa-sharp fa-solid fa-plus"></i> Add New
         </a>
      </div>

      <!-- Hidden Filter Form -->
      <div class="card-body border-top pt-3" id="filterForm" style="display: none;">
         <form method="POST" action="employee_list.php">
            <div class="row g-3">
               <!-- Station -->
               <div class="col-md-3">
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
               <div class="col-md-3">
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
               <div class="col-md-3">
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
               <div class="col-md-3">
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
            </div>
            <div class="mt-3 text-end">
               <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa-solid fa-search"></i> Apply Filter
               </button>
               <a href="employee_list.php" class="btn btn-secondary btn-sm">
                  <i class="fa-solid fa-rotate-left"></i> Reset
               </a>
            </div>
         </form>
      </div>
      <div class="card-body">
         <?php
         $employees = [];
         $sql = "SELECT e.id,e.name,e.f_name,e.gender,e.dob,e.doj,e.doe,e.mobile_no,st.station_name AS station,dp.title AS department, dg.title AS designation, sf.name AS shift FROM `zuraud_employee` e LEFT JOIN zuraud_station st ON st.id=e.station LEFT JOIN zuraud_department dp ON dp.id= e.department LEFT JOIN zuraud_designation dg ON dg.id= e.designation LEFT JOIN zuraud_shift sf ON sf.id = e.shift WHERE 1 ";

         if(isset($_POST['station']) && !empty($_POST['station'])){
            $sql .= "AND e.station = '{$_POST['station']}' ";
         }
         if(isset($_POST['department']) && !empty($_POST['department'])){
            $sql .= "AND e.department = '{$_POST['department']}' ";
         }
         if(isset($_POST['designation']) && !empty($_POST['designation'])){
            $sql .= "AND e.designation = '{$_POST['designation']}' ";
         }
         if(isset($_POST['shift']) && !empty($_POST['shift'])){
            $sql .= "AND e.shift = '{$_POST['shift']}' ";
         }

         $result = $conn->query($sql);
         if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $employees[] = $row;
            }
         }
         if (!empty($employees)) { ?>
            <div class="table-responsive">
               <table id="employeeTable" class="table table-bordered table-striped align-middle">
                  <thead class="table-light">
                     <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Mobile No</th>
                        <th>DOB</th>
                        <th>DOJ</th>
                        <th>DOE</th>
                        <th>Work Detail</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($employees as $index => $emp) { ?>
                        <tr>
                           <td><?= $index + 1 ?></td>
                           <td><?= $emp['name'] ?></td>
                           <td><?= $emp['mobile_no'] ?></td>
                           <td><?= (!empty($emp['dob'])) ? date('d-m-Y', strtotime($emp['dob'])) : '' ?></td>
                           <td><?= (!empty($emp['doj'])) ? date('d-m-Y', strtotime($emp['doj'])) : '' ?></td>
                           <td><?= (!empty($emp['doe'])) ? date('d-m-Y', strtotime($emp['doe'])) : '' ?></td>
                           <td class="text-sm">
                              <strong>Station:</strong> <?= $emp['station'] ?><br>
                              <strong>Department:</strong> <?= $emp['department'] ?><br>
                              <strong>Designation:</strong> <?= $emp['designation'] ?><br>
                              <strong>Shift:</strong> <?= $emp['shift'] ?>
                           </td>
                           <td class="text-center">
                              <a title="Edit" href="employee_add.php?id=<?= $emp['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                 <i class="fas fa-edit"></i>
                              </a>
                              <a title="Delete" href="#" class="btn btn-sm btn-outline-danger delete-employee" data-del_id=<?= $emp['id'] ?>>
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
      $('#employeeTable').DataTable({
         pageLength: 10, // default rows per page
         lengthMenu: [5, 10, 25, 50, 100],
         ordering: true, // enable column sorting
         searching: true, // enable search bar
         language: {
            search: "_INPUT_",
            searchPlaceholder: "Search employees..."
         }
      });

      $('#filterToggle').on('click', function() {
         $('#filterForm').slideToggle();
      });

   });
</script>