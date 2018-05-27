@extends('layouts.app')

@section('title')
	登录
@endsection

@section('hero')
	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					登录
				</h1>
				<h2 class="subtitle">
					登录后可查看个人矿工列表，算力，钱包余额和支付记录。
				</h2>
			</div>
		</div>
	</section>
@endsection

@section('content')
	<div class="columns is-marginless is-centered">
		<div class="column is-5">
			<div class="card">
				<header class="card-header">
					<p class="card-header-title">登录</p>
				</header>

				<div class="card-content">
					<form class="login-form" method="POST" action="{{ route('login') }}">
						{{ csrf_field() }}

						<div class="field is-horizontal">
							<div class="field-label">
								<label class="label">Nick</label>
							</div>

							<div class="field-body">
								<div class="field">
									<p class="control">
										<input class="input" id="nick" type="text" name="nick" value="{{ old('nick') }}" maxlength="20" required autofocus>
									</p>

									@if ($errors->has('nick'))
										<p class="help is-danger">
											{{ $errors->first('nick') }}
										</p>
									@endif
								</div>
							</div>
						</div>

						<div class="field is-horizontal">
							<div class="field-label">
								<label class="label">Password</label>
							</div>

							<div class="field-body">
								<div class="field">
									<p class="control">
										<input class="input" id="password" type="password" name="password" required>
									</p>

									@if ($errors->has('password'))
										<p class="help is-danger">
											{{ $errors->first('password') }}
										</p>
									@endif
								</div>
							</div>
						</div>

						<div class="field is-horizontal">
							<div class="field-label"></div>

							<div class="field-body">
								<div class="field">
									<p class="control">
										<label class="checkbox">
											<input type="checkbox"
												   name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
										</label>
									</p>
								</div>
							</div>
						</div>

						<div class="field is-horizontal">
							<div class="field-label"></div>

							<div class="field-body">
								<div class="field is-grouped">
									<div class="control">
										<button type="submit" class="button is-primary">登录</button>
									</div>

									<div class="control">
										<a href="{{ route('password.request') }}">
											忘记了密码？
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
