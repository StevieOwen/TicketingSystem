<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    protected $fillable=['id','subject','description','issueType','status','attachment','rejection_motive','student_id','officer_id','updated_at','created_at'];

     public function student(): BelongsTo
    {
        return $this->belongsTo(User::class,'student_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class,'officer_id');
    }

    public function ticketLogs(): HasMany
    {
        return $this->hasMany(Ticketlog::class);
    }
    
}
