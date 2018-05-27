@extends('layouts.app')

@section('title')
	算力 - {{ $miner->short_address }}
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					算力图表
				</h1>
				<h2 class="subtitle">
					你的矿工表现
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="hashrate-graph-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<h4 class="title is-4">地址 {{ $miner->address }}</h4>

				<div class="tabs">
					<ul>
						<li{!! $type == 'latest' ? ' class="is-active"' : '' !!}><a href="{{ route('miners.hashrate.graph', [$miner->uuid, 'latest']) }}">过去 3 天</a></li>
						<li{!! $type == 'daily' ? ' class="is-active"' : '' !!}><a href="{{ route('miners.hashrate.graph', [$miner->uuid, 'daily']) }}">所有时间</a></li>
					</ul>
				</div>

				<div id="graph"></div>

				<h5 class="title is-5 is-pulled-right tooltip" data-tooltip="Averaged over last 4 hours."> 平均算力： {{ $average_hashrate }}</h5>
				<h5 class="title is-5">当前算力： {{ $current_hashrate }}</h5>

				<hr>
				<p><span class="important">注意：</span> 算力每5分钟更新一次。算力计算非常不精确，并不代表矿池内的真实算力，也不代表矿工的真实算力，更不会影响支付。数据仅为统计近似值，用作参考。大约6小时后数值会接近真实算力值。在CPU矿工控制台键入 <code>stats</code> 或者观察 GPU 矿工显示的数值可以得知真实算力。</p>
				<hr>
				<p><span class="important">注意：</span> 如果你删除了矿工或矿工掉线超过3天，其算力数据将永久丢失。只有注册并且活跃的矿工才有从注册时间开始的算力历史纪录。</p>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var hashrateView = new hashrateView('{{ $type }}', '{!! $graph_data !!}');
	</script>
@endsection
