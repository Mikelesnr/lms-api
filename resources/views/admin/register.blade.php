<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register Admin</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
  <div style="max-width: 400px; margin: 60px auto; padding: 24px; background-color: white; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h2 style="text-align: center; margin-bottom: 24px;">Admin Registration</h2>

    @if(session('success'))
      <div style="background-color: #e6ffed; color: #2f855a; padding: 8px 12px; margin-bottom: 16px; border-radius: 4px;">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background-color: #fff5f5; color: #c53030; padding: 8px 12px; margin-bottom: 16px; border-radius: 4px;">
        <ul style="margin: 0; padding-left: 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}">
      @csrf

      <label style="display: block; margin-bottom: 6px;">Name</label>
      <input type="text" name="name" required style="width: 100%; padding: 8px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px;" />

      <label style="display: block; margin-bottom: 6px;">Email</label>
      <input type="email" name="email" required style="width: 100%; padding: 8px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px;" />

      <label style="display: block; margin-bottom: 6px;">Password</label>
      <input type="password" name="password" required style="width: 100%; padding: 8px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px;" />

      <label style="display: block; margin-bottom: 6px;">Confirm Password</label>
      <input type="password" name="password_confirmation" required style="width: 100%; padding: 8px; margin-bottom: 24px; border: 1px solid #ccc; border-radius: 4px;" />

      <button type="submit" style="width: 100%; background-color: #2d89ef; color: white; padding: 10px; border: none; border-radius: 4px; font-weight: bold;">
        Create Admin
      </button>
    </form>
  </div>
</body>
</html>
