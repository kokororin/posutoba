var calendar = {
    dayTable: null,
    //初始化TABLE 
    year: null,
    //初始化年 
    month: null,
    _month: null,
    //初始化月份 
    getFirstDay: function(year, month) { //获取每个月第一天再星期几 
        var firstDay = new Date(year, month, 1);
        return firstDay.getDay(); //getDay()方法来获取 
    },
    getMonthLen: function(year, month) { //获取当月总共有多少天 
        var nextMonth = new Date(year, month + 1, 1); //获取下个月的第一天 
        nextMonth.setHours(nextMonth.getHours() - 3); //由于获取的天是0时,所以减去3小时则可以得出该月的天数 
        return nextMonth.getDate(); //返回当天日期 
    },
    createCalendar: function(form, date) { //创建日历方法 
    	$('#sign-table-tbody>.j_6,#sign-table-tbody>.j_5').show();
    	calendar.year = date.getFullYear(); //获得当时的年份,并赋值到calendar属性year中,以便别的方法的调用 
    	calendar.month = date.getMonth(); //跟上面获取年份的目的一样 
        if(calendar.month >= 0 && calendar.month <= 8){
        	_month = '0' + (calendar.month + 1);
        }
        else{
        	_month = calendar.month +1;
        }
        $('.j_calendar_month').html(calendar.year + '年' + _month + '月');
        $('#sign_month').val(calendar.year + '-' + (_month))//插入年份和月份 
        calendar.clearCalendar(form); //清空TABLE 
        var monthLen = calendar.getMonthLen(calendar.year, calendar.month); //获取月份长度 
        var firstDay = calendar.getFirstDay(calendar.year, calendar.month); //获取月份首天为星期几 
        for (var i = 1; i <= monthLen; i++) { //循环写入每天的值进入TABLE中 
            calendar.dayTable[i + firstDay - 1].innerHTML = i; //i为循环值,加上第一天的星期值刚可以对应TABLE位置,但由于数组从0开始算,所以需要减去1
            calendar.dayTable[i + firstDay - 1].className += " day-" +i;
        }
        signMark($('#sign_month').val(),$('#forum_id').val());
        //以下是删除空行
        	var dev= (this.dayTable.length - firstDay - monthLen) / 7;
        	if(dev>=1){
        		$('#sign-table-tbody>.j_6').hide();
        	}
        	if(dev>=2){
        		$('#sign-table-tbody>.j_5').hide();
        	}
        
    },
    clearCalendar: function(form) { //清空TABLE方法 
        this.dayTable = form.getElementsByTagName('td');
        for (var i = 0; i < this.dayTable.length; i++) {
            this.dayTable[i].innerHTML = ' ';
            calendar.dayTable[i].className = 'sign-table-tbody-day';
        }
    },
    init: function(form) { //主方法 
        this.dayTable = form.getElementsByTagName('td');
        this.createCalendar(form, new Date());
        var $preMon = $('.j_calendar_month_prev');
        var $nextMon = $('.j_calendar_month_next');
        $preMon.click(function(){ //当点击左按钮时,减去一个月,并重绘TABLE 
            calendar.createCalendar(form, new Date(calendar.year, calendar.month - 1, 1));
        });
        $nextMon.click(function(){ //当点击右按钮时,加上一个月,并重绘TABLE 
            calendar.createCalendar(form, new Date(calendar.year, calendar.month + 1, 1));
        });
    }
}

$(function() {  
    calendar.init($('#sign-table-tbody')[0]);
});