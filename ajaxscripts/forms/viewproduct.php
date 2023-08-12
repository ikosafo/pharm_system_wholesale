<?php
include ('../../config.php');
include ('../../functions.php');
$theid = $_POST['id_index'];
$getdetails = $mysqli->query("select * from products where prodid = '$theid'");
$resdetails = $getdetails->fetch_assoc();

?>

<div class="card">
        <div class="card-body">
          
          <h4 class="fw-bolder border-bottom pb-50 mb-1">View Details</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Product Name:</span>
                            <span><?php echo $resdetails['productname']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Quantity (For Sale):</span>
                            <span><?php echo $resdetails['quantitysale']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Quantity (In Stock):</span>
                            <span><?php echo $resdetails['quantitystock']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Low stock threshold:</span>
                            <span><?php echo $resdetails['stockthreshold']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Stock Keeping Unit:</span>
                            <span><?php echo $resdetails['sku']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Supplier:</span>
                            <span><?php echo supplierName($resdetails['supplier']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Expiry Date:</span>
                            <span><?php echo $resdetails['expirydate']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">UPC/EAN/ISBN:</span>
                            <span><?php echo $resdetails['isbn']; ?></span>
                        </li>
                    </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Category:</span>
                            <span><?php echo categoryName($resdetails['category']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Subcategory:</span>
                            <span><?php echo subcategoryName($resdetails['subcategory']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Variation 1:</span>
                            <span><?php echo variationName($resdetails['variation1']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Specify Variation 1:</span>
                            <span><?php echo $resdetails['variation1spec']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Variation 2:</span>
                            <span><?php echo variationName($resdetails['variation2']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Specify Variation 2:</span>
                            <span><?php echo $resdetails['variation2spec']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Variation 3:</span>
                            <span><?php echo variationName($resdetails['variation3']); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Specify Variation 3:</span>
                            <span><?php echo $resdetails['variation3spec']; ?></span>
                        </li>
                    </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Cost Price:</span>
                            <span><?php echo $resdetails['costprice']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Selling Price:</span>
                            <span><?php echo $resdetails['sellingprice']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Selling Price (Wholesale):</span>
                            <span><?php echo $resdetails['sellingpricewhole']; ?></span>
                        </li>
                    </ul>
                </div>
              </div>
             
             
            </div>
            <div class="row">
		        <div class="col-sm-12 offset-sm-12">
                    <button type="button" id="backtoproducts" class="btn btn-outline-primary waves-effect">Back to products</button>
                </div>
			</div>
          
        </div>
      </div>


<script>
 $("#backtoproducts").click(function(){
        window.location.href="/viewproducts";
    });
</script>