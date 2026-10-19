<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;

class AdminController extends Controller
{
    use PasswordValidationRules;

    public function overview(){
        $count_staffs=User::whereNotIn('role',['Student'])->count();
        $count_students=User::where('role','Student')->count();
        $count_tickets=Ticket::get();
        return view('admin.overview',compact('count_staffs','count_students','count_tickets'));
    }

    public function staffIndex(StaffService $staffService){ 
        $staffs=$staffService->getStaffs();  
        return view('admin.staffs',compact('staffs'));       
    }

    public function storeStaff(Request $request,StaffService $staffService){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'role' => 'required|in:Admin,IT officer,Finance officer,Academic officer',
            'department' => ['nullable','string', 'max:255'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required', 'same:password'],
            'status' => 'required|in:active,inactive',
        ]);
        $user_id=\Illuminate\Support\Str::uuid();

        $staffService->storeStaff(
            $user_id,
            $request->name,
            $request->email,
            $request->role,
            $request->department,
            $request->password,
            $request->status
        );

        return back()
            ->withInput()
            ->with('success','New staff added successfully');

    }

    public function updateStaff(User $user, Request $request, StaffService $staffService){
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'role' => 'required|in:Admin,IT officer,Finance officer,Academic officer',
            'department' => ['required', 'string', 'max:255'],
            'status' => 'required|in:active,inactive',
        ]);
        
        $staffService->updateStaff(
            $user,
           [
            $request->status,
            $request->department,
            $request->role,
            $request->email,
            ]
        );
        
        return back()
            ->withInput()
            ->with('success',"Staff updated successfully");
        

    }

    public function staffDelete(User $user, StaffService $staffService){
        $staffService->deleteStaff($user);

        return back()
                ->withInput()
                ->with('success','Staff deleted successfully');
    }


    public function ticketIndex(){
        $tickets=Ticket::with(['student','officer'])->latest()->get();
        $groupedStaff = User::whereNotIn('role', ['Student', 'Admin'])
        ->get()
        ->groupBy(function($staff) {
            return $staff->department ? $staff->department : 'General / Other';
        });

        return view('admin.tickets',compact(['tickets','groupedStaff']));
    }


    public function ticketUpdate(Request $request, Ticket $ticket, TicketService $ticketService){
        $request->validate([
            'status' => 'required|in:pending,accepted,processing,done,rejected',
            'officer_id'=>''
        ]);
        
        $ticketService->updateTicket(
            $ticket,
            [$request->status,
            $request->officer_id,]
        );
        
        return back()
            ->withInput()
            ->with('success',"Staff updated successfully");
        
    }

    public function studentIndex(){
        $students=User::where('role','student')->latest()->get();
        return view('admin.students',compact('students'));
    }

    public function studentUpdate(Request $request,User $user, StudentService $studentService){
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'department' => ['required', 'string', 'max:255'],
            'status' => 'required|in:active,inactive',
        ]);
        
        $studentService->updateStudent(
            $user,
            [
             $request->status,
             $request->department,
             $request->email,
            ]
        );
        
        return back()
            ->withInput()
            ->with('success',"Staff updated successfully");
    }

    public function settings(){
        return view('admin.settings');
    }

}
