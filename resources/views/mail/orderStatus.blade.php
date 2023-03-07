<html lang="en" class="no-js"><head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title> The Chef </title>
      <link rel="shortcut icon" type="image/png" href="{{asset('assets/media/fav-icon.png')}}">
      <meta name="description" content="">
      <meta name="keywords" content=" ">
      <meta name="author" content="TNM Online Solutions">
      <meta property="og:image" content="">
      <meta property="og:site_name" content="">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
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
                     <tbody>
                        <tr style="width: 100%;">
                           <td style="width:100%;float: left;">
                              <table width="100%" cellpadding="5" border="0" style="border: none;">
                                 <tbody>
                                    <tr style="width: 100%">
                                       <!--<th style="">-->
                                       <!--   <img src="{{asset('assets/media/mail/chef.jpg')}}" style="width:200px;"> -->
                                       <!--</th>-->
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
            <tr style="width: 100%;">
               <td style="width: 100%;">
                  <table border="0" cellpadding="0" style="width: 100%;border: solid 1px transparent;font-family: 'Roboto', sans-serif;">
                     <tbody>
                        <tr style="width: 100%;">
                           <td style="width:100%;float: left;">
                              <table width="100%" cellpadding="5" border="0" style="border: none;">
                                 <tbody>
                                

                                      <tr style="width: 100%">
                                       <th style="font-size:19px;line-height: 28px;font-weight: 600;color: #000;padding: 5px 0px;text-align:center;">Hi  {{ ucfirst($order->customer->name) }},Your Order Status Has Been Changed</th>
                                    </tr>
                                    <tr style="width: 100%">
                                     
                                       <th style="font-size:14px;line-height: 25px;font-weight:400;color:#504848;padding: 5px 0px;text-align:center;">
                                            Status: {{  $order->histories[0]->status->name}}<br>
                                            Comment:{{  $order->histories[0]->comment}}</th>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
           
          <tr style="width: 100%;height: 30px;"></tr>
            <tr><td style="width:100%;float: left;">
               <table class="table" border="1" cellpadding="5" cellspacing="0" style="width: 100%;float: left; border: none;;font-family: 'Roboto', sans-serif;">
                  <tbody>
                                        
                  </tbody>
               </table>
            </td></tr>     
            <tr style="width: 100%;height: 35px;"></tr>
            <tr><td style="width:100%;float: left;background-color: #2f3f4e;">
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