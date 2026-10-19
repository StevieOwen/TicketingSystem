<?php

namespace App\Http\Controllers;

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

        $ticketService->updateTicket($ticket,['status','rejection_motive']);
    }
}
