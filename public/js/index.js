$(function(){
	sidebarControl();
})
/**
 * 左侧,侧边栏相关
 */
function sidebarControl(){
	var oSidebar = $('#sidebar');
	var aMenu = oSidebar.find('.menu');
	var aTitle = aMenu.find('.title'),oMenuList;
	oMenuList =  $(this).parent().find('.menuList');
	// 菜单显示隐藏切换
	aTitle.toggle(function(){
		
		$(this).addClass('active');
		oMenuList.hide();
	},function(){
		$(this).removeClass('active');
		oMenuList.show();
	})
	// 导航点击切换
	var aNavList = $('#header .nav a');
	var aMenuItem =  $('#sidebar .menuItem');
	aNavList.each(function(index){
		$(this).click(function(){
			aNavList.removeClass('active');
			$(this).addClass('active');
			aMenuItem.hide();
			aMenuItem.eq(index).show();
			$("#iContent").attr('src',aMenuItem.eq(index).find(".menuList").find('a').eq(0).attr('href'));
		})
	})

		// 首页点击切换
	var cNavList = $('.yy_choice .nav li'),num=1;
	cNavList.each(function(index){
		$(this).click(function(){

			cNavList.removeClass('active');
			$(this).addClass('active');
			num = $(this).attr('role');
		})
	})

	//点击表单“提交”按钮
	$("#submitBut").bind("click", function() {

	    //触发submit事件，提交表单 
	    if($("#search").val()!=""){
	      var url = $("#submitForm").attr("action");
	    //更改form的action
	      $("#submitForm").attr("action", url+num);
	      $("#submitForm").submit();
	    }
	    else{
	       alert("You must input Something");
	    }
	});
}