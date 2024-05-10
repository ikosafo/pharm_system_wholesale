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
                <button type="button" id="customerSalesbtn" class="btn btn-warning me-1">Update Sales</button>
            </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        // Function to update the total price for all products
        function updateTotalPrice() {
            var total = 0;
            $('.total-price').each(function() {
                total += parseFloat($(this).text());
            });
            $('#totalSumCell').text(total.toFixed(2)); // Update the total sum cell
        }

        $('#amtPaid').keyup(function() {
            var totalPrice = 0;
            $('.total-price').each(function() {
                totalPrice += parseFloat($(this).text());
            });
            updateTotalPrice();
            var amtPaid = $('#amtPaid').val();
            var change = amtPaid - totalPrice; // Corrected variable name here
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



        // Event handler for clicking the "customerSalesbtn" button
        $('#customerSalesbtn').click(function() {
            var errorOccurred = false; // Flag to track if any error occurred
            var successCounter = 0; // Counter to track successful AJAX requests
            var error = '';

            // Loop through each row in the table
            $('.quantity-input').each(function() {
                var $quantityInput = $(this);
                var tsid = $quantityInput.data('tsid');
                var originalQuantity = $quantityInput.data('original-quantity');
                var newQuantity = $quantityInput.val();
                var pricePerItem = parseFloat($quantityInput.data('price'));
                var customerName = $("#customerName").val();
                var customerTel = $("#customerTel").val();
                var amtPaid = $("#amtPaid").val();
                var changeGiven = $("#changeGiven").val();

                // Update totalPrice with the latest value
                var totalPrice = 0;
                $('.total-price').each(function() {
                    totalPrice += parseFloat($(this).text());
                });

                // Check for errors related to amount paid
                if (totalPrice > amtPaid || changeGiven < 0) {
                    errorOccurred = true; // Set the error flag
                    error += 'Amount paid is insufficient \n';
                    $("#amtPaid").focus();
                }

                // Proceed with AJAX request only if there are no errors
                if (!errorOccurred) {
                    // Perform AJAX request to update quantity
                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/queries/edit/salesDetail.php",
                        data: {
                            tsid: tsid,
                            quantity: newQuantity,
                            pricePerItem: pricePerItem,
                            customerName: customerName,
                            customerTel: customerTel,
                            amtPaid: amtPaid,
                            changeGiven: changeGiven,
                            totalPrice: totalPrice // Pass the updated totalPrice
                        },
                        success: function(response) {
                            // Increment the success counter
                            successCounter++;

                            // Handle success response
                            alert('Updated successfully');
                            location.reload();
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            // Handle error
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            // Recalculate the total price for all products
                            updateTotalPrice();

                            // Check if all requests have been completed successfully
                            if (successCounter === $('.quantity-input').length) {
                                // Display success message only once
                                $.notify("Updated successfully", "success");
                            }
                        }
                    });
                }
            });

            // Display error message if any error occurred
            if (errorOccurred) {
                $.notify(error, "error");
            }
        });


    });
</script>