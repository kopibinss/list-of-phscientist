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
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/r-3.0.3/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/date-1.5.4/fc-5.0.4/fh-4.0.1/r-3.0.3/sc-2.4.3/sl-2.1.0/datatables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        

    </head>
    <body>
        <div class="d-flex justify-content-center align-items-center bg-dark" style="height: 100vh; font-family: 'figtree', sans-serif;">
            <div class="container">
                <div class="text-center">
                    <img src="{{ asset('img/nastphl-logo.png') }}" class="mb-3" alt="NAST PHL Logo" style="width: 120px;">
                </div>
                <div class="bg-primary rounded">
                    <h5 class="p-2 text-center text-white fw-bold">List of PH Scientists</h5>
                </div>
                <div class="card shadow p-2">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addScientistModal">
                        <i class="bi bi-plus-lg"></i>&nbsp;Scientist
                        </button>
                        @if($scientists->isEmpty())
                            <p class="text-center">No available scientists</p>
                        @else
                        <div class="table-responsive" id="tableView">
                            <table id="phscientist" class="mt-4 table table-striped table-hover display responsive" style="width:100%">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th class="text-center bg-dark text-white">ID</th>
                                            <th class="text-start bg-dark text-white">Name</th>
                                            <th class="text-start bg-dark text-white">Field</th>
                                            <th class="text-start bg-dark text-white">Specialization</th>
                                            <th class="text-start bg-dark text-white">Year Awarded</th>
                                            <th class="text-center bg-dark text-white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($scientists as $scientist)
                                        <tr>
                                            <td class="text-center">{{ $scientist->id }}</td>
                                            <td>{{ $scientist->name }}</td>
                                            <td>{{ $scientist->field }}</td>
                                            <td>{{ $scientist->specialization }}</td>
                                            <td class="text-start">{{ $scientist->year_awarded }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editScientistModal" data-id="{{ $scientist->id }}" data-name="{{ $scientist->name }}" data-field="{{ $scientist->field }}" data-specialization="{{ $scientist->specialization }}" data-year_awarded="{{ $scientist->year_awarded }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="{{ route('scientists.destroy', $scientist->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash3-fill"></i></button>
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
        </div>

        <!-- Modal to Add Scientist -->
        <div class="modal fade" id="addScientistModal" tabindex="-1" aria-labelledby="addScientistModalLabel" aria-hidden="true" style="height: 100vh; font-family: 'figtree', sans-serif;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addScientistModalLabel">New Scientist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('scientists.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
            
                            <div class="mb-3">
                                <label for="field" class="form-label">Field</label>
                                <input type="text" class="form-control" name="field" id="field" required>
                            </div>
            
                            <div class="mb-3">
                                <label for="specialization" class="form-label">Specialization</label>
                                <input type="text" class="form-control" name="specialization" id="specialization" required>
                            </div>
            
                            <div class="mb-3">
                                <label for="division" class="form-label">Division</label>
                                <input type="text" class="form-control" name="division" id="division" required>
                            </div>
            
                            <div class="mb-3">
                                <label for="year_awarded" class="form-label">Year Awarded</label>
                                <input type="number" class="form-control" name="year_awarded" id="year_awarded" required>
                            </div>
            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Add Scientist</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to Edit Scientist -->
        <div class="modal fade" id="editScientistModal" tabindex="-1" aria-labelledby="editScientistModalLabel" aria-hidden="true" style="height: 100vh; font-family: 'figtree', sans-serif;">
            <div class="modal-dialog modal-dialog-centered">
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
                                <button type="submit" class="ms-auto btn btn-primary">Save</button> &nbsp;
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Populate Data Fields -->
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

        <script>
            // Automatically hide alert messages after 5 seconds (5000ms)
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        alert.classList.add('fade');
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150); // Remove from DOM after fade out
                    });
                }, 5000); // Change the duration as needed
            });
        </script>

        <script>

        let dataTableInstance = null; // Store the initialized DataTable instance

        document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable on page load
        dataTableInstance = new DataTable('#phscientist', {
            searching: true, // Enable search
            paging: true, // Enable pagination
            info: true, // Enable table info
            ordering: true // Enable sorting
        });
        });

        </script>

        
    </body>
</html>
