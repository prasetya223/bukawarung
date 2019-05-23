<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Transaction_det;
class TransactionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $transaction = Transaction::select('transactions.id','name','address','total','courier','timeout','transactions.status')->join('users','users.id','=','transactions.user_id')->join('couriers','transactions.courier_id','=','couriers.id')->get();
        return view('/admin/approvement',compact("transaction"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $total_price = 0;
        // return($transaction);
        $data = Transaction_det::join('transactions','transaction_details.transaction_id','=','transactions.id')->join('products','transaction_details.product_id','=','products.id')->where('transaction_id',$id)->get();
        foreach ($data as $key) {
            $total_price+=$key->selling_price*$key->qty;
        }

        // return($data[0]["proof_of_payment"]);
        return view('/admin/approvement_detail',compact("total_price","data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id',$id)->get()->first();
        $transaction->status = 'verified';
        $transaction->save();
        return redirect('/admin/transactionAdmin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}