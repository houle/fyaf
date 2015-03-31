$(function(){

       	$("input[level=1]").click(function(){
              var inputs = $(this).parents('.panel').find('input');
              $(this).prop('checked')?inputs.prop("checked", true):inputs.removeAttr("checked");
       	  }
        )

        $("input[level=2]").click(function(){

              var inputs = $(this).parents('.panel-heading').next('.panel-body').find('input');
              if($(this).prop('checked'))
              	{
              		$(this).prop("checked", true);
              		inputs.prop("checked", true);
              	}else{
              		$(this).removeAttr("checked");
              		inputs.removeAttr("checked");
              	};
       	  }
        )

	/******  层级显示切换   ******/

	var aTr = $('#table tbody tr');
	var aUnfold = $('#table tbody tr .unfold');
	aTr.each(function(){
		//取得class名称
		var sClass = $(this).attr('class');
		//查询等级的正则
		var preg = /\d+?/;
		//查询tr等级
		var level = sClass.match(preg);
		if(level>1){
			$(this).addClass('hide');
		}
	})
	/**** 切换层级显示隐藏  ****/
	aUnfold.bind({
	   mouseover:function(){
		var aSonList = getSonList.call(this);
		if(aSonList.size()){
			$(this).text("-");
			aSonList.removeClass('hide');
	     }
	    },click:function(){
		var aSonList = getSonList.call(this);
		if(aSonList.size()){
			$(this).text("+");
			aSonList.addClass('hide');
	     }
		}
	});

	/**** 获取子集列表  ****/
	function getSonList(){
		var oParent = $(this).parents('tr');
		var pid = oParent.attr('cid');
		var sClass = '.pid_'+pid;
		return $('#table tbody').find(sClass);
	}





})




