<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
   $update_id = db_sanitize($_GET['id']);
   $shift_sql = $conn->query("SELECT * FROM `zuraud_shift` WHERE `id`='{$update_id}'");
   if ($shift_sql && $shift_sql->num_rows > 0) {
      $shift = $shift_sql->fetch_assoc();
   }
}
?>

<div class="container-fluid content-inner mt-n5">
   <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
         <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
               <div class="header-title">
                  <h4 class="card-title mb-0"><?= isset($update_id) ? "Update": 'Add' ?> Shift</h4>
               </div>
               <a href="shift_list.php" class="btn btn-sm btn-primary">
                  <i class="fas fa-list me-2"></i> List
               </a>
            </div>
            <div class="card-body">
               <form id="shift_add">

                  <!-- Departmet Name -->
                  <div class="mb-3">
                     <label for="name" class="form-label">Shift Name <span class="text-danger">*</span></label>
                     <input type="hidden" name="update_id" value="<?= @$shift['id'] ?>">
                     <input type="text" class="form-control" id="name" name="name" placeholder="Enter Shift name" value="<?= @$shift['name'] ?>">
                  </div>
                  
                     <div class="mb-3">
                        <label for="start_time" class="form-label">Shift Start Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?= @$shift['start_time'] ?>">
                     </div>
                     <div class="mb-3">
                        <label for="end_time" class="form-label">Shift End Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?= @$shift['end_time'] ?>">
                     </div>
                  <!-- Submit Button -->
                  <div class="d-grid">
                     <button type="submit" class="btn btn-primary btn-md" id="sub_btn">
                        <i class="fas fa-save me-2"></i> Save Shift
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>