<?php
include('../config.php');
include('./functions.php');

$theid = $_POST['id_index'];
$getdetails = $mysqli->query("SELECT * FROM tempsales t JOIN sales s ON t.`genid` = s.`newsaleid` WHERE tsid = '$theid'");
$resdetails = $getdetails->fetch_assoc();

?>
<p class="card-text font-small mb-2">
    Edit Sales
</p>
<hr />
<form class="form form-horizontal">
    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="customerName">Customer Name</label>
            <input type="text" id="customerName" class="form-control" placeholder="Customer Name" value="<?php echo $resdetails['customer']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="customerTel">Customer Telephone</label>
            <input type="number" id="customerTel" class="form-control" placeholder="Customer Telephone" value="<?php echo $resdetails['telephone']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="prodQuantity">Quantity</label>
            <input type="number" id="prodQuantity" class="form-control" placeholder="Quantity" value="<?php echo $resdetails['quantity']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="price">Price of Item</label>
            <input type="number" id="price" readonly step="0.01" class="form-control" placeholder="Price" value="<?php echo $resdetails['price']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="totalPrice">Total Price of all products bought by customer</label>
            <input type="number" id="totalPrice" readonly step="0.01" class="form-control" placeholder="Total Price" value="<?php echo $resdetails['totalprice']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="amtPaid">Amount Paid</label>
            <input type="number" id="amtPaid" step="0.01" class="form-control" placeholder="Amount Paid" value="<?php echo $resdetails['amountpaid']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="changeGiven">Change Given</label>
            <input type="number" id="changeGiven" readonly step="0.01" class="form-control" placeholder="Change Given" value="<?php echo $resdetails['change']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 offset-sm-12">
            <button type="button" id="customerbtn" class="btn btn-warning me-1">Update</button>
        </div>
    </div>

</form>

<script>
    $('#amtPaid').keyup(function() {
        var amtPaid = $('#amtPaid').val();
        var totalprice = $('#totalPrice').val();
        var change = amtPaid - totalprice; // Corrected variable name here
        $('#changeGiven').val(change.toFixed(2));
    });

    $('#prodQuantity').change(function() {
        var quantity = $(this).val();
        var productId = '<?php echo $resdetails['prodid']; ?>';

        getProductPrice(productId).then(function(price) {
            var totalPrice = price * quantity;
            $('#price').val(price.toFixed(2));
            $('#totalPrice').val(totalPrice.toFixed(2));
        }).catch(function(error) {
            console.error(error);
        });
    });



    // Add action on form submit
    $("#customerbtn").click(function() {

        var customerName = $("#customerName").val();
        var customerTel = $("#customerTel").val();
        var prodQuantity = $("#prodQuantity").val();
        var price = $("#price").val();
        var totalPrice = $("#totalPrice").val();
        var amtPaid = $("#amtPaid").val();
        var changeGiven = $("#changeGiven").val();
        var theid = '<?php echo $theid; ?>';

        var error = '';
        if (customerName == "") {
            error += 'Please enter full name \n';
            $("#customerName").focus();
        }
        if (customerTel == "") {
            error += 'Please enter phone number \n';
            $("#customerTel").focus();
        }
        if (prodQuantity == "") {
            error += 'Please enter company name \n';
            $("#prodQuantity").focus();
        }


        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajaxscripts/queries/edit/sales.php",
                beforeSend: function() {
                    $.blockUI({
                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                    });
                },
                data: {
                    customerName,
                    customerTel,
                    prodQuantity,
                    price,
                    totalPrice,
                    amtPaid,
                    changeGiven,
                    theid
                },
                success: function(text) {
                    //alert(text);

                    $.ajax({
                        url: "ajaxscripts/forms/addcustomer.php",
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
                    window.location.href = "/viewcustomers";


                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    $.unblockUI();
                },
            });
        } else {
            $("#error_loc").notify(error, {
                position: "bottom"
            });
        }
        return false;

    });
</script>