@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center"> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-plus"></i> {{ __('Create Task') }}
                </div>

                <div class="card-body">
                    @livewire('todo.todo')
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-list"></i> {{ __('Task List') }}</div>
                <div class="card-body">
                    @inject('to_dos', 'Illuminate\Support\Facades\Crypt')
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Task Description</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ctr =1;
                            @endphp
                            @foreach($todos as $todo)
                                <tr>
                                    <th>{{ $ctr }}</th>
                                    <td>{{ $todo->task }}</td>
                                    <td>{{ $todo->task_description }}</td>
                                    <td>{{ $todo->active_status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('to_do.show_to_do', ['id' => $to_dos::encryptString($todo->id)]) }}" class="btn btn-success">
                                            Update
                                        </a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $ctr }}">
                                            Remove
                                        </button>
                                    </td>
                                    <div class="modal fade" id="deleteModal{{ $ctr }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $ctr }}Title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Task</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are You Sure You Want To Delete Task "{{ $todo->task }}"?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('home') }}?action=cancelled" class="btn btn-secondary">{{ __('No') }}</a>
                                                    <a href="{{ route('to_do.remove_to_do', ['id' => $to_dos::encryptString($todo->id)]) }}" class="btn btn-danger">
                                                        Remove
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @php
                                    $ctr++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
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
                title: 'Done!',
                text: '{{session('danger_message') }}',
                icon: 'error',
                timer: 3000,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        @endif

        @if(session('cancel_message'))
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
