<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposit;
use Symfony\Component\Debug\Debug;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $deposits = Deposit::orderby('id','desc')->get();

        $deposit_total = Deposit::sum('amount');

//        return view('deposit.index')->withDeposits($deposits)->withDeposit_total($deposit_total);
        return view('deposit.index', compact('deposits', 'deposit_total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deposit = $this->validate(request(), [
            'company' => 'required',
            'amount' => 'required|numeric'
        ]);

        $deposit = new Deposit;
        $deposit->company = $request->company;
        $deposit->amount = $request->amount;
        $deposit->save();

//        Deposit::create($deposit);
        return back()->with('success', 'Product has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deposits = Deposit::find($id);
        return view('deposit.edit', compact('deposits', 'id'));
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
        $deposit = Deposit::find($id);
        $this->validate(request(), [
            'company' => 'required',
            'amount' => 'required|numeric'
        ]);
        $deposit->company = $request->get('company');
        $deposit->amount = $request->get('amount');
        $deposit->save();
        return redirect('deposit')->with('success','Deposit has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deposit = Deposit::find($id);
        $deposit->delete();
        return redirect('deposit')->with('success','Product has been  deleted');
    }

    public function deposit()
    {
        $deposits_total = Deposit::sum('amount');

        return view('list.process',compact('deposits_total'));


    }
}
