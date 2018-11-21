<style>
    img{max-width: 95%;}
</style>
@extends('common.default')
@section('contents')
    <div class="row">
        <div class="col-md-4">
            <img src="{{$prize->img}}" style="width: 100%"/>
        </div>
        <div class="col-md-8">
            <h2>{{$prize->title}}</h2>
            <p>{!! mb_substr($prize->content,0,50) !!}</p>
            <div>
                <p>提供<span class="text-danger">{{$prize->amount}}</span>份 | 已有<span class="text-danger">{{count($prize->prizeMember)}}</span>/{{$prize->signup_num}}人申请</p>

                @if(isset($woner))
                    <div class="bg-warning clearfix" style="padding: 10px;">
                        <h4 class="pull-left text-warning">获奖用户：</h4>
                        @foreach($woner as $user)
                            <div class="pull-left text-center">
                                <img src="{{$user->img}}" class="img-circle" style="width:40px; height: 40px; border:1px solid #ddd;"/>
                                <p>{{$user->name}}</p>
                            </div>
                        @endforeach
                    </div>
                @elseif($prize->signup_end <= time())
                    <h3>报名已截止 </h3>
                @elseif(strtotime($prize->prize_date) <= time())
                    <p style="width:300px"><a href="{{ route('prize.openPrize',[$prize]) }}" class="btn btn-danger btn-block btn-lg" role="button">立即开奖</a></p>
                @else
                    <h3 class="newtime"> 倒计时 </h3>
                @endif
            </div>
        </div>


    </div>
    <div class="panel panel-default" style="margin-top: 30px;">
        <div class="panel-heading">试用详情</div>
        <div class="panel-body">{!! $prize->content !!}</div>
    </div>


@endsection
<script>
    var runtimes = 0;
    function GetRTime(){
        var nMS = @php  echo ($prize->signup_end)-time(); @endphp *1000 - runtimes*1000;

        if (nMS>=0){
            var nD=Math.floor(nMS/(1000*60*60*24))%24;
            var nH=Math.floor(nMS/(1000*60*60))%24;
            var nM=Math.floor(nMS/(1000*60)) % 60;
            var nS=Math.floor(nMS/1000) % 60;
            var newtime=nD+'天'+nH+'小时'+nM+'分'+nS+'秒';
            $('.newtime').html(newtime);
            runtimes++;
            setTimeout("GetRTime()",1000);
        }
    }
    window.onload = function() {
        GetRTime();
    }
</script>