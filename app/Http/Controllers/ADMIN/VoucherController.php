<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Carbon\Carbon;
use App\Events\VoucherCreated;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = Voucher::orderby('ngaytao')->get();
        return view('admin.components.Voucher.index',compact('voucher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.components.Voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ma'=> 'unique:voucher',
            'dongiatoithieu'=> 'min:0|required',
            'sotiengiam' => 'required',
            'solansudung'=>'min:1|required',
            'ngayhethan'=>'date|required'
        ],[
            'ma.unique'=>'Mã này đã được sử dụng',
            'dongiatoithieu.min'=>'Đơn giá nhỏ nhất là 0đ',
            'dongiatoithieu.sotiengiam'=>'Đơn giá tối thiểu không được để trống',
            'sotiengiam.sotiengiam'=>'Số tiền giảm không được để trống',
            'solansudung.min'=>'Số lần sử dụng tối thiểu là 1',
            'solansudung.required'=>'Số lần sử dụng không được để trống',
            'ngayhethan.required'=>'Ngày hết hạn không được để trống',
            'ngayhethan.date'=>'Ngày hết hạn phải là 1 ngày',
        ]);
        // dd($request);
        // dd(Carbon::create($request->ngayhethan)->format('Y-m-d H:i:s'));
        try {
            $voucher = new Voucher;
            $voucher->ngaytao = Carbon::now();
            $voucher->ma = $data['ma'];
            $voucher->dongiatoithieu = $data['dongiatoithieu'];
            $voucher->sotiengiam = $data['sotiengiam'];
            $voucher->solansudung = $data['solansudung'];
            $voucher->ngayhethan = Carbon::create($data['ngayhethan'])->format('Y-m-d H:i:s');
            $voucher->save();
            event(new VoucherCreated($voucher));
            // VoucherCreated::dispatch('hehe');
            toastr()->success('Đã thêm mã khuyến mãi');
            return $this->index();
        } catch (\Throwable $th) {
            //throw $th;
            toastr()->error('Có lỗi khi thêm mã khuyến mãi');
            return redirect()->back();
        }

    }
    public function deleteVoucher(Request $request){
        $voucher = Voucher::whereIn('id',$request->id)->delete();
        toastr()->success('Xóa voucher thành công');
        return response()->json(['code' => 200, 'message' => 'Xóa voucher thành công']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
