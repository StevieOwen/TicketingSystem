<?php

namespace App\Http\Controllers;
use App\Services\StaffService;
use App\Services\TicketService;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function overview(TicketService $ticketService){

        $myAssignedTickets=$ticketService->getStaffAssignedTickets();

        return view('staff.overview',compact('myAssignedTickets'));
    }

    public function updateTicket(Request $request, TicketService $ticketService, Ticket $ticket){
        $request->validate([
            'status' => 'required|in:pending,accepted,processing,done,rejected',
            'rejection_motive' => ['required', 'string', 'max:255'],
        ]);
        try{
           $ticketService->updateTicket($ticket,['status','rejection_motive']);
           return back()
           ->withInput()
           ->with('success', 'Ticket updated successfully');
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

    }

    public function updateStaff(){
        
    }
}
