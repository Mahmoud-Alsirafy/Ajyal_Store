<x-front-layout title="Two Factor Challenge">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('two-factor.login.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Challenge</h3>
                                <p>Please enter your authentication code to login.</p>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="form-group input-group">
                                <label for="code">Authentication Code</label>
                                <input class="form-control" type="text" name="code" id="code" placeholder="Enter 6-digit code" autofocus autocomplete="one-time-code">
                            </div>
                            <div class="form-group input-group mt-3">
                                <label for="recovery_code">Or Recovery Code</label>
                                <input class="form-control" type="text" name="recovery_code" id="recovery_code" placeholder="Enter recovery code">
                            </div>
                            <div class="button mt-4">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
