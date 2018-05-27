@extends('layouts.app')

@section('title')
	Unix CPU 矿工设置 (Ubuntu 16.04)
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Unix CPU 矿工设置
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
						<ol>
							<li><code>cd</code> 到您的主目录。不要以 <code>root</code>运行矿工！</li>
							<li>执行： <code>sudo apt-get install gcc libssl-dev build-essential git</code></li>
							<li>执行： <code>git clone https://github.com/XDagger/xdag.git</code></li>
							<li>更改目录： <code> cd ./xdag/client</code></li>
							<li>运行 <code>make</code></li>
							<li>以 <code>./xdag -d -m 1 {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }}</code> 运行程序。设置你的钱包密码，输入随机密钥（至少3行随机密钥）。等到主机密钥生成。</li>
							<li>执行 <code>./xdag -i</code>。键入 <code>terminate</code> 并按下Enter键。</li>
							<li><code>cd</code> 到您的主目录</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_console.sh
#!/bin/bash

pidof xdag > /dev/null

if [ "$?" -ne 0 ]; then
	echo "Daemon not running! Start it with ./xdag_run.sh"
	exit 1
fi

echo Starting console...
(cd ./xdag/client &amp;&amp; ./xdag -i)
echo -n "Daemon PIDs: "
pidof xdag
EOD</pre>
							</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_run.sh
#!/bin/bash

PIDS="`pidof xdag`"

if [ "$?" -eq 0 ]; then
	echo "Daemon already running? PIDs: ${PIDS}"
	echo "run ./xdag_console.sh and type 'terminate' to terminate the daemon."
	exit 1
fi

echo Starting daemon...
(cd ./xdag/client &amp;&amp; ./xdag -d -m <span class="parameter">4</span> {{ Setting::get('pool_domain') }}:{{ Setting::get('pool_port') }})
echo -n "Daemon PIDs: "
pidof xdag
EOD</pre>将 <span class="parameter">4</span> 替换为挖矿所需要的线程数，对于只用来挖矿的机器，将其设置为CPU线程数以最大化采矿效率。稍后可以通过在XDAG控制台中键入 <code>mining N</code> 来控制此操作，其中 <span class="parameter">N</span> 是要运行的挖矿线程的数量。
							</li>
							<li>执行：
<pre>cat << 'EOD' > ./xdag_update.sh
#!/bin/bash

PIDS="`pidof xdag`"

if [ "$?" -eq 0 ]; then
	echo "Daemon is running! Stop it before updating. PIDs: ${PIDS}"
	echo "run ./xdag_console.sh and type 'terminate' to terminate the daemon."
exit 1
fi

echo Updating git repository...
(cd ./xdag &amp;&amp; git pull &amp;&amp; cd ./client &amp;&amp; make)

echo "Done! Start the daemon with ./xdag_run.sh"
EOD</pre>
							</li>
							<li>执行 <code>chmod +x xdag_*</code></li>
						</ol>
						<p>完成！有关用法，请参阅下列用法部分。</p>
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
							<li>要启动矿工，只需在您的个人文件夹中执行 <code>./xdag_run.sh</code> ，输入您的钱包密码。</li>
							<li>要随时连接到矿工控制台，请执行 <code>./xdag_console.sh</code>.</li>
							<li>要方便地将安装更新到最新版本，请执行以下操作来停止deamon： <code>./xdag_console.sh</code>，键入 <code>terminate</code>，按Enter键，运行 <code>./xdag_update.sh</code>，然后 <code>./xdag_run.sh</code> 再次键入您的钱包密码。</li>
							<li>要随时查看您的当前余额，请在矿工控制台输入 <code>balance</code> 。要显示您的钱包地址，请在矿工控制台输入 <code>account</code> 。您也可以使用我们的网站随时在主页上查看您的余额，或 <a href="{{ route('register') }}">注册</a> 你的矿工以自动显示余额，支出，未付份额等。</li>
						</ol>
					</div>
				</div>
			</nav>
		</div>
	</div>
@endsection
