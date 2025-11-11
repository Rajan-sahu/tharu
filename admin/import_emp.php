<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

?>

<div class="container-fluid content-inner mt-n5">
   <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
         <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
               <div class="header-title">
                  <h4 class="card-title mb-0"> Import Employees</h4>
               </div>
               <div>
                  <a href="./assets/sample/sample_employee.csv" download class="btn btn-sm btn-success ms-2">
                     <i class="fas fa-download me-2"></i> Download Sample
                  </a>
                  <a href="employee_list.php" class="btn btn-sm btn-primary">
                     <i class="fas fa-list me-2"></i> List
                  </a>
               </div>
            </div>
            <div class="card-body">
               <form id="import_emp">

                  <!-- Departmet Name -->
                  <div class="mb-3">
                     <label for="title" class="form-label">Upload File <span class="text-danger">*</span></label>
                     <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv">
                     
                  </div>
                  <!-- Submit Button -->
                  <div class="d-grid">
                     <button type="submit" class="btn btn-primary btn-md" id="sub_btn">
                        <i class="fas fa-save me-2"></i> Import Employees
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