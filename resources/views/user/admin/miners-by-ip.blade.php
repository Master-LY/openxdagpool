@extends('layouts.admin')

@section('title')
	矿工IP
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					矿工IP
				</h1>
				<h2 class="subtitle">
					矿池所有矿工按IP地址分组
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('adminContent')
	<table class="miners-grouped table is-fullwidth">
		<thead>
			<tr>
				<th>IP 地址</th>
				<th class="tooltip is-tooltip-multiline" data-tooltip="Miners connected from this IP, their addresses and ports.">矿工</th>
				<th class="tooltip is-tooltip-multiline" data-tooltip="Current estimated hashrate. The value is not averaged or corrected by any means.">算力</th>
				<th class="tooltip is-tooltip-multiline" data-tooltip="Registered users connected from this IP, and their miner addresses.">用户</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($ips as $ip => $data)
				<tr>
					<td><a href="#" class="ip-address-details" data-unpaid-shares="{{ $data['unpaid_shares'] }}" data-in-out-bytes="{{ $data['in_out_bytes'] }}">{{ $ip }}</a></td>
					<td class="tooltip is-tooltip-multiline is-tooltip-right ip-miners" data-tooltip="@foreach ($data as $key => $miner)
						@if ($key == 'machines' || $key == 'unpaid_shares' || $key == 'in_out_bytes')
							@continue
						@endif
						{{ $miner->getAddress() }}:
						{{ $miner->getIpsAndPort() }}
					@endforeach">{{ $data['machines'] }}</td>
					<td>
						@if ($pool_unpaid_shares == 0)
							-
						@else
							{{ $format->hashrate(($data['unpaid_shares'] / $pool_unpaid_shares) * $pool_hashrate) }}
						@endif
					</td>
					<td>
						@php($users = [])
						@foreach ($data as $key => $miner)
							@if ($key == 'machines' || $key == 'unpaid_shares' || $key == 'in_out_bytes')
								@continue
							@endif
							@php($users = array_merge($users, $miner->getUsers()))
						@endforeach
						@forelse ($users as $user)
							<a href="{{ route('user.admin.edit-user', $user->id) }}">{{ $user->nick }}</a>@if (!$loop->last), @endif
						@empty
							-
						@endforelse
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $ips->links() }}

	<div class="modal" id="ipAddressDetailsModal">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">IP 地址细节</p>
				<a class="delete close-modal" aria-label="close" href="#"></a>
			</header>
			<section class="modal-card-body">
				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label">
							<label class="label">IP 地址</label>
						</div>

						<div class="field-body">
							<div class="field">
								<p class="control has-icons-left has-icons-right">
									<input class="input is-disabled" type="text" name="ip_address" readonly>
									<span class="icon is-small is-left">
										<i class="fa fa-server"></i>
									</span>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label">
							<label class="label">未支付份额</label>
						</div>

						<div class="field-body">
							<div class="field">
								<p class="control has-icons-left has-icons-right">
									<input class="input is-disabled" type="text" name="unpaid_shares" readonly>
									<span class="icon is-small is-left">
										<i class="fa fa-money"></i>
									</span>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label">
							<label class="label">入 / 出 bytes</label>
						</div>

						<div class="field-body">
							<div class="field">
								<p class="control has-icons-left has-icons-right">
									<input class="input is-disabled" type="text" name="in_out_bytes" readonly>
									<span class="icon is-small is-left">
										<i class="fa fa-exchange"></i>
									</span>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label">
							<label class="label">矿工</label>
						</div>

						<div class="field-body">
							<div class="field">
								<textarea class="textarea is-disabled" name="miners" rows="8" readonly></textarea>
							</div>
						</div>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="button" class="button close-modal">关闭</button>
			</footer>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var adminMinersByIpView = new adminMinersByIpView();
	</script>
@endsection
