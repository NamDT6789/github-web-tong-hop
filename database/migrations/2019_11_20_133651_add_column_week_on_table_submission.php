<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnWeekOnTableSubmission extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('submission', function (Blueprint $table) {
			$table->integer('week')->after('urgent_mark')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('submission', function (Blueprint $table) {
			$table->dropColumn('week');
		});
	}
}
