<?php

namespace Modules\Wait\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Carrier\Services\CarrierService;
use Modules\Lobby\Services\LobbyService;
use Modules\Operation\Services\OperationService;
use Modules\Vehicle\Services\VehicleService;
use Modules\Wait\Services\WaitService;
use \SplFileObject;

class GetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wait:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get files to input in waits';

    /**
     * The wait service instance.
     *
     * @var WaitService
     */
    protected $waitService;

    /**
     * The carrier service instance.
     *
     * @var CarrierService
     */
    protected $carrierService;

    /**
     * The operation service instance.
     *
     * @var OperationService
     */
    protected $operationService;

    /**
     * The vehicle service instance.
     *
     * @var VehicleService
     */
    protected $vehicleService;

    /**
     * The lobby service instance.
     *
     * @var LobbyService
     */
    protected $lobbyService;

    /**
     * Mapping of header to key names appropriated.
     *
     * @var array
     */
    protected $mapping = [
        'CÓDIGO EMPRESA' => 'carrier_id_external',
        'EMPRESA' => 'carrier',
        'CODIGO PORTARIA' => 'lobby',
        'MOTORISTA' => 'driver',
        'PLACA CAVALO' => 'board_horse',
        'PLACA CARRETA' => 'board_cart',
        'Nº DE MNIFESTO' => 'manifest',
        'Nº LACRE 1' => 'seal1',
        'Nº LACRE 2' => 'seal2',
        'DATA CHEGADA' => 'arrival_date',
        'HORA CHEGADA' => 'arrival_time',
        'DATA ENTRDA' => 'entry_date',
        'HORA ENTRDA' => 'entry_time',
        'DATA SAÍDA ' => 'output_date',
        'HORA SAÍDA' => 'output_time',
        'TIPO' => 'operation',
        'AUTORIZADOR' => 'authorized_by',
    ];
    
    /**
     * Create a new command instance.
     *
     * @param $waitService WaitService
     * @param $carrierService CarrierService
     * @param $operationService OperationService
     * @param $vehicleService VehicleService
     * @return void
     */
    public function __construct(
        WaitService $waitService,
        CarrierService $carrierService,
        OperationService $operationService,
        VehicleService $vehicleService,
        LobbyService $lobbyService
    )
    {
        $this->waitService = $waitService;
        $this->carrierService = $carrierService;
        $this->operationService = $operationService;
        $this->vehicleService = $vehicleService;
        $this->lobbyService = $lobbyService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = base_path('dados-ronda.csv');
        $collection = new Collection();

        $file = new SplFileObject($filename);
        $file->setFlags(SplFileObject::READ_CSV);

        $file->seek(0);
        $header = $file->fgetcsv(';');

        while (!$file->eof()) {
            $attributes = $this->prepare(array_combine($header, $file->fgetcsv(';')));
            $entity = $this->waitService->create($attributes);
            $collection->push($entity);

            $this->info('New wait created successfully.');
            $this->line(sprintf('<comment>Wait ID:</comment> %d', $entity->id));
            $this->line(sprintf('<comment>Wait carrier:</comment> %s', $entity->carrier->name));
            $this->line(sprintf('<comment>Wait driver:</comment> %s', $entity->driver));
            $this->line(sprintf('<comment>Wait authorized by:</comment> %s', $entity->authorized_by));
        }

        if (empty($collection->count())) {
            $this->info('Nothing to import.');
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
        $data = $this->prepareKeys($data);

        dump($data);

        $attributes = [
            'driver' => $data['driver'],
            'manifest' => $data['manifest'],
            'seal1' => $data['seal1'],
            'seal2' => $data['seal2'],
            'authorized_by' => $data['authorized_by'],
            'arrival_at' => $this->dateFormat($data['arrival_date'], $data['arrival_time']),
            'entry_at' => $this->dateFormat($data['entry_date'], $data['entry_time']),
            'output_at' => $this->dateFormat($data['output_date'], $data['output_time']),
            'carrier_id' => $this->carrierService->firstOrCreate(['id_external' => $data['carrier_id_external']], [
                'name' => $data['carrier']
            ])->id,
            'operation_id' => $this->operationService->getRepository()->firstOrCreate(['name' => $data['operation']])->id,
            'board_horse_id' => (!empty($data['board_horse'])) ?
                $this->vehicleService->getRepository()->firstOrCreate(['board' => strtoupper($data['board_horse'])])->id : null,
            'board_cart_id' => (!empty($data['board_cart'])) ?
                $this->vehicleService->getRepository()->firstOrCreate(['board' => strtoupper($data['board_cart'])])->id : null,
            'lobby_id' => (!empty($data['lobby'])) ?
                $this->lobbyService->getRepository()->firstOrCreate(['name' => strtoupper($data['lobby'])])->id : null,
        ];

        dump($attributes);

        return $attributes;
    }

    /**
     * Format date to database
     *
     * @param $date
     * @param $time
     * @return string
     */
    private function dateFormat($date, $time)
    {
        return Carbon::createFromFormat('d/m/Y H:i', sprintf('%s %s', $date, $time))
            ->toDateTimeString();
    }

    /**
     * Change keys by mapping.
     *
     * @param $data
     * @return mixed
     */
    private function prepareKeys($data)
    {
        foreach ($data as $key => $value) {
            $data[$this->mapping[$key]] = $value;
            unset($data[$key]);
        }

        return $data;
    }
}
