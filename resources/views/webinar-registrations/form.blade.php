<div class="it-evn-sidebar-registration mb-40">
    <h4 class="it-evn-sidebar-title mb-30">Register for this Webinar</h4>
    
    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <strong>✓</strong> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 10px 0 0 20px; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('webinar.registration.store', $webinar->slug) }}" method="POST">
        @csrf
        
        <div class="form-group mb-20">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name <span style="color: #dc3545;">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" 
                   placeholder="Enter your full name" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
            @error('name')
                <span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-20">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email Address <span style="color: #dc3545;">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="Enter your email" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
            @error('email')
                <span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-20">
            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number <span style="color: #dc3545;">*</span></label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone') }}" 
                   placeholder="Enter your phone number" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
            @error('phone')
                <span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-20">
            <label for="location" style="display: block; margin-bottom: 8px; font-weight: 600;">Location <span style="color: #dc3545;">*</span></label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                   id="location" name="location" value="{{ old('location') }}" 
                   placeholder="Enter your location" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
            @error('location')
                <span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="it-btn w-100 text-center">
            <span>
                Register Now
                <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </button>
    </form>
</div>

<style>
.it-evn-sidebar-registration {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #e5e5e5;
}

.it-evn-sidebar-registration .form-group label {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 8px;
    display: block;
}

.it-evn-sidebar-registration .form-control {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.it-evn-sidebar-registration .form-control:focus {
    border-color: #c9a96e;
    box-shadow: 0 0 0 0.2rem rgba(201, 169, 110, 0.25);
    outline: none;
}

.it-evn-sidebar-registration .alert {
    border-radius: 5px;
    margin-bottom: 20px;
}

.it-evn-sidebar-title {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 20px;
}
</style>

