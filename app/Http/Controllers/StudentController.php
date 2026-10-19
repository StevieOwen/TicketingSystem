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

    public function storeticket(Request $request,TicketService $ticketService){
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

        // Find the officer in the same department with the fewest active/assigned tickets
        $officer = User::where('department', $student_department)
            ->whereIn('role', ['Academic officer', 'Finance officer', 'IT officer'])
            ->withCount('assignedTickets') // Counts tickets assigned to each officer
            ->orderBy('assigned_tickets_count', 'asc') // Sorts from lowest to highest ticket count
            ->first();

        // Fallback: If no officer is found strictly in the same department, 
        // pick any officer with the least tickets as a safety measure.
        if (!$officer) {
            $officer = User::whereIn('role', ['Academic officer', 'Finance officer', 'IT officer'])
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count', 'asc')
                ->first();
        }

        $officer_id = $officer ? $officer->user_id : null;
        

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

    $ticketService($ticket,['subject','description','attachment']);

    return back()
            ->withInput()
            ->with('success','Ticket well updated');

    }

    public function settings(){

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
        $studentService->updateStudent($user,['name','regNumber']);
        return back()
        ->withInput()
        ->with('success','informations updated successfully');

    }
}
