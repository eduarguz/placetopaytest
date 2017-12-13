@if(!$order->hasPaymentAttempt())
    El pago no se ha iniciado, puedes
    <a href="{{ route('orders.payments.pse.create', $order) }}">iniciar un con PSE</a>
@elseif($order->isFailed())
    El pago de esta orden ha falllado, puedes
    <a href="{{ route('orders.payments.pse.create', $order) }}">intentarlo de nuevo</a>
@elseif( $order->isApproved())
    Ahora puedes descargar el contenido de tu compra
    <a href="{{\App\PhotoOnSale::src()}}" download>Aquí</a>
@elseif($order->isDeclined())
    Se ha desistido de pagar esta order, puedes
    <a href="{{ route('orders.payments.pse.create', $order) }}">intentarlo de nuevo</a>
@elseif($order->isPending())
    La confirmación de el pago está pendiente,  Intenta más tarde
    <br><small>los datos se refrescan cada 7 minutos</small>
@endif