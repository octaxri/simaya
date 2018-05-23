<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Golongan;

class GolonganController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');
        $page = $request->input('page') ?? 1;
        $limit = $request->input('limit') ?? 10;

        $instance = Golongan::take($limit)
            ->when(strlen($search) > 0, function($query) use ($search) {
                $query->where('nama', 'like', "%${search}%");
            })
        ;

        $total = $instance->count();

        $instance->when(is_numeric($page), function($query) use ($page, $limit) {
            $skip = ($page - 1) * $limit;
            $query->skip($skip);
        });

        $result = $instance->get();

        return $this->dataMessage($result, $total);
    }

    public function show(Golongan $golongan)
    {
        return $this->dataMessage($golongan, false);
    }
}
