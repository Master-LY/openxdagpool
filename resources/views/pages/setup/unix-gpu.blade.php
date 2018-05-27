@extends('layouts.app')

@section('title')
	Unix GPU 矿工设置 (Ubuntu 16.04)
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Unix GPU 矿工设置
				</h1>
				<h2 class="subtitle">
					适用于 Ubuntu 16.04
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
						首先设置您的XDAG钱包。
						<ol>
							<li><code>cd</code> 到您的主目录。不要以 <code>root</code> 运行钱包！</li>
							<li>执行：<code>sudo apt-get install gcc libssl-dev build-essential git</code></li>
							<li>执行：<code>git clone https://github.com/XDagger/xdag.git</code></li>
							<li>更改目录： <code> cd ./xdag/client</code></li>
							<li>运行 <code>make</code></li>
							<li>以 <code>./xdag -d -m 1 {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}</code> 运行钱包。设置你的钱包密码，输入随机密钥（至少3行随机密钥）。等待主机密钥生成。</li>
							<li>执行 <code>./xdag -i</code> 。键入 <code>terminate</code> 并按Enter键关闭您的钱包。</li>
							<li><code>cd</code> 到您的主目录</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_wallet_console.sh
#!/bin/bash

pidof xdag > /dev/null

if [ "$?" -ne 0 ]; then
	echo "Wallet not running! Start it with ./xdag_wallet_run.sh"
	exit 1
fi

echo Starting wallet console...
(cd ./xdag/client &amp;&amp; ./xdag -i)
echo -n "Wallet PIDs: "
pidof xdag
EOD</pre>
							</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_wallet_run.sh
#!/bin/bash

PIDS="`pidof xdag`"

if [ "$?" -eq 0 ]; then
	echo "Wallet already running? PIDs: ${PIDS}"
	echo "run ./xdag_wallet_console.sh and type 'terminate' to terminate the wallet."
	exit 1
fi

echo Starting wallet...
(cd ./xdag/client &amp;&amp; ./xdag -d -m 1 {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }})
echo -n "Wallet PIDs: "
pidof xdag
EOD</pre>
							</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_wallet_update.sh
#!/bin/bash

PIDS="`pidof xdag`"

if [ "$?" -eq 0 ]; then
	echo "Wallet is running! Stop it before updating. PIDs: ${PIDS}"
	echo "run ./xdag_wallet_console.sh and type 'terminate' to terminate the wallet."
exit 1
fi

echo Updating git repository...
(cd ./xdag &amp;&amp; git pull &amp;&amp; cd ./client &amp;&amp; make)

echo "Done! Start the wallet with ./xdag_wallet_run.sh"
EOD</pre>
							</li>
							<li>执行 <code>chmod +x xdag_*</code></li>
						</ol>
						<p>你的钱包已经准备就绪。接下来，GPU矿工将成立。</p>

						<ol>
							<li>作为 <code>root</code>, 安装与您的发行版相匹配的 <a href="https://developer.amd.com/amd-accelerated-parallel-processing-app-sdk/" target="_blank">AMD APP SDK</a> 。这对于AMD和NVIDIA卡都是必需的。</li>
							<li>根据您的显卡安装 <a href="https://support.amd.com/en-us/download/linux" target="_blank">AMD</a> 或 <a href="http://www.nvidia.com/object/unix.html" target="_blank">NVIDIA</a> 显卡驱动程序。</li>
							<li><code>cd</code> 到您的主目录。不要以 <code>root</code> 运行GPU矿工！</li>
							<li>执行： <code>sudo apt-get install git gcc libssl-dev make ocl-icd-opencl-dev libboost-all-dev screen</code></li>
							<li>执行： <code>git clone https://github.com/jonano614/DaggerGpuMiner.git</code></li>
							<li>执行： <code>cd DaggerGpuMiner/GpuMiner</code></li>
							<li>执行： <code>make all</code></li>
							<li><code>cd</code> 到您的主目录。</li>
							<li>执行： <code>./xdag_wallet_run.sh</code>。输入您的钱包密码，然后执行 <code>./xdag_wallet_console.sh</code>。键入 <code>account</code>。复制您的钱包地址。键入 <code>terminate</code> 关闭你的钱包。</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_miner_run.sh
#!/bin/bash

PIDS="`pidof xdag-gpu`"

if [ "$?" -eq 0 ]; then
	echo "Miner already running? PIDs: ${PIDS}"
	echo "run 'screen -x' and press CTRL+C to terminate the miner."
	exit 1
fi

if [ "$STY" == "" ]; then
	echo "Please execute 'screen' first before executing this script."
	exit 1
fi

echo Starting miner...
(cd ./DaggerGpuMiner/GpuMiner &amp;&amp; ./xdag-gpu -G -a <span class="parameter">wallet_address</span> -p {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }} -t 0 -v 2 -opencl-platform <span class="parameter">platform_id</span> -opencl-devices <span class="parameter">device_nums</span>)
echo -n "Miner PIDs: "
pidof xdag-gpu
EOD</pre>
								将 <span class="parameter">wallet_address</span> 替换为您复制的地址。用您的OpenCL平台ID 替换 <span class="parameter">platform_id</span> ，这通常是的 <code>0</code> （也可以在必要时尝试 <code>1</code> 或 <code>2</code> ）。如果系统中有多个GPU，则从零计数到（设备数量 - 1），例如，如果系统中有4个GPU，则将 <span class="parameter">device_nums</span> 替换为 <code>0 1 2 3</code>。如果你只有一个GPU，用 <code>0</code> 替换 <span class="parameter">device_nums</span> 。要查看高级GPU矿工参数，请执行 <code>./xdag-gpu -h</code>。
							</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_miner_update.sh
#!/bin/bash

PIDS="`pidof xdag-gpu`"

if [ "$?" -eq 0 ]; then
	echo "Miner is running! Stop it before updating. PIDs: ${PIDS}"
	echo "run 'screen -x' and press CTRL+C to terminate the miner."
	exit 1
fi

echo Updating git repository...
(cd ./DaggerGpuMiner &amp;&amp; git pull &amp;&amp; make all)

echo "Done! Start the miner with 'screen ./xdag_miner_run.sh'."
EOD</pre>
							</li>
							<li>执行 <code>chmod +x xdag_*</code></li>
							<li>执行： <code>screen ./xdag_miner_run.sh</code>。矿工开始运行后，按住CTRL键，然后按a键，然后d。这将分离屏幕程序并返回到你的shell，矿工正在运行。您现在可以从机器上断开连接。</li>
						</ol>
						<p>完成！您的GPU矿工正在运行。有关用法，请参阅下一个用法部分。</p>
						<p><span class="important">注意：</span> 如果您使用的是NVIDIA GPU，请确保在步骤10中添加 <code>-nvidia-fix</code> 到GPU矿工命令行的末尾以防止高系统CPU使用率并增加哈希率。</p>
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
							<li>要启动矿工，请在您的个人文件夹中执行 <code>screen ./xdag_miner_run.sh</code> 并按住CTRL的同时按下字母a以便从屏幕中分离，然后按d键</li>
							<li>执行 <code>screen -x</code> 随时查看您的矿工状态。</li>
							<li>要将安装更新到最新版本，请执行 <code>screen -x</code> 并且通过 <code>CTRL+C</code> 停止矿工。执行 <code>./xdag_miner_update.sh</code> 。完成后，执行 <code>screen ./xdag_miner_run.sh</code>。</li>
							<li>要随时查看您的当前余额，请在您的主目录中执行 <code>./xdag_wallet_run.sh</code> ，输入您的钱包密码，按回车键，执行 <code>./xdag_wallet_console.sh</code>，键入 <code>balance</code> 并按下回车键。如果您看到 <code>not ready to show balance</code>，请稍等一会并再次键入 <code>balance</code> ，然后按Enter键。完成后，键入 <code>terminate</code> 然后按Enter关闭您的钱包。您也可以使用我们的网站随时在主页上查看您的余额，或 <a href="{{ route('register') }}">注册</a> 矿工以自动显示余额，支出，未付份额等。</li>
						</ol>
					</div>
				</div>
			</nav>
		</div>
	</div>
@endsection
