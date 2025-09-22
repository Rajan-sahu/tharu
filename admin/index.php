<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');
?>  

<div class="container-fluid content-inner mt-n5 py-0">
   <div class="row g-4"> <!-- g-4 gives nice spacing between cards -->

      <!-- Total Stations -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
         <a href="./station_list.php" class="text-decoration-none">
            <div class="card shadow-sm h-100">
               <div class="card-body d-flex align-items-center">
                  <i class="fa-sharp fa-solid fa-train-subway fa-3x me-3 text-primary"></i>
                  <div>
                     <p class="mb-1">Total Stations</p>
                     <?php
                     $station = "SELECT COUNT(id) AS total FROM zuraud_station";
                     $result = $conn->query($station);
                     $total_stations = 0;
                     if ($result && $row = $result->fetch_assoc()) {
                         $total_stations = $row['total'];
                     }
                     ?>
                     <h4 class="counter mb-0"><?= $total_stations; ?></h4>
                  </div>
               </div>
            </div>
         </a>
      </div>

      <!-- Total Departments -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
         <a href="./department_list.php" class="text-decoration-none">
            <div class="card shadow-sm h-100">
               <div class="card-body d-flex align-items-center">
                  <i class="fa-sharp fa-solid fa-building fa-3x me-3 text-success"></i>
                  <div>
                     <p class="mb-1">Total Departments</p>
                     <?php
                     $department = "SELECT COUNT(id) AS total FROM zuraud_department";
                     $result = $conn->query($department);
                     $total_departments = 0;
                     if ($result && $row = $result->fetch_assoc()) {
                         $total_departments = $row['total'];
                     }
                     ?>
                     <h4 class="counter mb-0"><?= $total_departments; ?></h4>
                  </div>
               </div>
            </div>
         </a>
      </div>

      <!-- Total Designations -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="800">
         <a href="./designation_list.php" class="text-decoration-none">
            <div class="card shadow-sm h-100">
               <div class="card-body d-flex align-items-center">
                  <i class="fa-sharp fa-solid fa-briefcase fa-3x me-3 text-warning"></i>
                  <div>
                     <p class="mb-1">Total Designations</p>
                     <?php
                     $designation = "SELECT COUNT(id) AS total FROM zuraud_designation";
                     $result = $conn->query($designation);
                     $total_designations = 0;
                     if ($result && $row = $result->fetch_assoc()) {
                         $total_designations = $row['total'];
                     }
                     ?>
                     <h4 class="counter mb-0"><?= $total_designations; ?></h4>
                  </div>
               </div>
            </div>
         </a>
      </div>

      <!-- Total Shifts -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="1200">
         <a href="./shift_list.php" class="text-decoration-none">
            <div class="card shadow-sm h-100">
               <div class="card-body d-flex align-items-center">
                  <i class="fa-sharp fa-solid fa-clock fa-3x me-3 text-danger"></i>
                  <div>
                     <p class="mb-1">Total Shifts</p>
                     <?php
                     $shift = "SELECT COUNT(id) AS total FROM zuraud_shift";
                     $result = $conn->query($shift);
                     $total_shifts = 0;
                     if ($result && $row = $result->fetch_assoc()) {
                         $total_shifts = $row['total'];
                     }
                     ?>
                     <h4 class="counter mb-0"><?= $total_shifts; ?></h4>
                  </div>
               </div>
            </div>
         </a>
      </div>
      <!-- Total Employees -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="1600">
         <a href="./employee_list.php" class="text-decoration-none">
            <div class="card shadow-sm h-100">
               <div class="card-body d-flex align-items-center">
                  <i class="fa-sharp fa-solid fa-user-tie fa-3x me-3 text-danger"></i>
                  <div>
                     <p class="mb-1">Total Employees</p>
                     <?php
                     $employee = "SELECT COUNT(id) AS total FROM zuraud_employee";
                     $result = $conn->query($employee);
                     $total_employees = 0;
                     if ($result && $row = $result->fetch_assoc()) {
                         $total_employees = $row['total'];
                     }
                     ?>
                     <h4 class="counter mb-0"><?= $total_employees; ?></h4>
                  </div>
               </div>
            </div>
         </a>
      </div>

   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>  

<!-- AOS JS Init -->
<script>
  AOS.init({
    duration: 800,   // animation duration
    once: true       // animation happens only once when scrolled
  });
</script>
