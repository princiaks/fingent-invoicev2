<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
        $data = array();

		$this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->database();
        $this->load->model('admin_model');	 
		
     }

     public function index()
     {
	
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
		
     }
	
	 // For Listing Items
	 public function item_list()
	 {
		$data=array();
		$table_name='tbl_item_details';
		$columns='id,name';
		$data['itemlist']=$this->admin_model->get_lists($table_name,$columns);
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/generate-invoice',$data);
		$this->load->view('admin/footer');

	 }

	 // For Adding Items To Database
	 public function add_products()
	 {
		 $data=array();
		 $products=$this->input->post();
		 for($i=0;$i<count($products['name']);$i++)
		 {
			 $data[$i]['name']=$products['name'][$i];
			 $data[$i]['quantity']=$products['quantity'][$i];
			 $data[$i]['price']=$products['price'][$i];
			 $data[$i]['tax']=$products['tax'][$i];
		 }
		 $result=$this->admin_model->add_products($data);
		 $response=array('success'=>$result,'status'=>'error','title'=>'Failed!!','msg'=>'Adding Item(s) Failed','redirect'=>'');
		 if($result)
		 $response=array('success'=>$result,'status'=>'success','title'=>'Success!!','msg'=>'Item(s) Added Successfully','redirect'=>'adminpanel');
		 echo json_encode($response);
	 }

	 public function get_item_details()
	 {
		$id=$this->input->post('itemid');
		$qty=$this->input->post('qty');
		$where=" quantity >=".$qty;
		$itemdetails=$this->admin_model->get_single_item_withid('*',$id,'tbl_item_details',$where);
		if($itemdetails)
		{
			echo json_encode(array('status'=>1,'itemdetails'=>$itemdetails));
		}
		else
		{
			echo json_encode(array('status'=>0));
		}

	 }

	 public function generate_invoice()
	 {
		$data=array();
		$html="";
		$products=$this->input->post();
		for($i=0;$i<count($products['name']);$i++)
		{
			$data[$i]['name']=$this->admin_model->get_single_item_withid('name',$products['name'][$i],'tbl_item_details')->name;
			$data[$i]['quantity']=$products['quantity'][$i];
			$this->admin_model->update_item_quantity($products['name'][$i],$products['quantity'][$i]);
			$data[$i]['price']=$products['price'][$i];
			$data[$i]['tax']=$products['tax'][$i];
			$data[$i]['actualtotal']=floatval($products['quantity'][$i]*$products['price'][$i]);
			$tax=  floatval($data[$i]['actualtotal']*$data[$i]['tax']/100);
			$data[$i]['taxvalue']=$tax;
			$data[$i]['total']= floatval($data[$i]['actualtotal']+$tax);  
		}
		$today=date('d-m-Y',strtotime('now'));
		$invoiceno=rand(1,10000);
		$disctype=" $";
		if($this->input->post('disctype'))
		{
			$disctype=" %";
		}
		$subtotal=$this->input->post('subtotal');
		$subwithtax=$this->input->post('subwithtax');
		$discount=$this->input->post('discount');
		$grand_total=$this->input->post('grand_total');
		$html.='
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
					  <small class="float-right">Date: '.$today.'</small>
					</h4>
				  </div>
				  <!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
				  <!-- /.col -->
				  <div class="col-sm-4 invoice-col">
					<b>Invoice No #'.$invoiceno.'</b><br>
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
					  <tbody>';
					  $i=1;
					  if($data)
					  {
					  foreach($data as $detail)
					  {
						$html.='<tr>
						<td>'.$i.'</td>
						<td>'.$detail['name'].'</td>
						<td>'. $detail['quantity'].'</td>
						<td>$'.number_format($detail['price'],2).'</td>
						<td>'.number_format($detail['taxvalue'],2).'('.$detail['tax'].' % )</td>
						<td>$'.number_format($detail['total'],2).'</td>
					 
					 </tr> ';
						$i++;
					  } 
					}
					else{
						$html.='<tr><td>Items List Not Available</td></tr>';
					}
					$html.='</tbody>
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
						  <td>$'.number_format($subtotal,2).'</td>
						</tr>
						<tr>
						  <th>Discount</th>
						  <td>'.$discount.$disctype.'</td>
						</tr>
						<tr>
						  <th>Subtotal(Incl.Tax):</th>
						  <td>$'.number_format($subwithtax,2).'</td>
						</tr>
						<tr>
						  <th>Grand Total:</th>
						  <td>$'.number_format($grand_total,2).'</td>
						</tr>
					  </table>
					</div>
				  </div>
				  <!-- /.col -->
				</div>
				<!-- /.row -->
  
				<!-- this row will not appear when printing -->
			
			  </div>
			  <!-- /.invoice -->
			</div><!-- /.col -->
		  </div><!-- /.row -->
		</div><!-- /.container-fluid -->
	  </section>
		';
		echo $html;

	 }
	
}
