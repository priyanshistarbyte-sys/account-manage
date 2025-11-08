<form action="{{  route('category.store') }}" method="POST">
    @csrf
     <div class="modal-body">
        <div class="row">
            <div class="mb-3">
                <label for="name" class = "form-label">Name</label>
                <input type="text" name="name" id="name" class = "form-control" placeholder="Enter Name" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
    </div>
  </form>