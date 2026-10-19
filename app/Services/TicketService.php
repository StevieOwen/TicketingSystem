<?php
namespace App\Services;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class TicketService{

    public function getStudentsTickets(){
      $tickets=Ticket::with(['officer','student'])->get();
       return $tickets;
    } 

    public function getStaffAssignedTickets(){
        $officer=auth()->user();
        return $officer ? $officer->assignedTickets : collect();
    }

    public function getStudentTickets(){
       $student = auth()->user();
       return $student ? $student->submittedTickets : collect();
    } 



    public function createTicket($subject,$description,$issueType,$status,$attachment,$student_id,$officer_id){
        $ticket=new Ticket;

        $ticket->subject=$subject;
        $ticket->description=$description;
        $ticket->issueType=$issueType;
        $ticket->status=$status;
        $ticket->student_id=$student_id;
        $ticket->officer_id=$officer_id;

        if ($attachment instanceof UploadedFile) {
        // Store it in storage/app/public/tickets and save the path string
        $ticket->attachment = $attachment->store('tickets', 'public');
        } else {
            $ticket->attachment = null;
        }

        $ticket->save();

        return $ticket;
    }


    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        // Define the fields you want to allow for modification
        $allowedFields = ['status', 'officer_id', 'rejection_motive','attachment','subject','description','issueType'];

        // Filter the incoming array to only include allowed keys, then update & save
        $ticket->update(array_intersect_key($data, array_flip($allowedFields)));

        return $ticket;
    }

    
}