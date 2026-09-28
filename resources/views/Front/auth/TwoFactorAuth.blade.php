<x-front-layout title="Two Factor Authentication">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="card login-form">
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                            </div>
                            @if (session('status') == 'two-factor-authentication-enabled')
                                <div class="alert alert-success mb-4 font-medium text-sm">
                                    Two-factor authentication is enabled. Scan the QR code below with your authenticator app.
                                </div>
                            @elseif (session('status') == 'two-factor-authentication-confirmed')
                                <div class="alert alert-success mb-4 font-medium text-sm">
                                    Two-factor authentication confirmed successfully.
                                </div>
                            @elseif (session('status') == 'two-factor-authentication-disabled')
                                <div class="alert alert-warning mb-4 font-medium text-sm">
                                    Two-factor authentication has been disabled.
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            @if (!$user->two_factor_secret)
                                <form action="{{ route('two-factor.enable') }}" method="post">
                                    @csrf
                                    <p class="mb-4">
                                        When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
                                    </p>
                                    <div class="button">
                                        <button class="btn" type="submit">Enable</button>
                                    </div>
                                </form>
                            @else
                                <div class="mb-4 text-center">
                                    {!! $user->twoFactorQrCodeSvg() !!}
                                </div>

                                @if (\Laravel\Fortify\Fortify::confirmsTwoFactorAuthentication() && !$user->two_factor_confirmed_at)
                                    <form action="{{ route('two-factor.confirm') }}" method="post" class="mb-3">
                                        @csrf
                                        <div class="form-group input-group">
                                            <label for="confirm_code">Confirmation Code</label>
                                            <input class="form-control" type="text" name="code" id="confirm_code" placeholder="Enter 6-digit code" required>
                                        </div>
                                        <div class="button mt-2">
                                            <button class="btn" type="submit">Confirm 2FA</button>
                                        </div>
                                    </form>
                                @endif

                                <form action="{{ route('two-factor.disable') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="button">
                                        <button class="btn" type="submit">Disable</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
