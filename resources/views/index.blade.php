@extends('common.default')
@section('contents')
@include('common._errors')

<h2>截止目前，平台已为 <span class="text-danger">{{$memberCount}}</span> 会员，提供超过<span class="text-danger">{{$goodsCount}}</span> 份菜品。</h2>

<div class="row ">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>最近一周订单量统计</strong></div>
            <!--最近一周订单量统计图-->
            <div class="panel-body">
                <div id="main" style="height:400px;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr  class="active">
                    <td>日期</td>
                    @foreach($orderWeek as $date=>$count)
                        <td>{{$date}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>单量</td>
                    @foreach($orderWeek as $date=>$count)
                        <td>{{$count}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>金额</td>
                    @foreach($orderMoney as $total)
                            <td @if($total!=0) class="text-primary" @endif>{{$total}}</td>
                    @endforeach
                </tr>
            </table>

        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>最近三月订单量统计</strong></div>
            <!--最近三月订单量统计图-->
            <div class="panel-body">
                <div id="main2" style="height:400px; width: 100%;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr class="active">
                    <td>日期</td>
                    @foreach($orderMonth as $date=>$count)
                        <td>{{$date}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>单量</td>
                    @foreach($orderMonth as $date=>$count)
                        <td>{{$count}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>金额</td>
                    @foreach($monthMoney as $total)
                            <td @if($total!=0) class="text-primary" @endif>{{$total}}</td>
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading"><strong>最近一周商家菜品销量统计</strong></div>
            <!--最近一周商家菜品销量统计图-->
            <div class="panel-body">
                <div id="main3" style="height:400px;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr class="active">
                    <td>商家名称</td>
                    @foreach($week as $day)
                    <td>{{$day}}</td>
                    @endforeach
                </tr>
                @foreach($shopWeek as $id=>$date)
                    <tr>
                        <td><a href="{{route('shop.show',[$id])}}">{{mb_substr($shops[$id],0,5)}}</a></td>
                        @foreach($date as $amount)
                            <td @if($amount!=0) class="text-danger" @endif>{{$amount}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading"><strong>最近三月商家菜品销量统计</strong></div>
            <!--最近三月商家菜品销量统计图-->
            <div class="panel-body">
                <div id="main4" style="height:400px;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr class="active">
                    <td>商家名称</td>
                    @foreach($months as $month)
                        <td>{{$month}}</td>
                    @endforeach
                </tr>
                @foreach($shopMonth as $id=>$date)
                    <tr>
                        <td><a href="{{route('shop.show',[$id])}}">{{mb_substr($shops[$id],0,5)}}</a></td>
                        @foreach($date as $amount)
                            <td @if($amount!=0) class="text-danger" @endif>{{$amount}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>
<script src="/js/echarts.common.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'),'light');
    // 指定图表的配置项和数据
    var option = {
        title: {
            text: '最近一周订单量统计图'
        },
        tooltip: {},
        legend: {
            data:['订单量']
        },
        xAxis: {
            type: 'category',
            data: @php echo json_encode(array_keys($orderWeek)) @endphp
        },
        yAxis: {},
        series: [{
            data: @php echo json_encode(array_values($orderWeek)) @endphp,
            type: 'line'
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    //图2
    var myChar2 = echarts.init(document.getElementById('main2'),'light');
    // 指定图表的配置项和数据
    var option2 = {
        title: {
            text: '最近三月订单量统计图'
        },
        tooltip: {},

        xAxis: {
            data: @php echo  json_encode(array_keys($orderMonth)) @endphp
        },
        yAxis: {},
        series: [{
            name: '销量',
            type: 'bar',
            data: @php echo json_encode(array_values($orderMonth)) @endphp
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChar2.setOption(option2);

    //图3
    var myChart3 = echarts.init(document.getElementById('main3'),'light');
    // 指定图表的配置项和数据
    var option3 = {
        title: {
            text: '最近一周商家菜品销量统计图'
        },
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: @php echo json_encode($week) @endphp
        },
        yAxis: {
            type: 'value'
        },
        series: @php echo json_encode($series) @endphp
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option3);

    //图4
    var myChart4 = echarts.init(document.getElementById('main4'),'light');
    // 指定图表的配置项和数据
    var option4 = {
        title: {
            text: '最近三月商家菜品销量统计图'
        },
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: @php echo json_encode($months) @endphp
        },
        yAxis: {
            type: 'value'
        },
        series: @php echo json_encode($series2) @endphp
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart4.setOption(option4);


</script>



@endsection