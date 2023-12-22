<?php
include ('../../config.php');
?>

<form class="form form-horizontal">
            <div class="row">
               
                <div class="col-12">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label" for="searchcriteria">Search Criteria</label>
                    </div>
                    <div class="col-sm-9">
                        <select class="form-select" id="searchcriteria">
                            <option></option>
                            <option value="Search by Category">Search by Category</option>
                            <option value="Search by Subcategory">Search by Subcategory</option>
                            <option value="Search by Expiry Date">Search by Expiry Date</option>
                            <option value="Search by Quantity">Search by Quantity</option>
                            <option value="Search by Supplier">Search by Supplier</option>      
                        </select>
                    </div>
                    </div>
                </div>
            

                <!-- Get criteria divs -->


               <!--  Category -->
                <div class="col-12" style="display:none" id="category_div">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Category</label>
                    </div>
                    <div class="col-sm-9">
                    <select id="category" class="form-select">
                        <option></option>
                        <?php
                        $getcategory = $mysqli->query("select * from categories where status IS NULL");
                        while ($rescategory = $getcategory->fetch_assoc()) { ?>
                        <option value="<?php echo $rescategory['catid'] ?>">
                        <?php echo $rescategory['categoryname']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    </div>
                </div>
               
                <!--  Subcategory -->
                <div class="col-12" style="display:none" id="subcategory_div">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label">SubCategory</label>
                    </div>
                    <div class="col-sm-9">
                    <select id="subcategory" class="form-select">
                        <option></option>
                        <?php
                        $getsubcategory = $mysqli->query("select * from subcategories where status IS NULL");
                        while ($ressubcategory = $getsubcategory->fetch_assoc()) { ?>
                        <option value="<?php echo $ressubcategory['subcatid'] ?>">
                        <?php echo $ressubcategory['subcategoryname']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    </div>
                </div>

                <!--  Expiry date -->
                <div class="col-12" style="display:none" id="expirydate_div">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Expiry Date</label>
                    </div>
                    <div class="col-sm-9">
                    <select id="expirydate" class="form-select">
                        <option></option>
                        <option value="Expired">Expired</option>
                        <option value="Not Expired">Not Expired</option>
                        <option value="Expired in one week">Expired in one week</option>
                        <option value="Expired in one month">Expired in one month</option>
                        <option value="Expired in one year">Expired in one year</option>
                    </select>
                    </div>
                    </div>
                </div>

                 <!--  Quantity -->
                 <div class="col-12" style="display:none" id="quantity_div">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Quantity</label>
                    </div>
                    <div class="col-sm-9">
                    <select id="quantity" class="form-select">
                        <option></option>
                        <option>None for sale</option>
                        <option>Less than threshold</option>
                        <option>More than threshold</option>
                        <option>In stock</option>
                    </select>
                    </div>
                    </div>
                </div>
               
                 <!--  Supplier -->
                 <div class="col-12" style="display:none" id="supplier_div">
                    <div class="mb-1 row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Supplier</label>
                    </div>
                    <div class="col-sm-9">
                    <select id="supplier" class="form-select">
                        <option></option>
                        <?php
                        $getsupplier = $mysqli->query("select * from supplier where status IS NULL");
                        while ($ressupplier = $getsupplier->fetch_assoc()) { ?>
                        <option value="<?php echo $ressupplier['supid'] ?>">
                        <?php echo $ressupplier['companyname'].' - '.$ressupplier['fullname']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    </div>
                </div>
               

            </div>
 </form>

 <div id="searchdiv"></div>



<script>
    //Jquery plugins
    $("#searchcriteria").select2({
        placeholder: "Select criteria",
        allowClear: true
    });

    $("#category").select2({
        placeholder: "Select category",
        allowClear: true
    });

    $("#subcategory").select2({
        placeholder: "Select subcategory",
        allowClear: true
    });

    $("#expirydate").select2({
        placeholder: "Select option",
        allowClear: true
    });

    $("#quantity").select2({
        placeholder: "Select option",
        allowClear: true
    });

    $("#supplier").select2({
        placeholder: "Select supplier",
        allowClear: true
    });

    $("#searchcriteria").change(function () {
        var searchcriteria = $("#searchcriteria").val();
      
        if (searchcriteria == 'Search by Category') {
            $("#category_div").show();
            $("#subcategory_div").hide();
            $("#expirydate_div").hide();
            $("#quantity_div").hide();
            $("#supplier_div").hide();
        }
        if (searchcriteria == 'Search by Subcategory') {
            $("#subcategory_div").show();
            $("#category_div").hide();
            $("#expirydate_div").hide();
            $("#quantity_div").hide();
            $("#supplier_div").hide();
        }
        if (searchcriteria == 'Search by Expiry Date') {
            $("#expirydate_div").show();
            $("#subcategory_div").hide();
            $("#category_div").hide();
            $("#quantity_div").hide();
            $("#supplier_div").hide();
        }
        if (searchcriteria == 'Search by Quantity') {
            $("#quantity_div").show();
            $("#expirydate_div").hide();
            $("#subcategory_div").hide();
            $("#category_div").hide();
            $("#supplier_div").hide();
        }
        if (searchcriteria == 'Search by Supplier') {
            $("#supplier_div").show();
            $("#quantity_div").hide();
            $("#expirydate_div").hide();
            $("#subcategory_div").hide();
            $("#category_div").hide(); 
        }

    });
     // 
     $("#category").change(function () {
         var categoryid = $("#category").val();
         //alert(categoryid);

         $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/searchcategory.php",
            beforeSend: function () {
                $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                categoryid: categoryid
                },
            success: function (text) {
                $('#searchform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },

        });

     });
    


     $("#subcategory").change(function () {
         var subcategoryid = $("#subcategory").val();
         //alert(subcategoryid);

         $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/searchsubcategory.php",
            beforeSend: function () {
                $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                subcategoryid: subcategoryid
                },
            success: function (text) {
                $('#searchform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },

        });

     });


     $("#expirydate").change(function () {
         var expirydate = $("#expirydate").val();
         //alert(subcategoryid);

         $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/searchexpirydate.php",
            beforeSend: function () {
                $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                expirydate: expirydate
                },
            success: function (text) {
                $('#searchform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },

        });

     });
    

     $("#quantity").change(function () {
         var quantity = $("#quantity").val();
         //alert(subcategoryid);

         $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/searchquantity.php",
            beforeSend: function () {
                $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                quantity: quantity
                },
            success: function (text) {
                $('#searchform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },

        });

     });


     $("#supplier").change(function () {
         var supplier = $("#supplier").val();
         //alert(subcategoryid);

         $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/searchsupplier.php",
            beforeSend: function () {
                $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
            },
            data: {
                supplier: supplier
                },
            success: function (text) {
                $('#searchform_div').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function () {
                $.unblockUI();
            },

        });

     });
    


</script>