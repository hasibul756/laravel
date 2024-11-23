<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Add New User</h1>

            <!-- Error Alert -->
             <!-- @if ($errors->all())
                <div class="alert alert-danger">
                    <p><strong>There were some issues with your input:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif -->

            <!-- Error Alert (General) -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p><strong>There were some issues with your input:</strong></p>
                </div>
            @endif

            <form action="{{url('/add_user')}}" method="post">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        id="name" 
                        placeholder="Enter your name"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        id="email" 
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        id="password" 
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Age -->
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input 
                        type="number" 
                        class="form-control @error('age') is-invalid @enderror" 
                        name="age" 
                        id="age" 
                        placeholder="Enter your age"
                        value="{{ old('age') }}"
                    >
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Skills Checkboxes -->
                <div class="mb-3">
                    <label class="form-label">Skills</label>
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input @error('skills') is-invalid @enderror" 
                            name="skills[]" 
                            id="skill-html" 
                            value="HTML"
                            {{ in_array('HTML', old('skills', [])) ? 'checked' : '' }}
                        >
                        <label for="skill-html" class="form-check-label">HTML</label>
                    </div>
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            name="skills[]" 
                            id="skill-css" 
                            value="CSS"
                            {{ in_array('CSS', old('skills', [])) ? 'checked' : '' }}
                        >
                        <label for="skill-css" class="form-check-label">CSS</label>
                    </div>
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            name="skills[]" 
                            id="skill-js" 
                            value="JavaScript"
                            {{ in_array('JavaScript', old('skills', [])) ? 'checked' : '' }}
                        >
                        <label for="skill-js" class="form-check-label">JavaScript</label>
                    </div>
                    @error('skills')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender Radios -->
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="form-check">
                        <input 
                            type="radio" 
                            class="form-check-input @error('gender') is-invalid @enderror" 
                            name="gender" 
                            id="gender-male" 
                            value="Male"
                            {{ old('gender') == 'Male' ? 'checked' : '' }}
                        >
                        <label for="gender-male" class="form-check-label">Male</label>
                    </div>
                    <div class="form-check">
                        <input 
                            type="radio" 
                            class="form-check-input" 
                            name="gender" 
                            id="gender-female" 
                            value="Female"
                            {{ old('gender') == 'Female' ? 'checked' : '' }}
                        >
                        <label for="gender-female" class="form-check-label">Female</label>
                    </div>
                    <div class="form-check">
                        <input 
                            type="radio" 
                            class="form-check-input" 
                            name="gender" 
                            id="gender-other" 
                            value="Other"
                            {{ old('gender') == 'Other' ? 'checked' : '' }}
                        >
                        <label for="gender-other" class="form-check-label">Other</label>
                    </div>
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role Dropdown -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select 
                        class="form-select @error('role') is-invalid @enderror" 
                        name="role" 
                        id="role"
                    >
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Editor" {{ old('role') == 'Editor' ? 'selected' : '' }}>Editor</option>
                        <option value="Viewer" {{ old('role') == 'Viewer' ? 'selected' : '' }}>Viewer</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>