<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply to Teach | CMFI School</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: hsl(223, 100%, 58%);
            --primary-dark: hsl(223, 100%, 45%);
            --bg-main: #F4F7F6;
            --text-main: #1A1D1F;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 600px;
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            color: var(--primary-dark);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #EFEFEF;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
        }
        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background-color: #E8F5E9;
            color: #1B5E3F;
            border: 1px solid #C8E6C9;
        }
        .error-msg {
            color: #FF6A55;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <h1>Teacher Application</h1>
            <p>Join our academic team at CMFI School</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" required value="{{ old('first_name') }}">
                    @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" required value="{{ old('last_name') }}">
                    @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required value="{{ old('email') }}">
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" required value="{{ old('phone') }}">
                @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Position Applying For</label>
                <select name="job_opening_id" required>
                    <option value="">Select a position</option>
                    @foreach($openings as $opening)
                        <option value="{{ $opening->id }}">{{ $opening->position->title }} ({{ $opening->position->department->name }})</option>
                    @endforeach
                </select>
                @error('job_opening_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Applicant Type</label>
                <select name="applicant_type" id="applicant_type" required onchange="toggleStaffId()">
                    <option value="new">New Applicant</option>
                    <option value="current_teacher">Current CMFI Teacher (Reapplication)</option>
                </select>
            </div>

            <div class="form-group" id="staff_id_group" style="display: none;">
                <label>Staff ID / Employee Code</label>
                <input type="text" name="staff_id" value="{{ old('staff_id') }}">
                @error('staff_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Upload CV (PDF/Doc)</label>
                <input type="file" name="cv" required>
                @error('cv') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn">Submit Application</button>
        </form>
    </div>

    <script>
        function toggleStaffId() {
            const type = document.getElementById('applicant_type').value;
            const group = document.getElementById('staff_id_group');
            group.style.display = type === 'current_teacher' ? 'block' : 'none';
        }
        lucide.createIcons();
    </script>
</body>
</html>
