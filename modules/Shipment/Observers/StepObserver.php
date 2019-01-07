<?php

namespace Modules\Shipment\Observers;

use Illuminate\Support\Carbon;
use Modules\Notification\Services\NotificationService;
use Modules\Shipment\Entities\Step;

class StepObserver
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
     * Handle the step "created" event.
     *
     * @param Step $step
     * @return void
     */
    public function created(Step $step)
    {
        $carrier = $step->shipment->wait->carrier->name;
        $dock = $step->shipment->dock->name;
        $box = $step->shipment->box;

        if ($step->type->code == 1) {
            $this->notificationService->create([
                'title' => 'Veículo liberado',
                'message' => sprintf(
                    'Veículo da transportadora %s foi liberado para a doca %s.',
                    $carrier,
                    $dock
                ),
                'type' => 'vehicle-released',
            ]);
        } elseif ($step->type->code == 13) {
            $this->notificationService->create([
                'title' => 'Carregamento finalizado',
                'message' => sprintf(
                    'Carregamento na doca %s box %s foi finalizado.',
                    $dock,
                    $box
                ),
                'type' => 'finish-loading',
            ]);

            $step->shipment->finish_at = Carbon::now();
            $step->shipment->save();
        }
    }
}