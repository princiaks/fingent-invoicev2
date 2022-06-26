

 <style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
@media print {
  /* style sheet for print goes here */
  .noprint {
    visibility: hidden;
  }
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper m-4 p-3">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <a href="<?php echo site_url('adminpanel')?>" class="noprint pb-2">
            <svg class="bi bi-arrow-left text-dark" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
            </svg>Back to Home</a>
            <h1>Invoice</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> FINGENT GLOBAL SOLUTIONS.
                    <small class="float-right">Date: <?php echo date('d-m-Y',strtotime('now'));?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice No #<?php echo rand(1,10000);?></b><br>
                  <br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>SL No.</th>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Unit Price($)</th>
                      <th>Tax</th>
                      <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $subtotal=$subwithtax=$grandtotal=$discount=0;
                    if(isset($itemlist))
                    if($itemlist)
                                {
                                   $i=1;
                                 
                                   foreach($itemlist as $detail)
                                   {
                                    $subtotal+=$detail->actualtotal;
                                    $subwithtax+=$detail->total;
                                   ?>
                                 <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $detail->name;?></td>
                                    <td><?php echo $detail->quantity?></td>
                                    <td>$<?php echo number_format($detail->price,2);?></td>
                                    <td><?php echo number_format($detail->taxvalue,2)."(".$detail->tax." % )";?></td>
                                    <td>$<?php echo number_format($detail->total,2);?></td>
                                 
                                 </tr> 
                                 <?php $i++; } }
                                 else
                                 {
                                    ?>
                                    <tr><td>Items List Not Available</td></tr>
                                    <?php
                                 }?>
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                 
                </div>
                <!-- /.col -->
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$<?php echo number_format($subtotal,2)?></td>
                      </tr>
                      <tr>
                        <th>Discount</th>
                        <td><input type="number" id="discount" class="discount" style="border:none;width:50px" name="discount" value="0" step="0.01"><input type="checkbox" style="" data-toggle="switchbutton" checked data-size="sm" data-onstyle="secondary" data-offstyle="secondary" data-onlabel="%" data-offlabel="$" id="disctype"></td>
                      </tr>
                      <tr>
                        <th>Subtotal(Incl.Tax):</th>
                        <td>$<?php echo number_format($subwithtax,2)?></td>
                      </tr>
                      <tr>
                        <th>Grand Total:</th>
                        <td class="grandtotal">$<?php echo number_format(($subwithtax)-$discount,2)?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                    <input type="hidden" id="subwithtax" class="subwithtax" value="<?php echo $subwithtax;?>">
                  <button type="button" class="btn btn-success float-right noprint" onclick="window.print()"><i class="far fa-credit-card"></i> Generate Invoice
                  
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
