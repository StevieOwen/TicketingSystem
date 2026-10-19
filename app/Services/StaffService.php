<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class StaffService{
    public function getStaffs(){
        $staffs=User::whereNotIn('role',['Student'])->get();
        return $staffs;
    }
    public function storeStaff($user_id, $name, $email, $role, $department, $password,$status){
        $staff=new User;

        $staff->user_id=$user_id;
        $staff->name=$name;
        $staff->email=$email;
        $staff->role=$role;
        $staff->department=$department;
        $staff->password=Hash::make($password);
        $staff->status=$status;

        $staff->save();

        return $staff;

    }

    public function updateStaff(User $user, array $data){

        // Define the fields you want to allow for modification
        $allowedFields = ['name','status','department','role','email','password'];

        // Filter the incoming array to only include allowed keys, then update & save
        $user->update(array_intersect_key($data, array_flip($allowedFields)));

        return $user;
    }

    public function deleteStaff(User $user){
        $user->delete();
    }
}