<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<div class="bg-dark">
<div class="container">
    <div class="p-4" style="height: 100vh; font-family: 'figtree', sans-serif;">
        <div class="card p-4 shadow-sm">
            <h5 class="card-title text-center mb-4">Add a New Scientist</h5>
            <form action="{{ route('scientists.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
        
                <div class="mb-3">
                    <label for="field" class="form-label">Field:</label>
                    <input type="text" class="form-control" name="field" id="field" required>
                </div>
        
                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization:</label>
                    <input type="text" class="form-control" name="specialization" id="specialization" required>
                </div>
        
                <div class="mb-3">
                    <label for="division" class="form-label">Division:</label>
                    <input type="text" class="form-control" name="division" id="division" required>
                </div>
        
                <div class="mb-3">
                    <label for="year_awarded" class="form-label">Year Awarded:</label>
                    <input type="number" class="form-control" name="year_awarded" id="year_awarded" required>
                </div>
        
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add Scientist</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



