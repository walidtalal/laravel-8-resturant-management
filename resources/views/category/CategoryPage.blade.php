@extends('layouts.app')

@section('content')
    <h3>Category Page</h3>
    <div class="container" dir="rtl">
        @if (count($errors) > 0)
            <div class="card mt-5">
                <div class="card-body">
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p> {{ $error }}
                            <p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">الصنف</div>
                    <form action="{{ route('cat.store') }}" method="post">
                        @csrf
                        <div class="card-body text-right">
                            <div class="form-group">
                                <label for="name">اسم الصنف</label>
                                <input type="text" class="form-control" name="cat_name" placeholder="اسم الصنف">
                            </div>
                            <br>

                            <div class="form-group text-center">
                                <button class="btn btn-danger" type="submit">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">الأصناف</div>
                    <div class="card-body">
                        @if(session("message"))
                            <div class="alert alert-success" role="alert">
                                {{session("message")}}
                            </div>
                        @endif
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">اسم الصنف</th>
                                    <th scope="col">تعديل</th>
                                    <th scope="col">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;?>
                                @foreach($categories as $category)
                                    <?php $i++;?>
                                    <tr>
                                        <td style="width: 12%;"><?php echo $i?></td>
                                        <td hidden="">{{$category->id}}</td>
                                        <td>{{ $category->cat_name }}</td>

{{--                                        <td style="width: 15%;"><a  href="#"><button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">تعديل</button></a></td>--}}
                                        <td style="width: 15%;">
                                            <a href="#">
                                                <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary edit-btn" data-id="{{ $category->id }}" data-name="{{ $category->cat_name }}">تعديل</button>
                                            </a>
                                        </td>

{{--                                        <td style="width: 15%;"><a href="{{route('cat.delete', $category->id)}}"><button id="delete" class="btn btn-danger">حذف</button></a></td>--}}
                                        <td style="width: 15%;">
                                            <form action="{{ route('cat.delete', ['id' => $category->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button id="delete-btn" type="submit" class="btn btn-danger">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div dir="rtl" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">تعديل الصنف</h1>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('cat.update', $category->id), }}">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">اسم الصنف:</label>
                            <input type="text" name="cat_name" class="form-control" id="recipient-name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تعديل</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#recipient-id').val(id);
                $('#recipient-name').val(name);
            });

            $('#editCategory').on('click', function() {
                var id = $('#recipient-id').val();
                var name = $('#recipient-name').val();

                // Perform AJAX request to update category
                $.ajax({
                    url: '/update-category/' + id,
                    type: 'PUT',
                    data: {
                        cat_name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Refresh the page or update content after successful edit
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'هل تريد تأكيد الحذف؟', // Added missing closing quotation mark
                icon: 'question',
                iconHtml: '؟',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا',
                showCancelButton: true,
                showCloseButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                    Swal.fire(
                        'تم الحذف!',
                        'تم الحذف بنجاح.',
                        'success' // Changed 'نجاح' to 'success' for the toast style
                    );
                }
            });
        });
    </script>

@endsection
