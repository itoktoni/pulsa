<?php

namespace Modules\Procurement\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Procurement\Dao\Repositories\BranchRepository;
use Modules\Procurement\Dao\Repositories\MovementRepository;
use Modules\Procurement\Dao\Repositories\SupplierRepository;
use Modules\Procurement\Http\Requests\MovementRequest;
use Modules\Procurement\Http\Services\MovementCreateService;
use Modules\Procurement\Http\Services\MovementUpdateService;
use Modules\System\Http\Requests\DeleteRequest;
use Modules\System\Http\Requests\GeneralRequest;
use Modules\System\Http\Services\CreateService;
use Modules\System\Http\Services\DataService;
use Modules\System\Http\Services\DeleteService;
use Modules\System\Http\Services\SingleService;
use Modules\System\Http\Services\UpdateService;
use Modules\System\Plugins\Helper;
use Modules\System\Plugins\Response;
use Modules\System\Plugins\Views;

class MovementController extends Controller
{
    public static $template;
    public static $service;
    public static $model;

    public function __construct(MovementRepository $model, SingleService $service)
    {
        self::$model = self::$model ?? $model;
        self::$service = self::$service ?? $service;
    }

    private function share($data = [])
    {
        $branch = Views::option(new BranchRepository());
        $product = Views::option(new ProductRepository());
        $status = Views::status(self::$model->status);

        $view = [
            'branch' => $branch,
            'product' => $product,
            'status' => $status,
            'model' => self::$model,
        ];

        return array_merge($view, $data);
    }

    public function index()
    {
        return view(Views::index())->with([
            'fields' => Helper::listData(self::$model->datatable),
        ]);
    }

    public function create()
    {
        return view(Views::create())->with($this->share());
    }

    public function save(MovementRequest $request, MovementCreateService $service)
    {
        $data = $service->save(self::$model, $request);
        return Response::redirectBack($data);
    }

    public function data(DataService $service)
    {
        return $service
            ->setModel(self::$model)
            ->EditColumn([
                self::$model->branch_from() => 'branch_from_name',
                self::$model->branch_to() => 'branch_to_name',
            ])
            ->EditStatus([
                self::$model->flag() => self::$model->status,
            ])->make();
    }

    public function edit($code)
    {
        $data = $this->get($code);
        return view(Views::update())->with($this->share([
            'model' => $data,
            'detail' => $data->detail,
        ]));
    }

    public function update($code, MovementRequest $request, MovementUpdateService $service)
    {
        $data = $service->update(self::$model, $request, $code);
        return Response::redirectBack($data);
    }

    public function show($code)
    {
        return view(Views::show())->with($this->share([
            'fields' => Helper::listData(self::$model->datatable),
            'model' => $this->get($code),
        ]));
    }

    public function get($code = null, $relation = null)
    {
        $relation = $relation ?? request()->get('relation');
        if ($relation) {
            return self::$service->get(self::$model, $code, $relation);
        }
        return self::$service->get(self::$model, $code);
    }

    public function delete(DeleteRequest $request, DeleteService $service)
    {
        $code = $request->get('code');
        $data = $service->delete(self::$model, $code);
        return Response::redirectBack($data);
    }
}
