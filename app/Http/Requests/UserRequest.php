<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest //userRequest hamne create kari hai or FormRequest hmari inbuilt class hai
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool //ye authorize method hamare user ki authencity check krta hai k user real hai ya nhi
    {
        return true; //abhi hamne testing k liye isko true krdiya lekin ham wese isko if condition k andar true krte hn
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array //is method k andar hi hamay apni form fields k name or uske k saaray rules define krne hote hn
    {
        $rules = [
            'username'=>'required',//'username' hamare input field ka name hai. 'required' hamari validation ka rule hai iska matlab k ye input field khaali nhi ho sakti
            'useremail'=>'required|email|unique:users,email',//is tarah ham multiple rule daal skte hn
            'userage'=>'required|numeric|min:18|max:28',
            'usercity'=>'required',
            'userrole'=>'required',
            // 'admincode'=>'required|in:secret123',//agar user admin select karega to usko ye code bhi laazmi dena hoga
            'userpassword'=>'required|confirmed',          
        ];

        //admincode ki validation field value k mutabik
        if($this->input('userrole') === 'admin'){//ye $this matlab Ye request class sirf isi route ke liye use hogi". (jo user.store route hai hmare form ke action me diya hua).
        // Isliye $this automatically usi form se aayi values ko represent karta hai jisme hmare HTML fields hain (username, userrole, etc.). admincode hamari input field ka naam hai
            $rules['password'] = 'required|in:secret123';//$rules hamne variable banaya hai upper wo ek associative array hai jo Laravel ko batata hai ki kis field par kaun sa validation rule lagana hai.
        }//matlab agar hamare role ki value admin hogi to ye input field "admincode" par validation lag jayegi k iski value yahi honi chahiye is k elawa nhi honi chahiye
        else{
            $rules['password'] = 'nullable';// matlab field khali hai to error nhi ayega
        }
        //hame condition k mutabik rule lagana isi liye end me rule lagaya haiks

        return $rules;//Laravel validation ko ye $rules array return hota hai.
    }

    //agar hamen in rules me koi specific message dikhana hai to us k liye messages() function banaenge

    public function messages() //ye ham khud se banaenge lekin ye laravel ka inbuilt method hai jo hamare messages ko overwrite kar dega jo hamari FormRequest class me likhe hue hn.
    {
        return [
            'username.required'=>'User Name is required',//username hamare input name ka name phr dot laga kar validation rule ka naam phr uski error value ayegi
            'useremail.required'=>'User Email is required',
            'useremail.email'=>'Enter the corect email address',
            'userage.required'=>':attribute is required',//:attribute ka matlab hamare inputfield ka name
            'usercity.required'=>'User City is required',
            'userage.numeric'=>'Userage must be numeric',
            'userage.min'=>'Userage should be atleast 18',
            'userage.max'=>'Userage should not be more than 28',
            'password.required' => 'Enter valid Admin code',
            'password.in' => 'Enter valid Admin code',
            'userpassword.required'=>'Password is required',
            'confirm_password.required'=>':Password is required'
        ];
        
    }

    public function attributes(): array //is method k andar hi ham apne apne input field ka naam likhenge k us ki jagah kia likhna hai
    {
        return [
            'username'=>'User name',//'username' hamare input field ka name hai agar ham apne messages function me :attribute likhenge to hamare "username ki jagah "User name" hojaega
            'useremail'=>'User email',
            'userage'=>'User age',
            'usercity'=>'User city'
        ];
    }

    //agar ham chahte hn k hamara ek waqt me sirf 1 error show ho sare error ek sath show na ho to uske liye ham super global variable "$stopOnFirstFailure" ka use karenge
    
    //protected $stopOnFirstFailure = true;//ab hamara sirf ek error show hoga
}
