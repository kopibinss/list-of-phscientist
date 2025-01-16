<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh; font-family: 'figtree', sans-serif;">
            <div class="container p-6 bg-white">
                <div class="bg-primary rounded mt-4">
                    <h5 class="p-2 text-center text-white fw-bold">List of PH Scientists</h5>
                </div>
                <div class="card shadow p-4">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('scientists.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i>&nbsp;Scientist</a>
                        </div>
                        @if($scientists->isEmpty())
                            <p class="text-center">No available scientists</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Field</th>
                                        <th>Specialization</th>
                                        <th>Year Awarded</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scientists as $scientist)
                                    <tr>
                                        <td>{{ $scientist->id }}</td>
                                        <td>{{ $scientist->name }}</td>
                                        <td>{{ $scientist->field }}</td>
                                        <td>{{ $scientist->specialization }}</td>
                                        <td>{{ $scientist->year_awarded }}</td>
                                        <td>
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editScientistModal" data-id="{{ $scientist->id }}" data-name="{{ $scientist->name }}" data-field="{{ $scientist->field }}" data-specialization="{{ $scientist->specialization }}" data-year_awarded="{{ $scientist->year_awarded }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('scientists.destroy', $scientist->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"><i class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>


        <!-- Modal to Edit Scientist -->
        <div class="modal fade" id="editScientistModal" tabindex="-1" aria-labelledby="editScientistModalLabel" aria-hidden="true" style="height: 100vh; font-family: 'figtree', sans-serif;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editScientistModalLabel">Edit Scientist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to edit a scientist -->
                        <form action="" method="POST" id="editScientistForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 form-group">
                                <label for="edit-name">Name</label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="edit-field">Field</label>
                                <input type="text" class="form-control" id="edit-field" name="field" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="edit-specialization">Specialization</label>
                                <input type="text" class="form-control" id="edit-specialization" name="specialization" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="edit-year_awarded">Year Awarded</label>
                                <input type="number" class="form-control" id="edit-year_awarded" name="year_awarded" required>
                            </div>
                            <div class="d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const editModal = document.getElementById('editScientistModal');
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const field = button.getAttribute('data-field');
                    const specialization = button.getAttribute('data-specialization');
                    const year_awarded = button.getAttribute('data-year_awarded');

                    const form = document.getElementById('editScientistForm');
                    form.setAttribute('action', '/scientists/' + id);

                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-field').value = field;
                    document.getElementById('edit-specialization').value = specialization;
                    document.getElementById('edit-year_awarded').value = year_awarded;
                });
            });
        </script>
    </body>
</html>
