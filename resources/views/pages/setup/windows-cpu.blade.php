@extends('layouts.app')

@section('title')
	Windows CPU 矿工设置 (64位 Windows 10)
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Windows CPU 矿工设置
				</h1>
				<h2 class="subtitle">
					适用于64位 Windows 10
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="columns is-marginless is-centered">
		<div class="column is-7">
			<nav class="card">
				<header class="card-header">
					<p class="card-header-title">
						设置步骤
					</p>
				</header>

				<div class="card-content">
					<div class="content">
						<ol>
							<li>从 <a href="https://github.com/XDagger/xdag/releases" target="_blank">官方资源库</a> 下载 <code>XDag.x64.zip</code> 。</li>
							<li>将档案解压缩到 <code>C:\xdag</code></li>
							<li>创建一个新的bat文件 <code>C:\xdag\RUNMINER.bat</code></li>
							<li>在文件中插入一行： <pre class="oneline">C:\xdag\xdag.exe -d -m <span class="parameter">4</span> {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}</pre> 将 <span class="parameter">4</span> 替换为挖矿所需要的线程数，对于专用矿机，将其设置为CPU线程数以最大化采矿效率。</li>
							<li>双击 <code>RUNMINER.bat</code> 文件，设置您的钱包密码，输入随机密钥（至少3行随机密钥）。一旦主密钥生成（可能需要一段时间），矿工将开始运行。不要关闭控制台窗口。</li>
						</ol>
						<p>完成！有关用法，请参阅下一个部分。</p>
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
						用法
					</p>
				</header>

				<div class="card-content">
					<div class="content">
						<ol>
							<li>要启动矿工，只需运行 <code>RUNMINER.bat</code> 文件即可。</li>
							<li>要将安装更新到最新版本，请通过在挖矿控制台中输入 <code>terminate</code> 来停止矿工，然后按回车键。从 <a href="https://github.com/XDagger/xdag/releases" target="_blank">官方资源库</a> 下载新版本 <code>XDag.x64.zip</code>。将档案解压缩至 <code>C:\xdag</code>，覆盖文件。然后照常运行 <code>RUNMINER.bat</code> 。</li>
							<li>要随时查看您的当前余额，请在矿工控制台输入 <code>balance</code> 。如果你想看到你的钱包地址，请在矿工控制台输入 <code>account</code> 。要复制您的钱包地址，请使用鼠标选择它并按Enter键。您也可以使用我们的网站随时在主页上查看您的余额，或 <a href="{{ route('register') }}">注册</a> 你的矿工以自动显示余额，支出，未付份额等。</li>
						</ol>
					</div>
				</div>
			</nav>
		</div>
	</div>
@endsection
