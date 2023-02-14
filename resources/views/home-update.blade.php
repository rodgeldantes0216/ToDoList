@extends('layouts.app')

@section('content')
    @inject('to_dos', 'Illuminate\Support\Facades\Crypt')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-edit"></i> {{ __('Update Task') }}</div>

                    <div class="card-body">
                        @livewire("todo.todo-update", ['id' => $to_dos::encryptString($todo_id)])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        @if(session('success_message'))
            Swal.fire({
                title: 'Done!',
                text: '{{ session('success_message') }}',
                icon: 'success',
                timer: 3000,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Close'
            });
        @elseif(session('danger_message'))
            Swal.fire({
                title: 'Invalid Input!',
                text: '{{session('danger_message') }}',
                icon: 'error',
                timer: 3000,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        @endif

        @error('task')
            Swal.fire({
                title: 'Invalid Input!',
                text: '',
                icon: 'error',
                timer: 3000,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        @enderror

        @if(isset($_GET['action']) && $_GET['action'] == 'cancelled')
            Swal.fire({
                title: 'Action Cancelled!',
                text: '',
                icon: 'error',
                timer: 3000,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        @endif
    </script>
@endsection
