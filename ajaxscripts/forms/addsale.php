<?php include('../../config.php');
$newsaleid = $_POST['newsaleid'];
?>

<hr />

<div class="row" id="error_loc">
    <div class="col-12">

        <form class="faq-search-input mb-1">
            <div class="input-group input-group-merge">
                <div class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" id="product" class="form-control" autocomplete="off" placeholder="Search product name or barcode" />
            </div>
        </form>

        <div id="product_table"></div>

        <!--  <div class="mb-1">
            <div class="form-group" id="gender">
                <div>
                    <input type="radio" id="nobarcode" name="barcodechk" value="No barcodeexists" class="custom-control-input" checked>
                    <label class="custom-control-label" for="nobarcode">Product Name</label>

                    <input type="radio" id="barcodeexist" name="barcodechk" value="Barcodeexists" class="custom-control-input" style="margin-left:10px;margin-top:10px">
                    <label class="custom-control-label" for="barcodeexist">Barcode</label>
                </div>
            </div>
        </div> -->

        <!-- <div class="mb-1 row" id="barcodediv" style="display:none">
            <div class="col-sm-3">
                <label class="col-form-label" for="barcode">Barcode</label>
            </div>
            <div class="col-sm-9">
                <input type="text" id="barcode" class="form-control" autocomplete="off" placeholder="Enter barcode" />
            </div>
        </div> -->

        <!-- <div class="mb-1 row" id="productdiv">
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
        </div> -->
    </div>
</div>


<script>
    $("#product").focus();

    /*  $("input[name=barcodechk]").change(function() {
        var barcodechk = $('input[name=barcodechk]:checked').val();
        if (barcodechk == "Barcodeexists") {
            $("#barcodediv").show();
            $("#productdiv").hide();
            $("#barcode").focus();
        } else {
            $("#barcodediv").hide();
            $("#productdiv").show();
        }
    });

    $("#products").select2({
        placeholder: "Select product",
        allowClear: true
    });
 */






    //setup before functions
    var typingTimer; //timer identifier
    var doneTypingInterval = 300; //time in ms, 0.3 second for example
    var $input = $('#product');

    //on keyup, start the countdown
    $input.on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $input.on('keydown', function() {
        clearTimeout(typingTimer);
    });

    //user is "finished typing," do something
    function doneTyping() {
        //('start searching');
        //do something
        var txtlen = $input.val().length;
        var product_search = $("#product").val();

        if (txtlen > 1) {
            $("#product_table").show();
            $.ajax({
                type: "POST",
                url: "ajaxscripts/queries/search/product_sale.php",
                data: {
                    product_search: product_search
                },
                success: function(text) {
                    //alert(text);
                    $('#product_table').html(text);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
            });
        } else {
            //$("#prov-table").DataTable().ajax.reload(null, false );
            $("#product_table").hide();
        }

    }











    /*  $("#product").keyup(function() {
        var product = $("#product").val();
        alert(product);

        $.ajax({
            type: "POST",
            url: "ajaxscripts/queries/search/productsale.php",
            data: {
                productid: productid,
                newsaleid: '<?php echo $newsaleid; ?>'
            },
            dataType: "html",
            success: function(text) {
                if (text == 2) {
                    $("#error_loc").notify("Item already exists", "error");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/forms/addsale.php",
                        data: {
                            newsaleid: '<?php echo $newsaleid; ?>'
                        },
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

                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/tables/tempsales.php",
                        data: {
                            newsaleid: '<?php echo $newsaleid; ?>'
                        },
                        beforeSend: function() {
                            $.blockUI({
                                message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                            });
                        },
                        success: function(text) {
                            $('#pagetable_div').html(text);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            $.unblockUI();
                        },

                    });
                }
            },
            complete: function() {},
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    })
 */
</script>