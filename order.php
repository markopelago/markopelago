<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."' ORDER BY seller_user_id");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	$_transaction_ids = "";
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
		$_transaction_ids .= $transaction["id"].",";
	} $_transaction_ids = substr($_transaction_ids,0,-1);
	
	
?>
<script>
</script>
<form id="cart_form" role="form" method="POST" autocomplete="off">	
	<input type="hidden" id="action_mode" name="action_mode">
	<div class="container">
		<div class="row">
			<div class="common_title"><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;<?=v("order");?></div>
			<table <?=$__tblDesign100;?>>
				<tr>
					<td valign="top">
						<table <?=$__tblDesign100;?>>
							<?php 
								foreach($_trxBySeller as $seller_user_id => $transactions){
									$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
									$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
									$_trxByGoods = [];
									$_trx_ids = [];
									foreach($transactions as $transaction){ 
										$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
										$_trxByGoods[$transaction_details["goods_id"]] = $transaction_details; 
										$_trx_ids[$transaction_details["goods_id"]] .= $transaction["id"].",";
									}
							?>
								<tr>
									<td valign="top" width="<?=(isMobile())?"100%":"70%";?>">
										<div class="border_orange" style="margin-bottom:5px;">
											<table <?=$__tblDesign100;?>>
												<tr style="height:20px;">
													<td width="25"><?=$f->input("","1","type='checkbox' onclick=\"toogle_check(this,".$seller_user_id.")\"");?></td>
													<td style="font-size:1em;font-weight:bolder;">
														<a href="seller_detail.php?id=<?=$seller["id"];?>"><?=v("seller");?> : <?=$seller["name"];?></a>
													</td>
													<td width="30"><img style="cursor:pointer;" width="30" src="assets/delete_cart.png" onclick="deleteitem();"></td>
												</tr>
											</table>
										</div>
										<?php 
											foreach($_trxByGoods as $goods_id => $transaction_details){
												$transaction_ids = substr($_trx_ids[$goods_id],0,-1);
												$goods  = $db->fetch_all_data("goods",[],"id = '".$goods_id."'")[0];
												$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods_id."'","seqno")[0];
												if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
												$unit = $db->fetch_single_data("units","name_".$__locale,["id" => $transaction_details["unit_id"]]);
												$qty = $db->fetch_single_data("transaction_details","concat(sum(qty))",["transaction_id" => $transaction_ids.":IN","goods_id" => $goods_id]);
												$price = $transaction_details["gross"] + ($transaction_details["gross"] * $transaction_details["commission"] / 100);
												$subtotal = $price * $qty;
												$total_price += $subtotal;
										?>
											<div class="border_orange" style="margin-bottom:5px;">
												<table <?=$__tblDesign100;?>>
													<tr>
														<td width="25"><?=$f->input("chk[".$goods_id."]","1","type='checkbox'");?></td>
														<td>
															<table <?=$__tblDesign100;?>>
																<tr>
																	<td width="120"><img src="goods/<?=$goods_photos["filename"];?>" width="100" style="cursor:pointer;" onclick="window.location='product_detail.php?id=<?=$goods_id;?>';"></td>
																	<td valign="top">
																		<table <?=$__tblDesign100;?>>
																			<tr>
																				<td style="font-size:0.8em;font-weight:bolder;"><?=v("seller");?> : <?=$seller["name"];?></td>
																				<td id="subtotal[<?=$goods_id;?>]" style="font-size:1em;font-weight:bolder;color:#800000" rowspan="2" valign="middle" align="right" nowrap></td>
																			</tr>
																			<tr><td style="font-size:0.8em;font-weight:bolder;">
																				<a href="product_detail.php?id=<?=$goods_id;?>"><?=$goods["name"];?></a>
																			</td></tr>
																			<?=(isMobile())?"</tr><tr><td style='height:5px;'></td></tr><tr>":"<tr><td>&nbsp;</td></tr>";?>
																			<tr>
																				<td colspan="2">
																					<table <?=$__tblDesign100;?>>
																						<tr>
																							<td nowrap>
																								<div style="font-size:0.8em;font-weight:bolder;"><?=v("goods_qty");?></div>
																								<div class="oval_border" onclick="calculate('<?=$goods_id;?>');">
																									<div class="left_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepDown(1);">-</div>
																									<div class="center_text"><?=$f->input("qty[".$goods_id."]",$qty,"type='number' min='1' step='1' onchange=\"calculate('".$goods_id."');\"");?></div>
																									<div class="right_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepUp(1);">+</div>
																								</div>
																							</td>
																							<?=(isMobile())?"</tr><tr><td style='height:5px;'></td></tr><tr>":"";?>
																							<td style="font-size:0.8em;font-weight:bolder;" align="center" nowrap>
																								<?=v("weight");?><br>
																								<div id="weight[<?=$goods_id;?>]" style="border:1px solid #5F98AB;padding-left:5px;"><?=$transaction_details["weight"];?>g</div>
																							</td>
																							<td width="2%"></td>
																							<?=(isMobile())?"</tr><tr><td style='height:5px;'></td></tr><tr>":"";?>
																							<td style="font-size:0.8em;font-weight:bolder;" align="center" nowrap>
																								<?=v("price");?> / <?=$unit;?><br>
																								<div id="price[<?=$goods_id;?>]" style="border:1px solid #5F98AB;padding-right:5px;" align="right">Rp. <?=format_amount($price);?></div>
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</div>
									<?php } ?>
									</td>
								</tr>
								<tr><td><br></td></tr>
							<?php } ?>
						</table>
					</td>
					<?php
						$shopping_summary = "
							<div style=\"font-size:1em;font-weight:bolder;margin-bottom:18px;padding-top:10px; text-align:center;\">".v("shopping_summary")."</div>
							<div class=\"border_orange\">
								<table width=\"100%\"><tr>
									<td style=\"font-size:1em;font-weight:bolder;\">".v("total_price")."</td>
									<td id=\"total_price\" style=\"font-size:1em;font-weight:bolder;color:#800000;\" align=\"right\"></td>
								</tr></table>
								<br>
								<table width=\"100%\"><tr>
									<td align=\"center\">
										".$f->input("order","Order","type='submit' style=\"width:165px;\"","btn btn-info")."
										<div style=\"height:10px;\"></div>
										".$f->input("order",v("more_shopping"),"type='button' onclick=\"window.location='index.php'\" style=\"width:165px;\"","btn btn-danger")."
									</td>
								</tr></table>
							</div>";
					?>
					<?php if(!isMobile()){ ?>
						<td style="width:10px;"></td>
						<td valign="top" width="28%"><?=$shopping_summary;?></td>
					<?php } ?>
				</tr>
			</table>
		</div>
	</div>
</form>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>