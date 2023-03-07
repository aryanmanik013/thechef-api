@extends('admin.layouts.app')
@section('content')
<div class="container">
<div class="kt-portlet kt-portlet--tabs">
   <div class="kt-portlet__head" style="border-bottom:none;">
      <div class="kt-portlet__head-label" style="margin-top:3px;">
         <span class="kt-portlet__head-icon" style="margin-top:4px;margin-right:4px;float:left;">
         <i class="kt-font-brand flaticon2-tools-and-utensils" style="font-size: 20px"></i>
         </span>
         <h3 class="kt-portlet__head-title" style="">
            Invoice 
         </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    					<a href="" class="btn btn-brand btn-icon-sm print_in">
					<i class="la la-print"></i>
                       Print
                    </a>
                                    </div>
    </div>
   </div>
   
</div>
<!--Begin:: Portlet-->
<div class="">
				<div class="panel_6">

	              <div class="user_invoice_area" style="width: 100%;float: left;padding:30px 15px;position: relative;background: #fff;box-shadow: 0 0 5px rgba(0,0,0,0.15);-moz-box-shadow: 0 0 5px rgba(0,0,0,0.15);-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.15);">

	                    <div id="invoice-template" class="card-body" style="width: 100%;float: left;padding: 0;-ms-flex: 1 1 auto;flex: 1 1 auto;text-align: center;">

	                      <table border="0" style="width: 100%;display:inline;border: solid 1px #fff;">
	                        <tbody>
					<tr>
					<td style="width:20%;vertical-align: middle;">
                          <img src="{{asset('assets/media/logos/logo1.png')}}" style="width: 115px;height: auto;display: block;margin: 0 20px 0 0;">
                        </td>
                        </tr>
	                          <tr style="width: 100%;">
	                            <td style="width: 100%;">
	                              <table border="0" width="100%" style="border: none;">
	                                <tbody><tr style="width: 100%;">
	                                  <td style="width: 50%">
	                                    <table border="0" style="width: 100%;float: left;text-align: left;border-color: #000;margin: 0 0 20px;">
	                                      <tbody><tr style="width: 100%">
	                                        
	                                        <td style="width:50%;vertical-align: middle;">
	                                          <p style="width: 100%;font-size: 12px; line-height: 18px;font-weight: 500;color: #272727;font-family: 'Roboto', sans-serif !important;">Thechef<br>
                                        Electra Street,
                                        Near Honda Swowroom,<br>ABU DHABI Abu Dhabi, U.A.E ,P.O.Box: 41775<br>Ph:02 633 2302</p>
	                                        </td>
	                                      </tr>
	                                    </tbody></table>
	                                  </td>
	                                  <td style="width: 50%;">
	                                    <table border="0" style="width: 100%;float: left;text-align: right;margin: 0 0 20px;border: none;">
	                                      <tbody><tr style="width: 100%">
	                                        <td style="width:100%;vertical-align: middle;">
	                                          <h2 style="width: 100%;font-size: 22px;line-height: 30px;font-weight: 600;color: #c3332e;text-transform: uppercase;font-family: 'Roboto', sans-serif !important;">Invoice</h2>
	                                          <p style="width: 100%;font-size: 12px; line-height: 18px;font-weight: 500;color: #272727;font-family: 'Roboto', sans-serif !important;">Invoice No.: {{$order->invoice_prefix.$order->id }}<br>{{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}
	                                        
	                                          </p>
	                                          
	                                        </td>
	                                      </tr>
	                                    </tbody></table>
	                                  </td>
	                                </tr>
	                              </tbody></table>
	                              
	                            </td>                            
	                          </tr>


	                          <tr style="width: 100%;height: 10px;">
	                            <td style="width: 100%;border-top: solid 1px #d4d4d4;">
	                            </td>
	                          </tr>

	                          <tr style="width: 100%;">
	                            <td style="width: 100%;">
	                              <table border="0" style="width: 100%;float: left;text-align: left;border: none;">
	                                <tbody><tr style="width: 100%">
	                                  <td style="width:50%;vertical-align: middle;">
	                                    <p style="width: 100%;font-size: 12px; line-height: 18px;font-weight: 500;color: #272727;text-align: left;font-family: 'Roboto', sans-serif !important;">
	                                     <strong>Billing Address</strong><br>
	                                   {{ $order->shipping_name}}<br>{{ $order->shipping_address_1}},{{ $order->shipping_address_2}} <br>
                                            {{ !empty($order->shipping_city)?$order->shipping_city.',':''}}{{ !empty($order->shipping_landmark)?$order->shipping_landmark.',':''}}<br>
                                                 {{(!empty($order->shipping_state_id)) ? $order->state->name.',' : ''}} {{(!empty($order->shipping_country_id)) ? $order->country->name : ''}} {{ (!empty($order->shipping_postcode)) ? '-'.$order->shipping_postcode :''}}
	                                      <br><strong>Ph:</strong> {{ !empty($order->shipping_phone) ? $order->shipping_phone : $order->phone }} </p>
	                                  </td>
	                                  <td style="width:50%;vertical-align: middle;">
	                                    <p style="width: 100%;font-size: 12px; line-height: 20px;font-weight: 500;color: #272727;text-align: right;font-family: 'Roboto', sans-serif !important;">
	                                    	<strong>Delivering Address</strong><br>
	                                  {{ $order->shipping_name}}<br>{{ $order->shipping_address_1}},{{ $order->shipping_address_2}} <br>
                                            {{ !empty($order->shipping_city)?$order->shipping_city.',':''}}{{ !empty($order->shipping_landmark)?$order->shipping_landmark.',':''}}<br>
                                                 {{(!empty($order->shipping_state_id)) ? $order->state->name.',' : ''}} {{(!empty($order->shipping_country_id)) ? $order->country->name : ''}} {{ (!empty($order->shipping_postcode)) ? '-'.$order->shipping_postcode :''}}
	                                      <br><strong>Ph:</strong> {{ !empty($order->shipping_phone) ? $order->shipping_phone : $order->phone }} </p>
	                                  </td>
	                                </tr>
	                              </tbody></table>
	                            </td>
	                          </tr>

	                          <tr style="width: 100%;height: 40px;"></tr>


	                          <tr style="width: 100%;">
	                            <td style="width: 100%">
	                              <table class="table" border="1" cellpadding="5" cellspacing="0" style="width: 100%;float: left;border-bottom: solid 1px #d4d4d4 !important;font-family: 'Roboto', sans-serif !important;">
	                                <tbody><tr style="width: 100%;border-top: solid 1px #c1c1c1;">
	                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #272727;text-align: left;">#</th>
	                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #272727;text-align: left;">Product(s).</th>
	                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #272727;text-align: left;">Quantity</th>
	                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #272727;text-align: left;">Unit Price</th>
	                                   	                                  
	                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #272727;text-align: left;">Total</th>
	                                </tr>

	                     	    @php $i=1; @endphp
	                                @foreach($foods as $food)
	                                <tr style="width: 100%;background: #f4f4f4;">
	                                  <td style="font-size: 12px;line-height: 20px;font-weight: 500;color: #454545;">{{$i++}}</td>
	                                  <td style="font-size: 12px;line-height: 20px;font-weight: 500;color: #454545;">{{$food->name}} 
	                       			  
                                            
                                        </td>
                                        <td style="font-size: 12px;line-height: 20px;font-weight: 500;color: #454545;">{{$food->quantity}}</td>
	                                  <td style="font-size: 12px;line-height: 20px;font-weight: 500;color: #454545;">{{number_format($food->price,2)}}</td>
	                          
	                                 
	                                  <td style="font-size: 12px;line-height: 20px;font-weight: 500;color: #454545;">{{number_format($food->total,2)}}</td>
	                                </tr>
	                                @endforeach
	                                	                                
	                              </tbody></table>
	                            </td>
	                          </tr>


	                          <tr style="width: 100%;height: 20px;"></tr>


	                          <tr style="width: 100%;">
	                            <td style="width: 100%;">
	                              <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif !important;">
	                                <tbody><tr style="width: 100%;">
	                                  <td style="width: 45%;float: left;">
	                                    <table width="100%" cellpadding="5" border="0" style="border: none;">
	                                      <tbody><tr style="width: 100%">
	                                        <th style="font-size: 14px;line-height: 25px;font-weight: 600;color: #272727;padding: 5px 0px;text-align: left;">Payment Methods: {{ strtoupper($order->payment_method) }} </th>
	                                      </tr>
										</tbody></table>
	                                  </td>
	                                  
	                                  <td style="width: 35%;float: right;">
	                                    <table width="100%" cellpadding="5">
	                                      <tbody>
	                                      <tr style="width: 100%">
	                                        <th style="width: 100%;font-size: 14px;line-height: 25px;font-weight: 600;color: #272727;padding: 5px 5px;text-align: left;">Total Due</th>
	                                      </tr>
									      @foreach($ordertotal as $total)
	                                      <tr style="width: 100%;border-bottom: solid 1px #d4d4d4;">
	                                        <th style="width: 100%;text-align: left;font-size: 11px;line-height: 20px;font-weight: 600;color: #585858;padding: 5px;border-bottom: solid 1px #d4d4d4;">{{$total->title}}<span style="float: right;font-size: 11px;line-height: 20px;font-weight: 500;color: #585858;">Rs.{{number_format($total->value,2)}}</span></th>
	                                      </tr>
	                                      @endforeach
							

	                                      	                                    
	                                    </tbody></table>
	                                  </td>
	                                </tr>
	                              </tbody></table>
	                            </td>
	                          </tr>

	                          <tr style="width: 100%;height: 20px;"></tr>

	                          <tr style="width: 100%;">
	                            <td style="width: 100%;">
	                              <table border="0" style="width: 100%;">
	                                <tbody><tr style="width: 100%;">
	                                  <td style="width: 70%;vertical-align: bottom;">
	                                    <p style="width: 70%;font-size: 11px;line-height: 20px;font-weight: 400;color: #585858;text-align: justify;font-family: 'Roboto', sans-serif !important;"><strong style="line-height: 25px;font-size: 12px;font-weight: 500;">Terms &amp; Condition</strong><br>You know, being a test pilot isn't always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.</p>
	                                  </td>
	                                  <td style="width: 30%;">
	                                    <h4 style="width: 100%;text-align: center;font-size: 14px;line-height: 25px;font-weight: 500;color: #272727;font-family: 'Roboto', sans-serif !important;">Authorized person</h4>
	                                    <div style="width: 100%;height: 50px;float: left;"></div>
	                                    <p style="width: 100%;text-align: center;font-size: 13px;line-height: 20px;font-weight: 500;color: #585858;font-family: 'Roboto', sans-serif !important;">Thechef</p>

	                                  </td>
	                                </tr>
	                              </tbody></table>
	                            </td>
	                          </tr>

	                        </tbody>
	                      </table>
	                    </div>
	                </div>

		        </div>


</div></div>
@endsection

@push('scripts')
 
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
 
<script type="text/javascript">
   $(document).ready(function() {
       function printData() {
           var divToPrint = document.getElementById("invoice-template");
           newWin = window.open("");
           newWin.document.write(divToPrint.outerHTML);
           newWin.print();
           newWin.close();
       }
       $('.print_in').on('click', function() {
           printData();
       });
   });
</script>
	@endpush