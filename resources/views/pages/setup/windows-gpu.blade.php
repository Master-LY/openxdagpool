@extends('layouts.app')

@section('title')
	Windows GPU 矿工设置 (64位 Windows 10)
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Windows GPU 矿工设置
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
							<li>从 <a href="https://github.com/jonano614/DaggerGpuMiner/releases" target="_blank">GitHub</a> 下载最新的 <code>x64</code> 压缩包。</li>
							<li>将档案解压缩到 <code>C:\DaggerGpuMiner</code></li>
							<li>从 <a href="https://github.com/XDagger/xdag/releases" target="_blank">官方资源库</a> 下载 <code>XDag.x64.zip</code> 钱包。</li>
							<li>将档案解压缩到 <code>C:\DaggerGpuMiner\wallet</code></li>
							<li>创建一个新的bat文件 <code>C:\DaggerGpuMiner\wallet\RUNWALLET.bat</code></li>
							<li>用记事本编辑。在文件中插入一行： <pre class="oneline">C:\DaggerGpuMiner\wallet\xdag.exe -d -m 1 {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}</pre>
							<li>运行 <code>RUNWALLET.bat</code> 文件。</li>
							<li>设置你的钱包密码，输入随机密钥（至少3行随机密钥）。等到主机密钥生成（可能需要一段时间）。</li>
							<li>键入 <code>state</code> 并按下Enter键。如果输出不是 <code>Connected to the mainnet pool. Mining on. Normal operation.</code> ，请稍等一下，然后键入 <code>state</code> 并再次回车。</li>
							<li>键入 <code>account</code> 。你会看到你的XDAG地址。使用鼠标选择它，然后按ENTER将其复制到剪贴板中。</li>
							<li>打开一个新的记事本窗口，并在那里粘贴您的XDAG钱包地址。</li>
							<li>返回到打开的CPU矿工控制台，输入 <code>terminate</code> ，然后按enter键。</li>
							<li>创建一个新的bat文件 <code>C:\DaggerGpuMiner\RUNMINER.bat</code></li>
							<li>用记事本编辑。在文件中插入一行： <pre class="oneline">C:\DaggerGpuMiner\DaggerGpuMiner.exe -G -a <span class="parameter">wallet_address</span> -p {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }} -t 0 -v 2 -opencl-platform <span class="parameter">platform_id</span> -opencl-devices <span class="parameter">device_nums</span></pre> 用您复制到记事本中的地址替换 <span class="parameter">wallet_address</span> 。用您的OpenCL平台ID替换 <span class="parameter">platform_id</span> ，这通常是最常用的 <code>0</code> （也可以在必要时尝试 <code>1</code> 或 <code>2</code> ）。如果系统中有多个GPU，则从零计数到（设备数量 - 1），例如，如果系统中有4个GPU，则将 <span class="parameter">device_nums</span> 替换为 <code>0 1 2 3</code> 。如果你只有一个GPU，用<code>0</code> 更换 <span class="parameter">device_nums</span> 。要查看高级GPU矿工参数，请执行 <code>DaggerGpuMiner.exe -h</code>.</li>
							<li>双击 <code>RUNMINER.bat</code> 文件，你的矿工将开始运行。不要关闭控制台窗口。</li>
						</ol>
						<p>完成！有关用法，请参阅下面用法部分。</p>
						<p><span class="important">注意：</span> 如果您使用的是NVIDIA GPU，请确保在步骤14中添加 <code>-nvidia-fix</code> 到GPU矿工命令行的末尾以防止高系统CPU使用率并增加哈希率。</p>
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
							<li>要启动矿工，只需运行该 <code>RUNMINER.bat</code> 文件即可。</li>
							<li>要将安装更新到最新版本，请通过在矿工控制台按下 <code>CTRL+C</code> 来停止矿工。从 <a href="https://github.com/jonano614/DaggerGpuMiner/releases" target="_blank">GitHub</a> 下载新版 <code>x64</code> 压缩包。解压到 <code>C:\DaggerGpuMiner</code>，覆盖文件。照常运行 <code>RUNMINER.bat</code> 。</li>
							<li>要随时查看您当前的余额，请执行 <code>RUNWALLET.bat</code>，输入您的钱包密码，按回车，键入 <code>balance</code> 并回车。如果您看到 <code>not ready to show balance</code>，请稍等一会并再次输入 <code>balance</code> 然后回车。完成操作后，输入 <code>terminate</code> 并回车，关闭钱包。您也可以使用我们的网站随时在主页上查看您的余额，或 <a href="{{ route('register') }}">注册</a> 你的矿工以自动显示余额，支出，未付份额等。</li>
						</ol>
					</div>
				</div>
			</nav>
		</div>
	</div>
@endsection
