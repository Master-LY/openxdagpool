@extends('layouts.app')

@section('flashMessagesWidth', '8')

@section('content')
	<div class="admin-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-8">
				<div class="tabs">
					<ul>
						<li{!! $section == 'users' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.users') }}">用户</a></li>
						<li{!! $section == 'settings' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.settings') }}">设置</a></li>
						<li{!! $section == 'mass-email' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.mass-email') }}">主要 e-mail</a></li>
						<li{!! $section == 'miners-by-ip' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.miners-by-ip') }}">矿工IP</a></li>
						<li{!! $section == 'miners-by-hashrate' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.miners-by-hashrate') }}">矿工算力</a></li>
						<li{!! $section == 'pool-state' ? ' class="is-active"' : '' !!}><a href="{{ route('user.admin.pool-state') }}">矿池状态</a></li>
					</ul>
				</div>

				@yield('adminContent')
			</div>
		</div>
	</div>
@endsection
