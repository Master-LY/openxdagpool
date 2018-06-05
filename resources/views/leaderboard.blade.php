@extends('layouts.app')

@section('title')
	Leaderboard
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					排行榜
				</h1>
				<h2 class="subtitle">
					贡献了最多算力的已注册用户
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="leaderboard-view">
		<div class="columns is-marginless is-centered">
			<div class="column is-7">
				@if (isset($authUser) && $authUser->isActive())
					<div class="notification is-info">
						<button class="delete"></button>
						@if ($authUser->exclude_from_leaderboard)
							你目前没有包含在排行榜内。如果想改变现有设置，请访问你的 <a href="{{ route('profile') }}">用户页面</a> 。
						@else
							@if ($authUser->anonymous_profile)
								你的昵称目前向其他人隐藏了，只有你能看见。你可以登出以后进一步确认。如果想改变现有设置，请访问你的 <a href="{{ route('profile') }}">用户页面</a> 。
							@else
								你的昵称目前向其他人显示。如果想改变现有设置，请访问你的 <a href="{{ route('profile') }}">用户页面</a> 。
							@endif
						@endif
					</div>
				@endif

				@if (isset($authUser) && $authUser->isAdministrator())
					<div class="notification is-info">
						<button class="delete"></button>
						您是管理员，所有的用户昵称和所有用户都可见。您可以登出以其他用户身份查看排行榜。
					</div>
				@endif

				<table class="table is-fullwidth is-striped">
					<thead>
						<tr>
							<th>排名</th>
							<th>昵称</th>
							<th class="tooltip is-tooltip-multiline" data-tooltip="Current hashrate of all user's registered miners. Updates every 5 minutes.">算力</th>
						</tr>
					</thead>
					<tbody>
						@php ($shown_full = $shown_myself = false)
						@php ($myself = $myself_rank = $myself_hashrate = null)
						@forelse ($leaderboard as $index => $item)
							@if ($index > 24)
								@if (isset($authUser) && $item['user']->id === $authUser->id)
									@php ($myself = $item['user'])
									@php ($myself_rank = $index + 1)
									@php ($myself_hashrate = $item['hashrate'])
								@endif
								@if (!$shown_full && !$shown_myself && isset($authUser) && (!$authUser->exclude_from_leaderboard || $authUser->isAdministrator()))
									@php ($shown_full = true)
									<tr>
										<td>...</td>
										<td colspan="2"></td>
									</tr>
								@endif
							@else
								@if (!$shown_myself && isset($authUser) && $item['user']->id === $authUser->id)
									@php ($shown_myself = true)
								@endif
								<tr{!! isset($authUser) && $item['user']->id === $authUser->id ? ' class="is-selected"' : '' !!}>
									<th>#{{ $loop->iteration }}</th>
									<td>{{ $item['user']->display_nick }}</td>
									<td>{{ $item['hashrate'] }}</td>
								</tr>
							@endif
						@empty
							<tr>
								<td colspan="3">目前没有可供显示的用户，请稍后再来查看！;-)</td>
							</tr>
						@endforelse
						@if ($myself)
							<tr class="is-selected">
								<th>#{{ $myself_rank }}</th>
								<td>{{ $myself->display_nick }}</td>
								<td>{{ $myself_hashrate }}</td>
							</tr>
						@endif
					</tbody>
				</table>

				<hr>
				<p><span class="important">注意：</span> 算力每5分钟更新。算力计算非常不准确，不代表矿池实际算力，或真实挖矿速度。仅是统计近似数值，仅供参考。大约开始挖矿6小时后数值会接近真实算力值。显示的算力值不影响支出。</p>
			</div>
		</div>
	</div>
@endsection
