<?php

use App\Models\Finance\Transactions\FmsTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fms_transactions', function (Blueprint $table) {
            $table->double('amount_local',16,2)->default(0.00)->after('total_amount'); 
        });
      $transactions =  FmsTransaction::all();
      if(count($transactions)>0){
      foreach($transactions as $trans){
        $transamount = $trans->total_amount*$trans->rate;
        FmsTransaction::where('id', $trans->id)->update([
            'amount_local' => $transamount,
        ]);
      }
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fms_transactions', function (Blueprint $table) {
            //
        });
    }
};
