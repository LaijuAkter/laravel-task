@extends('layouts.app')

@section('styles')
<style>
  .form-container {
    max-width: 700px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.06);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .form-container h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #222;
  }

  .form-group {
    margin-bottom: 1.2rem;
  }

  label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
  }

  input[type="text"],
  input[type="date"],
  input[type="file"],
  textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #374151;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  input:focus,
  textarea:focus {
    border-color: #4f46e5;
    outline: none;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
  }

  textarea {
    resize: vertical;
  }

  .btn-submit {
    background-color: #4f46e5;
    color: white;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .btn-submit:hover {
    background-color: #4338ca;
  }

  .alert-danger {
    background-color: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
  }

  /* Responsive tweaks */
  @media (max-width: 600px) {
    .form-container {
      padding: 1.5rem;
    }
    .btn-submit {
      width: 100%;
      text-align: center;
    }
  }
</style>
@endsection

@section('content')
<div class="form-container">
    <h2>Create New Report</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Details</label>
            <textarea name="details" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label>Report Date</label>
            <input type="date" name="report_date" required>
        </div>

        <div class="form-group">
            <label>Image (optional)</label>
            <input type="file" name="image">
        </div>

        <button type="submit" class="btn-submit">Submit Report</button>
    </form>
</div>
@endsection
