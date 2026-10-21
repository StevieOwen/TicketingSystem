<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Services\TicketService;
use App\Services\StudentService;


class StudentController extends Controller
{
    public function overview(TicketService $ticketService){
        
        $mySubmittedTickets=$ticketService->getStudentTickets();

        return view('student/overview',compact('mySubmittedTickets'));
    }

    public function createTicket(Request $request,TicketService $ticketService){
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'issueType' => 'required|in:academic,finance,system',
            'attachment'=>'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $student = auth()->user();
        $student_id = $student->user_id;
        $student_department = $student->department;
        $status = 'pending';

        // 1. Map the issue type to the corresponding officer role
        $requiredRole = match (strtolower($issueType)) {
            'finance'  => 'Finance officer',
            'system'   => 'IT officer',
            'academic' => 'Academic officer',
            default    => null,
        };

        $officer = null;

        if ($requiredRole === 'Academic officer') {
            // 2a. Academic officers have departments: Try finding one in the student's department first
            $officer = User::where('department', $student_department)
                ->where('role', 'Academic officer')
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count', 'asc')
                ->first();

            // 2b. Fallback: If none in that department, pick any Academic officer
            if (!$officer) {
                $officer = User::where('role', 'Academic officer')
                    ->withCount('assignedTickets')
                    ->orderBy('assigned_tickets_count', 'asc')
                    ->first();
            }
        } 
        elseif ($requiredRole === 'Finance officer') {
            // 3. Finance officers don't have departments: Pick the one with the least tickets globally
            $officer = User::where('role', 'Finance officer')
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count', 'asc')
                ->first();
        } 
        elseif ($requiredRole === 'IT officer') {
            // 4. IT officers don't have departments: Pick the one with the least tickets globally
            $officer = User::where('role', 'IT officer')
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count', 'asc')
                ->first();
        }

        // 5. Absolute Last Resort Fallback: If the issue type is unknown or no officer was found,
        // grab any available officer with the fewest tickets overall.
        if (!$officer) {
            $officer = User::whereIn('role', ['Academic officer', 'Finance officer', 'IT officer'])
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count', 'asc')
                ->first();
        }

        $officer_id = $officer ? $officer->user_id : null;
        
        try{
             $ticketService->createTicket(
            $request->subject,
            $request->description,
            $request->issueType,
            $status,
            $request->attachment,
            $student_id,
            $officer_id,

             );

            return back()
                ->withInput()
                ->with('success','Ticket well submited, you\'ll get a feedback soon');


        }catch(\Exception $e){
            // Log actual error for debugging
            Log::error('Ticket creation failed: ' . $e->getMessage());

            // Return back to form with input data and a generic error message
            return back()
                ->withInput()
                ->with('error', 'Failed to create ticket. Please try again.'. $e->getMessage());
        }

       
    }

   

    public function updateTicket(TicketService $ticketService, Request $request, Ticket $ticket){
    
     $request->validate(
        [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'attachment'=>'required|image|mimes:jpeg,png,jpg,webp|max:5120',

        ]
     );

     $status='pending';

     try{
        $ticketService($ticket,['subject','description','attachment']);

    return back()
            ->withInput()
            ->with('success','Ticket well updated');
     }catch(\Exception $e){
            // Log actual error for debugging
            Log::error('Ticket update failed: ' . $e->getMessage());

            // Return back to form with input data and a generic error message
            return back()
                ->withInput()
                ->with('error', 'Failed to update ticket. Please try again.'. $e->getMessage());
        }

    }

     public function settings(){
        return view('student.settings');
    }

    public function updateStudent(User $user, Request $request, StudentService $studentService){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'regNumber' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
        ]);
        try{
            $studentService->updateStudent($user,['name','regNumber']);
            return back()
            ->withInput()
            ->with('success','informations updated successfully');
        }catch(\Exception $e){
            // Log actual error for debugging
            Log::error('Information update failed: ' . $e->getMessage());

            // Return back to form with input data and a generic error message
            return back()
                ->withInput()
                ->with('error', 'Failed to update informations. Please try again.'. $e->getMessage());
        }
        

    }
}
