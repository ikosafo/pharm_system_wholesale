<?php
include('../../config.php');
include('../../functions.php');

$genid = $_POST['saleTransaction'];
$getDetails = $mysqli->query("SELECT * FROM tempsales t JOIN sales s ON t.`genid` = s.`newsaleid` WHERE t.`genid` = '$genid'");
$detailsArray = [];
while ($resDetail = $getDetails->fetch_assoc()) {
    $detailsArray[] = $resDetail;
}
?>

<section id="datatable" class="mt-4">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table mt-2 table-sm" id="table-data">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;
                        foreach ($detailsArray as $resDetails) {
                            $totalPrice += getProductPrice($resDetails['prodid']) * $resDetails['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <?php echo getProdName($resDetails['prodid']); ?>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity-input" value="<?php echo $resDetails['quantity']; ?>" data-tsid="<?php echo $resDetails['tsid']; ?>" data-price="<?php echo getProductPrice($resDetails['prodid']); ?>" data-original-quantity="<?php echo $resDetails['quantity']; ?>">
                                </td>
                                <td class="total-price">
                                    <?php echo getProductPrice($resDetails['prodid']) * $resDetails['quantity']; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <!-- Add a row for the total sum -->
                        <tr>
                            <td colspan="2" style="text-align: right;"><strong>Total Price of all products:</strong></td>
                            <td id="totalSumCell"><?php echo $totalPrice; ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>


</section>
<!--/ Basic table -->

<div id="form_div" class="mt-4">
    <form class="form form-horizontal">
        <div class="row">
            <div class="mb-1 col-md-4">
                <label class="form-label" for="customerName">Customer Name</label>
                <input type="text" id="customerName" class="form-control" placeholder="Customer Name" value="<?php echo $detailsArray[0]['customer']; ?>" />
            </div>
            <div class="mb-1 col-md-4">
                <label class="form-label" for="customerTel">Customer Telephone</label>
                <input type="number" id="customerTel" class="form-control" placeholder="Customer Telephone" value="<?php echo $detailsArray[0]['telephone']; ?>" />
            </div>
            <div class="mb-1 col-md-4">
                <label class="form-label" for="amtPaid">Amount Paid</label>
                <input type="number" id="amtPaid" step="0.01" class="form-control" placeholder="Amount Paid" value="<?php echo $detailsArray[0]['amountpaid']; ?>" />
            </div>
            <div class="mb-1 col-md-4">
                <label class="form-label" for="changeGiven">Change Given</label>
                <input type="number" id="changeGiven" readonly step="0.01" class="form-control" placeholder="Change Given" value="<?php echo $detailsArray[0]['change']; ?>" />
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 offset-sm-12">
                <button type="button" id="customerbtn" class="btn btn-warning me-1">Update Sales</button>
            </div>
        </div>
    </form>
</div>


<script>
    /*    $(document).ready(function() {
        // Event handler for changing the quantity input
        $(document).on('input', '.quantity-input', function() {
            var quantity = parseFloat($(this).val()); // Parse the quantity as a float
            var pricePerItem = parseFloat($(this).closest('tr').find('.price-per-item').text()); // Get the price per item from the table cell
            var totalPrice = quantity * pricePerItem; // Calculate the total price


            // Update the total price cell with the new calculated total price
            $(this).closest('tr').find('.total-price').text(totalPrice.toFixed(2));

            // Recalculate the total price for all products
            var total = 0;
            $('.total-price').each(function() {
                total += parseFloat($(this).text());
            });
            $('#totalPrice').val(total.toFixed(2));
        });

        // Event handler for clicking the update button
        $('#customerbtn').click(function() {
            var customerName = $('#customerName').val();
            var customerTel = $('#customerTel').val();
            var prodQuantity = $('#prodQuantity').val();
            var price = $('#price').val();
            var totalPrice = $('#totalPrice').val();
            var amtPaid = $('#amtPaid').val();
            var changeGiven = $('#changeGiven').val();

            // Perform AJAX request to update customer details or quantities
            $.ajax({
                type: "POST",
                url: "update_customer_details.php",
                data: {
                    customerName: customerName,
                    customerTel: customerTel,
                    prodQuantity: prodQuantity,
                    price: price,
                    totalPrice: totalPrice,
                    amtPaid: amtPaid,
                    changeGiven: changeGiven
                },
                beforeSend: function() {
                    $.blockUI({
                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                    });
                },
                success: function(response) {
                    // Handle success response
                    alert(response); // Display success message or handle as needed
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });
    }); */



    $(document).ready(function() {

        $('#amtPaid').keyup(function() {
            var amtPaid = $('#amtPaid').val();
            var totalprice = '<?php echo $totalPrice; ?>';
            var change = amtPaid - totalprice; // Corrected variable name here
            $('#changeGiven').val(change.toFixed(2));
        });

        // Event handler for changing the quantity input
        $(document).on('input', '.quantity-input', function() {
            var $quantityInput = $(this);
            var tsid = $quantityInput.data('tsid'); // Get the transaction ID
            var originalQuantity = $quantityInput.data('original-quantity'); // Retrieve the original quantity from the data attribute
            var newQuantity = $quantityInput.val(); // Get the updated quantity
            var pricePerItem = parseFloat($quantityInput.data('price')); // Get the price per item from the data attribute

            // Check if the pricePerItem is a valid number
            if (!isNaN(pricePerItem)) {
                var totalPrice = newQuantity * pricePerItem; // Calculate the total price

                // Perform AJAX request to update quantity
                $.ajax({
                    type: "POST",
                    url: "ajaxscripts/queries/edit/sales.php",
                    data: {
                        tsid: tsid,
                        quantity: newQuantity
                    },
                    beforeSend: function() {
                        $.blockUI({
                            message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                        });
                    },
                    success: function(response) {
                        if (response === '0') {
                            // Quantity exceeded what is left.
                            alert("Quantity exceeded what is left.");

                            // Reverse the quantity back to the original value
                            $quantityInput.val(originalQuantity);

                            // Update the product price to its original value
                            $quantityInput.closest('tr').find('.total-price').text(originalQuantity * pricePerItem);

                            // Recalculate the total price for all products
                            updateTotalPrice();
                        } else {
                            // Update the new quantity in the input field
                            //alert('Quantity updated successfully.');

                            // Update the total price cell with the new calculated total price
                            $quantityInput.closest('tr').find('.total-price').text(totalPrice.toFixed(2));

                            // Recalculate the total price for all products
                            updateTotalPrice();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // Handle error
                        alert(xhr.status + " " + thrownError);
                    },
                    complete: function() {
                        $.unblockUI();
                    },
                });
            } else {
                console.log('Price Per Item is NaN');
            }
        });

        // Function to update the total price for all products
        function updateTotalPrice() {
            var total = 0;
            $('.total-price').each(function() {
                total += parseFloat($(this).text());
            });
            $('#totalSumCell').text(total.toFixed(2)); // Update the total sum cell
        }
    });
</script>