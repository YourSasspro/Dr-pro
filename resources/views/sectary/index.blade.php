@extends('layouts.master')

@section('title')
{{ __('sentence.Sectary') }}
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-8">
                    <h6 class="m-0 font-weight-bold text-primary w-75 p-2">{{ __('sentence.Sectary') }}</h6>
                </div>
                <div class="col-4">
                    <a href="{{ route('sectary.create') }}" class="btn btn-primary btn-sm float-right "><i
                            class="fa fa-plus"></i> {{ __('sentence.New Sectary') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('sentence.ID') }}</th>
                            <th>{{ __('sentence.Full Name') }}</th>
                            <th class="text-center">{{ __('sentence.Email') }}</th> 
                            <th class="text-center">{{ __('sentence.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sectary as $item)
                            <tr>
                                <td>{{ $item->id ?? '' }}</td>
                                <td> {{ $item->name ?? '' }}</td>
                                <td class="text-center">{{ $item->email ?? '' }} </td>
                                <td class="text-center">
                                    {{-- <a href="{{ route('sectary.show', $item->id) }}"
                                        class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a> --}}
                                    <a href="{{ route('sectary.edit' , $item->id) }}"
                                        class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-pen"></i></a>
                                    <button onclick="sectaryDelete{{ $item->id }}({{ $item->id }})"
                                        class="btn btn-outline-danger btn-circle btn-sm"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <span class="float-right mt-3">{{ $sectary->links() }}</span>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>
    @foreach ($sectary as $item)
        <script>
            function sectaryDelete{{ $item->id }}(id) {
                swal({
                    title: "Are You Sure Want To Delete Sectary?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var url = '{{ route('deleteSectary', ':id') }}';
                        url = url.replace(':id', id);
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: url,
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                console.log(data);
                                //var data = JSON.parse(response);
                                iziToast.success({
                                    message: data.message,
                                    position: 'topRight'
                                });
                                //Reload page
                                window.location.reload();

                            }
                        });
                    }
                });

            }
        </script>
    @endforeach
@endsection
