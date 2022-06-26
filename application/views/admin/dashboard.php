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

</style>
<div id="content-page" class="content-page">
         <div class="container-fluid">
           <div class="row">
               <div class="col-md-12">
                  <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Add Items</h4>
                        </div>
                       
                     </div>
                     <form id="additem" method="POST" action="" data-form="ajaxform" enctype="multipart/form-data">
                     <div class="iq-card-body">
                        <div class="table-responsive">
                           <table class="table mb-0 table-borderless">
                             <thead>
                               <tr>
                                 <th scope="col">item Name</th>
                                 <th scope="col">Quantity</th>
                                 <th scope="col">Unit Price($)</th>
                                 <th scope="col">Tax</th>
                                 <th scope="col">Total</th>
                                 <th scope="col"></th>
                               </tr>
                             </thead>
                             <tbody class="repeat_field">
                               
                               <tr class="formrow">
                                
                                 <td> <input type="text" class="form-control" placeholder="Name" name="name[]" value="" required></td>
                                 <td><input type="number" class="form-control itqty" placeholder="Qty" name="quantity[]" value="0" required step="1"></td>
                                 <td><input type="number" class="form-control itprice" placeholder="Unit Price" name="price[]" value="0.00" required step="0.01"></td>
                                 <td><input type="number" class="form-control ittax" placeholder="Tax" name="tax[]" value="0" required step="0.01"></td>
                                 <td> <input type="button" name="add" value="+"class=" p-1 form-control text-white add_more" style="min-width: 45px; background-color:green"/></td>
                               </tr>
                             </tbody>
                           </table>
                        </div>
                        <!-- <br><br>
                        <table class="table mb-0 table-borderless">
                            <tbody class="totals">
                            <tr>
                                <td>Sub total</td>
                                <td><input type="number" id="subtotal" disabled value="0.00"></td>
                               </tr>
                               <tr>
                                <td>Discount</td>
                                <td><input type="number" id="discount" class="discount" name="discount" value="0" step="0.01"><input type="checkbox" style="" data-toggle="switchbutton" checked data-size="sm" data-onstyle="secondary" data-offstyle="secondary" data-onlabel="%" data-offlabel="$" id="disctype"></td>
                               </tr>
                               <tr>
                                <td>Sub total(Including tax)</td>
                                <td><input type="number" id="subwithtax" value="0.00" disabled></td>
                               </tr>
                               <tr>
                                <td>Grand Total</td>
                                <td><input type="number" id="grand_total" value="0.00" disabled></td>
                               </tr>
                            </tbody>
                        </table> -->
                             
                         
                         
						<div class="form-row" style="padding-top:50px;">
                     <div class="col text-right">
                     <button type="submit" class="btn btn-primary">Submit</button>
                              </div>


                           </div>
                           </div> 
                     </form>
                        
                  </div>
                     </div>
                    
               </div>
               
            </div>
        
         </div>