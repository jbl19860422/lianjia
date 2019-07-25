<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<base href="<?=HOST_URL?>/"/>
		<title></title>
		
		<script src="https://cdn.bootcss.com/vue/2.4.4/vue.min.js"></script>
		<link href="../../../static/public/bootstrap/css/bootstrap.css" rel="stylesheet"/>
		<link href="../../../static/css/base.css" rel="stylesheet">
		<link href="../../../static/css/city_page.css" rel="stylesheet">
		<link href="https://cdn.bootcss.com/zui/1.7.0/css/zui.min.css" rel="stylesheet">
		<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
		<script src="../../../static/js/iconfont.js" type="text/javascript"></script>
		<script src="../../../static/public/bootstrap/js/bootstrap.js"></script>
		<script src="static/js/common.js?v=2"></script>
		<script src="static/js/api.js?v=1"></script>
		<script src="https://cdn.bootcss.com/zui/1.7.0/js/zui.min.js"></script>
	</head>
	<body>
		<div id="content_warp">
			<div class="header">
				<div class="bar mg-c">
					<?php include dirname(__file__)."/../inc/menu.php"?>
					<div class="user-info">
					</div>
				</div>
			</div>
			<div class="mg-c" style="margin-top:40px">
				<div class="panel panel-default">
					<div class="panel-heading panel-title">
						<p class="panel-p">实勘图片详情</p>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6 col-sm-4 col-md-3"  style="margin:20px" v-if="message.content.follow_imgs.structure">
									<a :href="message.content.follow_imgs.structure" data-toggle="lightbox" data-group="image-group-1" class="lightbox-toggle structure card"><img :src="message.content.follow_imgs.structure" class="img-rounded" alt="">
									<div class="card-heading"><strong>格局图片</strong></div></a>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3" style="margin:20px" v-if="message.content.follow_imgs.rooms" v-for="(room,index) in message.content.follow_imgs.rooms">
									<a :href="room" data-toggle="lightbox" data-group="image-group-1" class="lightbox-toggle room card" :data-ind="index"><img :src="room" class="img-rounded" alt="">
									<div class="card-heading"><strong v-html="'室'+(index+1)"></strong></div></a>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3"  style="margin:20px" v-if="message.content.follow_imgs.halls" v-for="(hall,index) in message.content.follow_imgs.halls">
									<a :href="hall" data-toggle="lightbox" data-group="image-group-1" class="lightbox-toggle hall card" :data-ind="index"><img :src="hall" class="img-rounded" alt="">
									<div class="card-heading"><strong v-html="'厅'+(index+1)"></strong></div></a>
								</div>
								
								<div class="col-xs-6 col-sm-4 col-md-3"  style="margin:20px" v-if="message.content.follow_imgs.kitchens" v-for="(kitchen,index) in message.content.follow_imgs.kitchens">
									<a :href="kitchen" data-toggle="lightbox" data-group="image-group-1" class="lightbox-toggle hall card" :data-ind="index"><img :src="kitchen" class="img-rounded" alt="">
									<div class="card-heading"><strong v-html="'厨'+(index+1)"></strong></div></a>
								</div>
								
								<div class="col-xs-6 col-sm-4 col-md-3"  style="margin:20px" v-if="message.content.follow_imgs.toilets" v-for="(toilet,index) in message.content.follow_imgs.toilets">
									<a :href="toilet" data-toggle="lightbox" data-group="image-group-1" class="lightbox-toggle hall card" :data-ind="index"><img :src="toilet" class="img-rounded" alt="">
									<div class="card-heading"><strong v-html="'卫'+(index+1)"></strong></div></a>
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="row">
								<div style="margin:auto; text-align:center;">
									<div class="btn btn-success btn-lg" @click="allowFollowImg()">审核通过</div>
									<div class="btn btn-danger btn-lg" @click="rejectApply()">拒绝通过</div>
								</div>
							</div>
						</div>
						<div style="clear:both"></div>
					</div>
				</div>
			</div>
		</div>		
	</body>
	<script>
		var g_page;
		var g_host_url = "<?=HOST_URL?>";
		$(function() {
			g_page = new Vue({
				el:'#content_warp',
				data:{
					message:<?=json_encode($message)?>,
					agent_info:''
				},
				created:function() {
					this.message.content = JSON.parse(this.message.content);
				},
				mounted:function() {
					$(this.$el).find("#dlg_indenpdent_broker").css("display",'');
					
					$('a.structure').lightbox({
						image: $(this).attr("href"),
						caption: '格局'
					});
					
					$('a.room').lightbox({
						image: $(this).attr("href"),
						caption: '室'+($(this).index(this)+1)
					});
					
					$('a.hall').lightbox({
						image: $(this).attr("href"),
						caption: '厅'+($(this).index(this)+1)
					});
					
					$('a.kitchen').lightbox({
						image: $(this).attr("href"),
						caption: '厨'+($(this).index(this)+1)
					});
					
					$('a.toilet').lightbox({
						image: $(this).attr("href"),
						caption: '卫'+($(this).index(this)+1)
					});
				},
				methods:{
					allowFollowImg:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'houseinfo', 'allowFollowImg', this.message, function(json) {
							if(json.code == 0) {
								history.back(-1);
							}
						});
					},
					rejectApply:function() {
						var that = this;
						API.invokeModuleCall(g_host_url, 'msg', 'setMsgStatus', {msg_id:this.message.msg_id,status:1}, function(json) {
							if(json.code == 0) {
								showMsg("已经处理");
							}
						});
					},
				}
			})
		});
	</script>
</html>
