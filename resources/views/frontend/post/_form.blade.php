@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post') }}</div>

                <div class="card-body">
                    @if ($action == 'create')
                        <form method="post" role="form" action="{{ route("post.store") }}">
                    @elseif ($action == 'edit')
                        <form method="post" role="form" action="{{ route("post.update", $post->id) }}">
                            @method('PUT')
                    @endif
                            @csrf
                        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" name="title" id="title" value="{{ old('title', $post->title) }}">
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('content') ? 'has-error' : '' }}">
                            <label for="content" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea name="content" id="content" cols="60" rows="10">
                                    {{ old('content', $post->content) }}
                                </textarea>
                                {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        @if ($action == 'create')
                            <button type="submit" class="btn btn-primary mb-2">Create</button>
                        @elseif ($action == 'edit')
                            <button type="submit" class="btn btn-primary mb-2">Update</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          Modal body..
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
  
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('button[type=submit]').forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault()
                const btn = e.currentTarget
                const form = btn.parentNode
                const url = form.getAttribute('action')
                const values = Object.values(form).reduce((obj, field) => {
                    
                    if (field.classList.contains('is-invalid')) {
                        const errorDiv = field.nextElementSibling
                        field.parentNode.removeChild(errorDiv)
                    }
                   
                    obj[field.name] = field.value;
                    return obj;
                },{})

                if (form.classList.contains('was-validated')) {
                    form.classList.remove('was-validated')
                }
                                
                const modal = document.querySelector('#myModal')
                const modalTitle = modal.querySelector('.modal-title')
                const modalBody = modal.querySelector('.modal-body')
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: JSON.stringify(values),
                    dataType: "json",
                    contentType: "application/json",
                    success: function(response) {
                        const success = response.success
                        const message = response.message

                        $(modalTitle).text('Message')
                        $(modalBody).text(message)
                        $(modal).modal()
                        if (success) {
                            setTimeout(() => {
                                location.reload()
                            }, 2000)
                            
                        }
                        // console.log(response.success)
                    },
                    error: function(xhr, ajaxOptions, error) {
                        const response = JSON.parse(xhr.responseText)
                        if (response) {

                            form.classList.add('was-validated');

                            const { errors, message } = response
                            Object.keys(errors).forEach(key => {
                                const inputElem = form.querySelector(`#${key}`)
                                const errMessages = errors[key].join(' ')
                                
                                inputElem.classList.add('is-invalid')

                                const errorMessageDiv = document.createElement('div')
                                errorMessageDiv.id = `<div id="validation${key}Feedback`
                                errorMessageDiv.classList.add('invalid-feedback')
                                errorMessageDiv.innerText = errMessages

                                inputElem.insertAdjacentElement('afterend', errorMessageDiv);
                            })
                        }
                    }
                })
            })
        })
    </script>
@endpush