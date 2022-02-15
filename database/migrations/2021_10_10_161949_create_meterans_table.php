<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeteransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meterans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pelanggan_id')->unsigned()->index();
            $table->string('periode', 6)->index();
            $table->decimal('awal', 10,2)->default(0);
            $table->decimal('akhir', 10,2)->default(0);
            $table->decimal('pemakaian', 10,2)->default(0);
            $table->boolean('is_generate_bill')->default(0);
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meterans');
    }
}
