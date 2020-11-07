@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
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
        const redirectPath = '{{ $ret["redirectPath"]}}' || ''
        if (redirectPath != '') {
            const redirectMsg = '{{ $ret["redirectMsg"]}}' || ''
            const redirectTime = parseInt('{{ $ret["redirectTime"]}}') || 0

            $(".modal-title").text('Caution')
            $(".modal-body").text(redirectMsg)
            $("#myModal").modal()
            
            setTimeout(() => {
                goNext(redirectPath)
            }, redirectTime)
        }

        const goNext = url => location.href = url
        document.querySelector(".modal-footer button").addEventListener('click', () => {
            goNext(redirectPath)
        })
    </script>
@endpush

