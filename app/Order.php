<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentAttempts()
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    /**
     * Determine is the order has old payments, it means more than the latest.
     *
     * @return bool
     */
    public function hasOldPaymentAttempts()
    {
        return $this->paymentAttempts->count() > 1;
    }

    /**
     * The old payment attempts, it splices the latest one.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function oldPaymentAttempts()
    {
        return $this->paymentAttempts->sortByDesc('created_at')->splice(1);
    }

    /**
     * The latest payment attempt
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function paymentAttempt()
    {
        return $this->hasOne(PaymentAttempt::class)->latest();
    }

    /**
     * Determine if the order has a payment attempt.
     *
     * @return bool
     */
    public function hasPaymentAttempt()
    {
        return !!$this->paymentAttempt;
    }

    /**
     * Determine if the order is missing the payment attempt
     *
     * @return bool
     */
    public function isMissingPayment()
    {
        return !$this->hasPaymentAttempt();
    }

    /**
     * Formatted amount, using COP format.
     *
     * @return string
     */
    public function formattedAmount()
    {
        return number_format($this->amount, 0, '', '.');
    }

    /**
     * Uses the payment attempt to check if there is a need to synchronize it.
     *
     * @return bool
     */
    public function needsToSyncPayment()
    {
        return !!optional($this->paymentAttempt)->needsSyncTransaction();
    }

    /**
     * Wrapper method to synchronize the payment attempt.
     *
     * @param $paymentGateway
     * @return $this
     */
    public function syncPayment($paymentGateway)
    {
        optional($this->paymentAttempt)->syncTransaction($paymentGateway);
        $this->load('paymentAttempt');

        return $this;
    }

    public function isFailed()
    {
        return optional($this->paymentAttempt)->isFailed();
    }

    public function isApproved()
    {
        return optional($this->paymentAttempt)->isApproved();
    }

    public function isDeclined()
    {
        return optional($this->paymentAttempt)->isDeclined();
    }

    public function isPending()
    {
        return optional($this->paymentAttempt)->isPending();
    }
}
