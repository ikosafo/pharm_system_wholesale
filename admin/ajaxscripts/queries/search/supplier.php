<?php
include ('../../../config.php');
include ('../../../functions.php');

$supplier = $_POST['supplier'];
if ($supplier == "Others") {
    $supplierid = 0;
}
else {
    $supplierid = $supplier;
}

$getproducts = $mysqli->query("select * from products where supplier = '$supplierid' AND STATUS IS NULL ORDER BY productname");

?>

                            <section id="datatable">
                
   
                                  <div class="row">
                                      <div class="col-12">
                                      <div class="card" style="height:400px;overflow-y:scroll;">
                                          <table class="table table-hover table-sm mt-2" id="table-data">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th width="20%">Product Name</th>
                                                    <th width="20%">Quantity</th>
                                                    <th width="15%">Expiry Date</th>
                                                    <th width="20%">Pricing</th>
                                                    <th width="20%">Variation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $count = 1;
                                                while ($resproducts = $getproducts->fetch_assoc()) {
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td> 
                                                            <?php echo getProductName($resproducts['prodid']); ?>
                                                        </td>
                                                        <td>
                                                            Sale: <?php echo $resproducts['quantitysale']; ?><br/>
                                                            Stock: <?php echo $resproducts['quantitystock']; ?><br/>
                                                            Threshold: <?php echo $resproducts['stockthreshold']; ?><br/>
                                                            SKU:<?php echo $resproducts['sku']; ?> <br/>
                                                            UPC/EAN/ISBN:<?php echo $resproducts['isbn']; ?>
                                                        </td>
                                                        <td><?php echo $resproducts['expirydate'] ?></td>
                                                        <td>
                                                            Supplier: <?php echo getSupplierName($resproducts['supplier']); ?> <br/>
                                                            Cost Price: <?php echo $resproducts['costprice']; ?> <br/>
                                                            Selling Price: <?php echo $resproducts['sellingprice']; ?> <br/>
                                                            Wholesale Price: <?php echo $resproducts['sellingpricewhole']; ?> <br/>
                                                        </td>
                                                        <td>
                                                            Category: <?php echo categoryName($resproducts['category']); ?> <br/>
                                                            <?php echo variationName($resproducts['variation1']) ?>: <?php echo $resproducts['variation1spec'] ?> <br/>
                                                            <?php echo variationName($resproducts['variation2']) ?>: <?php echo $resproducts['variation2spec'] ?> <br/>
                                                            <?php echo variationName($resproducts['variation3']) ?>: <?php echo $resproducts['variation3spec'] ?> <br/>

                                                        </td>
                                                        
                                                    </tr>

                                                <?php  $count++; }?>
                                               
                                               
                                            </tbody>
                                          </table>
                                          
                                      </div>
                                      </div>
                                  </div>
    
                       </section>