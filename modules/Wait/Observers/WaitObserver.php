<?php

namespace Modules\Wait\Observers;

use Modules\Notification\Services\NotificationService;
use Modules\Wait\Entities\Wait;

class WaitObserver
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
     * Handle the wait "created" event.
     *
     * @param Wait $wait
     * @return void
     */
    public function created(Wait $wait)
    {
        $carrier = $wait->carrier->name;

        $this->notificationService->create([
            'title' => 'Novo veículo - Direcionar doca',
            'message' => sprintf(
                'Um novo veículo da transportadora %s está no pátio aguardando, direcione uma doca.',
                $carrier
            ),
            'type' => 'vehicle-waiting',
        ]);
    }
}