<?php include('includes/header.php') ?>

<style>
    body {
        overflow-x: hidden;
    }
</style>


<!-- BEGIN: Content-->

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body"><!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Select Transaction to edit</label>
                                    <div class=" col-lg-6 col-md-9 col-sm-12">
                                        <select id="saleTransaction" class="form-select form-control kt-select2" name="productCategory" required>
                                            <option value="">Select Transaction</option>
                                            <?php
                                            $getCat = $mysqli->query("SELECT DISTINCT(s.`newsaleid`), s.`salesid`,s.`customer`,s.`datetime` FROM tempsales t JOIN sales s ON t.`genid` = s.`newsaleid`");
                                            while ($resCat = $getCat->fetch_assoc()) {
                                                // Convert datetime to day, date, month, year, and time
                                                $dateTime = new DateTime($resCat['datetime']);
                                                $day = $dateTime->format('l'); // Day of the week (e.g., Monday)
                                                $date = $dateTime->format('jS F Y'); // Date (e.g., 9th May 2024)
                                                $time = $dateTime->format('h:i A'); // Time (e.g., 03:45 PM)
                                            ?>
                                                <option value="<?php echo $resCat['newsaleid'] ?>"><?php echo $resCat['customer'] . ' - ' . $day . ', ' . $date . ' at ' . $time ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div id="sales_table_div"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- Basic Horizontal form layout section end -->



        </div>
    </div>
</div>

<!-- END: Content-->


<?php include('includes/footer.php') ?>


<script>
    $("#saleTransaction").select2({
        placeholder: "Select Transaction"
    });


    $("#saleTransaction").change(function() {
        var saleTransaction = $("#saleTransaction").val();
        //alert(saleTransaction);
        $.ajax({
            type: "POST",
            url: "ajaxscripts/tables/editSalestable.php",
            beforeSend: function() {
                $.blockUI({
                    message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                });
            },
            data: {
                saleTransaction: saleTransaction
            },
            success: function(text) {
                $('#sales_table_div').html(text);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function() {
                $.unblockUI();
            },

        });
    });
</script>