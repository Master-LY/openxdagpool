@extends('layouts.admin')

@section('title')
	矿工算力
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					矿工算力
				</h1>
				<h2 class="subtitle">
					矿池所有矿工按算力分组
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('adminContent')
	<table class="miners-grouped table is-fullwidth">
		<thead>
			<tr>
				<th>矿工地址</th>
				<th>机器数量</th>
				<th>未支付份额</th>
				<th class="tooltip is-tooltip-multiline" data-tooltip="Current estimated hashrate. The value is not averaged or corrected by any means.">算力</th>
				<th class="tooltip is-tooltip-multiline" data-tooltip="Miner address is registered to these user accounts.">用户</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($miners as $miner)
				<tr>
					<td><a href="#" class="miner-details" data-unpaid-shares="{{ $miner->getUnpaidShares() }}" data-in-out-bytes="{{ $miner->getInOutBytes() }}">{{ $miner->getAddress() }}</a></td>
					<td class="tooltip is-tooltip-multiline is-tooltip-right ips-and-port" data-tooltip="{{ $miner->getIpsAndPort() }}">{{ $miner->getMachinesCount() }}</td>
					<td>{{ $miner->getUnpaidShares() }}</td>
					<td>{{ $format->hashrate($miner->getHashrate()) }}</td>
					<td>
						@forelse ($miner->getUsers() as $user)
							<a href="{{ route('user.admin.edit-user', $user->id) }}">{{ $user->nick }}</a>@if (!$loop->last), @endif
						@empty
							-
						@endforelse
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $miners->links() }}

	<div class="modal" id="minerDetailsModal">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">矿工细节</p>
				<a class="delete close-modal" aria-label="close" href="#"></a>
			</header>
			<section class="modal-card-body">
				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label">
							<label class="label">地址</label>
						</div>

						<div class="field-body">
							<div class="field">
								<p class="control has-icons-left has-icons-right">
									<input class="input is-disabled" type="text" name="address" readonly>
									<span class="icon is-small is-left">
										<i class="fa fa-address-card-o"></i>
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
							<label class="label"> 入/出 bytes </label>
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
							<label class="label">机器</label>
						</div>

						<div class="field-body">
							<div class="field">
								<textarea class="textarea is-disabled" name="ips_and_port" rows="8" readonly></textarea>
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
		var adminMinersByHashrateView = new adminMinersByHashrateView();
	</script>
@endsection
