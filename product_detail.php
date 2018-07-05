<?php include_once "header.php"; ?>

<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text">
		<?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?>
		</div>
	</div>
    
    <div class="row">
        
        <div class="col-md-9" style="border-top: 1px solid #ccc;">
            <div style="height:20px;"></div>
            <div class="col-md-5">
               <div class="panel panel-default">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <?php 
                        $products = $db->fetch_all_data("goods_photos",[],"goods_id = '".$_GET["id"]."'");
                      
                        $count = count($products);
                        //echo $count;
                   
                        for($a=0;$a<$count;$a++){
                          if($a == 0){
                            ?>
                            <li data-target="#myCarousel" data-slide-to="<?=$a;?>"  class="active"></li>
                            <?php 
                          }else{
                            ?>
                            <li data-target="#myCarousel" data-slide-to="<?=$a;?>"></li>
                            <?php 
                          }
                          
                      }
                      
                      ?>
                        <!--li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li-->
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" style="height: auto !important ">
                      <?php
                      $files = $db->fetch_all_data("goods_photos",[],"goods_id = '".$_GET["id"]."'");

                      foreach($files as $file){
                      $name = $file["filename"];

                      if(substr($name, 0, -4) == $_GET["id"]){
                        echo '
                        <div class="item active">
                          <img src="products/'.$name.'">
                        </div>
                      ';
                      }else{
                        echo '
                        <div class="item">
                          <img src="products/'.$name.'">
                        </div>
                      ';
                      }
                      

                      }
                      ?>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right"></span>
                      <span class="sr-only">Next</span>
                    </a>
              </div>
            </div>
          </div>
            <div class="col-md-7">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title"><b><?=v("product_information");?></b></h3>
                  </div>
                  <div class="panel-body">
                    <table class="table table-striped">
                      <?php
                      $products_data = $db->fetch_all_data("goods",[],"id = '".$_GET["id"]."'");
                        foreach ($products_data as $data) {
                          $data["weight"];
                          $data["dimension"];
                          $data["is_new"];
                        }
                      ?>
                          <tr>
                            <td>Weight</td>
                            <?php
                            echo'
                              <td>'.$data["weight"].'</td>
                            ';
                            ?>
                          </tr>
                          <tr>
                            <td>Dimension</td>
                            <?php
                            echo'
                              <td>'.$data["dimension"].'</td>
                            ';
                            ?>
                          </tr>
                          <tr>
                            <td>Is New</td>
                            <?php
                              if($data["is_new"] == 1){
                                echo'
                                  <td>New</td>
                                ';
                              }else{
                                echo'
                                  <td>Second</td>
                                ';
                              }
                            ?>
                         </tr>
                      </table>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title"><b><?=v("product_description");?></b></h3>
                  </div>
                  <div class="panel-body">
                        <p><?=$db->fetch_single_data("goods","description",["id"=>$_GET["id"]]);?></p>
                  </div>
                </div>
            </div>
        </div>
        <div style="height:20px;"></div>
        <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title"><center><b><?=v("price");?></b></center></h3>
              </div>
              <div class="panel-body">
                <h3><b><center><?=$db->fetch_single_data("goods","price",["id"=>$_GET["id"]]);?></center></b></h3>
              </div>
            </div>
            <div style="height:2px;"></div>
            <button class="btn btn-primary btn-lg" style="width:100%"><?=v("buy");?></button>
        </div>
    </div>
</div>


<div style="height:40px;"></div>

<?php include_once "footer.php"; ?>