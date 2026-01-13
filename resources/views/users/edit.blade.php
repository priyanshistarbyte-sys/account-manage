<form action="{{ route('user.update', $user->id) }}" method="POST">
     @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="mb-3">
                <label for="name" class = "form-label">Name</label>
                <input type="name" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="mb-3">
                <label for="email" class = "form-label">Email</label>
                <input type="email" name="email" id="email"  value="{{ old('email', $user->email) }}" class="form-control" placeholder="Enter Email" required>
            </div>
             <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" placeholder="Leave blank to keep current password">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button class="btn btn-primary" type="submit">{{__('Update')}}</button>
    </div>
</form>

