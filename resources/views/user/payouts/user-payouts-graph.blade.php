@extends('layouts.app')

@section('title')
	{{ $authUser->display_nick }} 的收入
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					支出历史
				</h1>
				<h2 class="subtitle">
					在本矿池获取的币
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="payouts-graph-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<h4 class="title is-4">{{ $authUser->display_nick }} 的收入</h4>

				<div class="tabs">
					<ul>
						<li class="is-active"><a href="{{ route('user.payouts.graph') }}">图形</a></li>
						<li><a href="{{ route('user.payouts.listing') }}">排列</a></li>
					</ul>
				</div>

				<div id="graph"></div>

				<h5 class="title is-5"> 共计：{{ number_format($payouts_sum, 9, '.', ',') }} XDAG</h5>

				<a class="button is-primary is-pulled-right" href="{{ route('user.payouts.export-graph') }}" target="_blank">
					<span class="icon"><i class="fa fa-file-excel-o"></i></span>
					<span>输出</span>
				</a>

				<a class="button" href="{{ route('miners') }}">
					<span>返回</span>
				</a>
				<hr>
				<p><span class="important">注意：</span> 支出数据大约4小时更新一次。当就绪时会立即支付。</p>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var payoutsView = new payoutsView('{!! $graph_data !!}');
	</script>
@endsection
