<html lang="en" class="no-js"><head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title> The Chef </title>

<link rel="shortcut icon" type="image/png" href="../img/favi-icon.png">
 <meta name="description" content="">
<meta name="keywords" content=" ">
<meta name="author" content="TNM Online Solutions">
<meta property="og:image" content="">
<meta property="og:site_name" content=" The Chef">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body style="background: aliceblue;     margin: 0px;">

<!--special-offer-section-->
  <table width="" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" class="MainContainer">
         <tbody style="display:inline-block;">
            <tr style="padding: 0px;width: 100%;background: #2f3f4e;">
               <td style="width: 100%;">
                  <table border="0" width="100%" style="border: none;">
                     <tbody><tr style="width: 100%;">
                        <td style="width: 50%">
                           <table border="0" style="width: 100%;float: left;text-align: left;border-color:;margin: 0 0 0px;">
                              <tbody><tr style="width: 100%">
                                 <td style="padding: 0px;width:20%;vertical-align: middle;">
                                    <img src="{{asset('assets/media/mail/bg1.png')}}" style="margin: auto;display: block;">
                                 </td>
                              </tr>
                           </tbody></table>
                        </td>
                     </tr>
                  </tbody></table>
                              
                            </td>                            
                          </tr>




                                 <tr style="width: 100%;">
                                                      <td style="width: 100%;">
                                                        <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif;">
                                                          <tbody><tr style="width: 100%;">





                          <td style="width:100%;float: left;">
                          <table width="100%" cellpadding="5" border="0" style="border: none;">
                          <tbody>
                          <tr style="width: 100%">
                          <th style="">
                          <img src="{{asset('assets/media/mail/success.png')}}" style="height:200px;
                              /* float: left; */
                            "> 
                          </th>
                          </tr>                                 
                          </tbody></table>
                          </td>
                          </tr>
                          </tbody></table>
                          </td>
                          </tr>
                      

                         

                        <tr style="width: 100%;">
                            <td style="width: 100%;">
                              <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif;">
                                <tbody><tr style="width: 100%;">





                                  <td style="width:100%;float: left;">
                                    <table width="100%" cellpadding="5" border="0" style="border: none;">
                                      <tbody>
                                        <tr style="width: 100%">
                                        <th style="font-size: 20px;line-height: 25px;font-weight: 600;color:#4f8a10;padding: 5px 0px;text-align:center;">Congratulations {{ ucfirst($order->customer->name) }} ! Your order at the kitchen {{ ucfirst($order->kitchen->name) }}  has been placed</th>
                                      </tr>

                                        <tr style="width: 100%">
                                        <th style="font-size:15px;line-height: 25px;font-weight:400;color:#504848;padding: 5px 0px;text-align:center;">Thank you for your order({{ $order->invoice_prefix . $order->id }}). <br> Your order details are as follows.</th>
                                      </tr>
                                @if($order->delivery_type==0)
                                @if($order->kitchen)
                                    <tr><th style="    width: 100%;    float: left;    text-align: center;"><a href="https://www.google.com/maps/search/?api=1&query={{$order->kitchen->latitude}},{{$order->kitchen->longitude}}" style="    padding: 10px;background: #2f3f4e;color: #fff;
                                    margin: 14px auto;    display: inline-block;    text-decoration: none;
                                    font-size: 14px;">Navigate to Pick Up</a></th></tr>
                                    @endif
                                @endif
                                     
                                      
                                    </tbody></table>
                                  </td>




                                 
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>





                        <tr style="width: 100%;height: 10px;">
                            <td style="width: 100%;">
                            </td>
                          </tr>


                            <tr style="width: 100%;height: 10px;">
                            <td style="width: 100%;">
                            </td>
                          </tr>

                       

                          <tr style="width: 100%;">
                            <td style="width: 100%">
                              <table class="table" border="1" cellpadding="5" cellspacing="0" style="width: 100%;float: left;border-bottom: solid 1px #2f3f4e !important;font-family: 'Roboto', sans-serif;">
                                <tbody><tr style="width: 100%;border-top: solid 1px #c1c1c1;">

                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #fff; text-align: left;     border: solid 1px #2f3f4e;     background: #2f3f4e"> </th>
                               
                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #fff; text-align: left;     border: solid 1px #2f3f4e;     background: #2f3f4e;">Food Name </th>
                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #fff;text-align: left;     border: solid 1px #2f3f4e;     background: #2f3f4e;">Qty  </th>
                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #fff;text-align: left;     border: solid 1px #2f3f4e;     background:#2f3f4e;">Unit Price </th>
                                  <th style="font-size: 13px;line-height: 20px;font-weight: 600;color: #fff;text-align: left;border: solid 1px #2f3f4e;background: #2f3f4e;">Subtotal </th>
                                </tr>

                  
                        
                     @if(!empty($order->food))
                        @foreach($order->food as $food)
                        <tr style="width: 100%;background: #f4f4f4;">
                         <td style="font-size: 14px;line-height: 20px;font-weight: 500;color: #454545;
                        text-align: center;"> 
                        <img style="width:60px; height:60px;" src="{{ !empty($food->food->getMedia('gallery')->first()) ?$food->food->getMedia('gallery')->first()->getUrl() : asset('assets/front/images/no-image.jpg') }}" alt="The Chef">
                        </td>
                        
                        
                        <td style="font-size: 14px;line-height: 20px;font-weight: 500;color: #454545; text-align: left;">
                        <a href="" style="font-size:14px;
                        font-weight:bold; color:#260b45; text-decoration:none;">{{$food->food->name}}</a>
                  
                        
                        
                        </td>
                        
                        <td style="font-size: 14px;line-height: 20px;font-weight: 500;color: #454545; text-align: left;"> {{$food->quantity}}</td>
                        <td style="font-size: 14px;line-height: 20px;font-weight: 500;color: #454545; text-align: left;">
                                                             {{ number_format($food->price,2)}}
                        </td>
                        
                        
                        <td style="font-size: 15px;line-height: 20px;font-weight: 500;color: #454545; text-align: left;">
                        <strong> {{ number_format($food->total,2)}}</strong>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      
 
                                                                       
                                                
                                               
                </tbody></table>
                </td>
                </tr>


                <tr style="width: 100%;height:20px;"></tr>









                <tr style="width: 100%;height:10px;"></tr>


                <!--payment Details-->   
                <tr style="width: 100%;     background: #2f3f4e">
                <td style="width: 100%;">
                <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif;">
                <tbody><tr style="width: 100%;">
                <td style="width: 100%;float: left;">
                <table width="100%" cellpadding="5" border="0" style="border: none;">
                <tbody><tr style="width: 100%">
                <th style="font-size: 15px;line-height: 30px;font-weight: 600;color: #ffffff;padding: 5px 0px;text-align: left;background:#2f3f4e;padding-left: 12px;">Payment Details</th>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody></table>
                </td>
                </tr>
                <!--payment Details--> 



                            
                            <tr style="width: 100%;">
                            <td style="width: 100%;">
                              <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif;">
                                <tbody><tr style="width: 100%;">
                            
                                  <td style="width: 45%;float: left;">
                                    <table width="100%" cellpadding="5" border="0" style="border: none;">
                                      <tbody>
                                  
                                    
                                      
                                    </tbody></table>
                                  </td>




                                        <td style="width: 40%;float: right;">
                                                    <table width="100%" cellpadding="5">
                                                      <tbody><tr style="width: 100%">
                                                        <th style="width: 100%;font-size: 14px;line-height: 25px;font-weight: 600;color:#2f3f4e;padding: 5px 5px;text-align: left;">Total Due</th>
                                                      </tr>
                                              @foreach($order->totals as $total)
                                      <tr style="width: 100%;border-bottom: solid 1px #d4d4d4;">
                                      @if($total->code=='total')

                                        <th style="width: 100%;text-align: left;font-size: 11px;line-height: 20px;font-weight: 700;color: #585858;padding: 5px;border-bottom: solid 1px #d4d4d4;">{{ $total->title }}<span style="float: right;font-size: 11px;line-height: 20px;font-weight: 700;color: #585858;">{{ number_format($total->value,2) }}</span></th>
                                        @else
                                           <th style="width: 100%;text-align: left;font-size: 11px;line-height: 20px;font-weight: 600;color: #585858;padding: 5px;border-bottom: solid 1px #d4d4d4;">{{ $total->title }}<span style="float: right;font-size: 11px;line-height: 20px;font-weight: 500;color: #585858;">{{ number_format($total->value,2) }}</span></th>

                                        @endif
                                      </tr>
                                     @endforeach
                                                    </tbody></table>
                                                  </td>
                                                </tr>
                                              </tbody></table>
                                            </td>
                                          </tr>





                <tr style="width: 100%;height: 30px;"></tr>


                <tr><td style="width:100%;float: left;">

                </td></tr>     

                 <tr style="width: 100%;height: 35px;"></tr>


                <tr><td style="width:100%;float: left;     background-color: #2f3f4e;">
                  <table class="table" border="1" cellpadding="5" cellspacing="0" style="
                                  width: 100%;
                                  float: left;
                                  border: none;
                                  font-family: 'Roboto', sans-serif;
                                  margin-top: 14px;
                                  background-color: #2f3f4e;
                                  margin-bottom: 14px;
                                  ">
                                  <tbody>
                                     <tr style="width: 100%;background: #2f3f4e;">
                                        <td style="font-size: 14px;line-height: 20px;font-weight: 400;color: #fff; text-align: center;     border: #fff;">
                                           <a href="" style="color:#fff; text-decoration:none; font-size: 13px; 
                                              padding-right:10px;">
                                           <img src="{{asset('assets/media/mail/fb.png')}}" style="position:relative; top:3px; margin-right:5px;"></a>
                                           <a href="" style="color:#fff; text-decoration:none; font-size:13px; padding-right:10px;">
                                           <img src="{{asset('assets/media/mail/inst.png')}}" style="position:relative; top:3px; margin-right:5px;"></a>
                                        </td>
                                     </tr>
                                     <tr style="width: 100%;height:10px;"></tr>
                                     <tr style="width: 100%;background: #2f3f4e;">
                                        <td style="font-size: 13px;line-height: 20px;font-weight: 400;color: #fff; text-align: center;     border: #fff;">
                                           Copyrights 2020 The Chef. All rights reserved 
                                        </td>
                                     </tr>
                                  </tbody>
                               </table>
                </td></tr>                           
                                 




                       

                       

                         

</tbody>
</table>






<!--special-offer-section-->






















  


   




</body></html>