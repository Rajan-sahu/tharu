<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

if(isset($_GET['id'] ) && !empty($_GET['id']))
{
   $update_id= db_sanitize($_GET['id']);
   $station_sql=$conn->query("SELECT * FROM `zuraud_station` WHERE `id`='{$update_id}'");
   if($station_sql && $station_sql->num_rows>0){
      $station = $station_sql->fetch_assoc();
   }

}
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title">
            <h4 class="card-title mb-0"><?= isset($update_id) ? "Update": 'Add' ?> Railway Station</h4>
         </div>
         <a href="station_list.php" class="btn btn-sm btn-primary">
            <i class="fas fa-list me-2"></i> List
         </a>
      </div>
      <div class="card-body">
         <form id="station_add">

            <!-- Station Name -->
            <div class="mb-3">
               <label for="station_name" class="form-label">Station Name <span class="text-danger">*</span></label>
               <input type="hidden" name="update_id" value="<?= @$station['id'] ?>">
               <input type="text" class="form-control" id="station_name"  name="station_name" placeholder="Enter station name" value="<?= @$station['station_name'] ?>">
            </div>

            <!-- Address -->
            <div class="mb-3">
               <label for="address" class="form-label">Address</label>
               <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address"><?= @$station['address'] ?></textarea>
            </div>

            <!-- Latitude & Longitude -->
            <div class="row">
               <div class="col-md-6 mb-3">
                  <label for="latitude" class="form-label">Latitude</label>
                  <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude" value="<?= @$station['latitude'] ?>">
               </div>
               <div class="col-md-6 mb-3">
                  <label for="longitude" class="form-label">Longitude</label>
                  <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude" value="<?= @$station['longitude'] ?>">
               </div>
            </div>

            <div class="row">
               <!-- State -->
               <div class="mb-3 col-md-6">
                  <?php                      
                     $state_sql= $conn->query("SELECT * FROM `tbl_states`");

                  ?>
                  <label for="state" class="form-label">State</label>
                  <select class="form-select" id="state" name="state">
                     <option value="" selected disabled>-- Select State --</option>
                     <?php

                     if($state_sql && $state_sql->num_rows>0){
                        $selectedstate= (isset($station['state']))? $station['state']: 0;
                        
                        while($state = $state_sql->fetch_assoc()){ 
                           $select= ($state['id']==$selectedstate)? "selected": '';
                           ?>
                        <option value="<?= $state['id'] ?>" <?= $select ?> ><?= $state['name'] ?></option>

                        <?php }
                     }

                     ?>
                  </select>                  
               </div>

               <!-- City -->
               <div class="mb-3 col-md-6">
                  <label for="city" class="form-label">City </label>
                  <select class="form-select" id="city" name="city">
                     <option value="" selected disabled>-- Select City --</option>
                     
                  </select>
               </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
               <button type="submit" class="btn btn-primary btn-md" id="sub_btn">
                  <i class="fas fa-save me-2"></i> Save Station
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>

<script>
$(document).ready(function () {
    function loadCities(stateId, selectedCityId = <?php echo json_encode(isset($station['city']) ? $station['city'] : null); ?>) {
        $("#city").empty().append('<option value="" disabled selected>-- Loading... --</option>');

        $.ajax({
            url: "./config/request/get_city.php",
            type: "POST",
            data: { state: stateId },
            dataType: "json",
            success: function (response) {
                $("#city").empty().append('<option value="" disabled selected>-- Select City --</option>');

                if (response.status === 200 && response.data.length > 0) {
                    $.each(response.data, function (index, item) {
                        let selected = (selectedCityId && selectedCityId == item.id) ? "selected" : "";
                        $("#city").append('<option value="' + item.id + '" ' + selected + '>' + item.city + '</option>');
                    });
                } else {
                    $("#city").append('<option value="" disabled>No Cities Found</option>');
                }
            },
            error: function () {
                $("#city").empty().append('<option value="" disabled selected>Error Loading Cities</option>');
            }
        });
    }

    // On state change
    $("#state").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            loadCities(stateId);
        } else {
            $("#city").empty().append('<option value="" disabled selected>-- Select City --</option>');
        }
    });


    $("#state").trigger("change");
});
</script>
