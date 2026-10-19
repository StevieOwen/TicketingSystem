<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentService{

    public function createStudent($user_id,$name,$email,$regNumber,$department,$password){
        
        $user=new User;

        $user->user_id=$user_id;
        $user->name=$name;
        $user->email=$email;
        $user->regNumber=$regNumber;
        $user->department=$department;
        $user->password=Hash::make($password);
        $user->role='student';
        $user->save();

        return $user;
      
    }
    
    public function updateStudent(User $user,array $data){

        // Define the fields you want to allow for modification
        $allowedFields = ['status','email','department','password'];

        // Filter the incoming array to only include allowed keys, then update & save
        $user->update(array_intersect_key($data, array_flip($allowedFields)));

        return $user;
    }


}