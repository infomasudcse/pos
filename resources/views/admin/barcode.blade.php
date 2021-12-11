@extends('admin')



@section('content')

 



<div class="content">

  <div class="container-fluid">

    <div class="row">

    <div class="col-sm-12"><button type="button" onClick="return  print_this('receiptDiv') " class=" float-right btn btn-sm btn-default">Print</button></div>         

      <div class="col-lg-12">

        <div class="card card-primary card-outline">

             

          <div class="card-body" id="receiptDiv">



        <style type="text/css">

        .bb{background-color:green;}

        .cc{background-color:#eaeaea;}

        .box_barcode{float:left;background-color:#dadada;border:1px solid #fff; text-align:center;height:80px; width:140px;padding:10px 10px;}

        .float-left{float:left;}

        .small-font{font-size:8px;}

        .medium-font{font-size:10px;}

        .single-line{line-height: 90%;}

        

        </style>





        <?php
//   $num = '123456789012';
//   echo $num; 
//  echo 'I25';
//  echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($num, 'I25',1,20) . '" />';
//  echo 'C128';
//  echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($num, 'C128',1,20) . '" />';
//  echo 'C128A';
//  echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($num, 'C128A',1,20) . '" />';
//  echo 'C93';
//  echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($num, 'C93',1,20) . '" />';


// echo '<hr/>';

        $json = json_decode($inv->variation);

        $img =  '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($inv->sku,'C128',1,20) . '" alt="barcode"   />';  



        $str = '';

        for($j = 0; $j < count($json); $j++){

            $str .= $json[$j]->value.', ';             

        }

        ?>





        <div class="" id="" style="width:50%;">



          <table style="width:100%;" style="margin-left:2%;margin-top:2%;" cellpadding="1" border="0">

          <?php

          $price = Helper::toCurrency($inv->unit_price);



          echo "<tr>";



          for($i=1;$i<=$qty;$i++){

              echo "<td style='text-align:center;height:122px;'>"; 

              echo "<table  style='text-align:center;width:100%;line-height:13px;' cellpadding='0' border='0' >

                  <tr><td  style='padding-bottom:2px;font-size:16px;'>".ucwords($inv->name)."</td></tr>

                  <tr><td>".$img."</td></tr>

                  <tr><td class='' style='padding:0;margin:0;font-size:12px;'>".$inv->sku."</td></tr>

                  <tr><td style='padding:0;margin:0;font-size:15px;'>".$price." + ".$configs->default_tax_name." </td></tr>

                  <tr><td style='padding:0;margin:0;font-size:12px;'>".$str."</td></tr>

                  <tr><td class='' style='padding:0;margin:0;font-size:12px' >". $configs->business_name."</td></tr>

                 </table>";                    

              echo "</td>";

              if($i%2==0){

                echo "</tr><tr>";

               }                    

          }

         echo "</tr>";

       ?>





          </table>



        </div>

      </div>

    </div>



        </div>

      </div>

  </div>

</div>          



<script type="text/javascript">

  document.addEventListener('DOMContentLoaded', function() {

   print_this('receiptDiv');

}, false);



</script>



@endsection