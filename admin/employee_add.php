<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
   $update_id = db_sanitize($_GET['id']);
   $emp_sql = $conn->query("SELECT * FROM `zuraud_employee` WHERE `id`='{$update_id}'");
   if ($emp_sql && $emp_sql->num_rows > 0) {
      $emp = $emp_sql->fetch_assoc();
   }
}
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title">
            <h4 class="card-title mb-0"><?= isset($update_id) ? "Update": 'Add' ?> Employee</h4>
         </div>
         <a href="employee_list.php" class="btn btn-sm btn-primary">
            <i class="fas fa-list me-2"></i> List
         </a>
      </div>
      <div class="card-body">
         <form id="employee_add">
            <div class="row">
               <!-- Employee Name -->
               <div class="mb-3 col-md-6">
                  <label for="name" class="form-label">Employee Name <span class="text-danger">*</span></label>
                  <input type="hidden" name="update_id" value="<?= @$emp['id'] ?>">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter employee name" value="<?= @$emp['name'] ?>">
               </div>
               <!-- Employee's Father Name -->
               <div class="mb-3 col-md-6">
                  <label for="f_name" class="form-label">Employee's Father Name</label>
                  <input type="text" class="form-control" id="f_name" name="f_name" placeholder="Enter employee's Father name" value="<?= @$emp['f_name'] ?>">
               </div>
               <!-- Employee's Gender -->
               <div class="mb-3 col-md-6">
                  <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                  <select class="form-select" name="gender" id="gender">
                     <option value="" disabled selected>----- Select Gender -----</option>
                     <option <?= ('Male' == @$emp['gender']) ? "selected" : '' ?> value="Male">Male</option>
                     <option <?= ('Female' == @$emp['gender']) ? "selected" : '' ?> value="Female">Female</option>
                     <option <?= ('Others' == @$emp['gender']) ? "selected" : '' ?> value="Others">Others</option>
                  </select>
               </div>

               <!-- Employee's Date Of Birth -->
               <div class="mb-3 col-md-6">
                  <label for="dob" class="form-label">Date Of Birth</label>
                  <input type="date" class="form-control" id="dob" name="dob" value="<?= @$emp['dob'] ?>">
               </div>
               <!-- Employee's Mobile -->
               <div class="mb-3 col-md-6">
                  <label for="mobile_no" class="form-label">Mobile No.</label>
                  <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?= @$emp['mobile_no'] ?>">
               </div>
               <!-- Employee's Date Of Joining -->
               <div class="mb-3 col-md-6">
                  <label for="doj" class="form-label">Date Of Joining</label>
                  <input type="date" class="form-control" id="doj" name="doj" value="<?= @$emp['doj'] ?>">
               </div>
               <!-- Employee's Date Of End -->
               <div class="mb-3 col-md-6">
                  <label for="doe" class="form-label">Date Of End</label>
                  <input type="date" class="form-control" id="doe" name="doe" value="<?= @$emp['doe'] ?>">
               </div>
               <!-- Station -->
               <div class="mb-3 col-md-6">
                  <?php
                  $station_sql = $conn->query("SELECT id,station_name FROM `zuraud_station`");

                  ?>
                  <label for="station" class="form-label">Railway Station <span class="text-danger">*</span></label>
                  <select class="form-select" id="station" name="station">
                     <option value="" selected disabled>----- Select Station -----</option>
                     <?php
                     if ($station_sql && $station_sql->num_rows > 0) {

                        while ($station = $station_sql->fetch_assoc()) {
                           $select = ($station['id'] == @$emp['station']) ? "selected" : '';
                     ?>
                           <option value="<?= $station['id'] ?>" <?= $select ?>><?= $station['station_name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>

               <!-- Department -->
               <div class="mb-3 col-md-6">
                  <?php
                  $department_sql = $conn->query("SELECT id,title AS name FROM `zuraud_department`");

                  ?>
                  <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                  <select class="form-select" id="department" name="department">
                     <option value="" selected disabled>----- Select Department -----</option>
                     <?php
                     if ($department_sql && $department_sql->num_rows > 0) {

                        while ($department = $department_sql->fetch_assoc()) {
                           $select = ($department['id'] == @$emp['department']) ? "selected" : '';
                     ?>
                           <option value="<?= $department['id'] ?>" <?= $select ?>><?= $department['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>
               <!-- Designation -->
               <div class="mb-3 col-md-6">
                  <?php
                  $designation_sql = $conn->query("SELECT id,title AS name FROM `zuraud_designation`");

                  ?>
                  <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                  <select class="form-select" id="designation" name="designation">
                     <option value="" selected disabled>----- Select Designation -----</option>
                     <?php
                     if ($designation_sql && $designation_sql->num_rows > 0) {

                        while ($designation = $designation_sql->fetch_assoc()) {
                           $select = ($designation['id'] == @$emp['designation']) ? "selected" : '';
                     ?>
                           <option value="<?= $designation['id'] ?>" <?= $select ?>><?= $designation['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>

               <!-- Shift -->
               <div class="mb-3 col-md-4">
                  <?php
                  $shift_sql = $conn->query("SELECT id, name FROM `zuraud_shift`");

                  ?>
                  <label for="shift" class="form-label">Shift <span class="text-danger">*</span></label>
                  <select class="form-select" id="shift" name="shift">
                     <option value="" selected disabled>----- Select Shift -----</option>
                     <?php
                     if ($shift_sql && $shift_sql->num_rows > 0) {

                        while ($shift = $shift_sql->fetch_assoc()) {
                           $select = ($shift['id'] == @$emp['shift']) ? "selected" : '';
                     ?>
                           <option value="<?= $shift['id'] ?>" <?= $select ?>><?= $shift['name'] ?></option>

                     <?php }
                     }
                     ?>
                  </select>
               </div>

               <div class="mb-3 col-md-4">
                  <label for="device_sr" class="form-label">Machine Sr. No</label>
                  <input type="text" class="form-control" id="device_sr" name="device_sr" value="<?= @$emp['device_sr'] ?>">
               </div>
               <div class="mb-3 col-md-4">
                  <label for="device_user" class="form-label">User Id in machine</label>
                  <input type="text" class="form-control" id="device_user" name="device_user" value="<?= @$emp['device_user'] ?>">
               </div>


            </div>

            <!-- Submit Button -->
            <div class="d-grid">
               <button type="submit" class="btn btn-primary btn-md" id="sub_btn">
                  <i class="fas fa-save me-2"></i> Save Employee
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>
