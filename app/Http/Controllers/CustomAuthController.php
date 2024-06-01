<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class CustomAuthController extends Controller
{
    public function user()
    {
        if(Auth::check()){
            return Auth::user();
        }
        return ;

    }
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Создание куки

            // $cookie = cookie('isAuthenticated', 'true', 0, null, null, false, false); // Куки истекает с окончанием сессии, httpOnly установлено в false
            // session(['isAuthenticated' => true]);

            $token = Auth::user()->createToken('authToken')->plainTextToken;

            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json(['redirect' => '/'])->withCookie($cookie);

        }
        // Возвращение сообщения об ошибке
        return response()->json(['error' => 'Неправильная почта или пароль', 'redirect' => '/auth']);
    }
    public function registration()
    {
        return view('auth.register');
    }
    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return response()->json(['redirect' => '/auth']);
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
    public function authCheck()
    {
        if (Auth::check()) {
            return 'true';
        }
        return 'false';
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    public function logout(Request $request){
        $cookie = Cookie::forget('jwt');

        return response()->json(['redirect' => '/'])->withCookie($cookie);
    }
}
