@extends('layouts.app')

@section('title')
	支出 - {{ $miner->short_address }}
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					支出历史
				</h1>
				<h2 class="subtitle">
					在本矿池获得的币
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
						<li><a href="{{ route('payouts.graph', ['address' => $miner->address]) }}">图表</a></li>
						<li class="is-active"><a href="{{ route('payouts.listing', ['address' => $miner->address]) }}">排列</a></li>
					</ul>
				</div>

				@include('user.payouts.partials.listing')

				<div class="links">
					<a class="button is-primary is-pulled-right" href="{{ route('payouts.export-listing', ['address' => $miner->address]) }}" target="_blank">
						<span class="icon"><i class="fa fa-file-excel-o"></i></span>
						<span>导出</span>
					</a>

					<a class="button" href="{{ route('home') }}">
						<span>返回</span>
					</a>
				</div>
				<hr>
				<p><span class="important">注意：</span> 支出平均每4小时更新一次。时间按照UTC排列。当准备就绪时系统会立即发送支出。</p>
			</div>
		</div>
	</div>
@endsection
