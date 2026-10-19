<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticketlog extends Model
{
    /** @use HasFactory<\Database\Factories\TicketlogFactory> */
    use HasFactory;

    protected $fillable=['id','note','action','student_id','officer_id','ticket_id','created_at','updated_at'];

    public function ticket():BelongsTo
    {
        return $this->belonsTo(Ticket::class);
    }

    
}
