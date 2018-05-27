@extends('layouts.app')

@section('title')
	矿工
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					矿工
				</h1>
				<h2 class="subtitle">
					Manage your miners easily.轻松管理你的矿工
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="miners-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				<form action="{{ route('miners.alerts') }}" method="post">
					{{ csrf_field() }}
					<table class="table is-fullwidth miners-list">
						<thead>
							<tr>
								<th>矿工地址</th>
								<th class="tooltip" data-tooltip="Status updates every 5 minutes.">状态</th>
								<th class="tooltip" data-tooltip="Estimated hashrate. Updates every 5 minutes.">算力</th>
								<th class="tooltip" data-tooltip="Unpaid shares. Updates every 5 minutes.">未支付份额</th>
								<th class="tooltip is-tooltip-multiline" data-tooltip="Current address balance. Updates approximately every 30 minutes.">余额</th>
								<th class="tooltip is-tooltip-multiline" data-tooltip="E-mail alerts when miner goes offline and back online.">警报</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@forelse ($authUser->miners as $miner)
								<tr class="miner" data-uuid="{{ $miner->uuid }}" data-address="{{ $miner->address }}" data-note="{{ $miner->note }}">
									<td class="miner-address tooltip is-tooltip-multiline" data-tooltip="{{ $miner->note ? $miner->address . ', ' . $miner->note : $miner->address }}"><a href="#" class="update-miner">{{ $miner->short_address }}</a></td>
									<td class="miner-status api is-loading"></td>
									<td class="miner-average-hashrate api is-loading"></td>
									<td class="miner-unpaid-shares api is-loading"></td>
									<td class="miner-balance api is-loading is-tooltip-multiline"></td>
									<td>
										<input type="hidden" name="alerts[{{ $miner->uuid }}]" value="0">
										<input type="checkbox" name="alerts[{{ $miner->uuid }}]" value="1"{{ $miner->email_alerts ? ' checked' : '' }}>
									</td>
									<td>
										<a class="button is-success tooltip" href="{{ route('miners.payouts.graph', $miner->uuid) }}" data-tooltip="View payouts">
											<span class="icon"><i class="fa fa-money"></i></span>
										</a>

										<a class="button tooltip" href="{{ route('miners.hashrate.graph', [$miner->uuid, 'latest']) }}" data-tooltip="Hashrate history">
											<span class="icon"><i class="fa fa-bar-chart"></i></span>
										</a>

										<a class="button is-danger tooltip delete-miner" href="#" data-tooltip="Delete miner">
											<span class="icon"><i class="fa fa-trash-o"></i></span>
										</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="8">No miners.</td>
								</tr>
							@endforelse
						</tbody>
					</table>

					@if ($authUser->miners->count())
						<button type="submit" class="button is-pulled-right">
							<span class="icon"><i class="fa fa-floppy-o"></i></span>
							<span>Save alert preferences</span>
						</button>
					@endif

					<a class="button is-primary" id="addMiner">
						<span class="icon"><i class="fa fa-plus-square-o"></i></span>
						<span>添加矿工</span>
					</a>
				</form>
				<hr>
				<p><span class="important">注意：</span> 状态、算力和未支付份额每隔5分钟更新。</p>
				<hr>
				<p><span class="important">注意：</span> 算力每5分钟更新一次。算力计算非常不精确，并不代表矿池内的真实算力，也不代表矿工的真实算力，更不会影响支付。数据仅为统计近似值，用作参考。大约6小时后数值会接近真实算力值。在CPU矿工控制台键入 <code>stats</code> 或者观察 GPU 矿工显示的数值可以得知真实算力。</p>
				<hr>
				<p><span class="important">注意：</span> 地址余额大约30分钟更新一次。收入/支出大约每4小时更新。和算力一样，系统显示的数值仅供每天一到两次快速查询矿工的工作状态。 如果你需要查询精确值，请在钱包控制台界面使用 <code>balance</code> 。</p>
			</div>
		</div>

		<div class="modal" id="addMinerModal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">添加矿工</p>
					<a class="delete close-modal" aria-label="close" href="#"></a>
				</header>
				<form id="addMinerForm" method="post" action="{{ route('miners.create') }}">
					{{ csrf_field() }}
					<section class="modal-card-body">
						<p>You can find your miner address by typing在钱包控制台键入 <code>account</code> 可以找到你的矿工地址。</p>

						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label">
									<label class="label">地址</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input" type="text" id="address" name="address" maxlength="32" required>
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
									<label class="label">Note</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input" type="text" id="note" name="note">
											<span class="icon is-small is-left">
												<i class="fa fa-sticky-note-o"></i>
											</span>
										</p>
									</div>
								</div>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button type="submit" class="button is-success">保存</button>
					</footer>
				</form>
			</div>
		</div>

		<div class="modal" id="deleteMinerModal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">删除矿工</p>
					<a class="delete close-modal" aria-label="close" href="#"></a>
				</header>
				<form id="deleteMinerForm" method="post" action="{{ route('miners.delete') }}">
					<input type="hidden" name="_method" value="delete">
					{{ csrf_field() }}
					<section class="modal-card-body">
						<p>你确定要从你的列表删除这个矿工？该操作将永久删除矿工的算力记录。</p>

						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label">
									<label class="label">Address</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input is-disabled" type="text" id="deleteMinerAddress" name="address" readonly>
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
									<label class="label">Note</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input is-disabled" type="text" id="deleteMinerNote" name="note" readonly>
											<span class="icon is-small is-left">
												<i class="fa fa-sticky-note-o"></i>
											</span>
										</p>
									</div>
								</div>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button type="submit" class="button is-danger">删除</button>
						<button type="button" class="button close-modal">返回</button>
					</footer>
				</form>
			</div>
		</div>

		<div class="modal" id="updateMinerModal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">矿工细节</p>
					<a class="delete close-modal" aria-label="close" href="#"></a>
				</header>
				<form id="deleteMinerForm" method="post" action="{{ route('miners.update') }}">
					<input type="hidden" name="uuid" id="updateMinerUuid" value="">
					<input type="hidden" name="_method" value="put">
					{{ csrf_field() }}
					<section class="modal-card-body">
						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label">
									<label class="label">Address</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input is-disabled" type="text" id="updateMinerAddress" name="address" readonly>
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
									<label class="label">Note</label>
								</div>

								<div class="field-body">
									<div class="field">
										<p class="control has-icons-left has-icons-right">
											<input class="input" type="text" id="updateMinerNote" name="note">
											<span class="icon is-small is-left">
												<i class="fa fa-sticky-note-o"></i>
											</span>
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label">
									<label class="label">IPs and ports</label>
								</div>

								<div class="field-body">
									<div class="field">
										<textarea class="input is-disabled" id="updateMinerIpsAndPorts" name="ips_and_ports" rows="5" readonly></textarea>
									</div>
								</div>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button type="submit" class="button is-primary">更新记录</button>
						<button type="button" class="button close-modal">返回</button>
					</footer>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var minersView = new minersView();
	</script>
@endsection
