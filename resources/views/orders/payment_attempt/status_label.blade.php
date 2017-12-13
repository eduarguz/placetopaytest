@if(is_null($paymentAttempt))
    <span class="label label-info">En espera</span>
@elseif($paymentAttempt->isFailed())
    <span class="label label-danger">{{ $paymentAttempt->readable_status }}</span>
@elseif($paymentAttempt->isApproved())
    <span class="label label-success">{{ $paymentAttempt->readable_status }}</span>
@elseif($paymentAttempt->isDeclined())
    <span class="label label-primary">{{ $paymentAttempt->readable_status }}</span>
@elseif($paymentAttempt->isPending())
    <span class="label label-warning">{{ $paymentAttempt->readable_status }}</span>
@endif