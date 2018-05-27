@extends('layouts.admin')

@section('title')
	矿池状态
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					矿池状态
				</h1>
				<h2 class="subtitle">
					查看矿池进程状态及其他各种信息
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('adminContent')
	<nav class="card">
		<header class="card-header">
			<p class="card-header-title">
				矿池状态、版本、统计数据和矿工
			</p>
		</header>

		<div class="card-content">
			<p>
				@if (!$state_normal)
					矿池状态 <strong>(abnormal)</strong>:
				@else
					矿池状态：
				@endif
<pre>{{ $state }}</pre>
			</p>
			<p>
				统计： <br>
<pre>{{ $stats }}</pre>
			</p>
			<p>
				矿工： <br>
<pre>{{ $miners }}</pre>
			</p>
		</div>
	</nav>
@endsection
