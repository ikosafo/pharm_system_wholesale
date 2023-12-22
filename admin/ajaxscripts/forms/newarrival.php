<?php include('../../config.php'); ?>

<p class="card-text">
    Field marked <span style="color:red">*</span> required </p>
<form class="form form-horizontal" autocomplete="off">
    <div id="error_loc"></div>
    <div class="row">

        <div class="mb-1 col-md-4">
            <label class="form-label" for="product">Product <span style="color:red">*</span></label>
            <select id="product" class="form-select">
                <option></option>
                <?php
                $getproduct = $mysqli->query("select * from products where status IS NULL");
                while ($resproduct = $getproduct->fetch_assoc()) { ?>
                    <option value="<?php echo $resproduct['prodid'] ?>">
                        <?php echo $resproduct['productname']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="quantitysale">Quantity (In Stock) <span style="color:red">*</span></label>
            <input type="text" id="quantitysale" class="form-control" onkeypress="return isNumber(event)" placeholder="Quantity (For Sale)" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="quantitystock">Quantity (In warehouse) <span style="color:red">*</span></label>
            <input type="text" id="quantitystock" class="form-control" onkeypress="return isNumber(event)" placeholder="Quantity (In Stock)" />
        </div>
    </div>
    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="supplier">Supplier <span style="color:red">*</span></label>

            <input list="suppliers" id="supplier" name="supplier" class="form-control" placeholder="Enter or select a supplier" />
            <datalist id="suppliers">
                <?php
                $getsupplier = $mysqli->query("select * from supplier where status IS NULL");
                while ($ressupplier = $getsupplier->fetch_assoc()) { ?>
                    <option>
                        <?php echo $ressupplier['fullname'] . ' - ' . $ressupplier['companyname']; ?>
                    </option>
                <?php } ?>
            </datalist>
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="expirydate">Expiry Date</label>
            <input type="text" id="expirydate" class="form-control" placeholder="Expiry Date" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="costprice">Cost Price <span style="color:red">*</span></label>
            <input type="text" id="costprice" onkeypress="return isNumberKey(event)" name="costprice" class="form-control" placeholder="Cost Price" />
        </div>

    </div>
    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="sellingpricewhole">Selling Price (Wholesale)</label>
            <input type="text" id="sellingpricewhole" onkeypress="return isNumberKey(event)" name="sellingpricewhole" class="form-control" placeholder="Selling Price (Wholesale)" />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 offset-sm-12">
            <button type="button" id="arrivalbtn" class="btn btn-primary me-1">Submit</button>
        </div>
    </div>

</form>

<script>
    // Page jquery scripts
    $("#expirydate").flatpickr();
    /* $("#supplier").select2({
        placeholder: "Select supplier",
        allowClear: true
    }); */
    $("#product").select2({
        placeholder: "Select product",
        allowClear: true
    });


    // Add action on form submit
    $("#arrivalbtn").click(function() {

        var product = $("#product").val();
        var quantitysale = $("#quantitysale").val();
        var quantitystock = $("#quantitystock").val();
        var supplier = $('#supplier').val();
        var expirydate = $("#expirydate").val();
        var costprice = $("#costprice").val();
        var sellingpricewhole = $("#sellingpricewhole").val();

        var error = '';
        if (product == "") {
            error += 'Please select product \n';
        }
        if (quantitysale == "") {
            error += 'Please enter quantity for sale \n';
            $("#quantitysale").focus();
        }
        if (quantitystock == "") {
            error += 'Please enter quantity in stock \n';
            $("#quantitystock").focus();
        }
        if (supplier == "") {
            error += 'Please select supplier \n';
        }
        if (costprice == "") {
            error += 'Please enter cost price \n';
            $("#costprice").focus();
        }
        if (sellingpricewhole == "") {
            error += 'Please enter selling price \n';
            $("#sellingpricewhole").focus();
        }

        if (error == "") {
            $.confirm({
                title: 'Save Record!',
                content: 'Are you sure to continue? This is not reversible',
                buttons: {
                    no: {
                        text: 'No',
                        keys: ['enter', 'shift'],
                        backdrop: 'static',
                        keyboard: false,
                        action: function() {
                            $.alert('Data is safe');
                        }
                    },
                    yes: {
                        text: 'Yes, Save it!',
                        btnClass: 'btn-blue',
                        action: function() {
                            $.ajax({
                                type: "POST",
                                url: "ajaxscripts/queries/save/newarrivals.php",
                                beforeSend: function() {
                                    $.blockUI({
                                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                                    });
                                },
                                data: {
                                    product: product,
                                    quantitysale: quantitysale,
                                    quantitystock: quantitystock,
                                    supplier: supplier,
                                    expirydate: expirydate,
                                    costprice: costprice,
                                    sellingpricewhole: sellingpricewhole
                                },
                                success: function(text) {
                                    //alert(text);

                                    $.ajax({
                                        url: "ajaxscripts/forms/newarrival.php",
                                        beforeSend: function() {
                                            $.blockUI({
                                                message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                                            });
                                        },
                                        success: function(text) {
                                            $('#pageform_div').html(text);
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            alert(xhr.status + " " + thrownError);
                                        },
                                        complete: function() {
                                            $.unblockUI();
                                        },

                                    });
                                    window.location.href = "/viewnewarrivals";
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + " " + thrownError);
                                },
                                complete: function() {
                                    $.unblockUI();
                                },
                            });
                        }
                    }
                }
            });

        } else {
            $("#error_loc").notify(error);
        }
        return false;
    });
</script>