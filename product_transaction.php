
<script type="text/javascript" src="jquery.js"></script>
<?php include_once "header.php"; 

if(isset($_POST["next"])){
    
    $date = date("Y-m-d h:i:sa");
    
    $cek_barang = $db->fetch_single_data("transactions","id",["goods_id"=>$_GET["id"],"seller_user_id"=>$_POST["seller_id"],"buyer_user_id"=>$_SESSION["user_id"]]);
        
    if($cek_barang == ''){

        $db->addtable("transactions");
        $db->addfield("goods_id");		    $db->addvalue($_GET["id"]);
        $db->addfield("seller_user_id");	$db->addvalue($_POST["seller_id"]);
        $db->addfield("buyer_user_id");		$db->addvalue($_SESSION["user_id"]);
        $db->addfield("transaction_at");    $db->addvalue($date);
        $inserting = $db->insert();


        $db->addtable("transaction_details");
        $db->addfield("transaction_id");	$db->addvalue($_POST["id_transaction"]);
        $db->addfield("goods_id");		    $db->addvalue($_GET["id"]);
        $db->addfield("qty");               $db->addvalue($_POST["qty"]);
        $db->addfield("unit_id");           $db->addvalue($_POST["unit_id"]);
        $db->addfield("price");             $db->addvalue($_POST["price"]);
        $db->addfield("total");             $db->addvalue(($_POST["qty"])*($_POST["price"]));
        $inserting = $db->insert();
      
    }else{
        
        $id_transaction = $db->fetch_single_data("transactions","id",["goods_id"=>$_GET["id"],"seller_user_id"=>$_POST["seller_id"],"buyer_user_id"=>$_SESSION["user_id"]]);
        
        $cek_qty = $db->fetch_single_data("transaction_details","qty",["transaction_id"=>$id_transaction]);
        
        $tot_qty = $cek_qty + $_POST["qty"];
        $total   = $tot_qty * $_POST["price"];
        
        $db->addtable("transaction_details");
        $db->where("transaction_id",$id_transaction);
        $db->addfield("goods_id");		    $db->addvalue($_GET["id"]);
        $db->addfield("qty");               $db->addvalue($tot_qty);
        $db->addfield("unit_id");           $db->addvalue($_POST["unit_id"]);
        $db->addfield("price");             $db->addvalue($_POST["price"]);
        $db->addfield("total");             $db->addvalue($total);

        $inserting = $db->update();
        
    }
    
    if($inserting["affected_rows"] > 0){
    
        $cek = $db->fetch_single_data("user_addresses","user_id",["user_id"=>$_SESSION["user_id"]]);

        if($cek == ''){
            $db->addtable("user_addresses");
            $db->addfield("user_id");			$db->addvalue($_POST["buyer_name"]);
            $db->addfield("default_buyer");		$db->addvalue(1);
            $db->addfield("name");			    $db->addvalue($_POST["buyer_name_det"]);
            $db->addfield("pic");				$db->addvalue($_POST["pic"]);
            $db->addfield("phone");	            $db->addvalue($_POST["phone"]);
            $db->addfield("address");			$db->addvalue($_POST["address"]);
            $inserting = $db->insert();
            if($inserting["affected_rows"] > 0){ ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#successTransaction').modal({backdrop: 'static', keyboard: false})  
                    });
                </script>
            <?php
            } else {
                $_SESSION["errormessage"] = v("failed_transaction");
            }
            $data = $_POST;
        }else{
            $db->addtable("user_addresses");
            $db->where("user_id",$_SESSION["user_id"]);
            $db->addfield("user_id");			$db->addvalue($_POST["buyer_name"]);
            $db->addfield("default_buyer");		$db->addvalue(1);
            $db->addfield("name");			    $db->addvalue($_POST["buyer_name_det"]);
            $db->addfield("pic");				$db->addvalue($_POST["pic"]);
            $db->addfield("phone");	            $db->addvalue($_POST["phone"]);
            $db->addfield("address");			$db->addvalue($_POST["address"]);
            $inserting = $db->update();
            if($inserting["affected_rows"] > 0){ ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#successTransaction').modal({backdrop: 'static', keyboard: false})  
                    });
                </script>
            <?php
            } else {
                $_SESSION["errormessage"] = v("failed_transaction");
            }
           $data = $_POST; 
        }
    }else{ 
        $_SESSION["errormessage"] = v("failed_transaction");
    }
}
?>


<script>
    function calculate() { 
             var qty = document.getElementById("qty").value;
             var price = document.getElementById("price").value;
             var total = qty * price;
             
             var num = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        
              $('#total').val(num);
    } 
</script>

<script type="text/javascript">
    var htmlobjek;
    $(document).ready(function(){
        //apabila terjadi event onchange terhadap object <select id=propinsi>
        $("#propinsi").change(function(){
        var propinsi = $("#propinsi").val();

            $.ajax({
            url: "get_city.php",
            data: "propinsi="+propinsi,
            cache: false,
            success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=kota>
            $("#kota").html(msg);
            }
            });
        });

        $("#kota").change(function(){
            var kota = $("#kota").val();
                $.ajax({
                url: "get_district.php",
                data: "kota="+kota,
                cache: false,
                success: function(msg){
                    $("#kec").html(msg);
                }
            });
        });
    });
 
</script>
<form role="form" method="POST" autocomplete="off">	
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
                                    <?php
                                        $seller_id = $db->fetch_single_data("goods","seller_id",["id"=>$_GET["id"]]);
                                        
                                        $sellers_id = $db->fetch_single_data("sellers","user_id",["id"=>$seller_id]);
                                    
                                        $seller_name = $db->fetch_single_data("a_users","name",["id"=>$sellers_id]);
                                    
                                        $id = ($db->get_maxrow("transactions")+1);                                       
                                    ?>
                                    <input type="hidden" name="id_transaction" id="id_transaction" value="<?=$id?>">
                                    <input type="hidden" name="seller_id" id="seller_id" value="<?=$seller_id?>">
                                    <input type="hidden" name="unit_id" id="unit_id" value="<?=$db->fetch_single_data("goods","unit_id",["id"=>$_GET["id"]]);?>">
                                    
                                    <?=$seller_name?>
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
                                    <input class="form-control" type="text" id="qty" name="qty" onkeyup="calculate()">
                                </td>
                                <td style="width:10%;"></td>
                                <td style="width:45%;">
                                    <b>
                                        <input type="hidden" id="price" value="<?=$db->fetch_single_data("goods","price",["id"=>$_GET["id"]])?>" onkeyup="calculate()">
                                        Rp<?=number_format($db->fetch_single_data("goods","price",["id"=>$_GET["id"]]))?>
                                        
                                        <input type="hidden" name="price" id="price" value="<?=$db->fetch_single_data("goods","price",["id"=>$_GET["id"]])?>">
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
                                    <input class="form-control" name ="buyer_name_det" type="text" value="<?=$db->fetch_single_data("a_users","name",["id"=>$_SESSION["user_id"]])?>">
                                    
                                    <input class="form-control" name ="buyer_name" type="hidden" value="<?=$db->fetch_single_data("a_users","id",["id"=>$_SESSION["user_id"]])?>">
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("pic");?></b>
                                    <input class="form-control" name="pic" type="text" value="<?= $_pic ?>">
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("phone");?></b>
                                    <input class="form-control" name="phone" type="text" value="<?= $_phone ?>">  
                                    <br>
                                </div>
                                <div class="col-md-4">
                                    <b><?=v("location");?></b>
                                    <select class="form-control" name="propinsi" id="propinsi">
                                        <option>--Pilih Provinsi--</option>
                                        <?php
                                        $datas = $db->fetch_all_data("province",[],"");
                                            
                                        foreach($datas as $data){
                                            $id = $data["id_prov"];
                                            $loc_name = $data["nama_prov"];
                                            
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
                                    <select class="form-control" name="kota" id="kota">
                                        <option>--Pilih Kota--</option>
                                        <?php
                                        $datas = $db->fetch_all_data("kabkot",[],"");
                                            
                                        foreach($datas as $data){
                                            $id = $data["id_kabkot"];
                                            $loc_name = $data["nama_kabkot"];
                                            
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
                                    <b><?=v("district");?></b>
                                    <select class="form-control" name="kec" id="kec">
                                        <option>--Pilih Kecamatan--</option>
                                        </select>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <b><?=v("address");?></b>
                                    <br>
                                    <textarea class="form-control" name="address" rows="5"><?=$_addres?></textarea>
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
                                    <input class="form-control" name="total" type="text" id="total" onkeyup="calculate()" readonly> 
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height:20px;"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <center>
                                <?=$f->input("next",v("buy"),"type='submit'","col-md-12 btn btn-primary btn-lg");?>
                        </center>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<div style="height:40px;"></div>

<div id="successTransaction" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?></h4>
      </div>
      <div class="modal-body">
          <p>&nbsp;&nbsp;
            <span class="glyphicon glyphicon-ok">
              <?=v("produk_berhasil_dimasukkan_ke_keranjang_belanja");?>
            </span>
          </p>
      </div>
      <div class="modal-footer">
          <center>
            <a href="product_detail.php?id=<?=$_GET["id"];?>">
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                    <?=v("lanjutkan_berbelanja");?>
                </button>
            </a>
            <a href="product_cart.php?user_id=<?=$_SESSION["user_id"];?>">
                <button type="button" class="btn btn-primary">
                    <span class="glyphicon glyphicon-credit-card"></span>&nbsp;
                    <?=v("bayar");?>
                </button>
              </a>
          </center>
      </div>
    </div>

  </div>
</div>


<?php include_once "footer.php"; ?>