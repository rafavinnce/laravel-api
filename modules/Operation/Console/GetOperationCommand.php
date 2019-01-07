<?php

namespace Modules\Operation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Carrier\Services\CarrierService;
use Modules\Shipment\Services\LoadService;
use \SplFileObject;

class GetOperationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data of operation files to input in system';

    /**
     * The carrier service instance.
     *
     * @var CarrierService
     */
    protected $carrierService;

    /**
     * The load service instance.
     *
     * @var LoadService
     */
    protected $loadService;

    /**
     * Mapping of header to key names appropriated.
     *
     * @var array
     */
    protected $mapping = [
        'datetime',
        'sales_order',
        'item_code',
        'load_status_start',
        'wave',
        'pre_number',
        'billing_warehouse',
        'carrier_id',
        'dispatch_route',
        'customer_code',
        'load_number',
        'load_status',
        'amount',
        'volumes',
        'order_cubing',
    ];
    
    /**
     * Create a new command instance.
     *
     * @param $carrierService CarrierService
     * @param $loadService LoadService
     *
     * @return void
     */
    public function __construct(CarrierService $carrierService, LoadService $loadService)
    {
        $this->carrierService = $carrierService;
        $this->loadService = $loadService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = base_path('operation_rev5_full.csv');
        $collection = new Collection();
        $withoutCarrier = new Collection();

        $file = new SplFileObject($filename);
        $file->setFlags(SplFileObject::READ_CSV);

        while (!$file->eof()) {
            $rows = $file->fgetcsv(',');
            if (count($rows) > 1 && in_array(strtoupper($rows[11]), ['PR', 'CQ'])) {
                $attributes = $this->prepare($rows);

                if (!empty($attributes['carrier_id'])) {
                    $entity = $this->loadService->create($attributes);
                    $collection->push($attributes);

                    $this->info('New operation created successfully.');
                    $this->line(sprintf('<comment>Operation ID:</comment> %d', $entity->id));
                    $this->line(sprintf('<comment>Operation carrier:</comment> %s', $entity->carrier->name));
                    $this->line(sprintf('<comment>Operation wave:</comment> %s', $entity->wave));
                } else {
                    $withoutCarrier->push($attributes);
                }
            }
        }

        if (empty($collection->count())) {
            $this->info('Nothing to import.');
        }

        if ($withoutCarrier->count()) {
            $this->info(sprintf('<comment>%d</comment> operation(s) not imported for being without carrier', $withoutCarrier->count()));
        }
    }

    /**
     * Prepare keys and data of row.
     *
     * @param $data
     * @return mixed
     */
    private function prepare($data)
    {
        $attributes = array_combine($this->mapping, $data);

        $regex = '/([0-9]{4})-([0-9]{2})-([0-9]{2}).([0-9]{2}).([0-9]{2}).([0-9]{2})/i';
        preg_match($regex, $attributes['datetime'],$matches);
        $attributes['datetime'] = $this->dateFormat($matches[0]);

        $carrier = $this->carrierService->findWhere([
            'id_external' => (int) $attributes['carrier_id'],
        ], ['id'])->first();

        $attributes['carrier_id'] = ($carrier) ? $carrier->id : null;
        $attributes['amount'] = $this->toInteger($attributes['amount']);
        $attributes['volumes'] = $this->toInteger($attributes['volumes']);
        $attributes['order_cubing'] = $this->toFloat($attributes['order_cubing']);

        return $attributes;
    }

    /**
     * Prepare and transform value in float.
     *
     * @param $value
     * @return int
     */
    private function toFloat($value)
    {
        $value = str_replace('.', '', $value);
        return (float) $value;
    }

    /**
     * Prepare and transform value in integer.
     *
     * @param $value
     * @return int
     */
    private function toInteger($value)
    {
        $value = str_replace('.', '', $value);
        return (int) $value;
    }

    /**
     * Format date to database
     *
     * @param $datetime
     * @return string
     */
    private function dateFormat($datetime)
    {
        return Carbon::createFromFormat('Y-m-d-H.i.s', $datetime)->toDateTimeString();
    }
}