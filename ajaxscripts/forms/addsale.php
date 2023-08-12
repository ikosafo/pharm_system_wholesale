<?php include ('../../config.php'); 
$newsaleid = $_POST['newsaleid'];
?>

<hr/>

<div class="row" id="error_loc">
    <div class="col-12">

         <div class="mb-1">
            <div class="form-group" id="gender">
                <div>
                    <input type="radio" id="barcodeexist"
                            name="barcodechk" value="Barcodeexists"
                            class="custom-control-input" checked>
                    <label class="custom-control-label" for="barcodeexist">Barcode</label>
                
                    <input type="radio" id="nobarcode"
                            name="barcodechk" value="No barcodeexists"
                            class="custom-control-input" style="margin-left:10px;margin-top:10px">
                    <label class="custom-control-label" for="nobarcode">No Barcode</label>
                </div>
            </div>   
        </div>

        <div class="mb-1 row" id="barcodediv">
            <div class="col-sm-3">
                <label class="col-form-label" for="barcode">Barcode</label>
            </div>
            <div class="col-sm-9">
                <input type="text" id="barcode" class="form-control" autocomplete="off" 
                    placeholder="Enter barcode" />
            </div>
        </div>
        <div class="mb-1 row" id="productdiv" style="display:none">
            <div class="col-sm-3">
                <label class="col-form-label" for="products">Product</label>
            </div>
            <div class="col-sm-9">
                <select class="form-select" id="products">
                    <option></option>
                    <?php
                    $getproduct = $mysqli->query("select * from products where status IS NULL");
                    while ($resproduct = $getproduct->fetch_assoc()) { ?>
                        <option value="<?php echo $resproduct['prodid'] ?>"><?php echo $resproduct['productname'] ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
    </div>   
</div>


<script>

$("#barcode").focus(); 

    $("input[name=barcodechk]").change(function () {
        var barcodechk = $('input[name=barcodechk]:checked').val();
        if (barcodechk == "Barcodeexists") {
            $("#barcodediv").show();
            $("#productdiv").hide();
            $("#barcode").focus(); 
        }
        else {
            $("#barcodediv").hide();
            $("#productdiv").show();
        }  
    });

    $("#products").select2({
        placeholder: "Select product",
        allowClear: true
    });


    $("#products").change(function() {
        var productid = $("#products").val();
        //alert(productid);

        $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/productsale.php",
            data: {
                productid: productid,
                newsaleid:'<?php echo $newsaleid; ?>'
            },
            dataType: "html",
            success: function (text) {
                if (text == 2) {
                        $("#error_loc").notify("Item already exists","error");
                    }
                    else {
                        $.ajax({
                        type: "POST",
                        url: "ajaxscripts/forms/addsale.php",
                        data: {
                            newsaleid:'<?php echo $newsaleid; ?>'
                        },
                        beforeSend: function () {
                            $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
                        },
                        success: function (text) {
                            $('#pageform_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            $.unblockUI();
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/tables/tempsales.php",
                        data: {
                            newsaleid:'<?php echo $newsaleid; ?>'
                        },
                        beforeSend: function () {
                            $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
                        },
                        success: function (text) {
                            $('#pagetable_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            $.unblockUI();
                     },

                    }); 
                }                
            },
            complete: function () {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    })
    

      //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 100;  //time in ms, 0.1 second for example
        var $input = $('#barcode');

        //on keyup, start the countdown
        $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
        clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {
           
            //('start searching');
        //do something
        var txtlen = $input.val().length;
        var barcode = $("#barcode").val();
        var newsaleid = '<?php echo $_POST['newsaleid'] ?>';
        //alert(barcode);

        $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/barcode.php",
            data: {
                barcode: barcode,
                newsaleid:'<?php echo $newsaleid; ?>'
            },
            dataType: "html",
            success: function (text) {
                    //alert(text);
                    if (text == 2) {
                        $("#error_loc").notify("Item already exists","error");
                    }
                    else {
                        $.ajax({
                        type: "POST",
                        url: "ajaxscripts/forms/addsale.php",
                        data: {
                            newsaleid:'<?php echo $newsaleid; ?>'
                        },
                        beforeSend: function () {
                            $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
                        },
                        success: function (text) {
                            $('#pageform_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            $.unblockUI();
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/tables/tempsales.php",
                        data: {
                            newsaleid:'<?php echo $newsaleid; ?>'
                        },
                        beforeSend: function () {
                            $.blockUI({ message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>' });
                        },
                        success: function (text) {
                            $('#pagetable_div').html(text);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function () {
                            $.unblockUI();
                     },

                }); 

              }
                   
            },

            complete: function () {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });    
    }


</script>