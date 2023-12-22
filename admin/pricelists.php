<?php include('includes/header.php');
include('functions.php');
?>


<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">

                <div class="row match-height">
                    <div class="card card-apply-job">
                        <div class="card-body">

                        </div>
                    </div>
                </div>

            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>
</div>
<!-- END: Content-->


<?php include('includes/footer.php') ?>

<script>
    $("#viewlogs").click(function() {
        window.location.href = "/userlogs";
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        setInterval(runningTime, 1000);
    });

    function runningTime() {
        $.ajax({
            url: 'indextimeScript.php',
            success: function(data) {
                $('#runningTime').html(data);
            },
        });
    }
</script>