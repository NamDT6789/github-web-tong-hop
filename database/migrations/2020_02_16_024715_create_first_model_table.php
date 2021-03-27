<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstModelTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('first_model', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('submission_id', 191)->nullable();
			$table->string('device_code', 150)->nullable();
			$table->string('model_name', 150)->nullable();
			$table->string('sale_code', 150)->nullable();
			$table->string('check_file_cts')->nullable();
			$table->string('check_list')->nullable();
			$table->string('asignment')->nullable();
			$table->integer('status')->nullable();
			$table->integer('type')->nullable();
			$table->integer('ratio_assignment')->default(0);
			$table->integer('ratio_check_file')->default(0);
			$table->integer('ratio_check_list')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('first_model');
	}
}
