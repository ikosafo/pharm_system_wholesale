<?php include ('../../config.php'); ?>

<form class="form form-horizontal">
      <div class="row">
       
        <div class="mb-1 col-md-6">
          <label class="form-label" for="supplier">Supplier</label>
          <select id="supplier"  class="form-select">
                <option></option>
                <?php
                 $getsupplier = $mysqli->query("select * from supplier where status IS NULL");
                  while ($ressupplier = $getsupplier->fetch_assoc()) { ?>
                  <option value="<?php echo $ressupplier['supid'] ?>">
                  <?php echo $ressupplier['fullname'].' - '.$ressupplier['companyname']; ?></option>
                <?php } ?>
                <option value="Others">Others</option>
              </select>
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label"></label> <br/>
            <button type="button" id="statbtn" class="btn btn-primary me-1">Search</button>
        </div>
       
      </div>
      
    </form>
    
<script>

 $("#supplier").select2({
        placeholder:"Select Supplier",
        allowClear:true
      });

    // Add action on form submit
    $("#statbtn").click(function(){
    var supplier = $("#supplier").val();

    var error = '';
   
    if (supplier == "") {
        error += 'Please select supplier \n';
    }
   
    if (error == "") {
        $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/supplier.php",
            beforeSend: function () {
                    $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                supplier:supplier
            },
            success: function (text) {
                //alert(text);
                $('#searchform_div').html(text);
              },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    }
    else {
        $.notify(error, {position: "top right"});
    }
    return false;

});

</script>