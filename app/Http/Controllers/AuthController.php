<?php 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        dd($request->all());

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Check user's role and redirect accordingly
            if ($user->hasRole('user')) {
                return redirect('/');
            } else {
                return redirect('/admin/user');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
