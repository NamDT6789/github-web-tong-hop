<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTableSubmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('submission_id',191)->nullable();
            $table->string('device_code',150)->nullable();
            $table->string('ap_version',150)->nullable();
            $table->string('modem_version',150)->nullable();
            $table->string('csc_version',150)->nullable();
            $table->integer('total_csc')->nullable();
            $table->string('approval_type',150)->nullable();
            $table->string('reviewer',150)->nullable();
            $table->string('pl_email',150)->nullable();
            $table->boolean('first_model')->default(false);
            $table->boolean('svmc_project')->default(false);
            $table->dateTime('submit_date_time')->nullable();
            $table->dateTime('svmc_review_date')->nullable();
            $table->boolean('urgent_mark')->default(false);
            $table->integer('svmc_review_status')->nullable();
            $table->text('svmc_comment')->nullable();
            $table->integer('progress')->nullable();
            $table->integer('google_review_status')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission');
    }
}