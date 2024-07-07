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
                            <th>Action</th>
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
                                    <?php echo $resDetails['quantity']; ?>
                                </td>
                                <td class="total-price">
                                    <?php echo getProductPrice($resDetails['prodid']) * $resDetails['quantity']; ?>
                                </td>
                                <td>
                                    <a class="deletesalesbtn" title="Delete Sale" i_index=<?php echo $resDetails['tsid'] ?>>
                                        <span class="icon-wrapper cursor-pointer"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </span>
                                    </a>
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

<div id="form_div" class="mt-2">
    <form class="form form-horizontal">
        <div class="row">
            <div class="mb-1 col-md-4">
                <label class="form-label" for="amtPaid">Amount Paid</label>
                <input type="number" id="amtPaid" step="0.01" class="form-control" placeholder="Amount Paid" value="<?php echo $detailsArray[0]['amountpaid']; ?>" />
            </div>
           <!--  <div class="mb-1 col-md-4">
                <label class="form-label" for="changeGiven">Change Given</label>
                <input type="number" id="changeGiven" readonly step="0.01" class="form-control" placeholder="Change Given" value="<?php echo $detailsArray[0]['change']; ?>" />
            </div> -->
        </div>

    </form>
</div>


<script>
    $(document).ready(function() {


        //Delete product after icon click
        $(document).off('click', '.deletesalesbtn').on('click', '.deletesalesbtn', function() {
            var theindex = $(this).attr('i_index');
            var amtPaid = $("#amtPaid").val();
            var totalPrice = '<?php echo $totalPrice; ?>';
            //alert(theindex + " " + amtPaid + " " + totalPrice);

            $.confirm({
                title: 'Delete Sale!',
                content: 'Are you sure to continue?',
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
                        text: 'Yes, Delete it!',
                        btnClass: 'btn-blue',
                        action: function() {
                            $.ajax({
                                type: "POST",
                                url: "ajaxscripts/queries/delete/sale.php",
                                data: {
                                    i_index: theindex,
                                    amtPaid:amtPaid,
                                    totalPrice:totalPrice
                                },
                                dataType: "html",
                                success: function(text) {
                                    //alert(text);

                                    if (text == 2) {
                                        alert("Amount paid is not sufficient");
                                            $("#amtPaid").focus();
                                    }
                                    else {
                                        alert("The new change given is " + text);
                                        location.reload();
                                    }
                                },

                                complete: function() {},
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + " " + thrownError);
                                }
                            });
                        }
                    }
                }
            });

        });



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

                if (amtPaid - changeGiven != totalPrice) {
                    errorOccurred = true; // Set the error flag
                    error += 'Change given is incorrect. Re-enter amount paid \n';
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
                            if (successCounter === $('.quantity-input').length) {
                                // Display success message only once
                                $.notify("Updated successfully", "success");
                                location.reload();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            // Handle error
                            alert(xhr.status + " " + thrownError);
                        },
                        complete: function() {
                            // Recalculate the total price for all products
                            updateTotalPrice();
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