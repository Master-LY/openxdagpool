@extends('layouts.app')

@section('title')
	主页
@endsection

@section('hero')
	<section class="hero is-primary home-hero">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					{{ Setting::get('pool_name') }}
					@if ($pools)
						<div class="dropdown is-hoverable">
							<div class="dropdown-trigger">
								<button class="button" aria-haspopup="true" aria-controls="pool-selection">
									<span>{{ $current_pool_name }}</span>
									<span class="icon is-small">
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</span>
								</button>
							</div>

							<div class="dropdown-menu" id="pool-selection" role="menu">
								<div class="dropdown-content">
									@foreach ($pools as $pool)
										<a href="{{ $pool['url'] }}" class="dropdown-item{{ $pool['is_current_pool'] ? ' is-active' : '' }}">
											{{ $pool['name'] }}
										</a>
									@endforeach
								</div>
							</div>

							<span class="pool-selection-info tooltip is-tooltip-multiline" data-tooltip="Each pool has it's own database and user accounts. Register to use the pool to the fullest extent."><i class="fa fa-info-circle"></i></span>
						</div>
					@endif
				</h1>
				@if(Setting::get('pool_tagline') !== null)
					<h2 class="subtitle">
						@if (Setting::get('pool_tooltip') !== null)
							<span class="tooltip" data-tooltip="{{ Setting::get('pool_tooltip') }}">
								{{ Setting::get('pool_tagline') }}
							</span>
						@else
							{{ Setting::get('pool_tagline') }}
						@endif
					</h2>
				@endif
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="home-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				@if ($message)
					<div class="notification is-info">
						<button class="delete"></button>
						{!! $message !!}
					</div>
				@endif

				@if (isset($authUser) && $authUser->isAdministrator())
					<div class="notification is-danger" id="adminPoolStateAlert">
						<button class="delete"></button>
						警告，矿池进程状态异常。本通知仅管理员可见。<br>
						<span id="poolVersion"></span><br>
						<span id="poolState"></span>
					</div>
				@endif

				<div class="notification" id="balanceResult">
					<button class="delete"></button>
					<span></span>
					<p><a href="#">查看支出</a></p>
				</div>

				<nav class="card">
					<header class="card-header">
						<div class="tabs stat-tabs">
							<ul>
								<li class="is-active" data-target=".pool-stats"><a>矿池统计</a></li>
								<li data-target=".pool-blocks"><a>已发现区块</a></li>
								<li data-target=".network-stats"><a>全网统计</a></li>
								@if (!Auth::guest())
									<li data-target=".user-stats"><a>{{ Auth::user()->display_nick }} 的统计</a></li>
								@endif
							</ul>
						</div>
					</header>

					<div class="card-content stats">
						<nav class="level is-mobile pool-stats">
							<div class="level-item has-text-centered tooltip" data-tooltip="Past 4 hours hashrate. Click for details.">
								<div>
									<p class="heading">算力</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="pool_hashrate"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered tooltip" data-tooltip="Currently active miners. Click for details.">
								<div>
									<p class="heading">矿工</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="miners"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered stat-tooltip is-tooltip-multiline" data-stat="config">
								<div>
									<p class="heading">费用</p>
									<p class="title stat api is-loading" data-stat="fees"></p>
								</div>
							</div>
							<div class="level-item has-text-centered stat-tooltip is-tooltip-multiline" data-stat="uptime_exact">
								<div>
									<p class="heading">上线时间</p>
									<p class="title stat api is-loading" data-stat="uptime"></p>
								</div>
							</div>
						</nav>
						<nav class="level is-mobile pool-blocks inactive-tab-stats">
							<div class="level-item has-text-centered tooltip is-tooltip-multiline" data-tooltip="Updates every 4 hours. Click for details.">
								<div>
									<p class="heading">上一月</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="blocks_last_month"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered tooltip is-tooltip-multiline" data-tooltip="Updates every 4 hours. Click for details.">
								<div>
									<p class="heading">上一周</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="blocks_last_week"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered tooltip is-tooltip-multiline" data-tooltip="Updates every 4 hours. Click for details.">
								<div>
									<p class="heading">昨日</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="blocks_last_day"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered tooltip is-tooltip-multiline" data-tooltip="Updates every 4 hours. Approximate value based on last 20 blocks found. Click for a listing of latest found blocks.">
								<div>
									<p class="heading">每个块</p>
									<p class="title">
										<a href="{{ route('found-blocks') }}" class="stat api is-loading" data-stat="block_found_every"></a>
									</p>
								</div>
							</div>
						</nav>
						<nav class="level is-mobile network-stats inactive-tab-stats">
							<div class="level-item has-text-centered tooltip" data-tooltip="Past 4 hours hashrate. Click for details.">
								<div>
									<p class="heading">算力</p>
									<p class="title">
										<a href="{{ route('stats') }}" class="stat api is-loading" data-stat="network_hashrate"></a>
									</p>
								</div>
							</div>
							<div class="level-item has-text-centered tooltip" data-tooltip="Number of known blocks">
								<div>
									<p class="heading">区块</p>
									<p class="title stat api is-loading" data-stat="blocks"></p>
								</div>
							</div>
							<div class="level-item has-text-centered stat-tooltip" data-stat="supply" data-stat-prefix="Coin supply: ">
								<div>
									<p class="heading">主区块</p>
									<p class="title stat api is-loading" data-stat="main_blocks"></p>
								</div>
							</div>
							<div class="level-item has-text-centered stat-tooltip" data-stat="difficulty_exact">
								<div>
									<p class="heading">难度</p>
									<p class="title stat api is-loading" data-stat="difficulty"></p>
								</div>
							</div>
						</nav>
						@if (!Auth::guest())
							<nav class="level is-mobile user-stats inactive-tab-stats">
								<div class="level-item has-text-centered tooltip" data-tooltip="Your estimated hashrate. Click for details.">
									<div>
										<p class="heading">算力</p>
										<p class="title">
											<a href="{{ route('miners') }}" class="stat api is-loading" data-stat="user_hashrate"></a>
										</p>
									</div>
								</div>
								<div class="level-item has-text-centered tooltip" data-tooltip="Your active miners (machines). Click for details.">
									<div>
										<p class="heading">矿工</p>
										<p class="title">
											<a href="{{ route('miners') }}" class="stat api is-loading" data-stat="user_miners"></a>
										</p>
									</div>
								</div>
								<div class="level-item has-text-centered stat-tooltip" data-stat="user_earnings" data-stat-prefix="Earnings: ">
									<div>
										<p class="heading">余额</p>
										<p class="title">
											<a href="{{ route('miners') }}" class="stat api is-loading" data-stat="user_balance"></a>
										</p>
									</div>
								</div>
								<div class="level-item has-text-centered tooltip is-tooltip-multiline" data-tooltip="Out of all pool users with registered miners, this is how your hashrate compares to them.">
									<div>
										<p class="heading">排名</p>
										<p class="title">
											<a href="{{ route('leaderboard') }}" class="stat api is-loading" data-stat="user_rank"></a>
										</p>
									</div>
								</div>
							</nav>
						@endif
					</div>
				</nav>
			</div>
		</div>

		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<nav class="card">
					<header class="card-header">
						<p class="card-header-title">
							钱包余额和支出
						</p>
					</header>

					<div class="card-content">
						<div class="content">
							<form action="#" method="post" id="balanceCheckForm">
								<div class="field has-addons is-horizontal">
									<div class="control is-expanded">
										<input class="input is-fullwidth" type="text" name="address" placeholder="Wallet address" maxlength="32" required>
									</div>
									<div class="control">
										<button class="button tooltip is-tooltip-multiline" data-tooltip="Balances update every 30 minutes. Payouts update every 4 hours." type="submit">
											显示
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<nav class="card">
					<header class="card-header">
						<p class="card-header-title">
							挖矿信息
						</p>
					</header>

					<div class="card-content">
						<p>Windows GPU (<a href="{{ route('pages', 'setup/windows-gpu') }}">详细介绍</a>):</p>
						<pre class="oneline">
							<span class="parameter">C:\DaggerGpuMiner</span>\DaggerGpuMiner.exe -G -a <span class="parameter">wallet_address</span> -p {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }} -t 0 -v 2 -opencl-platform <span class="parameter">platform_id</span> -opencl-devices <span class="parameter">device_nums</span>
						</pre>
						<p class="offset">用你的xdag矿工安装目录替代 <span class="parameter">C:\DaggerGpuMiner</span> 。</p>
						<p>用你的钱包地址替代 <span class="parameter">wallet_address</span> 。</p>
						<p>用 <code>0</code>, <code>1</code> 或 <code>2</code> 替代 <span class="parameter">platform_id</span> 。先尝试 <code>0</code> ，这是最普遍的平台id。</p>
						<p>用 <code>0</code> 或 <code>0 1 2 3</code> 替代 <span class="parameter">device_nums</span> 。根据矿机的GPU数量-1来设置，从 <code>0</code> 开始计数（一个GPU填0，两个填1，3个填2，以此类推）。</p>
						<p><span class="important">注意：</span> 如果你使用的是 NVIDIA GPU，为防止过高的系统CPU占用以及增加算力，请在命令行添加 <code>-nvidia-fix</code> 。</p>

						<hr>

						<p>Windows CPU (<a href="{{ route('pages', 'setup/windows-cpu') }}">详细介绍</a>):</p>
						<pre class="oneline">
							<span class="parameter">C:\xdag</span>\xdag.exe -d -m <span class="parameter">4</span> {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}
						</pre>
						<p class="offset">用你的xdag安装目录替代 <span class="parameter">C:\xdag</span> 。</p>
						<p>用挖矿线程数替代 <span class="parameter">4</span> ，对于专用矿机，将该数量设置为CPU线程数。</p>

						<hr>

						<p>Unix GPU (<a href="{{ route('pages', 'setup/unix-gpu') }}">详细介绍</a>):</p>
						<pre class="oneline">
							./xdag-gpu -G -a <span class="parameter">wallet_address</span> -p {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }} -t 0 -v 2 -opencl-platform <span class="parameter">platform_id</span> -opencl-devices <span class="parameter">device_nums</span>
						</pre>
						<p class="offset">用你的钱包地址替代 <span class="parameter">wallet_address</span> 。</p>
						<p>用 <code>0</code>，<code>1</code> 或 <code>2</code> 替代 <span class="parameter">platform_id</span> 。先尝试用 <code>0</code> ，这是最普遍的平台id。</p>
						<p>用 <code>0</code> 或 <code>0 1 2 3</code> 替代 <span class="parameter">device_nums</span> 。根据矿机的GPU数量-1来设置，从 <code>0</code> 开始计数（一个GPU填0，两个填1，3个填2，以此类推）。</p>
						<p><span class="important">注意：</span> 如果你使用的是 NVIDIA GPU，为防止过高的系统CPU占用以及增加算力，请在命令行添加 <code>-nvidia-fix</code> 。</p>

						<hr>
						<p>Unix CPU (<a href="{{ route('pages', 'setup/unix-cpu') }}">详细介绍</a>):</p>
						<pre class="oneline">
							./xdag -d -m <span class="parameter">4</span> {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}
						</pre>
						<p class="offset">用挖矿线程数替代 <span class="parameter">4</span> ，对于专用矿机，将该数量设置为CPU线程数。</p>
					</div>
				</nav>
			</div>
		</div>

		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<nav class="card"
					<header class="card-header">
						<p class="card-header-title">
							注册（可选）
						</p>
					</header>

					<div class="card-content">
						<div class="content">
							注册后可以更容易地追踪你的矿工，包括它们的算力，余额，支出和在矿工离线的时候收到email提醒。
						</div>
					</div>
				</nav>
			</div>
		</div>

		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<nav class="card">
					<header class="card-header">
						<p class="card-header-title">
							矿池新闻
						</p>
					</header>

					<div class="card-content">
						<div class="content">
							{!! Setting::get('pool_news_html') !!}
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var homeView = new homeView();
	</script>
@endsection
