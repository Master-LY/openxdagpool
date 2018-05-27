@extends('layouts.app')

@section('title')
	Payouts - {{ $miner->short_address }}
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
	<div class="payouts-listing-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<h4 class="title is-4">地址 {{ $miner->address }}</h4>

				<div class="tabs">
					<ul>
						<li><a href="{{ route('miners.payouts.graph', $miner->uuid) }}">图像</a></li>
						<li class="is-active"><a href="{{ route('miners.payouts.listing', $miner->uuid) }}">排列</a></li>
					</ul>
				</div>

				@include('user.payouts.partials.listing')

				<div class="links">
					<a class="button is-primary is-pulled-right" href="{{ route('miners.payouts.export-listing', $miner->uuid) }}" target="_blank">
						<span class="icon"><i class="fa fa-file-excel-o"></i></span>
						<span>输出</span>
					</a>

					<a class="button" href="{{ route('miners') }}">
						<span>返回</span>
					</a>
				</div>
				<hr>
				<p><span class="important">注意：</span> 支出数据大约4小时更新一次。按UTC排列。当就绪时会立即支付。</p>
			</div>
		</div>
	</div>
@endsection
