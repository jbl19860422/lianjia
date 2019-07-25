$(function() {
	var sideSubMenu = Vue.component('side-sub-menu', {
		props:['submenu','host_url','submenu_name'],
		template:
		'<li :class="{active:submenu_name==submenu.name}">'+
			'<a :href="submenu.url?(host_url+\'/admin/\'+submenu.url):\'javascript:\'">'+
				'<i class="icon-double-angle-right"></i>'+
				'{{submenu.name}}'+
			'</a>'+
		'</li>'
	});
	var sideMenu = Vue.component('side-menu',{
		props:['menu','host_url','menu_name','submenu_name','open_menu'],
		template:
		'<li :class="{active:menu_name==menu.name,open:menu.submenus&&(menu_name==menu.name||open_menu==menu.name)}">'+
			'<a :href="menu.submenus?\'javascript:\':(host_url+\'/admin/\'+menu.url)" :class="{\'dropdown-toggle\':menu.submenus}" @click="onClickMenu()">'+
				'<i :class="menu.icon"></i>'+
				'<span class="menu-text" v-html="menu.name"></span>'+
				'<b :class="{arrow:menu.submenus,\'icon-angle-down\':(menu_name==menu.name||open_menu==menu.name),\'icon-angle-right\':menu.submenus}" v-if="menu.submenus"></b>'+
			'</a>'+
			'<ul class="submenu" v-if="menu.submenus" :style="[menu_name==menu.name||open_menu==menu.name?{display:\'block\'}:{}]">'+
				'<side-sub-menu v-for="submenu in menu.submenus" :host_url="host_url" :submenu="submenu"></side-sub-menu>'+
			'</ul>'+
		'</li>',
		methods:{
			onClickMenu:function() {
				this.$emit('clickmenu',this.menu);
			}
		}
	});
	
	var sideMenus = Vue.component('side-menus',{
		props:['menus','host_url','menu_name','submenu_name'],
		template:
		'<ul class="nav nav-list">'+	
			'<side-menu v-for="menu in menus" :host_url="host_url" :menu="menu" :menu_name="menu_name" :submenu_name="submenu_name" :open_menu="open_menu" @clickmenu="clickMenu"></side-menu>'+
		'</ul>',
		data:function() {
			return {
				open_menu:''
			};
		},
		mounted:function() {
		},
		methods:{
			clickMenu:function(m) {
				if(this.open_menu == m.name) {
					this.open_menu = '';
				} else {
					this.open_menu = m.name;
				}
				console.log(this.open_menu);
				this.$forceUpdate();
			}
		}
	});
	
	var g_side = new Vue({
		el:'#sidebar-menu-list',
		mounted:function() {
		},
		data:{
			open_menu:'',
			min:false,
			host_url:g_host_url,
			menus:
			[
				{
					name:'基本信息',
					icon:'icon-dashboard',
					url:'app_manager_page'
				},
				{
					name:'视频管理',
					icon:'icon icon-video-camera',
					submenus:[
						{
							name:'频道管理',
							url:'channel_manager_page'
						},
						{
							name:'专题管理',
							url:'topic_manager_page'
						},
						{
							name:'直播管理',
							url:'live_manager_page'
						},
						{
							name:'分类管理',
							url:'videocate_manager_page'
						},
					]
				},
				{
					name:'商品管理',
					icon:'icon icon-drawer2',
					submenus:[
						{
							name:'商品类别',
							url:'goods_category_page'
						},
						{
							name:'商品属性',
							url:'goods_attr_page'
						},
						{
							name:'商品列表',
							url:'goods_list_page'
						},
						{
							name:'虚拟商品列表',
							url:'virtual_goods_list_page'
						},
						{
							name:'商品展示分类',
							url:'goods_showcate_page'
						},
						{
							name:'订单管理',
							url:'order_manager_page'
						}
					]
				},
				{
					name:'虚拟物品管理',
					icon:'icon icon-command',
					submenus:[
						{
							name:'自定义虚拟物品',
							url:'item_manager_page'
						},
						{
							name:'打折卡',
							url:'discountcard_manager_page'
						},
						{
							name:'兑换券管理'
						}
					]
				},
				{
					name:'营销活动管理',
					icon:'icon icon-amazon',
					submenus:[
						{
							name:'抽奖类活动',
							url:'lottery_manager_page'
						},
						{
							name:'赠送类活动',
							url:'gift_manager_page'
						},
						{
							name:'报名活动',
							url:'enroll_manager_page'
						}
					]
				},
				{
					name:'页面管理',
					icon:'icon icon-files-empty',
					url:'page_manager_page'
				},
				{
					name:'图片素材管理',
					icon:'icon icon-images',
					url:'pic_list_page'
				},
				{
					name:'子账号管理',
					icon:'icon icon-users',
					submenus:[
						{
							name:'子账号列表',
							url:'child_users_page'
						},
						{
							name:'子账号视频',
							url:'childuser_videoes_page'
						},
						{
							name:'子账号订单',
							url:'childuser_order_page'
						},
						{
							name:'子账号收益'
						}
					]
				}
			]
		},
		methods:{
			toggleCollapse:function() {
				this.min = !this.min;
			}
		},
		created:function() {

		}
	});
});