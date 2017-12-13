<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentAttempt extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'response_body' => 'array'
    ];

    /**
     * Accesor for a nice way to read the status of the payment.
     *
     * @return string
     */
    public function getReadableStatusAttribute()
    {
        $status = $this->attributes['status'];

        return ['Fallido', 'Aprobado', 'Declinado', 'Pendiente'][$status];
    }

    /**
     * Accesor for the bank date in a nicer format
     *
     * @return string
     */
    public function getBankDateAttribute()
    {
        if (array_key_exists('bankProcessDate', $this->response_body)) {
            return Carbon::parse($this->response_body['bankProcessDate'])->toDateTimeString();
        }

        return $this->created_at->toDateTimeString();
    }

    /**
     * Check if there is need to synchronize the transaction.
     *
     * @return bool
     */
    public function needsSyncTransaction()
    {
        if (!$this->isPending()) {
            return false;
        }

        // When it is pending, then has been updated at least once? or has more than 7 minutes of being updated
        if ($this->updated_at->lte($this->created_at) || now()->diffInMinutes($this->updated_at) > 7) {
            return true;
        }

        return false;
    }

    /**
     * Sync the current payment attempt using the given payment gateway.
     *
     * @param $paymentGateway
     * @return $this
     */
    public function syncTransaction($paymentGateway)
    {
        if ($this->needsSyncTransaction()) {
            $response = $paymentGateway->getTransaction($this->attributes['transaction_id']);
            $this->update([
                'status' => $response->responseCode,
                'response_body' => $response
            ]);
            $this->touch();
        }

        return $this;
    }

    public function isFailed()
    {
        return $this->status == 0;
    }

    public function isApproved()
    {
        return $this->status == 1;
    }

    public function isDeclined()
    {
        return $this->status == 2;
    }

    public function isPending()
    {
        return $this->status == 3;
    }
}
