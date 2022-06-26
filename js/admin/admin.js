  $(".add_more").click(function (e) {
  
    e.preventDefault;
    var html=disabled=itqty="";
    html+=`<tr class="formrow">`;
    if($(this).hasClass('generateinvoice'))
    {
      itqty='itemqty';
      disabled='disabled';
      var itemlist=$('.itemname').html();
      html+=`<td><select class="form-control itemname" id="exampleFormControlSelect1" name="name[]">
      `+itemlist+`
      </select></td>`;

    }
    else
    {
      html+=`<td> <input type="text" class="form-control" placeholder="Name" name="name[]" value="" required></td>`;
    }
    html += `
    <td><input type="number" class="form-control itqty `+itqty+`" placeholder="Qty" name="quantity[]" value="0" required step="1"></td>
    <td><input type="number" class="form-control itprice" placeholder="Unit Price" `+disabled+` name="price[]" value="0.00" required step="0.01"></td>
    <td><input type="number" class="form-control ittax" placeholder="Tax" name="tax[]" `+disabled+` value="0" required step="0.01"></td>`;
    if($(this).hasClass('generateinvoice'))
    {
      html+=`<td><input type="number" disabled class="form-control linetot" placeholder="Total" name="total[]" value="0.00" required></td>`
    }
    html+=`
    <td>
   <input
   type="button"
   id="removebtn"
   name="add"
   value="-"
   class=" p-1 form-control text-white remove" style="max-width: 40px; background-color:pink"
   />
   </td></tr>`;
  $(".repeat_field").append(html);
  
  });

  $(".repeat_field").on('click', '.remove', function (e) {
    e.preventDefault;
      $(this).closest('.formrow').remove();
  });

  $('.repeat_field').on('keyup','.itemqty',function(e){

    e.preventDefault();
    var html="";
    var data={itemid:$(this).closest('tr').find('.itemname :selected').val(),qty:$(this).val()};
    var itemname=$(this).closest('tr').find('.itemname :selected').val();
    var elemthis=$(this);
    var qty=$(this).val();
    if(itemname)
    {
    if(qty)
    {
    ajaxcall1(data,'get-item-details',function(data){
      var data=JSON.parse(data);
      if(data.status)
      {
        var tot=parseFloat(qty)* parseFloat(data.itemdetails.price);
        var taxval=parseFloat(tot) * (parseFloat(data.itemdetails.tax)/100);
        elemthis.closest('tr').find('.itprice').val(parseFloat(data.itemdetails.price).toFixed(2));
        elemthis.closest('tr').find('.ittax').val(data.itemdetails.tax);
        elemthis.closest('tr').find('.linetot').val((tot+taxval).toFixed(2));
        elemthis.closest('tr').find('.lineacttot').val(tot);
        calculations();
      }
      else
      {
        swal('Not Available','Please Check Stock First','info');
      }

    });
  }
  else
  {
    $(this).closest('tr').find('.itprice').val('0.00');
    $(this).closest('tr').find('.ittax').val(0);
    $(this).closest('tr').find('.linetot').val('0.00');
    $(this).closest('tr').find('.lineacttot').val('0.00');
    $('#subwithtax').val('0.00');
    $('#subtotal').val('0.00');
    $('#grand_total').val('0.00');
  }
 }
 else
 {
  swal('Please Choose an Item First');
  $(this).val("");
 }


  });
  
  function calculations()
  {
    var subwithtax=0.00;
    $('.linetot').each(function(){
      subwithtax += parseFloat(this.value);
    });
    $('#subwithtax').val(subwithtax.toFixed(2));
    var subtotal=0.00;
    $('.lineacttot').each(function(){
      subtotal += parseFloat(this.value);
    });
    $('#subtotal').val(subtotal.toFixed(2));
    calcGrandTotal();
  }
  
  $(".repeat_field").on('keyup', '.itqty,.itprice,.ittax', function (e) {
    e.preventDefault();
    if($(this).val()){
      var arr = new Array(0,1,5,10);
      if($(this).hasClass('ittax'))
      {
        if ($.inArray(parseFloat($(this).val()), arr) != -1)
        {
          var tot=parseFloat($(this).closest('tr').find('.itqty').val())* parseFloat($(this).closest('tr').find('.itprice').val());
          var taxval=parseFloat(tot) * (parseFloat($(this).closest('tr').find('.ittax').val())/100);
          $(this).closest('tr').find('.linetot').val((tot+taxval).toFixed(2));
        }
        else
        {
          swal("Please enter valid tax value(eg:0,1,5,10)");
        }
      }
      else{
          var tot=parseFloat($(this).closest('tr').find('.itqty').val())* parseFloat($(this).closest('tr').find('.itprice').val());
          var taxval=parseFloat(tot) * (parseFloat($(this).closest('tr').find('.ittax').val())/100);
          $(this).closest('tr').find('.linetot').val((tot+taxval).toFixed(2));
      }
    
    }
    else
    {
      $(this).closest('tr').find('.linetot').val(0.00);
      $(this).closest('tr').find('.lineacttot').val(0.00);
    }
    });

    $('#additem').submit(function(e){
      e.preventDefault();
      var data=new FormData(this);
      ajaxcall(data,'add-item',function(data)
      {
        swaltext(data);
      });
    });

    $('#disctype').change(function(e){
      if($('.discount').val())
      {
      calcGrandTotal();
      }
    })
    $(".discount").on('keyup',function(e){
      if($('.discount').val())
      {
      calcGrandTotal();
      }
    });

   
    function calcGrandTotal()
    {
      var discount=0;
      var subwithtax = 0.00;
      
      discount=parseFloat($('.discount').val());
      subwithtax= parseFloat($('#subwithtax').val());

      if($('#disctype').is(':checked'))
      {
        $('#grand_total').val((subwithtax-(subwithtax * discount/100)).toFixed(2));
      }
      else
      {
      $('#grand_total').val(((subwithtax)-discount).toFixed(2));
      }

    }

    $('#generateinvoice').submit(function(e){
      e.preventDefault();
      var data=new FormData(this);
      ajaxcall(data,'generate-invoice-print',function(data)
      {
        $('#section-to-print').html(data);
        window.print();
        $('#section-to-print').html("");
      });
    })





    function ajaxcall(formElem,ajaxurl,handle)
    {
      $.ajax({
        url: base_url+ajaxurl,
        type: 'POST',
        data:formElem,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(data) {
          handle(data);
        }
    });
    }

    function ajaxcall1(data,ajaxurl,handle)
    {
    $.ajax({
      url: base_url+ajaxurl,
      type: 'POST',
      data:data,
      datatype:'json',
      success: function(data) {
        handle(data);
      }
      });
    }

    function swaltext(data)
    {
      var data=JSON.parse(data);
      swal(data.title,data.msg,data.status);
      if(data.redirect){window.location.href=base_url+data.redirect}
    }


