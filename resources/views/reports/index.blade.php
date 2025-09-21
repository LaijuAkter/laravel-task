@extends('layouts.app')

@section('styles')
<style>
  /* Container */
  .reports-container {
    max-width: 960px;
    margin: 2rem auto;
    padding: 0 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  h2 {
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    color: #222;
  }

  .btn-primary {
    background-color: #4f46e5;
    color: white;
    padding: 0.5rem 1rem;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
  }
  .btn-primary:hover {
    background-color: #4338ca;
  }

  /* Alerts */
  .alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border: 1px solid #10b981;
    position: relative;
  }

  /* Responsive Table */
  table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border-radius: 10px;
    overflow: hidden;
  }

  thead {
    background: linear-gradient(90deg, #6366f1, #4f46e5);
    color: white;
  }

  thead th {
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    font-size: 0.95rem;
  }

  tbody tr {
    border-bottom: 1px solid #e0e0e0;
    background-color: #fff;
    transition: background-color 0.2s ease;
  }

  tbody tr:hover {
    background-color: #f3f4f6;
  }

  tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    font-size: 0.95rem;
    color: #374151;
  }

  /* Image */
  .report-image {
    width: 80px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
  }

  /* Action buttons */
  .btn-action {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
  }

  .btn-edit {
    color: #2563eb;
  }
  .btn-edit:hover {
    background-color: #e0e7ff;
  }

  .btn-delete {
    color: #dc2626;
  }
  .btn-delete:hover {
    background-color: #fee2e2;
  }

  /* Responsive tweaks */
  @media (max-width: 700px) {
    table, thead, tbody, th, td, tr {
      display: block;
      width: 100%;
    }
    thead tr {
      display: none;
    }
    tbody tr {
      margin-bottom: 1.5rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      border-radius: 10px;
      padding: 1rem;
      background-color: #fff;
    }
    tbody td {
      padding-left: 50%;
      position: relative;
      text-align: right;
      font-size: 0.9rem;
      border: none;
      border-bottom: 1px solid #e5e7eb;
    }
    tbody td:last-child {
      border-bottom: none;
    }
    tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      top: 12px;
      font-weight: 600;
      color: #6b7280;
      text-transform: uppercase;
      font-size: 0.75rem;
    }
  }
</style>
@endsection

@section('content')
<div class="reports-container">
    <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Daily Reports</h2>
        <a href="{{ route('reports.create') }}" class="btn-primary">+ New Report</a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reports->count())
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Report Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td data-label="Title">{{ $report->title }}</td>
                    <td data-label="Report Date">{{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}</td>
                    <td data-label="Image">
                        @if ($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="report-image" />
                        @else
                            <span style="color: #9ca3af;">No image</span>
                        @endif
                    </td>
                    <td data-label="Actions" style="text-align:right;">
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn-action btn-edit" title="Edit">✏️</a>

                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this report?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" title="Delete">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No reports found. <a href="{{ route('reports.create') }}">Create one now!</a></p>
    @endif
</div>
@endsection
