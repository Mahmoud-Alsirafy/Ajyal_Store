<div class="row">
    <div class="col-md-6 form-group mb-3">
        <x-form.input label="Name" class="form-control" name="name" :value="$admin->name" required />
    </div>
    <div class="col-md-6 form-group mb-3">
        <x-form.input label="Email" type="email" class="form-control" name="email" :value="$admin->email" required />
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group mb-3">
        <x-form.input label="Username" class="form-control" name="username" :value="$admin->username" required />
    </div>
    <div class="col-md-6 form-group mb-3">
        <x-form.input label="Phone Number" class="form-control" name="phone_number" :value="$admin->phone_number" required />
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group mb-3">
        <x-form.input label="Password" type="password" class="form-control" name="password" />
        @if ($admin->id)
            <small class="text-muted d-block mt-1">Leave empty to keep current password.</small>
        @endif
    </div>
    <div class="col-md-6 form-group mb-3">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="active" @selected(old('status', $admin->status) == 'active')>Active</option>
            <option value="inactive" @selected(old('status', $admin->status) == 'inactive')>Inactive</option>
        </select>
        <x-form.validation-feedback name="status" />
    </div>
</div>

<fieldset class="mb-4">
    <legend>{{ __('Roles') }}</legend>

    @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                id="role_{{ $role->id }}"
                @checked(in_array($role->id, old('roles', $admin_roles ?? [])))>
            <label class="form-check-label" for="role_{{ $role->id }}">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
    <x-form.validation-feedback name="roles" />
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    <a href="{{ route('admins.index') }}" class="btn btn-secondary">Cancel</a>
</div>
