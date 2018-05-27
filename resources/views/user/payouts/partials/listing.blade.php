<table class="table is-fullwidth">
	<thead>
		<tr>
			<th>日期和时间</th>
			<th>发送方</th>
			<th>接收方</th>
			<th>数量</th>
		</tr>
	</thead>
	<tbody>
		@forelse ($payouts as $payout)
			<tr>
				<td class="tooltip" data-tooltip="{{ $payout->precise_made_at->format('Y-m-d H:i:s.u') }}">{{ $payout->made_at->format('Y-m-d H:i:s') }}</td>
				<td class="tooltip" data-tooltip="{{ $payout->sender }}">{{ $payout->short_sender }}</td>
				<td class="tooltip" data-tooltip="{{ $payout->recipient }}">{{ $payout->short_recipient }}</td>
				<td>{{ number_format($payout->amount, 9, '.', ',') }} XDAG</td>
			</tr>
		@empty
			<tr>
				<td colspan="4">尚未支出，请稍后再查看！;-)</td>
			</tr>
		@endforelse
	</tbody>
	@if ($payouts->count())
		<tfoot>
			<tr>
				<th colspan="3">页面总数</th>
				<th>{{ number_format($payouts->sum('amount'), 9, '.', ',') }} XDAG</th>
			</tr>
			<tr>
				<th colspan="3">总计</th>
				<th>{{ number_format($payouts_sum, 9, '.', ',') }} XDAG</th>
			</tr>
		</tfoot>
	@endif
</table>
@if ($payouts->count())
	{{ $payouts->links() }}
@endif
