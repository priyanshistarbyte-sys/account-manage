<form action="{{  route('account.store') }}" method="POST">
    @csrf
     <div class="modal-body">
        <div class="row">
            <div class="mb-3">
                <label for="email" class = "form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" required>
                   <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
    </div>
  </form>