<?php

namespace Koisystems\MassEmails\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTransactionItem extends Model
{
    use HasFactory;

    protected $table="email_transactions_items";
}
