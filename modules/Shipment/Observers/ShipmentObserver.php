<?php

namespace Modules\Shipment\Observers;

use Modules\Notification\Services\NotificationService;
use Modules\Shipment\Entities\Shipment;

class ShipmentObserver
{
    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the shipment "created" event.
     *
     * @param Shipment $shipment
     * @return void
     */
    public function created(Shipment $shipment)
    {
        $carrier = $shipment->wait->carrier->name;
        $board = $shipment->wait->boardHorse->board;
        $dock = $shipment->dock->name;

        $this->notificationService->create([
            'title' => 'Veículo direcionado',
            'message' => sprintf(
                'O veículo da transportadora %s, placa %s foi direcionado para a doca %s, libere o veículo.',
                $carrier,
                $board,
                $dock
            ),
            'type' => 'vehicle-directed',
        ]);
    }
}