@extends('layouts.app')

@section('style')
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end my-3">
                    <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
                </div>
                <table class="table" id="category">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry the Bird</td>
                            <td>@twitter</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>  

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    categoryList();
     function categoryList() {
        $('#category').DataTable().destroy();
      var table = $('#category').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('category.index') }}",
          columns: [
              {data: 'id', name: 'id', width: '35%'},
              {data: 'category', name: 'category', width: '35%'},
              {data: 'action', name: 'action', width: '30%', orderable: false, searchable: false},
          ]
      });
        
    }

    function deletecat(id) {
            if (id != '') {
                swal({
                        title: "Are you sure You want to Delete It ?",
                        text: "Once deleted, you will not be able to recover this Record",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                        //   let url = "{{ route('category.destroy',':id') }}";
                          let url = "{{ route('category.destroy',':id') }}";
                              url = url.replace(':id', id);
                            jQuery.ajax({
                                type: "delete",
                                url: url,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': id
                                },
                                dataType: 'JSON',
                                success: function(data) {
                                    if (data.success == 1) {
                                        swal("Your Record has been deleted!", {
                                            icon: "success",
                                        });
                                        setTimeout(function() {
                                            categoryList();
                                        }, 1000);
                                    }
                                }
                            });
                        } else {
                            swal("Cancelled", "", "error");
                            setTimeout(function() {
                                categoryList();
                            }, 1000);
                        }
                    });
            } else {
                swal("Please select atleast One Record", "", "warning");
            }
        }
</script>
    
@endsection
