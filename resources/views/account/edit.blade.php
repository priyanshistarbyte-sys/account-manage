<form action="{{ route('account.update', $account->id) }}" method="POST">
     @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="mb-3">
                <label for="email" class = "form-label">Email</label>
                <input type="email" name="email" id="email"  value="{{ old('email', $account->email) }}" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" required>
                   <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $account->category == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
                        @endforeach
                </select>
            </div>
             <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" value="{{ old('password', $account->password) }}" class="form-control" placeholder="Enter Password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control">{{$account->note}}</textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button class="btn btn-primary" type="submit">{{__('Update')}}</button>
    </div>
</form>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});
</script>