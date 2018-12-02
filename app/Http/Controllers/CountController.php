<?php
//统计
namespace App\Http\Controllers;

use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    //首页
    public function index()
    {
        //最近一周订单量统计
        $time_start=date('Y-m-d 00:00:00',strtotime('-6 day'));
        $time_end=date('Y-m-d 23:59:59');
        $rows=DB::select("select date(created_at) as date,count(*) as count,sum(total) as total from orders where created_at>='{$time_start}' and created_at<= '{$time_end}' GROUP BY date(created_at)");
        //重构时间格式 日期=>单量 和日期=>金额
        $orderWeek=[];
        $orderMoney=[];
        $week=[]; //一周时间格式
        for($i=6;$i>=0;$i--){
            $week[]=date('Y-m-d',strtotime("-{$i} day"));
        }
        //dd($week);
        foreach($week as $k=>$date){
            $orderWeek[$date]=0;
            $orderMoney[$date]=0;
        }
        foreach($rows as $row){
            $orderWeek[$row->date]=$row->count;
            $orderMoney[$row->date]=$row->total;
        }
        //dd($weekMoney);

        //最近三月订单量统计
        $month_start=date('Y-m-d 00:00:00',strtotime('-3 month'));
        $rows2=DB::select("select month(created_at) as month,count(*) as count,sum(total) as total from orders where created_at>='{$month_start}' and created_at<= '{$time_end}' GROUP BY month(created_at)");
        //dd($rows2);
        //重构时间格式 月=>单量 月=>金额
        $orderMonth=[];
        $monthMoney=[];
        $months=[];
        for($i=2;$i>=0;$i--){
            $months[]=date('Y-m',strtotime("-{$i} month"));
        }
        foreach($months as $month){
            $orderMonth[$month]=0;
            $monthMoney[$month]=0;
        }
        foreach($rows2 as $row2){
            $orderMonth[date('Y-').str_pad($row2->month,2,0,0)]=$row2->count;
            $monthMoney[date('Y-').str_pad($row2->month,2,0,0)]=$row2->total;
        }
        //dd($monthMoney);

        //最近一周商家菜品销量统计
        $rows3=DB::select("SELECT
	date(orders.created_at) AS date,
	sum(order_details.amount) as amount,
	orders.shop_id as shop_id
FROM
	orders JOIN order_details on orders.id=order_details.order_id
WHERE
	orders.created_at >= '{$time_start}'
AND orders.created_at <= '{$time_end}'
GROUP BY
	orders.shop_id,date(orders.created_at)");
        //dd($rows3);
        $shopWeek=[];
        //获取商家列表
        $shops=Shop::where('status',1)->select('id','shop_name')->get();
        $keyed=$shops->mapWithKeys(function ($item){
            return [$item['id']=>$item['shop_name']];
        });
        $shops=$keyed->all();
        foreach($shops as $id=>$name){
            foreach($week as $date){
                $shopWeek[$id][$date]=0;
            }
        }
        //dd($shopWeek);
        foreach($rows3 as $row3){
            $shopWeek[$row3->shop_id][$row3->date]=$row3->amount;
        };
        //前端图形数据
        $series = [];
        foreach ($shopWeek as $id=>$data){
            $serie = [
                'name'=> $shops[$id],
                'type'=>'line',
                'data'=>array_values($data)
            ];
            $series[] = $serie;
        }


        //最近三月商家菜品销量统计
        $rows4=DB::select("SELECT
	orders.shop_id as shop_id,
	month(orders.created_at) AS month,
	sum(order_details.amount) as amount	
FROM
	orders JOIN order_details on orders.id=order_details.order_id
WHERE
	orders.created_at >= '{$month_start}'
AND orders.created_at <= '{$time_end}'
GROUP BY
	orders.shop_id,month(orders.created_at)");
        $shopMonth=[];
        foreach($shops as $id=>$name){
            foreach($months as $month){
                $shopMonth[$id][$month]=0;
            }
        }
        foreach($rows4 as $row4){
            $shopMonth[$row4->shop_id][date('Y-').str_pad($row4->month,2,0,0)]=$row4->amount;
        };
        //前端图形数据
        $series2 = [];
        foreach ($shopMonth as $id=>$data){
            $serie2 = [
                'name'=> $shops[$id],
                'type'=>'line',
                'data'=>array_values($data)
            ];
            $series2[] = $serie2;
        }

        //会员数
        $members=DB::select("select count(*) as count from members");
        $memberCount=0;
        foreach($members as $count){
            $memberCount=$count->count;
        }

        //已销售菜品总量
        $goodsAmount=DB::select("select sum(amount) as amount from order_details");
        $goodsCount=0;
        foreach($goodsAmount as $amount){
            $goodsCount=$amount->amount;
        }
        return view('index',compact('orderWeek','orderMoney','orderMonth','monthMoney','shops',
            'shopWeek','week','series','shopMonth','series2','months','memberCount','goodsCount'));

    }
}
