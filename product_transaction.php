<?php include_once "header.php"; ?>

<script>
    function calculate() { 
             var qty = document.getElementById("qty").value;
             var price = document.getElementById("price").value;
             var total = qty * price;
             
             var num = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        
              $('#total').val(num);
    } 
</script>

<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
		<div class="sub-title-text">
		  Beli
		</div>
	</div>
    
    <div class="row">
        <div style="height:20px;"></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form form-group">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td colspan="2"><b><?=v("product_name");?></b></td>
                                <td><b><?=v("seller");?></b></td>
                            </tr>
                            <tr>
                                <td style="width:100%;" colspan="2">
                                    <?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?>
                                </td>
                                <td style="width:100%;">
                                    <?=$db->fetch_single_data("goods","seller_id",["id"=>$_GET["id"]]);?>
                                </td>
                            </tr>
                            <tr style="height:20px;"></tr>
                            <tr>
                                <td style="width:45%;"><b><?=v("qty");?></b></td>
                                <td style="width:10%;"></td>
                                <td style="width:45%;"><b><?=v("price");?></b></td>
                            </tr>
                            <tr>
                                <td style="width:45%;">
                                    <input class="col-md-12 form-control" type="text" id="qty" onkeyup="calculate()">
                                </td>
                                <td style="width:10%;"></td>
                                <td style="width:45%;">
                                    <b>
                                        <input type="hidden" id="price" value="<?=$db->fetch_single_data("goods","price",["id"=>$_GET["id"]])?>" onkeyup="calculate()">
                                        Rp<?=number_format($db->fetch_single_data("goods","price",["id"=>$_GET["id"]]))?>
                                    </b>
                                </td>
                            </tr>
                            <tr style="height:20px;"></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td><b><?=v("promo_code");?></b></td>
                            </tr>
                            <tr>
                                <td>
                                    <input class="col-md-12 form-control" type="text">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="height:20px;"></div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" style="background-color:#eaeaea;">
                                <?php
                                //echo $_SESSION["user_id"];
                                
                                $addresses = $db->fetch_all_data("user_addresses",[], "user_id = '".$_SESSION["user_id"]."'");
                                foreach($addresses as $address){
                                    //$_default_buyer = $address["default_buyer"];
                                    $_pic  = $address["pic"];
                                    $_name = $address["name"];
                                    $_phone  = $address["phone"];
                                    $_location = $address["location_id"];
                                    $_addres  = $address["address"];
                                    
                                    //echo $_default_buyer;
                                }
                                
                                ?>
                                
                                <div class="col-md-4">
                                    <b><?=v("buyer");?></b>
                                    <input class="form-control" type="text" value="<?=$db->fetch_single_data("a_users","name",["id"=>$_SESSION["user_id"]])?>">
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("pic");?></b>
                                    <input class="form-control" type="text" value="<?= $_pic ?>">
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("phone");?></b>
                                    <input class="form-control" type="text" value="<?= $_phone ?>">  
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("location");?></b>
                                    <select class="form-control">
                                        <?php
                                        $datas = $db->fetch_all_data("locations",[],"");
                                            
                                        foreach($datas as $data){
                                            $id = $data["id"];
                                            $loc_name = $data["name_".$__locale.""];
                                            
                                            $selected = ($id == $_location)
                                                ? 'selected' : '';
                                            
                                            echo '
                                                <option value="'.$id.'" '.$selected.'>'.$loc_name.'</option>
                                            ';
                                        }
                                            
                                        ?>
                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("city");?></b>
                                    <select class="form-control">
                                        <option>Jawa Barat</option>
                                        <option>Jawa Tengah</option>
                                        <option>Jawa Timur</option>
                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("district");?></b>
                                    <select class="form-control">
                                       
                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <b><?=v("address");?></b>
                                    <br>
                                    <textarea class="form-control" rows="5"></textarea>
                                    <br>
                                </div>
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <b>Total</b>
                                    <br>
                                    <br>
                                    <div class="col-md-2">
                                        <b>Rp</b>
                                    </div>    
                                    <div class="col-md-10">
                                    <input class="form-control" type="text" id="total" onkeyup="calculate()" readonly> 
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height:20px;"></div>
                    <div class="col-md-6">
                        <center>
                            <button class="col-md-12 btn btn-danger btn-lg"><?=v("purchase_another");?></button>
                        </center>
                    </div>
                    <div class="col-md-6">
                        <center>
                            <button class="col-md-12 btn btn-primary btn-lg"><?=v("pay");?></button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>



<div style="height:40px;"></div>

<?php include_once "footer.php"; ?>